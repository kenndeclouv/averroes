<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ZipArchive;

class BackupController extends Controller
{
    protected string $backupDir;

    public function __construct()
    {
        $this->backupDir = storage_path('app/backups');
        if (!File::exists($this->backupDir)) {
            File::makeDirectory($this->backupDir, 0755, true);
        }
    }

    /**
     * Tampilkan daftar file backup
     */
    public function index()
    {
        $files = File::files($this->backupDir);
        $backups = [];

        foreach ($files as $file) {
            $extension = strtolower($file->getExtension());
            if (!in_array($extension, ['sql', 'zip'])) {
                continue;
            }

            $backups[] = [
                'name' => $file->getFilename(),
                'size' => $this->formatSize($file->getSize()),
                'created_at' => Carbon::createFromTimestamp($file->getMTime())->setTimezone('Asia/Jakarta')->format('d M Y, H:i:s'),
                'timestamp' => $file->getMTime(),
                'type' => $extension === 'zip' ? 'Full (Database + Storage)' : 'Simple (Database)',
                'raw_type' => $extension,
                'badge' => $extension === 'zip' ? 'bg-label-primary' : 'bg-label-info',
                'icon' => $extension === 'zip' ? 'fa-file-zipper' : 'fa-database',
            ];
        }

        // Urutkan backup terbaru di paling atas
        usort($backups, fn($a, $b) => $b['timestamp'] <=> $a['timestamp']);

        return view('roles.SuperAdmin.backup.index', compact('backups'));
    }

    /**
     * Backup Simple: hanya database (.sql)
     */
    public function backupDatabase()
    {
        try {
            set_time_limit(300);
            $filename = 'backup_db_' . date('Y-m-d_H-i-s') . '.sql';
            $filePath = $this->backupDir . DIRECTORY_SEPARATOR . $filename;

            $this->generateSqlDump($filePath);

            return redirect()->route('superadmin.backup.index')
                ->with('success', "Backup database berhasil dibuat: {$filename}");
        } catch (\Exception $e) {
            return redirect()->route('superadmin.backup.index')
                ->withErrors(['error' => 'Gagal membuat backup database: ' . $e->getMessage()]);
        }
    }

    /**
     * Backup Full: Database + Seluruh File Upload Storage (.zip)
     */
    public function backupTotal()
    {
        try {
            set_time_limit(600);
            ini_set('memory_limit', '512M');

            if (!class_exists('ZipArchive')) {
                throw new \Exception('Ekstensi PHP ZipArchive tidak aktif di server ini.');
            }

            $timestamp = date('Y-m-d_H-i-s');
            $tempSqlPath = $this->backupDir . DIRECTORY_SEPARATOR . "temp_db_{$timestamp}.sql";
            $zipFilename = "backup_total_{$timestamp}.zip";
            $zipFilePath = $this->backupDir . DIRECTORY_SEPARATOR . $zipFilename;

            // 1. Dump Database
            $this->generateSqlDump($tempSqlPath);

            // 2. Buat ZIP Archive
            $zip = new ZipArchive();
            if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
                throw new \Exception("Tidak dapat membuat file ZIP di {$zipFilePath}");
            }

            // Masukkan SQL Dump ke root ZIP
            $zip->addFile($tempSqlPath, 'database.sql');

            // 3. Masukkan seluruh file uploads / storage publik (materials, attachments, transaksi, dll)
            $storagePublicPath = storage_path('app/public');
            if (File::exists($storagePublicPath)) {
                $files = new RecursiveIteratorIterator(
                    new RecursiveDirectoryIterator($storagePublicPath, RecursiveDirectoryIterator::SKIP_DOTS),
                    RecursiveIteratorIterator::LEAVES_ONLY
                );

                foreach ($files as $file) {
                    if (!$file->isDir()) {
                        $filePath = $file->getRealPath();
                        $relativePath = 'storage/' . substr($filePath, strlen($storagePublicPath) + 1);
                        $relativePath = str_replace('\\', '/', $relativePath);
                        $zip->addFile($filePath, $relativePath);
                    }
                }
            }

            $zip->close();

            // Hapus temporary SQL dump
            if (File::exists($tempSqlPath)) {
                File::delete($tempSqlPath);
            }

            return redirect()->route('superadmin.backup.index')
                ->with('success', "Backup Full (Database + File) berhasil dibuat: {$zipFilename}");
        } catch (\Exception $e) {
            if (isset($tempSqlPath) && File::exists($tempSqlPath)) {
                File::delete($tempSqlPath);
            }
            return redirect()->route('superadmin.backup.index')
                ->withErrors(['error' => 'Gagal membuat backup full: ' . $e->getMessage()]);
        }
    }

    /**
     * Restore dari file yang ada di daftar backup server
     */
    public function restore(string $filename)
    {
        try {
            set_time_limit(600);
            ini_set('memory_limit', '512M');

            $safeFilename = basename($filename);
            $filePath = $this->backupDir . DIRECTORY_SEPARATOR . $safeFilename;

            if (!File::exists($filePath)) {
                return redirect()->route('superadmin.backup.index')
                    ->withErrors(['error' => 'File backup tidak ditemukan.']);
            }

            $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
            $this->performRestore($filePath, $extension);

            return redirect()->route('superadmin.backup.index')
                ->with('success', "Restore berhasil diselesaikan dari file: {$safeFilename}");
        } catch (\Exception $e) {
            return redirect()->route('superadmin.backup.index')
                ->withErrors(['error' => 'Gagal me-restore data: ' . $e->getMessage()]);
        }
    }

    /**
     * Upload file backup (.sql atau .zip) dari komputer lalu restore
     */
    public function uploadAndRestore(Request $request)
    {
        $request->validate([
            'backup_file' => 'required|file|max:512000', // Maksimal 500MB
        ], [
            'backup_file.required' => 'Pilih file backup yang ingin di-upload.',
            'backup_file.max' => 'Ukuran file backup maksimal 500MB.',
        ]);

        try {
            set_time_limit(600);
            ini_set('memory_limit', '512M');

            $uploadedFile = $request->file('backup_file');
            $originalName = $uploadedFile->getClientOriginalName();
            $extension = strtolower($uploadedFile->getClientOriginalExtension());

            if (!in_array($extension, ['sql', 'zip'])) {
                return redirect()->route('superadmin.backup.index')
                    ->withErrors(['error' => 'Format file tidak didukung. Hanya file .sql dan .zip yang diperbolehkan.']);
            }

            // Simpan file upload ke folder backups
            $targetPath = $this->backupDir . DIRECTORY_SEPARATOR . $originalName;
            $uploadedFile->move($this->backupDir, $originalName);

            // Lakukan restore
            $this->performRestore($targetPath, $extension);

            return redirect()->route('superadmin.backup.index')
                ->with('success', "File {$originalName} berhasil di-upload dan sistem berhasil di-restore!");
        } catch (\Exception $e) {
            return redirect()->route('superadmin.backup.index')
                ->withErrors(['error' => 'Gagal me-restore file upload: ' . $e->getMessage()]);
        }
    }

    /**
     * Download file backup
     */
    public function download(string $filename)
    {
        $safeFilename = basename($filename);
        $filePath = $this->backupDir . DIRECTORY_SEPARATOR . $safeFilename;

        if (!File::exists($filePath)) {
            return redirect()->route('superadmin.backup.index')
                ->withErrors(['error' => 'File backup tidak ditemukan.']);
        }

        return response()->download($filePath, $safeFilename);
    }

    /**
     * Hapus file backup
     */
    public function destroy(string $filename)
    {
        $safeFilename = basename($filename);
        $filePath = $this->backupDir . DIRECTORY_SEPARATOR . $safeFilename;

        if (File::exists($filePath)) {
            File::delete($filePath);
            return redirect()->route('superadmin.backup.index')
                ->with('success', "File backup {$safeFilename} berhasil dihapus.");
        }

        return redirect()->route('superadmin.backup.index')
            ->withErrors(['error' => 'File backup tidak ditemukan.']);
    }

    /**
     * Eksekusi proses restore berdasarkan tipe file
     */
    protected function performRestore(string $filePath, string $extension): void
    {
        if ($extension === 'sql') {
            // Restore database dari .sql
            $this->executeSqlFile($filePath);
        } elseif ($extension === 'zip') {
            if (!class_exists('ZipArchive')) {
                throw new \Exception('Ekstensi PHP ZipArchive tidak aktif di server ini.');
            }

            $zip = new ZipArchive();
            if ($zip->open($filePath) !== true) {
                throw new \Exception("Gagal membuka file ZIP: {$filePath}");
            }

            $tempExtractDir = $this->backupDir . DIRECTORY_SEPARATOR . 'temp_restore_' . uniqid();
            if (!File::exists($tempExtractDir)) {
                File::makeDirectory($tempExtractDir, 0755, true);
            }

            $zip->extractTo($tempExtractDir);
            $zip->close();

            try {
                // 1. Restore Database jika ada database.sql di root ZIP
                $extractedSql = $tempExtractDir . DIRECTORY_SEPARATOR . 'database.sql';
                if (File::exists($extractedSql)) {
                    $this->executeSqlFile($extractedSql);
                }

                // 2. Restore file-file storage jika ada folder storage di dalam ZIP
                $extractedStorage = $tempExtractDir . DIRECTORY_SEPARATOR . 'storage';
                if (File::exists($extractedStorage)) {
                    $targetPublicStorage = storage_path('app/public');
                    if (!File::exists($targetPublicStorage)) {
                        File::makeDirectory($targetPublicStorage, 0755, true);
                    }
                    File::copyDirectory($extractedStorage, $targetPublicStorage);
                }
            } finally {
                // Bersihkan folder extract temporary
                if (File::exists($tempExtractDir)) {
                    File::deleteDirectory($tempExtractDir);
                }
            }
        } else {
            throw new \Exception("Tipe file .{$extension} tidak didukung untuk restore.");
        }
    }

    /**
     * Helper menjalankan file SQL dump ke database menggunakan streaming PDO
     */
    protected function executeSqlFile(string $sqlPath): void
    {
        if (!File::exists($sqlPath)) {
            throw new \Exception("File SQL {$sqlPath} tidak ditemukan.");
        }

        $pdo = DB::getPdo();
        $pdo->exec("SET FOREIGN_KEY_CHECKS = 0;");

        $handle = fopen($sqlPath, 'r');
        if (!$handle) {
            throw new \Exception("Tidak dapat membaca file SQL di {$sqlPath}");
        }

        $query = '';
        while (!feof($handle)) {
            $line = fgets($handle);
            $trimmed = trim($line);

            // Lewati komentar dan baris kosong
            if (empty($trimmed) || str_starts_with($trimmed, '--') || str_starts_with($trimmed, '/*')) {
                continue;
            }

            $query .= $line;

            // Jika baris berakhiran titik koma, jalankan query
            if (str_ends_with($trimmed, ';')) {
                $pdo->exec($query);
                $query = '';
            }
        }

        if (!empty(trim($query))) {
            $pdo->exec($query);
        }

        fclose($handle);
        $pdo->exec("SET FOREIGN_KEY_CHECKS = 1;");
    }

    /**
     * Helper membuat SQL Dump lengkap dengan murni PHP
     */
    protected function generateSqlDump(string $destinationPath): void
    {
        $handle = fopen($destinationPath, 'w+');
        if (!$handle) {
            throw new \Exception("Tidak dapat menulis file backup ke {$destinationPath}");
        }

        $pdo = DB::getPdo();
        $dbName = config('database.connections.mysql.database');

        fwrite($handle, "-- ========================================================\n");
        fwrite($handle, "-- Averroes Application Database Backup\n");
        fwrite($handle, "-- Tanggal: " . date('Y-m-d H:i:s') . "\n");
        fwrite($handle, "-- Database: {$dbName}\n");
        fwrite($handle, "-- ========================================================\n\n");
        fwrite($handle, "SET NAMES utf8mb4;\n");
        fwrite($handle, "SET FOREIGN_KEY_CHECKS = 0;\n\n");

        // Ambil semua tabel dasar
        $tables = [];
        $rows = DB::select('SHOW FULL TABLES WHERE Table_type = "BASE TABLE"');
        foreach ($rows as $row) {
            $rowArray = (array) $row;
            $tables[] = reset($rowArray);
        }

        foreach ($tables as $table) {
            fwrite($handle, "-- --------------------------------------------------------\n");
            fwrite($handle, "-- Struktur Tabel: `{$table}`\n");
            fwrite($handle, "-- --------------------------------------------------------\n");
            fwrite($handle, "DROP TABLE IF EXISTS `{$table}`;\n");

            $createTable = DB::select("SHOW CREATE TABLE `{$table}`");
            if (!empty($createTable)) {
                $createArray = (array) $createTable[0];
                $createSql = $createArray['Create Table'] ?? '';
                fwrite($handle, $createSql . ";\n\n");
            }

            fwrite($handle, "-- Data Tabel: `{$table}`\n");

            // Ambil data per chunk agar hemat memory
            $records = DB::table($table)->get();
            if ($records->isNotEmpty()) {
                $columns = array_keys((array) $records->first());
                $columnList = '`' . implode('`, `', $columns) . '`';

                foreach ($records->chunk(100) as $chunk) {
                    $valuesSql = [];
                    foreach ($chunk as $record) {
                        $rowValues = [];
                        foreach ($columns as $column) {
                            $val = $record->$column;
                            if (is_null($val)) {
                                $rowValues[] = 'NULL';
                            } else {
                                $rowValues[] = $pdo->quote((string)$val);
                            }
                        }
                        $valuesSql[] = '(' . implode(', ', $rowValues) . ')';
                    }

                    fwrite($handle, "INSERT INTO `{$table}` ({$columnList}) VALUES\n" . implode(",\n", $valuesSql) . ";\n");
                }
            }

            fwrite($handle, "\n");
        }

        fwrite($handle, "SET FOREIGN_KEY_CHECKS = 1;\n");
        fwrite($handle, "-- Selesai backup.\n");
        fclose($handle);
    }

    /**
     * Format bytes ke human readable
     */
    protected function formatSize(int $bytes): string
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            return $bytes . ' bytes';
        } elseif ($bytes == 1) {
            return $bytes . ' byte';
        } else {
            return '0 bytes';
        }
    }
}
