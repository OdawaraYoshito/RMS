# ベースイメージを指定 (NGINX + PHP-FPM)
FROM richarvey/nginx-php-fpm:1.7.2

# プロジェクトの全ファイルをコンテナ内にコピー
COPY . .

# Image config
# Composerスクリプトをスキップ
ENV SKIP_COMPOSER 1
# LaravelアプリケーションのWebルートを指定
ENV WEBROOT /var/www/html/public
# PHPのエラーログを標準エラー出力に送る
ENV PHP_ERRORS_STDERR 1
# 起動時にスクリプトを実行する
ENV RUN_SCRIPTS 1
# クライアントの実際のIPアドレスを取得するためのヘッダー設定
ENV REAL_IP_HEADER 1

# Laravel config
# アプリケーションの環境 (本番環境)
ENV APP_ENV production
# デバッグモードを無効化
ENV APP_DEBUG false
# ログの出力先を標準エラー出力に設定
ENV LOG_CHANNEL stderr

# Composerをrootユーザーで実行可能にする
ENV COMPOSER_ALLOW_SUPERUSER 1

# 起動スクリプトの指定
CMD ["/start.sh"]
