<?php

namespace RadFic\Gastropod\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Filesystem\Filesystem;

class CreateGastropodController extends Command
{
    protected $signature = 	'gastropod:controller 
							{model : The model you want to crud}';
    protected $description = 'Create a new Gastropod Controller in your App.';
    protected $stub = __DIR__ ."/../../stubs/gastropod.controller.stub";

    /**
     * Filesystem instance
     * @var Filesystem
     */
    protected $files;

    /**
     * Create a new command instance.
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }


    public function handle($model)
    {
        $fullyQualifiedModelName = 'App\\Models\\'.$model;
        $data = [
            ':|:fullyQualifiedModelName:|:' => $fullyQualifiedModelName,
            ':|:model:|:' => $model,
        ];

        $content = $this->getStubContents($this->stub, $data);
        $destinationPath = app_path('Http/Controllers/Gastropod');
        $destinationFilePath = $this->getDestinationFilePath($destinationPath, $model);

        //create directory if needed
        $this->makeDirectory($destinationPath);

        //copy content as a php file
        if (!$this->files->exists($destinationFilePath)) {
            $this->files->put($destinationFilePath, $content);
            $this->info("File : {$destinationFilePath} created");
        } else {
            $this->info("File : {$path} already exits");
        }
    }

    /**
     * Replace the stub variables(key) with the desire value
     *
     * @param $stub
     * @param array $stubVariables
     * @return bool|mixed|string
     */
    public function getStubContents($stub, $stubVariables = [])
    {
        $contents = file_get_contents($stub);

        foreach ($stubVariables as $search => $replace) {
            $contents = str_replace($search, $replace, $contents);
        }

        return $contents;
    }

    /**
     * Get the full path of generate class
     *
     * @return string
     */
    public function getDestinationFilePath($destinationPath, $model)
    {
        return $destinationPath . $model . '.php';
    }

    /**
     * Build the directory for the class if necessary.
     *
     * @param  string  $path
     * @return string
     */
    protected function makeDirectory($path)
    {
        if (! $this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0777, true, true);
        }

        return $path;
    }
}
