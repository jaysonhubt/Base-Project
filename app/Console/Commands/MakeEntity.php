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

        if ($this->confirm('Do you wish to create Model?')) {
            $command = 'make:model ' . ucfirst($name);
            if ($this->confirm('Do you wish to create Migration?')) {
                $command .= ' -m';
            }

            $this->callSilent($command);
        }

        $this->proceedAndSaveFile(
            $name,
            'services',
            app_path('Services/') . '/' . ucfirst($name).'Service.php'
        );

        $this->proceedAndSaveFile(
            $name,
            'repository',
            app_path('Repositories/') . '/' . ucfirst($name) . 'Repository.php'
        );
    }

    protected function proceedAndSaveFile($name, $stub, $path)
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

    protected function getStubs($type)
    {
        return $this->filesystem->get(__DIR__."/stubs/$type.stub");
    }
}
