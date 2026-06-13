#!/bin/bash
# =============================================================================
#  On Point Luxury — Production Deployment Script
#  Usage: bash deploy.sh
#  Safe to run multiple times (idempotent)
# =============================================================================

set -e

echo ""
echo "============================================="
echo "  On Point Luxury — Deployment Starting"
echo "============================================="
echo ""

# ---------------------------------------------------------------------------
# 1. Install PHP dependencies (production only, optimised autoloader)
# ---------------------------------------------------------------------------
echo "[1/9] Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

# ---------------------------------------------------------------------------
# 2. Put application into maintenance mode
# ---------------------------------------------------------------------------
echo "[2/9] Enabling maintenance mode..."
php artisan down --render="errors.503" || true

# ---------------------------------------------------------------------------
# 3. Clear all caches
# ---------------------------------------------------------------------------
echo "[3/9] Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear

# ---------------------------------------------------------------------------
# 4. Run database migrations
# ---------------------------------------------------------------------------
echo "[4/9] Running migrations..."
php artisan migrate --force

# ---------------------------------------------------------------------------
# 5. Seed database (safe — seeder uses updateOrCreate, idempotent)
# ---------------------------------------------------------------------------
echo "[5/9] Seeding database..."
php artisan db:seed --force

# ---------------------------------------------------------------------------
# 6. Create storage symlink (graceful if already exists)
# ---------------------------------------------------------------------------
echo "[6/9] Linking storage..."
php artisan storage:link || true

# ---------------------------------------------------------------------------
# 7. Rebuild caches for production performance
# ---------------------------------------------------------------------------
echo "[7/9] Caching config, routes, and views..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# ---------------------------------------------------------------------------
# 8. Set permissions (adjust paths for your server if needed)
# ---------------------------------------------------------------------------
echo "[8/9] Setting file permissions..."
chmod -R 775 storage bootstrap/cache 2>/dev/null || true
chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true

# ---------------------------------------------------------------------------
# 9. Bring application back online
# ---------------------------------------------------------------------------
echo "[9/9] Taking application out of maintenance mode..."
php artisan up

echo ""
echo "============================================="
echo "  Deployment Complete!"
echo "============================================="
echo ""
echo "  Login Credentials:"
echo "  Admin:   admin@onpointluxury.com / password"
echo "  Manager: manager@onpointluxury.com / password"
echo "  Client:  client@onpointluxury.com / password"
echo ""
echo "  IMPORTANT: Change all passwords after first login."
echo "  IMPORTANT: Set real Paystack keys in Admin > Settings > Paystack."
echo "  IMPORTANT: Configure SMTP in Admin > Settings > SMTP."
echo "============================================="
