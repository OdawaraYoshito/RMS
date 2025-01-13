# ベースイメージを指定 (NGINX + PHP-FPM)
FROM richarvey/nginx-php-fpm:latest

# 作業ディレクトリを指定
WORKDIR /var/www/html

# 必要なアプリケーションファイルをコピー
COPY . .

# NGINXの設定ファイルをコピー
COPY nginx.conf /etc/nginx/conf.d/default.conf

# パーミッションの設定
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 起動時のスクリプトを指定
CMD ["/start.sh"]
