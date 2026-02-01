<?php

namespace App\Demo;

/**
 * AES-256-CBC Encryption Demo
 * 
 * This demo demonstrates symmetric encryption using AES (Advanced Encryption Standard)
 * for the Campus Reserve System capstone project.
 * 
 * Programming Language: PHP 8.x with Laravel Framework
 */
class AESEncryptionDemo
{
    /**
     * =========================================
     * PART 1: KEY GENERATION
     * =========================================
     * 
     * AES-256 requires a 256-bit (32 byte) secret key.
     * This key is used for BOTH encryption AND decryption (symmetric).
     * 
     * In Laravel, this key is stored in .env as APP_KEY and is
     * automatically generated using: php artisan key:generate
     */
    public static function generateSecretKey(): string
    {
        // Generate a cryptographically secure random 32-byte key
        // openssl_random_pseudo_bytes() generates random bytes suitable for cryptographic use
        $key = openssl_random_pseudo_bytes(32);
        
        // Convert to base64 for safe storage/display
        return base64_encode($key);
    }

    /**
     * =========================================
     * PART 2: ENCRYPTION
     * =========================================
     * 
     * AES-256-CBC encrypts data using:
     * - The secret key (256 bits)
     * - An Initialization Vector (IV) - 16 bytes of random data
     * - CBC mode (Cipher Block Chaining) - each block depends on the previous
     * 
     * How it hides data:
     * 1. Data is split into 16-byte blocks
     * 2. Each block is XORed with the previous encrypted block (or IV for first block)
     * 3. The result is encrypted using the key through multiple rounds of:
     *    - SubBytes (substitution)
     *    - ShiftRows (transposition)
     *    - MixColumns (mixing)
     *    - AddRoundKey (XOR with key)
     * 4. Output is unreadable ciphertext
     */
    public static function encrypt(string $plaintext, string $base64Key): array
    {
        // Decode the base64 key back to binary
        $key = base64_decode($base64Key);
        
        // Generate a random 16-byte Initialization Vector (IV)
        // IV ensures same plaintext encrypts to different ciphertext each time
        $iv = openssl_random_pseudo_bytes(16);
        
        // Encrypt using AES-256-CBC
        // - 'aes-256-cbc': Algorithm (AES with 256-bit key in CBC mode)
        // - OPENSSL_RAW_DATA: Return raw binary data
        $ciphertext = openssl_encrypt(
            $plaintext,           // Data to encrypt
            'aes-256-cbc',        // Cipher method
            $key,                 // Secret key
            OPENSSL_RAW_DATA,     // Options
            $iv                   // Initialization Vector
        );
        
        return [
            'ciphertext' => base64_encode($ciphertext),  // Encrypted data (base64 for safe storage)
            'iv' => base64_encode($iv),                   // IV needed for decryption
        ];
    }

    /**
     * =========================================
     * PART 3: DECRYPTION
     * =========================================
     * 
     * Decryption reverses the encryption process:
     * 1. Uses the SAME key that was used for encryption
     * 2. Uses the SAME IV that was generated during encryption
     * 3. Applies inverse operations (InvSubBytes, InvShiftRows, etc.)
     * 4. Recovers the original plaintext
     */
    public static function decrypt(string $base64Ciphertext, string $base64Key, string $base64Iv): string
    {
        // Decode all base64 values back to binary
        $ciphertext = base64_decode($base64Ciphertext);
        $key = base64_decode($base64Key);
        $iv = base64_decode($base64Iv);
        
        // Decrypt using the same algorithm, key, and IV
        $plaintext = openssl_decrypt(
            $ciphertext,          // Encrypted data
            'aes-256-cbc',        // Same cipher method
            $key,                 // Same secret key
            OPENSSL_RAW_DATA,     // Options
            $iv                   // Same IV used during encryption
        );
        
        return $plaintext;
    }

    /**
     * =========================================
     * COMPLETE DEMO - Run this to see it work
     * =========================================
     */
    public static function runDemo(): void
    {
        echo "╔══════════════════════════════════════════════════════════════╗\n";
        echo "║     AES-256-CBC ENCRYPTION DEMO - Campus Reserve System      ║\n";
        echo "╚══════════════════════════════════════════════════════════════╝\n\n";

        // ===== STEP 1: Generate Secret Key =====
        echo "▶ STEP 1: KEY GENERATION\n";
        echo "─────────────────────────────────────────────────────────────────\n";
        $secretKey = self::generateSecretKey();
        echo "Generated Secret Key (Base64): " . $secretKey . "\n";
        echo "Key Length: 256 bits (32 bytes)\n\n";

        // ===== STEP 2: Sample Data to Encrypt =====
        echo "▶ STEP 2: SAMPLE DATA (Credentials)\n";
        echo "─────────────────────────────────────────────────────────────────\n";
        
        // Example: User credentials being stored
        $sampleData = [
            'site_name' => 'Campus Portal',
            'username' => 'john.student@university.edu',
            'password' => 'MySecretP@ssw0rd123!'
        ];
        
        echo "Original Data:\n";
        echo "  Site Name: " . $sampleData['site_name'] . "\n";
        echo "  Username:  " . $sampleData['username'] . "\n";
        echo "  Password:  " . $sampleData['password'] . "\n\n";

        // ===== STEP 3: Encrypt Each Field =====
        echo "▶ STEP 3: ENCRYPTION (Data becomes unreadable)\n";
        echo "─────────────────────────────────────────────────────────────────\n";
        
        $encryptedData = [];
        foreach ($sampleData as $field => $value) {
            $encrypted = self::encrypt($value, $secretKey);
            $encryptedData[$field] = $encrypted;
            echo "  {$field}:\n";
            echo "    Ciphertext: " . substr($encrypted['ciphertext'], 0, 40) . "...\n";
            echo "    IV:         " . $encrypted['iv'] . "\n\n";
        }

        // ===== STEP 4: Show what's stored in database =====
        echo "▶ STEP 4: DATABASE STORAGE (What attackers would see)\n";
        echo "─────────────────────────────────────────────────────────────────\n";
        echo "If someone accesses the database, they see:\n";
        echo "┌─────────────────────────────────────────────────────────────┐\n";
        echo "│ site_name: " . substr($encryptedData['site_name']['ciphertext'], 0, 45) . "│\n";
        echo "│ username:  " . substr($encryptedData['username']['ciphertext'], 0, 45) . "│\n";
        echo "│ password:  " . substr($encryptedData['password']['ciphertext'], 0, 45) . "│\n";
        echo "└─────────────────────────────────────────────────────────────┘\n";
        echo "Without the secret key, this data is COMPLETELY UNREADABLE!\n\n";

        // ===== STEP 5: Decrypt to recover original data =====
        echo "▶ STEP 5: DECRYPTION (Recovering original data with key)\n";
        echo "─────────────────────────────────────────────────────────────────\n";
        
        foreach ($encryptedData as $field => $encrypted) {
            $decrypted = self::decrypt(
                $encrypted['ciphertext'],
                $secretKey,
                $encrypted['iv']
            );
            echo "  {$field}: {$decrypted}\n";
        }

        echo "\n═══════════════════════════════════════════════════════════════\n";
        echo "DEMO COMPLETE - Data successfully encrypted and decrypted!\n";
        echo "═══════════════════════════════════════════════════════════════\n";
    }
}


/**
 * =========================================
 * HOW TO RUN THIS DEMO
 * =========================================
 * 
 * Option 1: Via Laravel Tinker
 *   php artisan tinker
 *   \App\Demo\AESEncryptionDemo::runDemo();
 * 
 * Option 2: Create a route in routes/web.php
 *   Route::get('/demo/encryption', function() {
 *       \App\Demo\AESEncryptionDemo::runDemo();
 *   });
 * 
 * Option 3: Run from command line
 *   php -r "require 'vendor/autoload.php'; \App\Demo\AESEncryptionDemo::runDemo();"
 */
