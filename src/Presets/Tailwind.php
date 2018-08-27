<?php

namespace CarloPaa\LaraPlate\Presets;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Foundation\Console\Presets\Preset;

class Tailwind extends Preset
{
    public static function install()
    {
        static::cleanDirectories();
        static::updatePackages();
        static::updateMix();
        static::updateScripts();
    }

    public static function cleanDirectories()
    {
        File::cleanDirectory(resource_path('assets/sass'));
        File::cleanDirectory(resource_path('assets/js/components'));
    }

    public static function updatePackageArray($packages)
    {
        return array_merge([
            'laravel-mix-tailwind' => '~0.1.0',
            'vue-stash' => '^2.0.1-beta'
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
        copy(__DIR__ . '/../stubs/store.js', resource_path('assets/js/store.js'));
        copy(__DIR__ . '/../stubs/app.js', resource_path('assets/js/app.js'));
        copy(__DIR__ . '/../stubs/bootstrap.js', resource_path('assets/js/bootstrap.js'));
    }
}
