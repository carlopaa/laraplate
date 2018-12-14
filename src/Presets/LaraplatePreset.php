<?php

namespace CarloPaa\LaraPlate\Presets;

use Illuminate\Foundation\Console\Presets\Preset;

abstract class LaraplatePreset extends Preset
{
    protected static $global_scripts = [
        'store.js' => 'store.js',
        'modules/ajaxify.js' => 'modules/ajaxify.js',
        'modules/serialize.js' => 'modules/serialize.js',
        'modules/extend.js' => 'modules/extend.js',
        'store/form.js' => 'store/form.js',
        'store/response.js' => 'store/response.js',
        'mixins/interceptor.js' => 'mixins/interceptor.js'
    ];
}
