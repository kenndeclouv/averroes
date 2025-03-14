<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Process;

class GenerateHash extends Command
{
    protected $signature = 'generate:hash {password}';
    protected $description = 'Generate hashed password and show it to terminal';

    public function handle()
    {
        $password = $this->argument('password');
        if (empty($password)) {
            $this->error('Password tidak boleh kosong!');
            return;
        }
        $hashedPassword = Hash::make($password);

        $this->info('Password berhasil dihash!');
        $this->info("Password: $password");
        $this->info("Hashed Password: $hashedPassword");

        // Copy to clipboard based on OS
        if (PHP_OS_FAMILY === 'Darwin') {
            Process::run("echo '$hashedPassword' | pbcopy");
        } elseif (PHP_OS_FAMILY === 'Windows') {
            Process::run("echo $hashedPassword | clip");
        } elseif (PHP_OS_FAMILY === 'Linux') {
            Process::run("echo '$hashedPassword' | xclip -selection clipboard");
        }

        $this->info('Password berhasil disalin ke clipboard!');
    }
}
