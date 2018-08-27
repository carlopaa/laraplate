<?php

namespace CarloPaa\LaraPlate\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\DetectsApplicationNamespace;

class MakeCardComponent extends Command
{
    protected $signature = 'make:component:card';

    protected $description = 'Generate a card component scaffold';

    public function handle()
    {
        if (! is_dir($directory = resource_path('views/components'))) {
            mkdir($directory, 0755, true);
        }

        copy(
            __DIR__ . '/../stubs/make/views/components/card.stub',
            resource_path('views/components/card.blade.php')
        );

        $this->info('Card component scaffold generated successfully.');
    }
}
