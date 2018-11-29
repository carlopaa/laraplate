<?php

namespace CarloPaa\LaraPlate;

use Illuminate\Support\ServiceProvider;
use CarloPaa\LaraPlate\Commands\InstallCommand;
use CarloPaa\LaraPlate\Commands\UpdateModelUser;
use CarloPaa\LaraPlate\Commands\MakeAvatarCommand;
use CarloPaa\LaraPlate\Commands\MakeProfileCommand;
use CarloPaa\LaraPlate\Commands\MakeComponentCommand;
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
                MakeComponentCommand::class,
                MakeProfileCommand::class,
                MakeAvatarCommand::class,
                UpdateModelUser::class,
                InstallCommand::class,
            ]);
        }
    }
}
