const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'assets/js')
    .sass('resources/scss/app.scss', 'assets/css')
    .sass('resources/scss/bootstrap/bootstrap.scss', 'assets/css')

    .webpackConfig({
        stats: {
            children: true,
        },
    });

mix.browserSync('http://localhost:8000');
