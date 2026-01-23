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
use Ro749\FullListingTemplate\Charts\AsesorsChart;
use Ro749\FullListingTemplate\Charts\ClientsChart;
use Ro749\FullListingTemplate\Charts\SoldUnitsChart;
use Ro749\FullListingTemplate\Charts\AvailableUnitsChart;
use Ro749\FullListingTemplate\Charts\QuotesChart;
use Ro749\FullListingTemplate\Charts\SalesChart;

use Ro749\SharedUtils\Getters\BaseGetter;
use Ro749\FullListingTemplate\Models\Unit;
use Ro749\FullListingTemplate\Models\Model;
use Ro749\SharedUtils\Models\LogicModifiers\LogicModifier;
use Ro749\SharedUtils\Statistics\Statistic;
use Ro749\SharedUtils\Statistics\StatisticColumn;
use Ro749\SharedUtils\Statistics\StatisticType;
use Ro749\SharedUtils\Tables\Column;
use Ro749\SharedUtils\Models\LogicModifiers\ForeignKey;
use Ro749\FullListingTemplate\Models\Quotation;
use Ro749\SharedUtils\Statistics\StatisticLink;
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
        $models__getter = new BaseGetter(
            model_class: Model::get_class(),
            columns : [
                'name'=>new Column(
                    display:"Modelos",
                ),
                'modelo_percent'=>new Column(
                    display:"Porcentaje",
                    logic_modifier: new ForeignKey(
                        table: 'model_stats',
                        column: 'modelo_percent'
                    )
                )
            ],
            statistics:[
                'model_stats' => new Statistic(
                    model_class: Unit::get_class(),
                    group_column: 'modelo',
                    columns: [
                        'modelo_percent'=>new StatisticColumn(
                            type: StatisticType::COUNT
                        ),
                    ]
                ),
                'quote_stats' => new Statistic(
                    model_class: Quotation::get_class(),
                    group_column: 'modelo',
                    columns: [
                        'quote_count'=>new StatisticColumn(
                            type: StatisticType::COUNT
                        ),
                    ],
                    link: new StatisticLink(
                        model_class: Unit::get_class(),
                        column: 'unit',
                    )
                )
            ],
            //debug: true
        );
        $model_data = $models__getter->get()['data'];
        foreach($model_data as $index => $model){
            $model_data[$index]->color = generate_color($index+1);
        }
        Log::info($model_data);
        return view('full-listing-template::dashboard', [
            'data'=>$data,
            'asesors_chart'=>$asesors_chart,
            'clients_chart'=>$clients_chart,
            'sold_units_chart'=>$sold_units_chart,
            'available_units_chart'=>$available_units_chart,
            'quotes_chart'=>$quotes_chart,
            'sales_chart'=>$sales_chart,
            'model_data'=>$model_data
        ]);
    }
}

function generate_color(int $seed){
    $goldenAngle = 137.5;

    $hue = ($seed * $goldenAngle) % 360;
    $saturation = 60 + (($seed * 23) % 35);
    $lightness = 50 + (($seed * 17) % 15); 
    return hslToHex($hue, $saturation, $lightness);
}

function hslToHex($h, $s, $l) {
    $s /= 100;
    $l /= 100;
    $c = (1 - abs(2 * $l - 1)) * $s;
    $x = $c * (1 - abs(fmod($h / 60, 2) - 1));
    $m = $l - $c / 2;
    if ($h < 60) {
        $r = $c; $g = $x; $b = 0;
    } elseif ($h < 120) {
        $r = $x; $g = $c; $b = 0;
    } elseif ($h < 180) {
        $r = 0; $g = $c; $b = $x;
    } elseif ($h < 240) {
        $r = 0; $g = $x; $b = $c;
    } elseif ($h < 300) {
        $r = $x; $g = 0; $b = $c;
    } else {
        $r = $c; $g = 0; $b = $x;
    }
    $r = round(($r + $m) * 255);
    $g = round(($g + $m) * 255);
    $b = round(($b + $m) * 255);
    return sprintf("#%02x%02x%02x", $r, $g, $b);
}
