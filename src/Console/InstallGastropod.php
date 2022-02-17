<?php

namespace RadFic\Gastropod\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;




class InstallGastropod extends Command
{
    protected $signature = 'gastropod:install';
    protected $description = 'Install Gastropod in your project.';

    public function handle()
    {
        $this->info('Installing Gastropod...');
        $parts = [
            'config',
            'migration',
            'assets',
            'views',
            'controllers',
            'routes'
        ];
        foreach ($parts as $part) {
            $this->info("Publishing $part...");
            if (!$this->exists($part)) {
                $this->publishTag($part);
                $this->info('Published '.$part);
            } else {
                if ($this->shouldOverwrite($part)) {
                    $this->info("Overwriting $part...");
                    $this->publishTag($part, true);
                } else {
                    $this->info("Existing $part was not overwritten");
                }
            }
        }

        $this->info("Registering GastropodRoutesServiceProvider in service container...");
        App::register(GastropodRoutesServiceProvider::class);

        $this->info('Gastropod successfully installed!');
    }

    private function exists($what)
    {
        switch ($what) {
            case 'config':
                return File::exists(config_path('gastropod.php'));
                break;
            case 'migration':
                return File::exists(config_path('gastropod.php'));
                break;
            case 'assets':
                return File::exists(public_path('gastropod_assets'));
                break;
            case 'views':
                return File::exists(resource_path('views/gastropod'));
                break;
            case 'controllers':
                return File::exists(app_path('Http/Controllers/Gastropod'));
                break;
            case 'routes':
                return File::exists(base_path('routes/gastropod.php'));
                break;
            default:
                return false;
        }
    }

    private function shouldOverwrite($what)
    {
        return $this->confirm(
            $what.' already exists. Do you want to overwrite it?',
            false
        );
    }

    private function publishTag($tag, $forcePublish = false)
    {
        $params = [
            '--provider' => "RadFic\Gastropod\GastropodServiceProvider",
            '--tag' => $tag
        ];

        if ($forcePublish === true) {
            $params['--force'] = true;
        }

        $this->call('vendor:publish', $params);
    }
}
