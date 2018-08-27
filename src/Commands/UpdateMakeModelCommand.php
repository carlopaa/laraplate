<?php

namespace CarloPaa\LaraPlate\Commands;

use Illuminate\Console\Command;

class UpdateMakeModelCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:make:model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Store models in Models directory.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (! is_dir($directory = base_path('app/Console/Commands'))) {
            mkdir($directory);
        }

        copy(__DIR__ . '/../stubs/commands/MakeModelCommand.php', base_path('app/Console/Commands/MakeModelCommand.php'));

        $this->info('Model creation successfully updated.');
    }
}
