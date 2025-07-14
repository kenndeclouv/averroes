<?php

/**
 * Dokumentasi untuk Fungsi Pembantu
 *
 * File ini berisi berbagai fungsi pembantu yang dapat digunakan di seluruh aplikasi.
 *
 * 1. getGender($value)
 *    - Mengonversi nilai gender ('male' atau 'female') ke representasi string yang sesuai.
 *    - Penggunaan:
 *      $gender = getGender('male'); // Mengembalikan 'Laki-laki'
 *
 * 2. formatDate($date, $format = 'd F Y')
 *    - Memformat tanggal ke format yang ditentukan menggunakan Carbon.
 *    - Format default adalah 'd F Y'.
 *    - Penggunaan:
 *      $formattedDate = formatDate('2025-01-01'); // Mengembalikan '01 Januari 2025'
 *
 * 3. sendWhatsAppMessage($to, $message)
 *    - Mengirim pesan WhatsApp menggunakan API UltraMsg.
 *    - Memerlukan ULTRAMSG_INSTANCE_ID dan ULTRAMSG_TOKEN dalam environment.
 *    - Penggunaan:
 *      $response = sendWhatsAppMessage('628123456789', 'Halo!');
 *
 * 4. sendWhatsAppImage($to, $imageUrl, $caption = null)
 *    - Mengirim gambar ke WhatsApp menggunakan API UltraMsg.
 *    - Penggunaan:
 *      $response = sendWhatsAppImage('628123456789', 'http://image.jpg', 'Caption');
 *
 * 5. getStatus($value)
 *    - Mengonversi status ke representasi string.
 *    - Penggunaan:
 *      $status = getStatus('approved'); // Mengembalikan 'Disetujui'
 *
 * 6. uploadFile($file, $folder, $disk = 'public')
 *    - Mengunggah file ke folder yang ditentukan.
 *    - Penggunaan:
 *      $filePath = uploadFile($request->file('document'), 'uploads');
 *
 * 7. deleteFile($path)
 *    - Menghapus file berdasarkan jalur yang diberikan.
 *    - Penggunaan:
 *      deleteFile('uploads/image.jpg');
 *
 * 8. indonesianCurrency($number)
 *    - Memformat angka ke format mata uang Indonesia.
 *    - Penggunaan:
 *      $formatted = indonesianCurrency(1000000); // Mengembalikan 'Rp 1.000.000'
 *
 * 9. formatPhoneToInternational($phone)
 *    - Memformat nomor telepon ke format internasional.
 *    - Penggunaan:
 *      $formatted = formatPhoneToInternational('08123456789'); // Mengembalikan '628123456789'
 *
 * 10. teacherType($type)
 *     - Mengonversi tipe pengajar ke representasi string.
 *     - Penggunaan:
 *       $type = teacherType('teacher'); // Mengembalikan 'Pengajar'
 *
 *  ©️ 2025 by kenndeclouv
 *  https://kenndeclouv.my.id
 */

use Illuminate\Support\Facades\Storage;
use App\Models\AppSetting;
use App\Models\Student;
use App\Models\Teacher;

if (!function_exists('getGender')) {
    function getGender($value)
    {
        // return $value === 'male' ? 'Laki-laki' : 'Perempuan';
        if ($value === 'male') {
            return 'Laki-laki';
        } else if ($value === 'female') {
            return 'Perempuan';
        } else {
            return '-';
        }
    }
}
if (!function_exists('formatDate')) {
    function formatDate($date, $format = 'd F Y')
    {
        return \Carbon\Carbon::parse($date)->translatedFormat($format);
    }
}
if (!function_exists('getStatusOptions')) {
    function getStatusOptions(string $type): array
    {
        $statuses = [
            'approval' => ['pending', 'approved', 'rejected'],
            'activation' => ['active', 'inactive'],
        ];

        return $statuses[$type] ?? [];
    }
}

if (!function_exists('getStatusLabel')) {
    function getStatusLabel(string $status, string $type): string
    {
        $labels = [
            'approval' => [
                'pending' => 'Menunggu',
                'approved' => 'Disetujui',
                'rejected' => 'Ditolak',
            ],
            'activation' => [
                'active' => 'Aktif',
                'inactive' => 'Tidak Aktif',
            ],
            'color' => [
                'pending' => 'warning',
                'approved' => 'success',
                'active' => 'success',
                'rejected' => 'danger',
                'inactive' => 'danger'
            ]
        ];

        return $labels[$type][$status] ?? 'Unknown';
    }
}
if (!function_exists('uploadFile')) {
    function uploadFile($file, $folder, $disk = 'public')
    {
        $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '', $file->getClientOriginalName());
        $file->storeAs($folder, $filename, $disk);
        return $filename;
    }
}
if (!function_exists('deleteFile')) {
    function deleteFile($path)
    {
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
if (!function_exists('indonesianCurrency')) {
    function indonesianCurrency($number)
    {
        return 'Rp ' . number_format($number, 0, ',', '.');
    }
}
if (!function_exists('formatPhoneToInternational')) {
    function formatPhoneToInternational($phone)
    {
        $phone = preg_replace('/\D/', '', $phone);
        if (substr($phone, 0, 1) === '0') {
            return '62' . substr($phone, 1);
        }
        return $phone;
    }
}
if (!function_exists('teacherType')) {
    function teacherType($type)
    {
        $types = [
            'teacher' => 'Pengajar',
            'companion' => 'Musrif',
            'headmaster' => 'Mudzir',
        ];

        return $types[$type] ?? '-';
    }
}

if (!function_exists('convertCase')) {
    function convertCase(string $input, string $targetCase): string
    {
        if (!preg_match('/[_\s-]|[a-z][A-Z]/', $input)) {
            throw new InvalidArgumentException("Input must have clear word boundaries (e.g., snake_case or camelCase).");
        }

        $normalized = preg_replace('/([a-z0-9])([A-Z])/', '$1 $2', $input); // camelCase -> camel Case
        $normalized = strtolower(preg_replace('/[_-]/', ' ', $normalized)); // snake_case/kebab-case -> snake case

        switch ($targetCase) {
            case 'camel':
                return lcfirst(str_replace(' ', '', ucwords($normalized)));
            case 'pascal':
                return str_replace(' ', '', ucwords($normalized));
            case 'snake':
                return strtolower(str_replace(' ', '_', $normalized));
            case 'kebab':
                return strtolower(str_replace(' ', '-', $normalized));
            case 'lowercase':
                return strtolower($normalized);
            case 'uppercase':
                return strtoupper($normalized);
            default:
                throw new InvalidArgumentException("Invalid target case: $targetCase");
        }
    }

    // if (!function_exists('generateNIS')) {
    //     function generateNIS()
    //     {
    //         $settings = AppSetting::first();
    //         $prefix = $settings->nis_prefix ?? ''; // default ''
    //         $start = $settings->nis_start_number ?? 1; // default 1
    //         $padding = $settings->nis_padding ?? 4; // default 4 (0001)
    //         $suffix = $settings->nis_suffix ?? ''; // default ''

    //         // cari semua NIS yang pernah ada, bukan cuma yang pakai format sekarang
    //         $lastNIS = Student::where('nis', 'REGEXP', '[0-9]+') // cari yang ada angka
    //             ->latest('id')
    //             ->value('nis');

    //         // ambil angka terakhir pakai regex
    //         preg_match('/\d+/', $lastNIS, $matches);
    //         $lastNumber = isset($matches[0]) ? (int) $matches[0] : null;

    //         // jika tidak ada data, pakai start number
    //         $newNumber = $lastNumber !== null ? $lastNumber + 1 : $start;

    //         // format sesuai padding
    //         $formattedNumber = str_pad($newNumber, $padding, '0', STR_PAD_LEFT);

    //         return "{$prefix}{$formattedNumber}{$suffix}";
    //     }
    // }
    // if (!function_exists('generateNIP')) {
    //     function generateNIP()
    //     {
    //         $settings = AppSetting::first();
    //         $prefix = $settings->nip_prefix ?? ''; // default ''
    //         $start = $settings->nip_start_number ?? 1; // default 1
    //         $padding = $settings->nip_padding ?? 4; // default 4 (0001)
    //         $suffix = $settings->nip_suffix ?? ''; // default ''

    //         // cari semua NIP yang pernah ada, bukan cuma yang pakai format sekarang
    //         $lastNIP = Teacher::where('nip', 'REGEXP', '[0-9]+') // cari yang ada angka
    //             ->latest('id')
    //             ->value('nip');

    //         // ambil angka terakhir pakai regex
    //         preg_match('/\d+/', $lastNIP, $matches);
    //         $lastNumber = isset($matches[0]) ? (int) $matches[0] : null;

    //         // jika tidak ada data, pakai start number
    //         $newNumber = $lastNumber !== null ? $lastNumber + 1 : $start;

    //         // format sesuai padding
    //         $formattedNumber = str_pad($newNumber, $padding, '0', STR_PAD_LEFT);

    //         return "{$prefix}{$formattedNumber}{$suffix}";
    //     }
    // }

    if (!function_exists('generateNIS')) {
        function generateNIS()
        {
            $settings = AppSetting::first();
            $prefix = $settings->nis_prefix ?? '';
            $start = $settings->nis_start_number ?? 1;
            $padding = $settings->nis_padding ?? 4;
            $suffix = $settings->nis_suffix ?? '';

            // Ambil SEMUA NIS yang mengandung angka
            $allNIS = Student::pluck('nis');

            $maxNumber = $start - 1; // Inisialisasi dengan start-1

            foreach ($allNIS as $nis) {
                if (preg_match('/(\d+)/', $nis, $matches)) {
                    $num = (int)$matches[1];
                    if ($num > $maxNumber) {
                        $maxNumber = $num;
                    }
                }
            }

            $newNumber = $maxNumber + 1;
            $formattedNumber = str_pad($newNumber, $padding, '0', STR_PAD_LEFT);

            return "{$prefix}{$formattedNumber}{$suffix}";
        }
    }

    if (!function_exists('generateNIP')) {
        function generateNIP()
        {
            $settings = AppSetting::first();
            $prefix = $settings->nip_prefix ?? '';
            $start = $settings->nip_start_number ?? 1;
            $padding = $settings->nip_padding ?? 4;
            $suffix = $settings->nip_suffix ?? '';

            // Ambil SEMUA NIP yang mengandung angka
            $allNIP = Teacher::pluck('nip');

            $maxNumber = $start - 1; // Inisialisasi dengan start-1

            foreach ($allNIP as $nip) {
                if (preg_match('/(\d+)/', $nip, $matches)) {
                    $num = (int)$matches[1];
                    if ($num > $maxNumber) {
                        $maxNumber = $num;
                    }
                }
            }

            $newNumber = $maxNumber + 1;
            $formattedNumber = str_pad($newNumber, $padding, '0', STR_PAD_LEFT);

            return "{$prefix}{$formattedNumber}{$suffix}";
        }
    }
}
