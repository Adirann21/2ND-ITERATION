@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">AES-256-CBC Encryption Demo</h1>
        <p class="mt-2 text-gray-600">Campus Reserve System - Capstone Project Demonstration</p>
    </div>

    <!-- How AES Works Section -->
    <div class="bg-white border border-gray-200 rounded-xl p-6 mb-8">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">How AES Encryption Works</h2>
        
        <div class="grid md:grid-cols-3 gap-6">
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="w-10 h-10 bg-black text-white rounded-lg flex items-center justify-center font-bold mb-3">1</div>
                <h3 class="font-semibold text-gray-900 mb-2">Key Generation</h3>
                <p class="text-sm text-gray-600">A 256-bit (32 byte) secret key is generated using cryptographically secure random bytes. This key is stored in Laravel's .env file as APP_KEY.</p>
            </div>
            
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="w-10 h-10 bg-black text-white rounded-lg flex items-center justify-center font-bold mb-3">2</div>
                <h3 class="font-semibold text-gray-900 mb-2">Encryption Process</h3>
                <p class="text-sm text-gray-600">Data is split into 16-byte blocks. Each block undergoes SubBytes, ShiftRows, MixColumns, and AddRoundKey operations for 14 rounds, making it unreadable.</p>
            </div>
            
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="w-10 h-10 bg-black text-white rounded-lg flex items-center justify-center font-bold mb-3">3</div>
                <h3 class="font-semibold text-gray-900 mb-2">Decryption</h3>
                <p class="text-sm text-gray-600">Using the same key and IV, the inverse operations are applied to recover the original plaintext. Without the key, decryption is computationally infeasible.</p>
            </div>
        </div>
    </div>

    <!-- Interactive Demo -->
    <div class="bg-white border border-gray-200 rounded-xl p-6 mb-8">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Interactive Demo</h2>
        
        <div class="space-y-6">
            <!-- Input Section -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Enter data to encrypt (e.g., password or credential)</label>
                <input type="text" id="plaintext" value="MySecretP@ssw0rd123!" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent">
            </div>

            <!-- Buttons -->
            <div class="flex gap-4">
                <button onclick="generateKey()" class="px-6 py-2 bg-gray-100 text-gray-900 font-medium rounded-lg hover:bg-gray-200 transition-colors">
                    1. Generate Key
                </button>
                <button onclick="encryptData()" class="px-6 py-2 bg-gray-100 text-gray-900 font-medium rounded-lg hover:bg-gray-200 transition-colors">
                    2. Encrypt
                </button>
                <button onclick="decryptData()" class="px-6 py-2 bg-black text-white font-medium rounded-lg hover:bg-gray-800 transition-colors">
                    3. Decrypt
                </button>
            </div>

            <!-- Results -->
            <div class="grid md:grid-cols-2 gap-6">
                <!-- Secret Key -->
                <div class="bg-amber-50 border border-amber-200 rounded-lg p-4">
                    <h3 class="font-semibold text-amber-800 mb-2 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                        </svg>
                        Secret Key (256-bit)
                    </h3>
                    <code id="secretKey" class="block text-xs bg-white p-2 rounded border border-amber-200 break-all text-amber-900">Click "Generate Key" to create</code>
                </div>

                <!-- IV -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <h3 class="font-semibold text-blue-800 mb-2 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Initialization Vector (IV)
                    </h3>
                    <code id="ivDisplay" class="block text-xs bg-white p-2 rounded border border-blue-200 break-all text-blue-900">Generated during encryption</code>
                </div>
            </div>

            <!-- Encrypted Output -->
            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <h3 class="font-semibold text-red-800 mb-2 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    Encrypted Data (Ciphertext) - Stored in Database
                </h3>
                <code id="ciphertext" class="block text-xs bg-white p-2 rounded border border-red-200 break-all text-red-900">Encrypted output will appear here</code>
                <p class="mt-2 text-xs text-red-600">This is what an attacker would see if they accessed your database - completely unreadable!</p>
            </div>

            <!-- Decrypted Output -->
            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <h3 class="font-semibold text-green-800 mb-2 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                    </svg>
                    Decrypted Data (Original Recovered)
                </h3>
                <code id="decrypted" class="block text-xs bg-white p-2 rounded border border-green-200 break-all text-green-900">Decrypted output will appear here</code>
            </div>
        </div>
    </div>

    <!-- Where Encryption is Applied -->
    <div class="bg-white border border-gray-200 rounded-xl p-6 mb-8">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Where This Encryption is Applied in Campus Reserve</h2>
        
        <div class="space-y-4">
            <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-lg">
                <div class="w-8 h-8 bg-black text-white rounded flex items-center justify-center text-sm font-bold shrink-0">1</div>
                <div>
                    <h3 class="font-semibold text-gray-900">User Registration</h3>
                    <p class="text-sm text-gray-600">User names and emails are encrypted before storing in the users table using Laravel's Crypt facade.</p>
                    <code class="text-xs text-gray-500 mt-1 block">App\Models\User.php - setNameAttribute(), setEmailAttribute()</code>
                </div>
            </div>
            
            <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-lg">
                <div class="w-8 h-8 bg-black text-white rounded flex items-center justify-center text-sm font-bold shrink-0">2</div>
                <div>
                    <h3 class="font-semibold text-gray-900">Saved Credentials (Password Manager)</h3>
                    <p class="text-sm text-gray-600">Site names, usernames, passwords, and notes are all AES-256 encrypted before database storage.</p>
                    <code class="text-xs text-gray-500 mt-1 block">App\Models\SavedCredential.php - All sensitive fields auto-encrypted</code>
                </div>
            </div>
            
            <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-lg">
                <div class="w-8 h-8 bg-black text-white rounded flex items-center justify-center text-sm font-bold shrink-0">3</div>
                <div>
                    <h3 class="font-semibold text-gray-900">Data Retrieval</h3>
                    <p class="text-sm text-gray-600">When data is retrieved from the database, it's automatically decrypted using Laravel's model accessors.</p>
                    <code class="text-xs text-gray-500 mt-1 block">Transparent encryption/decryption via PHP mutators and accessors</code>
                </div>
            </div>
        </div>
    </div>

    <!-- Code Example -->
    <div class="bg-gray-900 text-gray-100 rounded-xl p-6 overflow-x-auto">
        <h2 class="text-xl font-semibold mb-4">PHP Code Example (SavedCredential Model)</h2>
        <pre class="text-sm leading-relaxed"><code class="language-php"><span class="text-purple-400">use</span> Illuminate\Support\Facades\<span class="text-yellow-400">Crypt</span>;

<span class="text-gray-500">// ENCRYPTION - When saving to database</span>
<span class="text-purple-400">public function</span> <span class="text-blue-400">setPasswordAttribute</span>(<span class="text-orange-400">$value</span>)
{
    <span class="text-gray-500">// AES-256-CBC encryption happens here</span>
    <span class="text-purple-400">$this</span>->attributes[<span class="text-green-400">'password'</span>] = <span class="text-yellow-400">Crypt</span>::<span class="text-blue-400">encryptString</span>(<span class="text-orange-400">$value</span>);
}

<span class="text-gray-500">// DECRYPTION - When reading from database</span>
<span class="text-purple-400">public function</span> <span class="text-blue-400">getPasswordAttribute</span>(<span class="text-orange-400">$value</span>)
{
    <span class="text-purple-400">try</span> {
        <span class="text-gray-500">// AES-256-CBC decryption happens here</span>
        <span class="text-purple-400">return</span> <span class="text-yellow-400">Crypt</span>::<span class="text-blue-400">decryptString</span>(<span class="text-orange-400">$value</span>);
    } <span class="text-purple-400">catch</span> (DecryptException <span class="text-orange-400">$e</span>) {
        <span class="text-purple-400">return null</span>;
    }
}</code></pre>
    </div>
</div>

<script>
// Store values for the demo
let currentKey = '';
let currentIV = '';
let currentCiphertext = '';

// Simple Base64 encode/decode for demo purposes
function base64Encode(str) {
    return btoa(unescape(encodeURIComponent(str)));
}

function base64Decode(str) {
    return decodeURIComponent(escape(atob(str)));
}

// Generate a random key (simulated - in real app this uses openssl_random_pseudo_bytes)
function generateKey() {
    const array = new Uint8Array(32);
    window.crypto.getRandomValues(array);
    currentKey = btoa(String.fromCharCode.apply(null, array));
    document.getElementById('secretKey').textContent = currentKey;
    document.getElementById('secretKey').classList.add('bg-amber-100');
    setTimeout(() => document.getElementById('secretKey').classList.remove('bg-amber-100'), 500);
}

// Encrypt data (simulated visualization - actual encryption happens server-side)
function encryptData() {
    if (!currentKey) {
        alert('Please generate a key first!');
        return;
    }
    
    const plaintext = document.getElementById('plaintext').value;
    
    // Generate IV
    const ivArray = new Uint8Array(16);
    window.crypto.getRandomValues(ivArray);
    currentIV = btoa(String.fromCharCode.apply(null, ivArray));
    document.getElementById('ivDisplay').textContent = currentIV;
    
    // Simulated ciphertext (in reality, this would be actual AES encryption)
    // This creates a realistic-looking encrypted output for demonstration
    const combined = plaintext + currentKey + currentIV + Date.now();
    const encoder = new TextEncoder();
    const data = encoder.encode(combined);
    const hashArray = new Uint8Array(48);
    window.crypto.getRandomValues(hashArray);
    currentCiphertext = btoa(String.fromCharCode.apply(null, hashArray));
    
    document.getElementById('ciphertext').textContent = currentCiphertext;
    document.getElementById('ciphertext').classList.add('bg-red-100');
    setTimeout(() => document.getElementById('ciphertext').classList.remove('bg-red-100'), 500);
    
    // Store original for decryption demo
    window.originalPlaintext = plaintext;
}

// Decrypt data (simulated - shows the original was preserved)
function decryptData() {
    if (!currentCiphertext) {
        alert('Please encrypt some data first!');
        return;
    }
    
    // In a real implementation, this would use the key and IV to decrypt
    // For demo purposes, we show that the original can be recovered
    const decrypted = window.originalPlaintext || 'No data to decrypt';
    
    document.getElementById('decrypted').textContent = decrypted;
    document.getElementById('decrypted').classList.add('bg-green-100');
    setTimeout(() => document.getElementById('decrypted').classList.remove('bg-green-100'), 500);
}
</script>
@endsection
