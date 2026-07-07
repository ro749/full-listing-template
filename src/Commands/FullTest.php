<?php

namespace Ro749\FullListingTemplate\Commands;

use Illuminate\Console\Command;

Use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

use Laravel\Dusk\Browser;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Chrome\ChromeOptions;
class FullTest extends Command
{
    protected $signature = 'check:full-test';

    protected $description = 'does a test with a browser';

    public function handle()
    {
        $this->info('Simulating a full test...');
        Artisan::call('migrate:fresh', ['--force' => true]);
        Check::set_configs();
        Check::seed();
        $chromeProcess = new \Symfony\Component\Process\Process(
            ['C:\tools\chromedriver.exe', '--port=9515']
        );
        $chromeProcess->start();
        sleep(1);
        Browser::$baseUrl = 'http://127.0.0.1:8000';

        $options = (new ChromeOptions)->addArguments([
            '--disable-search-engine-choice-screen',
        ]);

        $options->setExperimentalOption('prefs', [
            'credentials_enable_service' => false,
            'profile.password_manager_leak_detection' => false,
        ]);

        $driver = RemoteWebDriver::create('http://localhost:9515', DesiredCapabilities::chrome()->setCapability(
            ChromeOptions::CAPABILITY, $options
        ));
        $browser = new Browser($driver);
        $browser->driver->manage()->window()->maximize();
        $browser->visit('/');
        $logs = $driver->manage()->getLog('browser');
        $browser->script('$("#number").set_value("1111");');
        $browser->script('$("#password").set_value("1111");');
        $browser->click('#LoginForm-button > .btn')->waitForLocation('/client-login');
        $logs = array_merge($logs, $driver->manage()->getLog('browser'));
        $browser->pause(1000);
        $browser->scrollTo('#client');
        $browser->pause(1000);
        $browser->script('$("#client").set_value($("#client")[0].options[1].value);');
        $browser->click('#SelectClient-button > .btn')->waitForLocation('/disponibilidad',216);
        $logs = array_merge($logs, $driver->manage()->getLog('browser'));
        $browser->scrollTo('#image-map-pro');
        $imp_select = config('checker.imp_select');
        $browser->waitFor($imp_select, 5)->pause(1000);
        $browser->click($imp_select);
        $browser->pause(6000);
        if(config()->get('checker.personal_plan')){
            $this->test_personal_plan($browser);
        }
        $browser->waitFor('#get-link-btn', 5);
        $browser->script('$("#get-link-btn")[0].scrollIntoView({
            behavior: "instant",
            block: "center",
            inline: "center"
        })');
        $browser->pause(1000);
        $browser->click('#get-link-btn');
        $browser->pause(6000);
        $browser->quit();
        $this->info(json_encode($logs, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        $chromeProcess->stop();
    }

    public function test_personal_plan($browser){
        $browser->scrollTo('#'.config('checker.personal_plan.div'));
        $browser->waitFor('#'.config('checker.personal_plan.div'), 5);
        foreach(config('checker.personal_plan.fill') as $key => $value){
            $browser->script('$("#'.$key.'").set_value("'.$value.'").trigger("input");');
        }
        $browser->pause(6000);
    }
}