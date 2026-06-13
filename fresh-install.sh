#!/bin/bash
# =============================================================================
#  On Point Luxury — Fresh Install / Dev Reset Script
#
#  ⚠️  WARNING: THIS SCRIPT DROPS ALL DATABASE DATA.
#  Use ONLY in local development environments.
#  NEVER run on production servers.
# =============================================================================

set -e

echo ""
echo "⚠️  WARNING: This will WIPE all database data and re-seed."
echo "   Use only in local/dev environments."
echo ""
read -p "Type 'yes' to confirm: " CONFIRM

if [ "$CONFIRM" != "yes" ]; then
    echo "Aborted."
    exit 0
fi

echo ""
echo "============================================="
echo "  Fresh Install Starting"
echo "============================================="

# Clear caches first
php artisan optimize:clear

# Drop all tables and re-run all migrations, then seed
php artisan migrate:fresh --seed --force

# Create storage symlink
php artisan storage:link || true

# Clear compiled views
php artisan view:clear

echo ""
echo "============================================="
echo "  Fresh Install Complete!"
echo "============================================="
echo ""
echo "  Login Credentials:"
echo "  Admin:   admin@onpointluxury.com / password"
echo "  Manager: manager@onpointluxury.com / password"
echo "  Client:  client@onpointluxury.com / password"
echo "============================================="
