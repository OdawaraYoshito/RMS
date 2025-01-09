// PostCSSの設定ファイル
// 使用するプラグインをここに定義します。
export default {
    plugins: {
        // Tailwind CSSプラグイン
        // TailwindのユーティリティクラスをCSSに生成します。
        tailwindcss: {},

        // Autoprefixerプラグイン
        // 各ブラウザの互換性を確保するために必要な
        // ベンダープレフィックス（例: -webkit-）を自動的に追加します。
        autoprefixer: {},
    },
};
