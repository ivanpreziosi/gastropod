<?php

namespace RadFic\Gastropod\Console;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Filesystem\Filesystem;

class CreateGastropodController extends GeneratorCommand
{
    protected $name = 'gastropod:controller';
    protected $description = 'Create a new Gastropod Controller in your App.';
    protected $type = 'GastropodCrudController';
    protected $signature = 	'gastropod:controller {model}';
    protected $stub = __DIR__ ."/../../stubs/gastropod.controller.stub";

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . 'RadFic\Gastropod\Http\Controllers';
    }

    protected function getStub()
    {
        return $stub;
    }

    public function handle()
    {
        parent::handle();
        $this->doOtherOperations();
    }

    protected function doOtherOperations()
    {
        // Get the fully qualified class name (FQN)
        $class = $this->qualifyClass($this->getNameInput());

        // get the destination path, based on the default namespace
        $path = $this->getPath($class);

        $content = file_get_contents($path);

        // Update the file content with additional data (regular expressions)

        file_put_contents($path, $content);
    }
}
