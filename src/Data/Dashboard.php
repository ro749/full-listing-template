<?php

namespace Ro749\FullListingTemplate\Data;
use Ro749\SharedUtils\Data\Data;
use Ro749\FullListingTemplate\Models\Asesor;
use Ro749\FullListingTemplate\Models\Client;
use Ro749\FullListingTemplate\Models\Unit;
use Ro749\FullListingTemplate\Models\Quotation;
use Ro749\FullListingTemplate\Enums\UnitsStatus;
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
        Log::info("Total units value: ".$ans->available_units_value);
        Log::info("Total units avg: ".$ans->available_units_avg);
        return $ans;
    }
}
