let mix = require('laravel-mix');

mix.js('resources/assets/js/app.js', 'js')
    .sass('resources/assets/sass/app.scss', 'css')
    .sourceMaps()
    .webpackConfig({
        resolve: {
            alias: {
                '@': path.resolve(__dirname, 'resources'),
                'styles': path.resolve(__dirname, 'resources/assets/sass'),
                'images': path.resolve(__dirname, 'resources/assets/images'),
                'fonts': path.resolve(__dirname, 'resources/assets/fonts'),
                'scripts': path.resolve(__dirname, 'resources/assets/js'),
                'components': path.resolve(__dirname, 'resources/assets/js/components')
            }
        }
    }).version();
