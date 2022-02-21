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

    public function handle()
    {
        parent::handle();
        $this->customizeStub();
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Http\Controllers';
    }

    protected function getStub()
    {
        return __DIR__ ."/stubs/GastropodStubController.stub";
    }
    
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the eloquent model you want to crud.'],
        ];
    }

    protected function customizeStub()
    {
        // Get the fully qualified class name (FQN)
        $modelClassName = $this->getNameInput();
        //$modelFQN = $this->qualifyClass($modelClassName);
        $controllerName = "Gastropod".$modelClassName."Controller";

        // get the destination path, based on the default namespace
        $path = $this->getPath($modelClassName);
        //get file contents
        $content = file_get_contents($path);
        //modify it
        $content = str_replace(":|:CONTROLLERNAME:|:", $controllerName, $content);
        $content = str_replace(":|:MODEL:|:", $modelClassName, $content);
        //save back
        file_put_contents($path, $content);
    }
}
