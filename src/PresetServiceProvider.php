<?php

namespace CarloPaa\LaraPlate;

use Illuminate\Support\ServiceProvider;
use CarloPaa\LaraPlate\Presets\Tailwind;
use CarloPaa\LaraPlate\Presets\Bootstrap;
use Illuminate\Foundation\Console\PresetCommand;

class PresetServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        PresetCommand::macro('laraplate-tailwind', function ($command) {
            Tailwind::install();

            $this->info($command, 'Tailwind');
        });

        PresetCommand::macro('laraplate-bootstrap', function ($command) {
            Bootstrap::install();

            $this->info($command, 'Bootstrap');
        });
    }

    protected function info($command, $preset)
    {
        $command->info($preset.' preset installed successfully.');
        $command->warn('Please run "npm install && npm run dev" to compile your assets.');
    }
}
