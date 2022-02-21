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
        return __DIR__ ."/stubs/GastropodStubController.stub";
    }
    
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the gastropod controller.'],
        ];
    }

   
}
