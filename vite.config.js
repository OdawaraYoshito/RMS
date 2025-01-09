// Viteの設定を定義する関数をインポート
import { defineConfig } from "vite";
// Laravel専用のViteプラグインをインポート
import laravel from "laravel-vite-plugin";

// Viteの設定をエクスポート
export default defineConfig({
    // 使用するプラグインのリスト
    plugins: [
        laravel({
            // ビルドのエントリーポイントを指定
            // ここで指定されたCSSやJSファイルがビルド対象になります
            input: ["resources/css/app.css", "resources/js/app.js"],
            // 開発中に変更を検知してブラウザを自動リロード
            refresh: true,
        }),
    ],
});
