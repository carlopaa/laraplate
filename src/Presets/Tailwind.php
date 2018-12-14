<?php

namespace CarloPaa\LaraPlate\Presets;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;

class Tailwind extends LaraplatePreset
{
    protected static $scripts = [
        'bootstrap.js' => 'bootstrap.js',
        'app.js' => 'app.js'
    ];

    public static function install()
    {
        static::cleanDirectories();
        static::updatePackages();
        static::updateMix();
        static::updateScripts();
        static::createSass();
    }

    public static function cleanDirectories()
    {
        File::cleanDirectory(resource_path('sass'));
        File::cleanDirectory(resource_path('js/components'));
    }

    public static function updatePackageArray($packages)
    {
        return array_merge([
            'tailwindcss' => '^0.7.3',
            'laravel-mix-tailwind' => '~0.1.0',
            'vue-stash' => '^2.0.1-beta',
            'laravel-mix' => '^4.0.6',
            'sass-loader' => '7.*',
            'sass' => '^1.15.2',
            'resolve-url-loader' => '3.0.0'
        ], Arr::except($packages, [
            'popper.js',
            'bootstrap',
            'jquery',
            'lodash'
        ]));
    }

    public static function updateMix()
    {
        copy(__DIR__ . '/../stubs/tailwind/webpack.mix.js', base_path('webpack.mix.js'));
    }

    public static function updateScripts()
    {
        foreach (array_merge(self::$global_scripts, self::$scripts) as $stub => $script) {
            copy(
                __DIR__ . '/../stubs/' . $stub,
                resource_path('js/' . $script)
            );
        }

        // Import modules
        $path = __DIR__ . '/../stubs/modules/';
        chdir($path);

        foreach (glob('*.js', GLOB_BRACE) as $script) {
            copy(
                $path . $script,
                resource_path('js/modules/' . $script)
            );
        }
    }

    public static function createSass()
    {
        copy(__DIR__ . '/../stubs/tailwind/sass/app.scss', resource_path('sass/app.scss'));
    }
}
