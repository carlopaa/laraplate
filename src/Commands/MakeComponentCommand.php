<?php

namespace CarloPaa\LaraPlate\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\DetectsApplicationNamespace;

class MakeComponentCommand extends Command
{
    protected $signature = 'laraplate:make:component {component}';

    protected $description = 'Generate a component scaffold (alert, card)';

    protected $components = [
        'card' => [
            'components/card.stub' => 'components/card.blade.php'
        ],
        'alert' => [
            'components/alert.stub' => 'components/alert.blade.php',
            'layouts/partials/alert.stub' => 'layouts/partials/alert.blade.php'
        ]
    ];

    public function handle()
    {
        if (! is_dir($directory = resource_path('views/components'))) {
            mkdir($directory, 0755, true);
        }

        if (! is_dir($directory = resource_path('views/layouts/partials'))) {
            mkdir($directory, 0755, true);
        }

        $this->exportComponent();

        $this->info(ucfirst($this->argument('component')) . ' component generated successfully.');
    }

    protected function exportComponent()
    {
        foreach ($this->components[$this->argument('component')] as $stub => $view) {
            copy(
                __DIR__ . '/../stubs/make/views/' . $stub,
                resource_path('views/' . $view)
            );
        }
    }
}
