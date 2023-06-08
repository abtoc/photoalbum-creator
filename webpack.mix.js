const mix = require('laravel-mix')

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .version();

mix.js('resources/js/script.js', 'public/js')
    .sass('resources/sass/style.scss', 'public/css')
    .version();
