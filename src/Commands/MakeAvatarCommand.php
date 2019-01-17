<?php

namespace CarloPaa\LaraPlate\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\DetectsApplicationNamespace;

class MakeAvatarCommand extends Command
{
    use DetectsApplicationNamespace;

    protected $signature = 'laraplate:make:avatar';

    protected $description = 'Scaffold vue component and migration';

    protected $controllers = [
        'account/AvatarController.stub' => 'Account/AvatarController.php'
    ];

    protected $requests = [
        'account/AvatarStoreRequest.stub' => 'Account/AvatarStoreRequest.php'
    ];

    protected $scripts = [
        'components/AvatarUpload.vue' => 'components/AvatarUpload.vue',
        'mixins/upload.js' => 'mixins/upload.js'
    ];

    public function handle()
    {
        $this->createDirectories();
        $this->exportScripts();
        $this->exportControllers();
        $this->exportRequests();
        $this->exportMigrations();
        $this->exportAvatarImage();

        $this->info('Avatar upload scaffolding generated successfully.');
        $this->warn('Please run "composer require intervention/image".');
        $this->warn('Please add "Vue.component(\'avatar-upload\', require(\'./components/AvatarUpload.vue\'));" in app.js file.');
        $this->warn('Please run "php artisan migrate" and "avatar_path" in User model\'s fillables.');
    }

    protected function createDirectories()
    {
        if (! is_dir($directory = resource_path('js/mixins'))) {
            mkdir($directory, 0755, true);
        }

        if (! is_dir($directory = app_path('Http/Requests/Account'))) {
            mkdir($directory, 0755, true);
        }

        if (! is_dir($directory = public_path('images'))) {
            mkdir($directory, 0755, true);
        }
    }

    protected function exportControllers()
    {
        foreach ($this->controllers as $key => $value) {
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

    protected function exportScripts()
    {
        foreach ($this->scripts as $key => $value) {
            copy(
                __DIR__.'/../stubs/make/vue/'.$key,
                resource_path('js/'.$value)
            );
        }
    }

    protected function exportMigrations()
    {
        $path = __DIR__.'/../stubs/make/migrations/';
        chdir($path);

        $migrations = glob('*.php', GLOB_BRACE);

        if (! $migrations) {
            return;
        }

        foreach ($migrations as $migration) {
            copy(
                $path.$migration,
                base_path('database/migrations/'.$migration)
            );
        }
    }

    protected function exportAvatarImage()
    {
        copy(
            __DIR__.'/../stubs/images/avatar.jpg',
            public_path('images/avatar.jpg')
        );
    }
}
