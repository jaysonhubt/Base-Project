<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeEntity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:entity {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make entity console command';

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * Create a new command instance.
     *
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        parent::__construct();

        $this->filesystem = $filesystem;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');

        // Create controller
        if ($this->confirm('Do you wish to create Controller?')) {
            $stub = 'controller';
            if ($this->confirm('Do you wish to create Resource Controller?')) {
                $stub .= '.resource';
            }

            $this->proceedAndSaveFile(
                $name,
                $stub,
                app_path('Http/Controllers/') . '/' . ucfirst($name).'Controller.php'
            );
        }

        // Create Model and Migration
        if ($this->confirm('Do you wish to create Model?')) {
            $this->callSilent('make:model', [
                'name' => ucfirst($name),
                '-m' => $this->confirm('Do you wish to create Migration?')
            ]);
        }

        // Create Service
        $this->proceedAndSaveFile(
            $name,
            'services',
            app_path('Services/') . '/' . ucfirst($name).'Service.php'
        );

        // Create Repository
        $this->proceedAndSaveFile(
            $name,
            'repository',
            app_path('Repositories/') . '/' . ucfirst($name) . 'Repository.php'
        );
    }

    private function proceedAndSaveFile($name, $stub, $path)
    {
        $template = str_replace(
            [
                '{{Model}}',
                '{{model}}',
            ],
            [
                ucfirst($name),
                lcfirst($name),
            ],
            $this->getStubs($stub)
        );

        $this->filesystem->put($path, $template);
    }

    private function getStubs($type)
    {
        return $this->filesystem->get(__DIR__."/stubs/$type.stub");
    }
}
