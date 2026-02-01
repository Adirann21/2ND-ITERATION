<?php

namespace App\Demo;

use Illuminate\Support\Facades\Crypt;

/**
 * Laravel's Built-in Encryption Demo
 * 
 * This shows how the SavedCredential model in the Campus Reserve System
 * uses Laravel's Crypt facade for automatic AES-256-CBC encryption.
 */
class LaravelCryptDemo
{
    /**
     * =========================================
     * LARAVEL'S APPROACH (What your app uses)
     * =========================================
     * 
     * Laravel's Crypt facade simplifies encryption by:
     * 1. Using APP_KEY from .env as the secret key (auto-generated)
     * 2. Automatically handling IV generation
     * 3. Adding MAC (Message Authentication Code) for integrity
     * 4. Encoding everything in a transportable format
     */

    public static function runDemo(): void
    {
        echo "╔══════════════════════════════════════════════════════════════╗\n";
        echo "║   LARAVEL CRYPT FACADE DEMO - Used in SavedCredential Model  ║\n";
        echo "╚══════════════════════════════════════════════════════════════╝\n\n";

        // Sample credential data
        $credential = [
            'site_name' => 'University Portal',
            'username'  => 'maria.santos@campus.edu',
            'password'  => 'SuperSecret@2024!'
        ];

        echo "▶ ORIGINAL DATA (Before storage)\n";
        echo "─────────────────────────────────────────────────────────────────\n";
        foreach ($credential as $field => $value) {
            echo "  {$field}: {$value}\n";
        }

        echo "\n▶ ENCRYPTED DATA (Stored in database)\n";
        echo "─────────────────────────────────────────────────────────────────\n";
        
        $encrypted = [];
        foreach ($credential as $field => $value) {
            // This is what happens in SavedCredential's setPasswordAttribute()
            $encrypted[$field] = Crypt::encryptString($value);
            echo "  {$field}:\n";
            echo "    " . substr($encrypted[$field], 0, 60) . "...\n\n";
        }

        echo "▶ DECRYPTED DATA (When retrieved from database)\n";
        echo "─────────────────────────────────────────────────────────────────\n";
        
        foreach ($encrypted as $field => $ciphertext) {
            // This is what happens in SavedCredential's getPasswordAttribute()
            $decrypted = Crypt::decryptString($ciphertext);
            echo "  {$field}: {$decrypted}\n";
        }

        echo "\n═══════════════════════════════════════════════════════════════\n";
        echo "This is exactly how SavedCredential model protects user data!\n";
        echo "═══════════════════════════════════════════════════════════════\n";
    }
}
