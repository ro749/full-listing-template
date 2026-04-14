<?php

namespace Ro749\FullListingTemplate\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Ro749\FullListingTemplate\Controllers\AsesorController;
use Ro749\FullListingTemplate\Controllers\DispoController;
use Ro749\FullListingTemplate\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;
use Ro749\FullListingTemplate\Models\Quotation;
use Ro749\FullListingTemplate\Models\Asesor;
use Ro749\FullListingTemplate\Models\Client;

class Check extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:listing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if this project is ready to uplad, and autofixes what it can';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        if (!file_exists(app_path('Mail/CotizationMail.php'))) {
            $this->error('Falta el correo.');
            return self::FAILURE;
        }

        $this->call('check');
        $packageConfig = require __DIR__.'/../../config/full-listing-template.php';
        $packageConfig = $packageConfig['overrides'];
        $config = require config_path('overrides.php');
        
        Config::set('overrides', $this->mergeConfigs($packageConfig, $config));

        Auth::guard('asesor')->loginUsingId(1);
        
        if($this->check_asesor_controller() == self::FAILURE){
            $this->error('Error en AsesorController');
            return self::FAILURE;
        }

        if($this->check_dispo_controller() == self::FAILURE){
            $this->error('Error en DispoController');
            return self::FAILURE;
        }

        if($this->check_admin_controller() == self::FAILURE){
            $this->error('Error en AdminController');
            return self::FAILURE;
        }

        
        return self::SUCCESS;
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

    function check_asesor_controller(){
        try{
            $control = AsesorController::instance();
            $control->index();
            $control->clients();
            $control->quotations();
            $req = Request::create('/asesor/profile', 'GET',['id'=>1]);
            $control->profile($req);
        }
        catch (\Exception $e){
            $this->error($e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());
            return self::FAILURE;
        }
    }

    function check_dispo_controller(){
        try{
            $control = DispoController::instance();
            $control->index();
            $control->torre();
            $quotation = Quotation::first();
            $req = Request::create('/', 'GET',['id'=>$quotation->id]);
            $control->client($req);
            $control->unavailable();

        }
        catch (\Exception $e){
            $this->error($e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());
            return self::FAILURE;
        }
    }

    function check_admin_controller(){
        try{
            $control = AdminController::instance();
            $control->clients();
            $control->torre();
            $control->ventas();
            $control->precios();
            $control->quotations();
            $client = Client::first();
            $asesor = Asesor::first();
            $req = Request::create('/', 'GET',['id'=>$client->id, 'asesor'=>$asesor->id]);
            $control->profile($req);
            $control->get_clients($req);
            //$control->dashboard();
        }
        catch (\Exception $e){
            $this->error($e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());
            return self::FAILURE;
        }
    }
}
