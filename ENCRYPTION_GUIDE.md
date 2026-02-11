# Campus Reserve - Environment-Based Encryption Key Management

## Overview

This guide explains how to manage **environment-specific APP_KEY** values for AES-256-CBC encryption in your Campus Reserve system.

---

## Why Environment-Based Keys?

| Aspect | Benefit |
|--------|---------|
| **Security** | Different keys for each environment prevent key exposure |
| **Data Isolation** | Production encrypted data cannot be accessed from staging/local |
| **Compliance** | Follows industry best practices (PCI-DSS, HIPAA, etc.) |
| **Flexibility** | Easy to rotate keys without affecting other environments |

---

## File Structure

```
project/
├── .env.example          # Template - no real keys
├── .env.local           # Development key (committed to git)
├── .env.staging         # Staging key (keep secret)
├── .env.production      # Production key (SECURE VAULT ONLY)
└── .env                 # Symlink/copy to environment-specific file
```

---

## Setup Instructions

### Step 1: Choose Your Environment

The APP_KEY comes from whichever `.env.*` file you're using:

```bash
# For local development (already has a key)
cp .env.local .env

# For staging
cp .env.staging .env

# For production (see Step 2)
cp .env.production .env
```

### Step 2: Generate New Keys

#### Local Development (First Time)
```bash
php artisan key:generate --env=local
```

This will:
- Generate a random 32-byte (256-bit) key
- Output: `base64:xxxxxxxxxxxxxxxxxxxxxx`
- Store it in `.env.local`

#### Staging Environment
```bash
php artisan key:generate --env=staging
```

Then update `.env.staging` with the generated key.

#### Production Environment (CRITICAL)
```bash
php artisan key:generate --env=production
```

**IMPORTANT:** 
- Do NOT store `.env.production` in Git
- Store the APP_KEY in a secure vault:
  - **AWS:** AWS Secrets Manager
  - **HashiCorp:** Vault
  - **Azure:** Key Vault
  - **Vercel:** Environment Variables (Settings > Environment Variables)

---

## How It Works

### Encryption Flow

```
User Input (plain text)
    ↓
Eloquent Model Mutator
    ↓
Crypt::encryptString(data)
    ↓
Uses APP_KEY from .env
    ↓
AES-256-CBC Algorithm
    ↓
Database Storage (ciphertext)
```

### Decryption Flow

```
Database Storage (ciphertext)
    ↓
Eloquent Model Accessor
    ↓
Crypt::decryptString(data)
    ↓
Uses same APP_KEY from .env
    ↓
Returns plain text to application
```

### Example

```php
// Saving a credential (automatic encryption)
SavedCredential::create([
    'password' => 'MySecret123'  // Plain text input
]);
// Stored in DB as: eyJpdiI6IkxKN3hDN1M3d0dxVzl...

// Retrieving a credential (automatic decryption)
$credential = SavedCredential::find(1);
echo $credential->password;  // Outputs: "MySecret123" (decrypted)
```

---

## Which Fields Are Encrypted?

### User Model
- `name`
- `email`

### SavedCredential Model
- `site_name`
- `site_url`
- `username`
- `password`
- `notes`

### Encryption is Automatic
You don't need to call encryption functions manually - just use the models normally.

---

## Key Rotation

### Why Rotate?
- Periodic security updates
- If a key is compromised
- Compliance requirements

### How to Rotate

#### Step 1: Create New Key
```bash
php artisan key:generate --env=production
```

#### Step 2: Deploy New Key
Update your vault (AWS Secrets Manager, etc.)

#### Step 3: Re-encrypt Existing Data
Create a command to decrypt all data with old key, then re-encrypt with new:

```php
php artisan make:command RotateEncryptionKey
```

```php
// In the command
foreach (User::all() as $user) {
    $user->save();  // Forces re-encryption with new APP_KEY
}

foreach (SavedCredential::all() as $cred) {
    $cred->save();  // Forces re-encryption with new APP_KEY
}
```

#### Step 4: Run Migration
```bash
php artisan rotate-key
```

---

## Testing Encryption

### In Laravel Tinker
```php
php artisan tinker

# Test encryption
use Illuminate\Support\Facades\Crypt;
$encrypted = Crypt::encryptString('Hello World');

# Test decryption
$decrypted = Crypt::decryptString($encrypted);
echo $decrypted;  // Should output: "Hello World"

# View encrypted data in database
use App\Models\User;
$raw = \DB::table('users')->first();
echo $raw->name;  // Shows: eyJpdiI6IkxKN3...
```

---

## Security Checklist

- [ ] Generate unique keys for each environment
- [ ] **Never** commit `.env.production` to Git
- [ ] Store production key in secure vault
- [ ] Rotate keys periodically (annually recommended)
- [ ] Back up keys in case of key loss
- [ ] Use HTTPS for all data transmission
- [ ] Monitor unauthorized decryption attempts
- [ ] Document key rotation procedures

---

## Troubleshooting

### "Failed to decrypt" Error
**Problem:** Accessing data with wrong environment key
**Solution:** Make sure you're using the correct `.env` file for the environment

### Lost Production Key
**Problem:** Cannot decrypt production data
**Solution:** 
1. Check secure vault backup
2. If no backup, recover from database backups with old key
3. Rotate to new key

### Data Seems Encrypted But Can't Decrypt
**Problem:** Using old key to decrypt data encrypted with new key
**Solution:** Use the correct APP_KEY that encrypted the data

---

## References

- [Laravel Encryption Documentation](https://laravel.com/docs/encryption)
- [OWASP Encryption Guidelines](https://cheatsheetseries.owasp.org/cheatsheets/Cryptographic_Storage_Cheat_Sheet.html)
- [AES-256-CBC Explanation](https://en.wikipedia.org/wiki/Advanced_Encryption_Standard)
