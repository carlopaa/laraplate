<?php

namespace CarloPaa\LaraPlate\Presets;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Foundation\Console\Presets\Preset;

class Bootstrap extends Preset
{
    protected static $scripts = [
        'bootstrap/bootstrap.js' => 'bootstrap.js',
        'store.js' => 'store.js',
        'app.js' => 'app.js',
        'store/validation.js' => 'store/validation.js',
        'mixins/validation.js' => 'mixins/validation.js'
    ];

    public static function install()
    {
        static::cleanDirectories();
        static::createDirectories();
        static::updatePackages();
        static::updateMix();
        static::updateScripts();
        static::updateSass();
    }

    public static function cleanDirectories()
    {
        File::cleanDirectory(resource_path('assets/sass'));
    }

    public static function createDirectories()
    {
        if (! is_dir($directory = resource_path('assets/sass/components'))) {
            mkdir($directory);
        }

        if (! is_dir($directory = resource_path('assets/js/modules'))) {
            mkdir($directory);
        }

        if (! is_dir($directory = resource_path('assets/js/store'))) {
            mkdir($directory);
        }

        if (! is_dir($directory = resource_path('assets/js/mixins'))) {
            mkdir($directory);
        }
    }

    public static function updatePackageArray($packages)
    {
        return array_merge([
            'vue-stash' => '^2.0.1-beta'
        ], Arr::except($packages, [
            'lodash'
        ]));
    }

    public static function updateMix()
    {
        copy(__DIR__ . '/../stubs/webpack.mix.js', base_path('webpack.mix.js'));
    }

    public static function updateScripts()
    {
        foreach (self::$scripts as $stub => $script) {
            copy(
                __DIR__ . '/../stubs/' . $stub,
                resource_path('assets/js/' . $script)
            );
        }

        // Import modules
        $path = __DIR__ . '/../stubs/modules/';
        chdir($path);

        foreach (glob('*.js', GLOB_BRACE) as $script) {
            copy(
                $path . $script,
                resource_path('assets/js/modules/' . $script)
            );
        }
    }

    public static function updateSass()
    {
        copy(__DIR__ . '/../stubs/bootstrap/sass/_variables.scss', resource_path('assets/sass/_variables.scss'));
        copy(__DIR__ . '/../stubs/bootstrap/sass/app.scss', resource_path('assets/sass/app.scss'));

        /** Components */
        $path = __DIR__ . '/../stubs/bootstrap/sass/components/';
        chdir($path);

        foreach (glob('*.scss', GLOB_BRACE) as $scss) {
            copy(
                $path . $scss,
                resource_path('assets/sass/components/' . $scss)
            );
        }
    }
}
