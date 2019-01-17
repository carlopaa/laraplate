<?php

namespace CarloPaa\LaraPlate\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\DetectsApplicationNamespace;

class MakeProfileCommand extends Command
{
    use DetectsApplicationNamespace;

    protected $signature = 'laraplate:make:profile
                    {--views : Only scaffold the profile views}
                    {--force : Overwrite existing views by default}';

    protected $description = 'Scaffold account profile views and routes';

    protected $views = [
        'account/index.stub' => 'account/index.blade.php',
        'account/profile/index.stub' => 'account/profile/index.blade.php',
        'account/password/index.stub' => 'account/password/index.blade.php',
        'account/layouts/default.stub' => 'account/layouts/default.blade.php',
    ];

    protected $controllers = [
        'account/AccountController.stub' => 'Account/AccountController.php',
        'account/ProfileController.stub' => 'Account/ProfileController.php',
        'account/PasswordController.stub' => 'Account/PasswordController.php'
    ];

    protected $requests = [
        'account/ProfileStoreRequest.stub' => 'Account/ProfileStoreRequest.php'
    ];

    protected $rules = [
        'ConfirmCurrentPassword.stub' => 'ConfirmCurrentPassword.php'
    ];

    public function handle()
    {
        if (! file_exists(resource_path('views/layouts/partials/head.blade.php'))) {
            return $this->error('Please generate the custom auth scaffolding first.');
        }

        $this->createDirectories();
        $this->exportViews();

        if (! $this->option('views')) {
            $this->changeDefaultRedirects();
            $this->attachNavigationLinks();
            $this->exportControllers();
            $this->exportRequests();
            $this->exportRules();

            file_put_contents(
                base_path('routes/web.php'),
                file_get_contents(__DIR__.'/../stubs/make/routes.account.stub'),
                FILE_APPEND
            );
        }

        $this->info('Account profile scaffolding generated successfully.');
    }

    protected function createDirectories()
    {
        if (! is_dir($directory = resource_path('assets/js/mixins'))) {
            mkdir($directory, 0755, true);
        }

        if (! is_dir($directory = resource_path('views/account/layouts'))) {
            mkdir($directory, 0755, true);
        }

        if (! is_dir($directory = resource_path('views/account/profile'))) {
            mkdir($directory, 0755, true);
        }

        if (! is_dir($directory = resource_path('views/account/password'))) {
            mkdir($directory, 0755, true);
        }

        if (! is_dir($directory = app_path('Http/Controllers/Account'))) {
            mkdir($directory, 0755, true);
        }

        if (! is_dir($directory = app_path('Http/Requests/Account'))) {
            mkdir($directory, 0755, true);
        }

        if (! is_dir($directory = app_path('Rules'))) {
            mkdir($directory, 0755, true);
        }
    }

    protected function exportViews()
    {
        foreach ($this->views as $key => $value) {
            if (file_exists($view = resource_path('views/'.$value)) && ! $this->option('force')) {
                if (! $this->confirm("The [{$value}] view already exists. Do you want to replace it?")) {
                    continue;
                }
            }

            copy(
                __DIR__.'/../stubs/make/views/'.$key,
                $view
            );
        }
    }

    protected function exportControllers()
    {
        foreach ($this->controllers as $key => $value) {
            if (file_exists($controller = app_path('Http/Controllers/'.$value)) && ! $this->option('force')) {
                if (! $this->confirm("The [{$value}] controller already exists. Do you want to replace it?")) {
                    continue;
                }
            }

            file_put_contents(
                app_path('Http/Controllers/'.$value),
                str_replace(
                    '{{namespace}}',
                    $this->getAppNamespace(),
                    file_get_contents(__DIR__.'/../stubs/make/controllers/'.$key)
                )
            );
        }
    }

    protected function exportRequests()
    {
        foreach ($this->requests as $key => $value) {
            if (file_exists($request = app_path('Http/Requests/'.$value)) && ! $this->option('force')) {
                if (! $this->confirm("The [{$value}] request already exists. Do you want to replace it?")) {
                    continue;
                }
            }

            file_put_contents(
                app_path('Http/Requests/'.$value),
                str_replace(
                    '{{namespace}}',
                    $this->getAppNamespace(),
                    file_get_contents(__DIR__.'/../stubs/make/requests/'.$key)
                )
            );
        }
    }

    protected function exportRules()
    {
        foreach ($this->rules as $key => $value) {
            if (file_exists($rules = app_path('Rules/'.$value)) && ! $this->option('force')) {
                if (! $this->confirm("The [{$value}] rule already exists. Do you want to replace it?")) {
                    continue;
                }
            }

            file_put_contents(
                app_path('Rules/'.$value),
                str_replace(
                    '{{namespace}}',
                    $this->getAppNamespace(),
                    file_get_contents(__DIR__.'/../stubs/make/rules/'.$key)
                )
            );
        }
    }

    protected function changeDefaultRedirects()
    {
        $files = [
            'Http/Controllers/Auth/LoginController.php',
            'Http/Controllers/Auth/RegisterController.php',
            'Http/Controllers/Auth/ResetPasswordController.php',
            'Http/Middleware/RedirectIfAuthenticated.php',
        ];

        foreach ($files as $file) {
            file_put_contents(
                $path = app_path($file),
                str_replace(
                    '/home',
                    '/account',
                    file_get_contents($path)
                )
            );
        }
    }

    protected function attachNavigationLinks()
    {
        $navigation = file_get_contents(resource_path('views/layouts/partials/navigation.blade.php'));

        file_put_contents(
            resource_path('views/layouts/partials/navigation.blade.php'),
            str_replace(
                '<div class="dropdown-menu" aria-labelledby="navbarDropdown">',
                $this->linksScaffold(),
                $navigation
            )
        );
    }

    protected function linksScaffold()
    {
        return '<div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a href="{{ route(\'account.index\') }}" class="dropdown-item">
                                Account
                            </a>
                            <a href="{{ route(\'account.profile.index\') }}" class="dropdown-item">
                                Profile
                            </a>
                            <a href="{{ route(\'account.password.index\') }}" class="dropdown-item">
                                Change Password
                            </a>
                            <div class="dropdown-divider"></div>';
    }
}
