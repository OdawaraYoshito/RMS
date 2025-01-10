# ベースイメージを指定 (PHP 8.1 + Composer + Node.js)
FROM php:8.1-fpm

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
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

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

# ポート番号を公開
EXPOSE 8000

# アプリケーションの起動コマンド
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
