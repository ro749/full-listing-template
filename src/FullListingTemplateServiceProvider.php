<?php

namespace Ro749\FullListingTemplate;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Ro749\FullListingTemplate\Commands\FullListingTemplateCommand;

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
            ->hasMigration('create_full_listing_template_table')
            ->hasCommand(FullListingTemplateCommand::class)
            ->hasRoutes('web');
    }

    public function register()
    {
        parent::register();
        $packageConfig = require __DIR__.'/../config/full-listing-template.php';
        config(['overrides' => $this->mergeConfigs($packageConfig['overrides'], config('overrides', []))]);    
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
