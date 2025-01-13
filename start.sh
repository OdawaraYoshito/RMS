#!/usr/bin/env bash

# Composer依存関係をインストール
echo "Running composer"
composer install --no-dev --working-dir=/var/www/html

# フロントエンドのビルド
echo "Building frontend assets..."
npm install
npm run build

# アプリケーションキャッシュの生成
echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Caching views..."
php artisan view:cache

# マイグレーションを強制実行
echo "Running migrations..."
php artisan migrate --force

# サービスを起動
echo "Starting PHP-FPM..."
php-fpm
