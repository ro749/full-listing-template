<?php

namespace Ro749\FullListingTemplate;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Ro749\FullListingTemplate\Commands\FullListingTemplateCommand;
use Ro749\FullListingTemplate\Commands\FixHeader;
use Ro749\FullListingTemplate\Commands\Check;
use Ro749\FullListingTemplate\Middleware\Admin;
use Illuminate\Support\Facades\Log;

class FullListingTemplateServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('full-listing-template')
            ->hasConfigFile()
            ->hasViews()
            ->hasAssets()
            ->hasMigration('create_full_listing_template_table')
            ->hasCommands([
                FullListingTemplateCommand::class,
                FixHeader::class,
                Check::class
            ])
            ->hasRoutes('web');
    }

    public function bootingPackage()
    {
        app('router')->pushMiddlewareToGroup('admin', Admin::class);
    }

    public function register()
    {
        parent::register();
        $packageConfig = require __DIR__.'/../config/full-listing-template.php';
        config(['overrides' => $this->mergeConfigs($packageConfig['overrides'], config('overrides', []))]);    
        config(['login' => $this->mergeConfigs($packageConfig['login'], config('login', []))]);
        config(['options' => $this->mergeConfigs($packageConfig['options'], config('options', []))]);
        config(['auth' => $this->mergeConfigs($packageConfig['auth'], config('auth', []))]);
    }

    protected function mergeConfigs(array $package, array $project): array
    {
        foreach ($project as $key => $value) {
            $package[$key] = (is_array($value) && isset($package[$key]) && is_array($package[$key]))
                ? $this->mergeConfigs($package[$key], $value)
                : $value;
        }
        return $package;
    }
}
