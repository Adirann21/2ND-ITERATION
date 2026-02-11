#!/bin/bash

# Campus Reserve - Environment Encryption Setup Script
# This script sets up environment-specific encryption keys

echo "================================"
echo "Campus Reserve - Encryption Setup"
echo "================================"
echo ""

# Check if Laravel is installed
if [ ! -f "artisan" ]; then
    echo "❌ Laravel not found. Make sure you're in the project root."
    exit 1
fi

# Ask user for environment
echo "Which environment are you setting up?"
echo "1) Local (Development)"
echo "2) Staging"
echo "3) Production"
read -p "Enter choice [1-3]: " env_choice

case $env_choice in
    1)
        ENV="local"
        ENV_FILE=".env.local"
        echo "📁 Setting up LOCAL environment..."
        ;;
    2)
        ENV="staging"
        ENV_FILE=".env.staging"
        echo "📁 Setting up STAGING environment..."
        ;;
    3)
        ENV="production"
        ENV_FILE=".env.production"
        echo "📁 Setting up PRODUCTION environment..."
        ;;
    *)
        echo "❌ Invalid choice"
        exit 1
        ;;
esac

# Copy environment file
if [ ! -f ".env" ]; then
    echo "📋 Copying $ENV_FILE to .env..."
    cp "$ENV_FILE" .env
    echo "✅ Environment file copied"
else
    echo "⚠️  .env already exists. Skipping copy."
fi

# Generate encryption key
echo ""
echo "🔐 Generating AES-256-CBC encryption key for $ENV..."
php artisan key:generate --env=$ENV
echo "✅ Key generated"

# Show the key
echo ""
echo "🔑 Your encryption key:"
php artisan tinker --execute="echo config('app.key');"

echo ""
echo "================================"
echo "✅ Encryption setup complete!"
echo "================================"
echo ""
echo "Next steps:"
echo "1. Update database credentials in .env"
echo "2. Run: php artisan migrate"
echo "3. Run: php artisan db:seed --class=FacilitySeeder"
echo ""
echo "For production:"
echo "- Store APP_KEY in your vault (AWS Secrets Manager, etc)"
echo "- Never commit .env to Git"
echo ""
