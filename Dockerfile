# ベースイメージを指定 (PHP 8.1 + Composer + Node.js)
FROM php:8.2-fpm

# 必要なパッケージをインストール
RUN apt-get update && apt-get install -y \
    curl \
    zip \
    unzip \
    git \
    libpq-dev \
    libonig-dev \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip

# Composerをインストール
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Node.jsとnpmをインストール
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs

# 作業ディレクトリを指定
WORKDIR /var/www/html

# アプリケーションのファイルをコピー
COPY . .

# 依存関係をインストール
RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

# アプリケーションのキャッシュを生成
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

# パーミッションの設定
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# ポート番号を公開
EXPOSE 8000

# アプリケーションの起動コマンド
CMD ["php-fpm"]
