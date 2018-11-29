<?php

namespace CarloPaa\LaraPlate\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'laraplate:install';

    protected $description = 'Runs all laraplate commands to setup everything.';

    public function handle()
    {
        $this->call('laraplate:make:auth');
        $this->call('laraplate:make:profile');
        $this->call('laraplate:update:model-user');
        $this->call('laraplate:make:avatar');
    }
}
