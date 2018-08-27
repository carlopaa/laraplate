<?php

namespace CarloPaa\LaraPlate;

use Illuminate\Support\ServiceProvider;
use CarloPaa\LaraPlate\Commands\MakeAvatarCommand;
use CarloPaa\LaraPlate\Commands\MakeCardComponent;
use CarloPaa\LaraPlate\Commands\MakeProfileCommand;
use CarloPaa\LaraPlate\Commands\UpdateModelsLocation;
use CarloPaa\LaraPlate\Commands\MakeCustomAuthCommand;
use CarloPaa\LaraPlate\Commands\UpdateMakeModelCommand;

class CommandServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                UpdateMakeModelCommand::class,
                MakeCustomAuthCommand::class,
                UpdateModelsLocation::class,
                MakeProfileCommand::class,
                MakeCardComponent::class,
                MakeAvatarCommand::class
            ]);
        }
    }
}
