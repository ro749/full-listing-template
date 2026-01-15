<?php

namespace Ro749\FullListingTemplate\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Ro749\SharedUtils\Controllers\Controller;
use Ro749\FullListingTemplate\Forms\ClientComment;
use Ro749\FullListingTemplate\Tables\ClientsAdmin;
use Ro749\FullListingTemplate\Tables\QuotationsAdmin;
use Ro749\FullListingTemplate\Tables\Ventas;
use Ro749\FullListingTemplate\Tables\TorreAdmin;
use Ro749\FullListingTemplate\Tables\ClientProfileTable;
use Ro749\FullListingTemplate\Forms\UpdatePrices;
use Ro749\FullListingTemplate\Tables\PreviewTable;
use Ro749\FullListingTemplate\Data\Dashboard as DashboardData;
use Ro749\SharedUtils\Statistics\ChartTime;
use Ro749\SharedUtils\Getters\TimeGetter;
use Ro749\FullListingTemplate\Charts\AsesorsChart;
use Ro749\FullListingTemplate\Charts\ClientsChart;
use Ro749\FullListingTemplate\Charts\SoldUnitsChart;
use Ro749\FullListingTemplate\Charts\AvailableUnitsChart;
use Ro749\FullListingTemplate\Charts\QuotesChart;
use Ro749\FullListingTemplate\Charts\SalesChart;
class AdminController extends Controller
{
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

    public function profile(Request $request){
        $client = DB::table('clients')->where('id', $request->input('id'))->first();
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
            return DB::table('clients')->where('asesor', $request->input('asesor'))->get();
        }
        $unit = DB::table('units')->where('id', $request->input('id'))->first();
        return DB::table('clients')
        ->select('id', 'name as value')
        ->where('asesor', $unit->asesor)->get();
    }

    public function dashboard(){
        $data = DashboardData::instance();
        $asesors_chart = new AsesorsChart();
        $clients_chart = new ClientsChart();
        $sold_units_chart = new SoldUnitsChart();
        $available_units_chart = new AvailableUnitsChart();
        $quotes_chart = new QuotesChart();
        $sales_chart = new SalesChart();
        return view('full-listing-template::dashboard', [
            'data'=>$data,
            'asesors_chart'=>$asesors_chart,
            'clients_chart'=>$clients_chart,
            'sold_units_chart'=>$sold_units_chart,
            'available_units_chart'=>$available_units_chart,
            'quotes_chart'=>$quotes_chart,
            'sales_chart'=>$sales_chart
        ]);
    }
}
