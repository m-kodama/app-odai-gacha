const mix = require("laravel-mix");
const glob = require('glob');
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.browserSync({
    proxy: "0.0.0.0:8000", // アプリの起動アドレス
    open: false // ブラウザを自動で開かない
});

const inDir = "resources"
const outDir = "public";
glob.sync(`${inDir}/js/**/*.js`).map((file) => {
    const dir = file.split('/').slice(0, -1).join('/').replace(inDir, outDir);
    mix.js(file, dir).version();
});