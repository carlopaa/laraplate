<?php

namespace CarloPaa\LaraPlate\Commands;

use Illuminate\Console\Command;

class UpdateModelsLocation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:models';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates the default model path';

    public function handle()
    {
        $this->updateNamespaces([
            app_path('Http/Controllers/Auth/RegisterController.php'),
            base_path('config/auth.php')
        ]);

        file_put_contents(
            app_path('Http/Controllers/Auth/RegisterController.php'),
            str_replace('|confirmed', '', file_get_contents(app_path('Http/Controllers/Auth/RegisterController.php')))
        );

        file_put_contents(
            app_path('Models/User.php'),
            $this->userModel()
        );
        \File::delete(app_path('User.php'));

        $this->call('update:make:model');

        $this->info('Models path updated successfully.');
    }

    /**
     * Update default namespaces
     */
    protected function updateNamespaces($files)
    {
        foreach ($files as $file) {
            file_put_contents(
                $file,
                $this->updateNamespace($file)
            );
        }
    }

    /**
     * Modify default namespace App\User - App\Models\User
     *
     * @param string $file
     * @return void
     */
    protected function updateNamespace($file)
    {
        return str_replace(
            'App\User',
            'App\Models\User',
            file_get_contents($file)
        );
    }

    /**
     * Modify default User Model namespace
     *
     * @return void
     */
    protected function userModel()
    {
        return str_replace(
            'namespace App',
            'namespace App\Models',
            file_get_contents(app_path('User.php'))
        );
    }
}
