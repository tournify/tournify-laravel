const mix = require('laravel-mix');

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

mix.sass(
    "resources/assets/sass/app.scss"
    , 'public/styles');
mix.styles(
    "resources/assets/css/all.css"
    , 'public/styles/all.css');
mix.styles(
    "resources/assets/css/screen.css"
    , 'public/styles/screen.css');
mix.styles(
    "resources/assets/css/print.css"
    , 'public/styles/print.css');

mix.copy('node_modules/socket.io-client/dist/socket.io.js', 'public/javascript/socket.io.js');

mix.copy('javascript/head.js', 'public/javascript/head.js');
mix.copy('javascript/jquery.js', 'public/javascript/jquery.js');
mix.copy('javascript/mobile.js', 'public/javascript/mobile.js');
mix.copy('javascript/scripts.js', 'public/javascript/scripts.js');
mix.copy('javascript/tf.js', 'public/javascript/tf.js');