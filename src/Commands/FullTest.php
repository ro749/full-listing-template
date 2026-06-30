<?php

namespace Ro749\FullListingTemplate\Commands;

use Illuminate\Console\Command;

Use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

use Laravel\Dusk\Browser;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;

class FullTest extends Command
{
    protected $signature = 'check:full-test';

    protected $description = 'does a test with a browser';

    public function handle()
    {
        Artisan::call('migrate:fresh', ['--force' => true]);
        Check::set_configs();
        Check::seed();
        $chromeProcess = new \Symfony\Component\Process\Process(
            ['C:\tools\chromedriver.exe', '--port=9515']
        );
        $chromeProcess->start();
        sleep(1);
        Browser::$baseUrl = 'http://127.0.0.1:8000';
        $driver = RemoteWebDriver::create('http://localhost:9515', DesiredCapabilities::chrome());
        $browser = new Browser($driver);
        $browser->visit('/');
        $logs = $driver->manage()->getLog('browser');
        $browser->script('$("#number").set_value("1111");');
        $browser->script('$("#password").set_value("1111");');
        $browser->click('#LoginForm-button > .btn')->waitForLocation('/client-login');
        $logs = array_merge($logs, $driver->manage()->getLog('browser'));
        $browser->quit();
        $this->info(json_encode($logs, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        $chromeProcess->stop();
    }
}