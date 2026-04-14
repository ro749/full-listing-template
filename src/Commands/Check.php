<?php

namespace Ro749\FullListingTemplate\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Ro749\FullListingTemplate\Controllers\AsesorController;
use Ro749\FullListingTemplate\Controllers\DispoController;
use Ro749\FullListingTemplate\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Ro749\FullListingTemplate\Models\Quotation;

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
        $normal = [
            '/'
        ];
        $asesor = [
            'client-login',
            'clients',
            'cotizaciones',
            'disponibilidad',
            'listado',
            'view-asesor',
            'client-profile',
            'reset-password',
            'admin',
            'client-view',
            'unavailable',
            'logout'
        ];
        $admin = [
            'admin/clients',
            'admin/unidades',
            'admin/ventas',
            'admin/actualizar-precios',
            'admin/cotizaciones',
            'admin/client-profile',
            'admin/clients-asesor',
            'admin/dashboard',
            'admin/register-asesor',
            'admin/asesors',
        ];

        Auth::guard('asesor')->loginUsingId(1);
        
        if($this->check_asesor_controller() == self::FAILURE){
            $this->error('Error en AsesorController');
            return self::FAILURE;
        }

        //foreach ($asesor as $route) {
        //    $request = Request::create('/asesor/' . $route, 'GET');
        //    app()->instance('request', $request);
        //    
        //}
        return self::SUCCESS;

        

        $this->call('check');
        return self::SUCCESS;
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
        }
        catch (\Exception $e){
            $this->error($e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());
            return self::FAILURE;
        }
    }
}
