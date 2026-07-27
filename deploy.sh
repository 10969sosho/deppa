#!/bin/bash

set -e

REPO_DIR="/home/alurelab/repositories/deppa"
TARGET_DIR="/home/alurelab/games.alureflow.com"
BRANCH="main"
COMPOSER="/home/alurelab/composer.phar"

echo "========================================"
echo "  Deploying DEPPA — Game Edukasi"
echo "  Branch : $BRANCH"
echo "  Target : $TARGET_DIR"
echo "========================================"

echo ""
echo "[1/7] Pulling latest code..."
cd "$REPO_DIR"
git checkout "$BRANCH"
git pull origin "$BRANCH"

echo ""
echo "[2/7] Syncing files to target directory..."
for f in "$REPO_DIR"/* "$REPO_DIR"/.[!.]* "$REPO_DIR"/.[!.].[!.]*; do
    base=$(basename "$f")
    case "$base" in
        .git|.gitignore|node_modules|vendor)
            continue
            ;;
    esac
    [ -e "$f" ] && cp -a "$f" "$TARGET_DIR/"
done
rm -rf "$TARGET_DIR/storage/framework/cache/data/" 2>/dev/null || true
rm -rf "$TARGET_DIR/storage/framework/sessions/" 2>/dev/null || true
rm -rf "$TARGET_DIR/storage/framework/views/" 2>/dev/null || true
rm -rf "$TARGET_DIR/storage/logs/" 2>/dev/null || true

echo ""
echo "[3/7] Setting up storage link..."
cd "$TARGET_DIR"
/usr/local/bin/php artisan storage:link --force 2>/dev/null || true

echo ""
echo "[4/7] Installing Composer dependencies..."
if [ -f "$TARGET_DIR/composer.lock" ]; then
    cd "$TARGET_DIR" && /usr/local/bin/php "$COMPOSER" install --no-dev --optimize-autoloader --no-interaction
else
    cd "$TARGET_DIR" && /usr/local/bin/php "$COMPOSER" install --no-interaction
fi

echo ""
echo "[5/7] Optimizing Laravel..."
cd "$TARGET_DIR"
/usr/local/bin/php artisan optimize:clear 2>/dev/null || true
/usr/local/bin/php artisan config:cache 2>/dev/null || true
/usr/local/bin/php artisan route:cache 2>/dev/null || true

echo ""
echo "[6/7] Setting permissions..."
chmod -R 775 "$TARGET_DIR/storage"
chmod -R 775 "$TARGET_DIR/bootstrap/cache"
if [ -d "$TARGET_DIR/public/storage" ]; then
    chmod -R 775 "$TARGET_DIR/public/storage"
fi

echo ""
if [ ! -f "$TARGET_DIR/.env" ]; then
    echo "  ⚠️  .env file not found! Copying from .env.example..."
    cp "$TARGET_DIR/.env.example" "$TARGET_DIR/.env"
    echo "  ⚠️  Please edit $TARGET_DIR/.env with your database credentials!"
fi

echo ""
echo "[7/7] Running database migrations..."
cd "$TARGET_DIR"
/usr/local/bin/php artisan migrate --force 2>/dev/null || echo "  ⚠️  Migration skipped or failed"

echo ""
echo "========================================"
echo "  ✅ Deploy complete!"
echo "  Target: $TARGET_DIR"
echo "========================================"
