const mix = require('laravel-mix');
const NodePolyfillPlugin = require("node-polyfill-webpack-plugin");
let path = require('path');

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

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css')
    .options({
        legacyNodePolyfills: false,
        processCssUrls: false,
        runtimeChunkPath: '.'
    })
    .extract(['vue', 'bootstrap-vue', 'vue-select'])
    .disableNotifications()
    .webpackConfig({
        plugins: [
            new NodePolyfillPlugin()
        ],
        output: {
            // This option will be available on production mode
            publicPath: '/',
            chunkFilename: 'assets/template/[name].[chunkhash].js',
        },
        resolve: {
            alias: {
                '@': path.resolve('resources')
            }
        }
    })
    .version();