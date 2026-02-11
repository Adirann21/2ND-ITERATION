# Environment-Based Encryption Setup Guide

## Overview

Your Campus Reserve application uses AES-256-CBC encryption with environment-specific keys. This ensures:
- **Local development** has its own encryption key
- **Staging environment** has its own key (doesn't share data with production)
- **Production** has its own highly-secure key

## File Structure

```
/vercel/share/v0-project/
├── .env                 # Current environment config (DO NOT COMMIT)
├── .env.example         # Template for new developers
├── .env.local           # Development environment with test key
├── .env.staging         # Staging environment configuration
├── .env.production       # Production environment configuration
└── laravel-templates/
    ├── app/
    │   ├── Models/
    │   │   ├── User.php              # Encrypts: name, email
    │   │   └── SavedCredential.php   # Encrypts: username, password, site_url
    │   └── Http/Controllers/
    └── config/
        └── app.php                    # Uses APP_KEY from .env
```

## Setup Instructions

### 1. Local Development Setup

```bash
# Copy local environment file
cp .env.local .env

# Generate a new local key
php artisan key:generate --env=local

# Run migrations
php artisan migrate

# Seed sample facilities
php artisan db:seed --class=FacilitySeeder
```

### 2. For Your Team (New Developers)

New developers should:
```bash
# Copy the example file
cp .env.example .env

# Generate their own development key
php artisan key:generate

# Setup database
php artisan migrate:fresh --seed
```

### 3. Staging Deployment

```bash
# Use staging environment file
cp .env.staging .env

# Update with actual staging database credentials
# Edit .env and set:
# - DB_HOST, DB_USERNAME, DB_PASSWORD (staging database)
# - MAIL credentials (your staging email provider)

# Generate staging key (or use existing from .env.staging)
php artisan key:generate --env=staging

# Run migrations on staging database
php artisan migrate
```

### 4. Production Deployment

```bash
# Use production environment file
cp .env.production .env

# IMPORTANT: Store APP_KEY in a secure vault:
# - AWS Secrets Manager
# - HashiCorp Vault
# - Environment variable from deployment platform

# Set environment variables
export APP_KEY=base64:xxxxxxxxxxxxx
export DB_PASSWORD=your_secure_password

# Run migrations
php artisan migrate

# Clear caches
php artisan cache:clear
php artisan config:clear
```

## Encryption Points

### User Model (`laravel-templates/app/Models/User.php`)
Automatically encrypts on save and decrypts on retrieve:
```php
// When saving
$user = User::create([
    'name' => 'John Doe',      // Stored encrypted in DB
    'email' => 'john@example.com'  // Stored encrypted in DB
]);

// When retrieving
echo $user->name;  // Automatically decrypts: "John Doe"
```

### SavedCredential Model (`laravel-templates/app/Models/SavedCredential.php`)
Encrypts sensitive credential data:
```php
SavedCredential::create([
    'site_name' => 'Gmail',
    'username' => 'user@gmail.com',      // Encrypted
    'password' => 'SecurePassword123',   // Encrypted
    'site_url' => 'https://gmail.com'    // Encrypted
]);
```

## Key Management

### View Current Key
```bash
# In Laravel Tinker
php artisan tinker
>>> config('app.key')
base64:K9jV8sL2mN5pQ7rT1uW3xY6zA4bC0dE8fG2hI4jK6lM=
```

### Generate New Keys Per Environment

```bash
# Local key
php artisan key:generate --env=local

# Staging key
php artisan key:generate --env=staging

# Production key (keep in secure vault)
php artisan key:generate --env=production
```

### Rotate Keys (Emergency)

If a key is compromised:

1. **Generate a new key**
   ```bash
   php artisan key:generate --env=production
   ```

2. **Re-encrypt all data** (create a command for this)
   ```php
   // Create app/Console/Commands/RotateEncryptionKey.php
   ```

3. **Update vault with new key**

## Testing Encryption

Visit `/demo/encryption` (when logged in) to see:
- Live encryption/decryption demo
- How AES-256-CBC works
- Example code implementation

## Troubleshooting

### "The payload is invalid" error
- **Cause**: Using wrong APP_KEY to decrypt data
- **Fix**: Ensure .env has correct APP_KEY for current environment

### All encrypted data becomes unreadable
- **Cause**: APP_KEY changed without re-encrypting data
- **Fix**: Restore old APP_KEY from backup, then perform key rotation

### New user registration fails
- **Cause**: APP_KEY not set in .env
- **Fix**: Run `php artisan key:generate`

## Security Checklist

- [ ] Never commit `.env` file to Git
- [ ] Never commit `.env.production` with real keys
- [ ] Use environment variables for production APP_KEY
- [ ] Regularly rotate keys in production
- [ ] Backup old keys before rotation
- [ ] Test encryption/decryption after key changes
- [ ] Monitor for decryption errors in logs

## For Your Capstone

When presenting this system, explain:

1. **Why environment-specific keys?**
   - Production data can't be decrypted with staging key
   - Prevents accidental data leaks between environments

2. **How does AES-256-CBC work?**
   - 256-bit key, 16-byte IV, 14 rounds of transformation
   - Results in unreadable ciphertext without correct key

3. **Where is encryption applied?**
   - User names/emails automatically encrypted
   - Saved credentials fully encrypted
   - Database stores only ciphertext
