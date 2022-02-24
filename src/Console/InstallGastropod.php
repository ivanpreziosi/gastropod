<?php

namespace RadFic\Gastropod\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;

/**
 * InstallGastropod Artisan Command
 * 
 * This command will publish all required files from vendor to
 * the appropriate folder in app's directory structure.
 */
class InstallGastropod extends Command
{
    protected $signature = 'gastropod:install';
    protected $description = 'Install Gastropod in your project.';

    public function handle()
    {
        $this->info('Installing Gastropod...');
        $parts = [
            'config',
            'migrations',
            'assets',
            'views',
            'admin_model',
            'routes'
        ];
        foreach ($parts as $part) {
            $this->info("Publishing $part...");
            if (!$this->exists($part)) {
                $this->publishTag($part);
            } else {
                if ($this->shouldOverwrite($part)) {
                    $this->info("Overwriting $part...");
                    $this->publishTag($part, true);
                } else {
                    $this->info("Existing $part was not overwritten");
                }
            }
        }
        $this->info('Gastropod successfully installed!');
    }

    /**
     * Checks if a determined part of gastropod files are already present in the
     * app's folders structure.
     *
     * @param string $what
     * 
     * @return bool
     * 
     */
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
            case 'admin_model':
                return File::exists(app_path('Models/GastropodAdmin.php'));
                break;
            default:
                return false;
        }
    }

    /**
     * Asks the user if he wants to overwrite a determined part of the installation files.
     *
     * @param string $what
     * 
     * @return bool
     * 
     */
    private function shouldOverwrite($what)
    {
        return $this->confirm(
            $what.' already exists. Do you want to overwrite it?',
            true
        );
    }

    /**
     * Calls `vendor:publish` on a tag.
     *
     * @param string $tag
     * @param bool $forcePublish
     * 
     * 
     */
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
