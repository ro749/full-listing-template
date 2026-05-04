<?php

namespace Ro749\FullListingTemplate\Data;
use Ro749\SharedUtils\Data\Data;
use Ro749\FullListingTemplate\Models\Asesor;
use Ro749\FullListingTemplate\Models\Client;
use Ro749\FullListingTemplate\Models\Unit;
use Ro749\FullListingTemplate\Models\Quotation;
use Ro749\FullListingTemplate\Enums\UnitsStatus;

use Ro749\SharedUtils\Getters\BaseGetter;
use Ro749\FullListingTemplate\Models\Model;
use Ro749\SharedUtils\Models\LogicModifiers\LogicModifier;
use Ro749\SharedUtils\Statistics\Statistic;
use Ro749\SharedUtils\Statistics\StatisticColumn;
use Ro749\SharedUtils\Statistics\StatisticType;
use Ro749\SharedUtils\Tables\Column;
use Ro749\SharedUtils\Models\LogicModifiers\ForeignKey;
use Ro749\SharedUtils\Statistics\StatisticLink;
use Illuminate\Support\Facades\Log;

class Dashboard extends Data
{
    public function __construct(){
        parent::__construct(dynamic: false);
    }

    public function init_data($request = null){
        $ans = new \stdClass();
        $ans->total_asesores = Asesor::get_class()::count();
        $ans->total_clients = Client::get_class()::count();
        $ans->sold_units = Unit::get_class()::where('status', UnitsStatus::Vendido)->count();
        $available_units = Unit::get_class()::where('status', '=', UnitsStatus::Disponible);
        $available_units_count = $available_units->count();
        $ans->available_units = $available_units_count;
        $ans->total_quotes = Quotation::get_class()::count();
        $ans->new_quotes = Quotation::get_class()::
            whereBetween('created_at', [now()->startOfMonth()->format('Y-m-d'), now()->endOfMonth()->format('Y-m-d')])
            ->count();
        $total_units = Unit::get_class()::where('status', '!=', UnitsStatus::Bloqueado)->count();
        $total_apartado = Unit::get_class()::where('status', UnitsStatus::Apartado)->count();
        $avaliable_units_total_price = $available_units->sum('price');
        $ans->percent_available = round($total_units > 0 ? $ans->available_units*100.0 / $total_units : 0,2).'%';
        $ans->percent_sold = round($total_units > 0 ? $ans->sold_units*100.0 / $total_units : 0,2).'%';
        $ans->percent_apartado = round($total_units > 0 ? $total_apartado*100.0 / $total_units : 0,2).'%';
        $ans->available_units_value = "$".number_format($avaliable_units_total_price, 2);
        $ans->available_units_avg =  "$".number_format(round($available_units_count > 0 ? $avaliable_units_total_price / $available_units_count : 0, 2), 2);
        $models_getter = new BaseGetter(
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
                ),
                'quote_count'=>new Column(
                    display:"Cotizaciones",
                    logic_modifier: new ForeignKey(
                        table: 'quote_stats',
                        column: 'quote_count'
                    )
                ),
                'price'=>new Column(
                    display:"Precio Promedio",
                    logic_modifier: new ForeignKey(
                        table: 'model_stats',
                        column: 'price'
                    )
                ),
            ],
            statistics:[
                'model_stats' => new Statistic(
                    model_class: Unit::get_class(),
                    group_column: 'modelo',
                    columns: [
                        'modelo_percent'=>new StatisticColumn(
                            type: StatisticType::COUNT
                        ),
                        'price' => new StatisticColumn(
                            type: StatisticType::AVERAGE,
                        ),
                    ]
                ),
                'quote_stats' => new Statistic(
                    model_class: Quotation::get_class(),
                    group_column: 'unit_id',
                    columns: [
                        'quote_count'=>new StatisticColumn(
                            type: StatisticType::COUNT
                        ),
                    ],
                    links: [new StatisticLink(
                        model_class: Unit::get_class(),
                        column: 'modelo',
                    )]
                )
            ]
        );
        //$asesors_quotes = new BaseGetter(
        //    
        //)
        $model_data = $models_getter->get()['data'];
        foreach($model_data as $index => $model){
            $model_data[$index]->color = generate_color($index+1);
        }
        $total = 0;
        foreach($model_data as $index => $model){
            $total += $model_data[$index]->quote_count;
        }
        foreach($model_data as $index => $model){
            $model_data[$index]->quote_percent = $total > 0 ? round(($model_data[$index]->quote_count / $total) * 100, 2) : 0;
        }
        $ans->model_data = $model_data;
        return $ans;
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

