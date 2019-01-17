<?php

namespace App\Console\Commands;

use Illuminate\Foundation\Console\ModelMakeCommand;

class MakeModelCommand extends ModelMakeCommand
{
    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\\Models';
    }
}
