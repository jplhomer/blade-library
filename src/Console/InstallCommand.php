<?php

namespace BladeLibrary\Console;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blade-library:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install all of the Blade Library resources';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->comment('Publishing Blade Library Config...');
        $this->callSilent('vendor:publish', ['--tag' => 'blade-library-config']);

        $this->comment('Publishing Blade Library Assets...');
        $this->callSilent('vendor:publish', ['--tag' => 'blade-library-assets']);

        $this->comment('Publishing Blade Library Partials...');
        $this->callSilent('vendor:publish', ['--tag' => 'blade-library-shared-views']);

        $this->info('Blade Library scaffolding installed successfully.');
    }
}
