<?php

namespace CarloPaa\LaraPlate\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\DetectsApplicationNamespace;

class MakeCustomAuthCommand extends Command
{
    use DetectsApplicationNamespace;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laraplate:make:auth
                    {--views : Only scaffold the authentication views}
                    {--force : Overwrite existing views by default}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scaffold custom login and registration views and routes';

    /**
     * The views that need to be exported.
     *
     * @var array
     */
    protected $views = [
        'auth/login.stub' => 'auth/login.blade.php',
        'auth/register.stub' => 'auth/register.blade.php',
        'auth/verify.stub' => 'auth/verify.blade.php',
        'auth/passwords/email.stub' => 'auth/passwords/email.blade.php',
        'auth/passwords/reset.stub' => 'auth/passwords/reset.blade.php',
        'layouts/app.stub' => 'layouts/app.blade.php',
        'layouts/partials/head.stub' => 'layouts/partials/head.blade.php',
        'layouts/partials/navigation.stub' => 'layouts/partials/navigation.blade.php',
        'layouts/partials/footer.stub' => 'layouts/partials/footer.blade.php',
        'home.stub' => 'home.blade.php',
    ];

    protected $controllers = [
        'auth/LoginController.stub' => 'Auth/LoginController.php',
        'auth/RegisterController.stub' => 'Auth/RegisterController.php',
        'auth/ResetPasswordController.stub' => 'Auth/ResetPasswordController.php',
        'auth/ForgotPasswordController.stub' => 'Auth/ForgotPasswordController.php',
        'HomeController.stub' => 'HomeController.php'
    ];

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->createDirectories();

        $this->exportViews();

        if (! $this->option('views')) {
            $this->exportControllers();

            file_put_contents(
                base_path('routes/web.php'),
                file_get_contents(__DIR__ . '/../stubs/make/routes.stub'),
                FILE_APPEND
            );
        }

        if (! file_exists(resource_path('views/components/card.blade.php'))) {
            $this->call('laraplate:make:component', ['component' => 'card']);
        }

        if (! file_exists(resource_path('views/components/alert.blade.php'))) {
            $this->call('laraplate:make:component', ['component' => 'alert']);
        }

        $this->info('Authentication scaffolding generated successfully.');
    }

    /**
     * Create the directories for the files.
     *
     * @return void
     */
    protected function createDirectories()
    {
        if (! is_dir($directory = resource_path('views/layouts/partials'))) {
            mkdir($directory, 0755, true);
        }

        if (! is_dir($directory = resource_path('views/auth/passwords'))) {
            mkdir($directory, 0755, true);
        }

        if (! is_dir($directory = app_path('Models'))) {
            mkdir($directory);
        }
    }

    /**
     * Export the authentication views.
     *
     * @return void
     */
    protected function exportViews()
    {
        foreach ($this->views as $key => $value) {
            if (file_exists($view = resource_path('views/'.$value)) && ! $this->option('force')) {
                if (! $this->confirm("The [{$value}] view already exists. Do you want to replace it?")) {
                    continue;
                }
            }

            copy(
                __DIR__ . '/../stubs/make/views/'.$key,
                $view
            );
        }
    }

    /**
     * Compiles controllers stub
     * Overrides the default auth login and register controller
     *
     * @return void
     */
    protected function exportControllers()
    {
        foreach ($this->controllers as $stub => $controller) {
            file_put_contents(
                app_path('Http/Controllers/' . $controller),
                str_replace(
                    '{{namespace}}',
                    $this->getAppNamespace(),
                    file_get_contents(__DIR__ . '/../stubs/make/controllers/' . $stub)
                )
            );
        }
    }
}
