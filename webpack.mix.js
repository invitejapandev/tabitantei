const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js').version().vue();
mix.sass('resources/sass/app.scss', 'public/css');

