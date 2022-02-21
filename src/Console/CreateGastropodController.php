<?php

namespace RadFic\Gastropod\Console;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Filesystem\Filesystem;

class CreateGastropodController extends GeneratorCommand
{
    protected $name = 'make:gastropodController';
    protected $description = 'Create a new Gastropod Controller in your App.';
    protected $type = 'GastropodCrudController';
    protected $signature = 	'make:gastropodController {name}';

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . 'RadFic\Gastropod\Http\Controllers';
    }

    protected function getStub()
    {
        return __DIR__ ."/../../stubs/gastropod.controller.stub";
    }
    
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the gastropod controller.'],
        ];
    }

    public function handle()
    {
        parent::handle();
        //$this->doOtherOperations();
    }

    protected function doOtherOperations()
    {
        // Get the fully qualified class name (FQN)
        $class = $this->argument($model);

        // get the destination path, based on the default namespace
        $path = $this->getPath($class);

        $content = file_get_contents($path);

        // Update the file content with additional data (regular expressions)

        file_put_contents($path, $content);
    }
}
