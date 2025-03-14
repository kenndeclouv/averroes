<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class EnvController extends Controller
{
    public function index()
    {
        $envPath = base_path('.env');

        // Check if the server allows viewing and editing the .env file
        if (!File::exists($envPath) || !is_writable($envPath)) {
            return back()->with('warning', 'Server tidak mengizinkan melihat atau mengedit file .env.');
        }

        $envContent = File::get($envPath);

        // ubah isi .env jadi array key-value
        $envLines = explode("\n", $envContent);
        $envData = [];

        foreach ($envLines as $line) {
            // skip line yang kosong
            $blackList = ['APP_HASHED_MASTER_PASSWORD'];
            foreach ($blackList as $blackItem) {
                if (strpos($line, $blackItem) === 0) {
                    continue 2;
                }
            }
            if (strpos($line, '=') !== false) {
                [$key, $value] = explode('=', $line, 2);
                $envData[$key] = str_replace('"', '', trim($value)); // remove all " from incoming env
            }
        }

        return view('roles.SuperAdmin.env.index', compact('envData'));
    }

    public function update(Request $request)
    {
        $envPath = base_path('.env');
        $envLines = file($envPath, FILE_IGNORE_NEW_LINES);

        // Validate the password before updating
        $request->validate([
            'password' => 'required|string',
        ], [
            'password.required' => 'Password tidak boleh kosong',
            'password.string' => 'Password harus berupa string',
        ]);

        $hashedPassword = env('APP_HASHED_MASTER_PASSWORD');

        // Cek password yang dimasukkan
        if (!Hash::check($request->input('password'), $hashedPassword)) {
            return back()->with('error', 'Password salah.');
        }

        // Proses update tanpa menghapus baris kosong atau komentar
        $newEnvLines = [];
        $updatedKeys = $request->except('_token', '_method', 'password');

        foreach ($envLines as $line) {
            if (strpos($line, '=') !== false) {
                [$key, $val] = explode('=', $line, 2);
                $key = trim($key);

                if (array_key_exists($key, $updatedKeys)) {
                    $line = $key . '="' . trim($updatedKeys[$key]) . '"';
                    unset($updatedKeys[$key]); // Supaya tidak ditulis ulang di bawah
                }
            }
            $newEnvLines[] = $line;
        }

        // Tambahin key baru kalau ada yang belum ada di .env
        foreach ($updatedKeys as $key => $value) {
            $newEnvLines[] = $key . '="' . trim($value) . '"';
        }

        // Pastikan APP_HASHED_MASTER_PASSWORD tetap ada
        if (!in_array('APP_HASHED_MASTER_PASSWORD="' . $hashedPassword . '"', $newEnvLines)) {
            $newEnvLines[] = 'APP_HASHED_MASTER_PASSWORD="' . $hashedPassword . '"';
        }

        try {
            File::put($envPath, implode(PHP_EOL, $newEnvLines) . PHP_EOL);
            return back()->with('success', 'Berhasil update .env');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal update .env: ' . $e->getMessage());
        }
    }
}
