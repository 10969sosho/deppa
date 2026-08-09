#!/bin/bash

set -e

REPO_DIR="/home/alurelab/repositories/deppa"
TARGET_DIR="/home/alurelab/games.alureflow.com"
BRANCH="main"
COMPOSER="/home/alurelab/.local/bin/composer"

echo "========================================"
echo "  Deploying DEPPA — Si Doel Smart Finance"
echo "  Branch : $BRANCH"
echo "  Target : $TARGET_DIR"
echo "========================================"

echo ""
echo "[1/8] Pulling latest code..."
cd "$REPO_DIR"
git checkout "$BRANCH"
git pull origin "$BRANCH"

echo ""
echo "[2/8] Syncing files to target directory..."
for f in "$REPO_DIR"/* "$REPO_DIR"/.[!.]* "$REPO_DIR"/.[!.].[!.]*; do
    base=$(basename "$f")
    case "$base" in
        .git|.gitignore|node_modules|vendor)
            continue
            ;;
    esac
    [ -e "$f" ] && cp -a "$f" "$TARGET_DIR/"
done
rm -rf "$TARGET_DIR/storage/logs/" 2>/dev/null || true

echo ""
echo "[3/8] Ensuring storage directories exist..."
mkdir -p "$TARGET_DIR/storage/framework/views"
mkdir -p "$TARGET_DIR/storage/framework/cache/data"
mkdir -p "$TARGET_DIR/storage/framework/sessions"

echo ""
echo "[4/8] Setting up storage link..."
cd "$TARGET_DIR"
/usr/local/bin/php artisan storage:link --force 2>/dev/null || true

echo ""
echo "[5/8] Installing Composer dependencies..."
if [ -f "$TARGET_DIR/composer.lock" ]; then
    cd "$TARGET_DIR" && /usr/local/bin/php "$COMPOSER" install --no-dev --optimize-autoloader --no-interaction
else
    cd "$TARGET_DIR" && /usr/local/bin/php "$COMPOSER" install --no-interaction
fi

echo ""
echo "[6/8] Optimizing Laravel..."
cd "$TARGET_DIR"
/usr/local/bin/php artisan optimize:clear 2>/dev/null || true
/usr/local/bin/php artisan config:cache 2>/dev/null || true
/usr/local/bin/php artisan route:cache 2>/dev/null || true

echo ""
echo "[7/8] Setting permissions..."
chmod -R 775 "$TARGET_DIR/storage"
chmod -R 775 "$TARGET_DIR/bootstrap/cache"
if [ -d "$TARGET_DIR/public/storage" ]; then
    chmod -R 775 "$TARGET_DIR/public/storage"
fi

echo ""
if [ ! -f "$TARGET_DIR/.env" ]; then
    echo "  WARNING: .env file not found! Copying from .env.example..."
    cp "$TARGET_DIR/.env.example" "$TARGET_DIR/.env"
    echo "  Please edit $TARGET_DIR/.env with your database credentials!"
fi

echo ""
echo "[8/8] Running database migrations..."
cd "$TARGET_DIR"
/usr/local/bin/php artisan migrate --force 2>/dev/null || echo "  Migration skipped or failed"

echo ""
echo "========================================"
echo "  Deploy complete!"
echo "  Target: $TARGET_DIR"
echo "========================================"
