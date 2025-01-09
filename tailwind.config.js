// Tailwind CSSのデフォルトテーマをインポート
import defaultTheme from "tailwindcss/defaultTheme";
// Tailwind CSSのフォーム用プラグインをインポート
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
// Tailwind CSSの設定オブジェクトをエクスポート
export default {
    // Tailwind CSSを適用するファイルを指定
    // 指定したファイル内で使用されているクラスのみが最終ビルドに含まれる
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    // テーマの設定
    theme: {
        extend: {
            // デフォルトのsans-serifフォントにFigtreeを追加
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
        },
    },

    // プラグインを有効化
    plugins: [
        // Tailwindのフォーム用プラグイン
        forms,
    ],

    // コアプラグインの設定
    corePlugins: {
        // TailwindのCSSリセット（preflight）を無効化
        // 他のCSSフレームワークと共存させたい場合などに有効
        preflight: false,
    },
};
