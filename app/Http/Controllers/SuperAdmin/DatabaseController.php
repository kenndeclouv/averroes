<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class DatabaseController extends Controller
{
    private function generateValidationRules($columns, $tableName, $isUpdate = false)
    {
        $rules = [];
        $columnDetails = DB::select("DESCRIBE $tableName");

        foreach ($columnDetails as $columnDetail) {
            if (in_array($columnDetail->Field, ['id', 'created_at', 'updated_at'])) {
                continue;
            }
            $columnName = $columnDetail->Field;
            $dataType = $columnDetail->Type;
            $isNullable = $columnDetail->Null === 'YES';

            // Aturan Required atau Sometimes
            if (!$isNullable) {
                $rules[$columnName][] = $isUpdate ? 'sometimes' : 'required';
            }

            // Aturan Berdasarkan Tipe Data
            if (str_contains($dataType, 'int')) {
                $rules[$columnName][] = 'integer';
            } elseif (str_contains($dataType, 'varchar') || str_contains($dataType, 'text')) {
                if (preg_match('/\((\d+)\)/', $dataType, $matches)) {
                    $maxLength = $matches[1];
                    $rules[$columnName][] = 'string';
                    $rules[$columnName][] = "max:$maxLength";
                } else {
                    $rules[$columnName][] = 'string';
                }
            } elseif (str_contains($dataType, 'date') || str_contains($dataType, 'time') || str_contains($dataType, 'year')) {
                $rules[$columnName][] = 'date';
            } elseif (str_contains($dataType, 'decimal') || str_contains($dataType, 'float') || str_contains($dataType, 'double')) {
                $rules[$columnName][] = 'numeric';
            } elseif (str_contains($dataType, 'enum')) {
                if (preg_match('/enum\((.*)\)/', $dataType, $matches)) {
                    $enumOptions = str_getcsv($matches[1], ',', "'");
                    $rules[$columnName][] = 'in:' . implode(',', $enumOptions);
                }
            } elseif (str_contains($dataType, 'json')) {
                $rules[$columnName][] = 'json';
            } elseif (str_contains($dataType, 'blob')) {
                $rules[$columnName][] = 'file';
            }

            // Aturan Unik untuk Key
            if ($columnDetail->Key === 'PRI') {
                // Abaikan primary key untuk operasi update
                if (!$isUpdate) {
                    $rules[$columnName][] = 'unique:' . $tableName;
                }
            } elseif ($columnDetail->Key === 'UNI') {
                $rules[$columnName][] = 'unique:' . $tableName;
            }
        }

        // Gabungkan aturan
        foreach ($rules as $key => $value) {
            $rules[$key] = implode('|', $value);
        }

        return $rules;
    }


    private function generateValidationMessages($columns, $tableName)
    {
        $messages = [];
        $columnDetails = DB::select("DESCRIBE $tableName");

        foreach ($columnDetails as $columnDetail) {
            if (in_array($columnDetail->Field, ['id', 'created_at', 'updated_at'])) {
                continue;
            }
            $columnName = $columnDetail->Field;
            $dataType = $columnDetail->Type;
            $isNullable = $columnDetail->Null === 'YES';

            // Pesan validasi dasar
            if (!$isNullable) {
                $messages["$columnName.required"] = "Kolom $columnName wajib diisi.";
            } else {
                $messages["$columnName.nullable"] = "Kolom $columnName boleh kosong.";
            }

            // Pesan validasi tipe data
            if (str_contains($dataType, 'int')) {
                $messages["$columnName.integer"] = "Kolom $columnName harus berupa angka.";
            } elseif (str_contains($dataType, 'varchar') || str_contains($dataType, 'text')) {
                if (preg_match('/\((\d+)\)/', $dataType, $matches)) {
                    $maxLength = $matches[1];
                    $messages["$columnName.string"] = "Kolom $columnName harus berupa teks.";
                    $messages["$columnName.max"] = "Kolom $columnName maksimal $maxLength karakter.";
                } else {
                    $messages["$columnName.string"] = "Kolom $columnName harus berupa teks.";
                }
            } elseif (str_contains($dataType, 'date') || str_contains($dataType, 'time') || str_contains($dataType, 'year')) {
                $messages["$columnName.date"] = "Kolom $columnName harus berupa tanggal yang valid.";
            } elseif (str_contains($dataType, 'decimal') || str_contains($dataType, 'float') || str_contains($dataType, 'double')) {
                $messages["$columnName.numeric"] = "Kolom $columnName harus berupa angka.";
            } elseif (str_contains($dataType, 'enum')) {
                if (preg_match('/enum\((.*)\)/', $dataType, $matches)) {
                    $enumOptions = str_getcsv($matches[1], ',', "'");
                    $messages["$columnName.in"] = "Kolom $columnName hanya dapat berisi nilai: " . implode(', ', $enumOptions) . ".";
                }
            } elseif (str_contains($dataType, 'json')) {
                $messages["$columnName.json"] = "Kolom $columnName harus berupa format JSON yang valid.";
            } elseif (str_contains($dataType, 'blob')) {
                $messages["$columnName.file"] = "Kolom $columnName harus berupa file.";
            }

            // Pesan validasi untuk key (Primary, Unique)
            if ($columnDetail->Key === 'PRI') {
                $messages["$columnName.unique"] = "Kolom $columnName harus unik.";
            } elseif ($columnDetail->Key === 'UNI') {
                $messages["$columnName.unique"] = "Kolom $columnName harus unik.";
            }
        }

        return $messages;
    }

    public function index()
    {
        $databases = count(DB::select('SHOW TABLES'));
        $databaseName = env('DB_DATABASE');
        $tables = collect(DB::select('SHOW TABLES'))->map(function ($table) {
            $tableName = array_values((array)$table)[0];
            $rowCount = DB::table($tableName)->count();
            $columns = Schema::getColumnListing($tableName);
            return [
                'name' => $tableName,
                'row_count' => $rowCount,
                'columns' => $columns,
            ];
        });
        return view('roles.SuperAdmin.database.index', compact('databases', 'tables','databaseName'));
    }

    public function indexSql()
    {
        return view('roles.SuperAdmin.database.indexSql');
    }

    public function indexDatabase()
    {
        // Nama database yang digunakan
        $databaseName = env('DB_DATABASE');

        // Query untuk mendapatkan daftar tabel dan ukuran tabel
        $tables = DB::select(
            "
            SELECT table_name AS table_name, 
                   ROUND(((data_length + index_length) / 1024), 2) AS size
            FROM information_schema.tables
            WHERE table_schema = :db_name",
            ['db_name' => $databaseName]
        );

        return view('roles.SuperAdmin.database.indexDatabase', compact('tables'));
    }

    public function showTable($table)
    {
        // Mengambil data dari tabel yang dipilih
        $data = DB::table($table)->get();

        // Mengambil detail kolom (nama dan tipe)
        $columns = collect(Schema::getColumnListing($table))->mapWithKeys(function ($column) use ($table) {
            // Ambil detail kolom menggunakan query SQL untuk tipe data yang lengkap
            $columnDetails = DB::select("SHOW COLUMNS FROM `$table` WHERE Field = ?", [$column])[0];
            preg_match('/^(\w+)(\((.*)\))?/', $columnDetails->Type, $matches);

            $type = $matches[1]; // Tipe dasar (misalnya, enum, int, varchar)
            $length = isset($matches[3]) ? $matches[3] : null; // Panjang (jika ada)

            // Handling berbagai tipe data
            if ($type === 'enum') {
                preg_match('/enum\((.*)\)/', $columnDetails->Type, $enumMatches);
                $options = str_getcsv($enumMatches[1], ',', "'");
                return [$column => ['type' => 'enum', 'enum' => $options]];
            } elseif ($type === 'set') {
                preg_match('/set\((.*)\)/', $columnDetails->Type, $setMatches);
                $options = str_getcsv($setMatches[1], ',', "'");
                return [$column => ['type' => 'set', 'set' => $options]];
            } elseif ($type === 'date') {
                return [$column => ['type' => 'date']];
            } elseif ($type === 'time') {
                return [$column => ['type' => 'time']];
            } elseif ($type === 'datetime' || $type === 'timestamp') {
                return [$column => ['type' => 'datetime-local']];
            } elseif ($type === 'year') {
                return [$column => ['type' => 'year']];
            } elseif (in_array($type, ['blob', 'tinyblob', 'mediumblob', 'longblob'])) {
                return [$column => ['type' => 'blob']];
            } elseif (in_array($type, ['integer', 'bigint', 'smallint', 'mediumint'])) {
                return [$column => ['type' => 'number']];
            } elseif (in_array($type, ['float', 'double', 'decimal'])) {
                return [$column => ['type' => 'decimal']];
            } elseif ($type === 'tinyint' && $length == 1) {
                return [$column => ['type' => 'boolean']];
            } else {
                return [$column => ['type' => 'text']];
            }
        });

        // deteksi foreign key secara dinamis
        $foreignData = [];
        $foreignKeys = DB::select("
        SELECT COLUMN_NAME, REFERENCED_TABLE_NAME
        FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
        WHERE TABLE_NAME = ?
        AND TABLE_SCHEMA = DATABASE()
        AND REFERENCED_TABLE_NAME IS NOT NULL", [$table]);

        foreach ($foreignKeys as $foreignKey) {
            $column = $foreignKey->COLUMN_NAME; // kolom yang jadi foreign key
            $relatedTable = $foreignKey->REFERENCED_TABLE_NAME; // tabel tujuan

            // Ambil data dari tabel relasi
            $foreignData[$column] = DB::table($relatedTable)->select('id', 'name')->get();
        }
        // Cek apakah data ada
        if ($data->isEmpty()) {
            return view('roles.SuperAdmin.database.show', compact('data', 'table', 'columns', 'foreignData'))->with('noData', true);
        }

        return view('roles.SuperAdmin.database.show', compact('data', 'table', 'columns', 'foreignData'));
    }

    public function store(Request $request, $tableName)
    {
        // Ambil kolom tabel
        $columns = DB::getSchemaBuilder()->getColumnListing($tableName);

        // Validasi data dinamis sesuai kolom tabel
        $validated = $request->validate(
            $this->generateValidationRules($columns, $tableName),
            $this->generateValidationMessages($columns, $tableName)
        );

        // Hapus kolom auto increment id, created_at dan updated_at dari data yang divalidasi
        unset($validated['id']);
        $validated['created_at'] = now();
        $validated['updated_at'] = now();

        DB::table($tableName)->insert($validated);

        return redirect()->route('superadmin.database.show', $tableName)->with('success', 'Data berhasil ditambahkan.');
    }

    public function update(Request $request, $tableName, $id)
    {
        try {
            $data = $request->input('data');
            if (is_array($data)) {
                unset($data['id']);
            }
            DB::table($tableName)->where('id', $id)->update($data);

            return response()->json(['message' => 'Data berhasil diperbarui'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($tableName, $id)
    {
        DB::table($tableName)->where('id', $id)->delete();

        return redirect()->route('superadmin.database.show', $tableName)->with('success', 'Data berhasil dihapus.');
    }

    public function empty($tableName)
    {
        DB::table($tableName)->truncate();

        return redirect()->route('superadmin.database.indexDatabase', $tableName)->with('success', 'Tabel berhasil dikosongkan.');
    }

    public function drop($tableName)
    {
        Schema::dropIfExists($tableName);

        return redirect()->route('superadmin.database.indexDatabase')->with('success', 'Tabel berhasil dihapus.');
    }

    public function sql(Request $request)
    {
        try {
            $sql = $request->input('sql');
            if (!$sql) {
                return response()->json(['message' => 'Tidak ada query yang dikirim.'], 400);
            }
    
            Log::info("Query yang diterima: {$sql}");
    
            // Jalankan query
            $result = DB::select($sql);
    
            // Debug hasil query
            Log::info("Hasil query: " . print_r($result, true));
    
            $arrayResult = json_decode(json_encode($result), true);

            if (empty($arrayResult)) {
                Log::info("Data kosong: Query tidak mengembalikan hasil.");
                return response()->json([
                    'message' => 'Query berhasil, tetapi tidak ada data.',
                    'formatted' => 'No data available.'
                ], 200);
            }
            
            // Debug array hasil query
            Log::info("Data array: " . print_r($arrayResult, true));
            
    
            // Ambil header (nama kolom)
            $headers = array_keys($arrayResult[0]);
    
            // Format menjadi tabel
            $table = $this->formatAsTable($headers, $arrayResult);
    
            return response()->json([
                'message' => 'Query berhasil!',
                'formatted' => $table
            ], 200);
        } catch (\Exception $e) {
            // Tangani error
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Fungsi untuk memformat data menjadi tabel
     */
    private function formatAsTable($headers, $rows)
    {
        Log::info("Headers: " . print_r($headers, true));
        Log::info("Rows: " . print_r($rows, true));
        // Hitung lebar kolom
        $columnWidths = array_map(function ($header) use ($rows) {
            $maxContentLength = max(array_map('strlen', array_column($rows, $header)));
            return max(strlen($header), $maxContentLength);
        }, $headers);
    
        // Buat baris header
        $table = '';
        foreach ($headers as $index => $header) {
            $table .= str_pad($header, $columnWidths[$index]) . ' | ';
        }
        $table = rtrim($table, ' | ') . PHP_EOL;
    
        // Tambahkan garis pemisah
        $table .= str_repeat('-', array_sum($columnWidths) + 3 * count($headers) - 1) . PHP_EOL;
    
        // Tambahkan data
        foreach ($rows as $row) {
            foreach ($headers as $index => $header) {
                $table .= str_pad($row[$header], $columnWidths[$index]) . ' | ';
            }
            $table = rtrim($table, ' | ') . PHP_EOL;
        }
    
        return $table;
    }
    
}
