<?php

namespace Ro749\FullListingTemplate\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Ro749\SharedUtils\Controllers\Controller;
use Ro749\FullListingTemplate\Models\Client;
use Ro749\FullListingTemplate\Models\Unit;
use Ro749\FullListingTemplate\Forms\ClientComment;
use Ro749\FullListingTemplate\Tables\ClientsAdmin;
use Ro749\FullListingTemplate\Tables\QuotationsAdmin;
use Ro749\FullListingTemplate\Tables\Ventas;
use Ro749\FullListingTemplate\Tables\TorreAdmin;
use Ro749\FullListingTemplate\Tables\ClientProfileTable;
use Ro749\FullListingTemplate\Forms\UpdatePrices;
use Ro749\FullListingTemplate\Tables\PreviewTable;
use Ro749\FullListingTemplate\Forms\UploadClients;


use Ro749\FullListingTemplate\Data\Dashboard as DashboardData;
use Ro749\FullListingTemplate\Charts\AsesorsChart;
use Ro749\FullListingTemplate\Charts\ClientsChart;
use Ro749\FullListingTemplate\Charts\SoldUnitsChart;
use Ro749\FullListingTemplate\Charts\AvailableUnitsChart;
use Ro749\FullListingTemplate\Charts\QuotesChart;
use Ro749\FullListingTemplate\Charts\SalesChart;
use Ro749\FullListingTemplate\Charts\AsesorsQuotesChart;
use Ro749\FullListingTemplate\Forms\RegisterClientAdmin;


use Ro749\FullListingTemplate\Tables\AsesorsDashboard;

class AdminController extends Controller
{
    protected $model_imgs_route = "https://propstudios.mx/img/Soho/Modelos/ISO/";
    protected $imgs_type = "png";

    public function clients() {
        $table = ClientsAdmin::instance();
        return view(config('overrides.views.simple-table'), ['table'=>$table]);
    }

    public function quotations() {
        $table = QuotationsAdmin::instance();
        return view(config('overrides.views.simple-table'), ['table'=>$table]);
    }

    public function torre() {
        $table = TorreAdmin::instance();
        return view(config('overrides.views.simple-table'), ['table'=>$table]);
    }

    public function ventas() {
        $table = Ventas::instance();
        return view(config('overrides.views.sales-table'), ['table'=>$table]);
    }

    public function precios() {
        $form = UpdatePrices::instanciate();
        $table = PreviewTable::instance();
        return view(config('overrides.views.actualizar-precios'),['form'=>$form, 'table'=>$table]);
    }

    public function cargar_clientes() {
        $form = UploadClients::instanciate();
        return view(config('overrides.views.cargar-clientes'),['form'=>$form]);
    }

    public function profile(Request $request){
        $client = Client::where('id', $request->input('id'))->first();
        $form = ClientComment::instanciate();
        $form->initial_data = ['long_comment'=>$client->long_comment];
        return view(config('overrides.views.client-profile-admin'), [
            'client'=>$client,
            'form'=>$form,
            'table'=>ClientProfileTable::instance()
        ]);
    }

    public function get_clients(Request $request){
        if($request->has('asesor')){
            return Client::instance()->where('asesor_id', $request->input('asesor'))->get();
        }
        $unit = Unit::instance()->where('id', $request->input('id'))->first();
        return Client::instance()->select('id', 'name as value')->where('asesor_id', $unit->asesor)->get();
    }

    public function dashboard(){
        if(!config()->has('listing.dashboard')) return;
        $data = DashboardData::instance();
        $asesors_chart = new AsesorsChart();
        $clients_chart = new ClientsChart();
        $sold_units_chart = new SoldUnitsChart();
        $available_units_chart = new AvailableUnitsChart();
        $quotes_chart = new QuotesChart();
        $sales_chart = new SalesChart();
        $asesores_table = AsesorsDashboard::instance();
        $asesors_quotes = new AsesorsQuotesChart();
        
        return view(config('overrides.views.dashboard'), [
            'data'=>$data,
            'asesors_chart'=>$asesors_chart,
            'clients_chart'=>$clients_chart,
            'sold_units_chart'=>$sold_units_chart,
            'available_units_chart'=>$available_units_chart,
            'quotes_chart'=>$quotes_chart,
            'sales_chart'=>$sales_chart,
            'asesores_table'=>$asesores_table,
            'asesors_quotes'=>$asesors_quotes,
            'model_imgs_route'=>$this->model_imgs_route,
            'imgs_type'=>$this->imgs_type
        ]);
    }

    public function register_client(){
        $form = RegisterClientAdmin::instanciate();
        return view(config('overrides.views.register-client'), ['form'=>$form]);
    }

    public function get_default_args($function){
        if(Client::count() == 0){
            Client::create([
                'name'=>'Test Client',
                'mail'=>'a@a.com',
                'phone'=>'3337811700',
            ]);
        }
        switch ($function) {
            case 'profile':
                return ['request' => Request::create('/', 'GET',['id'=>Client::first()->id])];
            case 'get_clients':
                return ['request' => Request::create('/', 'GET',['id'=>Client::first()->id])];
            default:
                return [];
        }
    }
}


