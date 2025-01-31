<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Relation Management System (RMS)

このアプリケーションは、会社と人物の情報を効率的に管理するためのシンプルで直感的なウェブアプリケーションです。

## 主な機能

- 会社情報（名前、URL、ステータス、備考など）の管理
- 人物情報（名前、所属会社、連絡先、ステータス、備考など）の管理
- 検索機能を活用した迅速な情報アクセス
- CSV/Excel形式でのデータのインポート／エクスポート
- 認証とセキュリティの向上を重視した設計
- お問い合わせフォームを通じたメール送信機能
- ヘルプページ（基本的な使い方やよくある質問を掲載）

## インストール手順

### 必要条件
- PHP 8.2+
- Composer
- Node.js 16+
- NPM または Yarn

### 手順
1. リポジトリをクローンします:
   ```bash
   cd ~/local
   git clone https://github.com/OdawaraYoshito/RMS.git
   ```

2. 依存関係をインストールします:
   ```bash
   composer install
   npm install
   ```

3. 環境ファイルを作成し、設定を更新します:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. データベースを設定し、マイグレーションを実行します:
   ```bash
   php artisan migrate --seed
   ```

5. ローカルサーバを起動します:
   ```bash
   php artisan serve
   npm run dev
   ```

## 使用方法
1. ブラウザで以下にアクセスします:
   ```plaintext
   http://localhost:8000
   ```

2. 登録、ログイン後、ダッシュボードから会社や人物情報を管理できます。

3. ヘルプページを確認したい場合は、以下にアクセスしてください:
   ```plaintext
   http://localhost:8000/help
   ```
   ヘルプページには、基本的な使い方やよくある質問が掲載されています。

## テストの実行方法
- テストを実行するには以下を使用してください:
   ```bash
   php artisan test
   ```

## ライセンス
このプロジェクトは MITライセンス のもと提供されています。
