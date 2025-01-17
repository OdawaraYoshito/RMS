#!/usr/bin/env bash

# Composer依存関係をインストール
echo "Running composer"
composer install --no-dev --working-dir=/var/www/html

# フロントエンドのビルド
echo "Building frontend assets..."
npm install
npm run build

# ビューキャッシュをクリア
echo "Clearing view cache..."
php artisan view:clear

# アプリケーションキャッシュの生成
echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

# マイグレーションを強制実行
echo "Running migrations..."
php artisan migrate --force

# シーダーを実行
echo "Seeding database..."
php artisan db:seed --force
