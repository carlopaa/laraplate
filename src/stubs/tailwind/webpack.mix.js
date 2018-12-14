let mix = require('laravel-mix');

require('laravel-mix-tailwind');

mix.js('resources/js/app.js', 'js')
    .sass('resources/sass/app.scss', 'css')
    .sourceMaps()
    .tailwind()
    .webpackConfig({
        resolve: {
            alias: {
                '@': path.resolve(__dirname, 'resources'),
                'styles': path.resolve(__dirname, 'resources/sass'),
                'images': path.resolve(__dirname, 'resources/images'),
                'fonts': path.resolve(__dirname, 'resources/fonts'),
                'scripts': path.resolve(__dirname, 'resources/js'),
                'components': path.resolve(__dirname, 'resources/js/components')
            }
        }
    }).version();
