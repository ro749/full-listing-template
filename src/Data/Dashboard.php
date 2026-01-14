<?php

namespace Ro749\FullListingTemplate\Data;
use Ro749\SharedUtils\Data\Data;
use Ro749\FullListingTemplate\Models\Asesor;
use Ro749\FullListingTemplate\Models\Client;
use Ro749\FullListingTemplate\Models\Unit;
use Ro749\FullListingTemplate\Models\Quotation;
use Ro749\FullListingTemplate\Enums\UnitsStatus;

class Dashboard extends Data
{
    public function __construct(){
        parent::__construct(dynamic: false);
    }

    public function init_data($request = null){
        $ans = [];
        $ans['total_asesores'] = Asesor::get_class()::count();
        $ans['total_clients'] = Client::get_class()::count();
        $ans['sold_units'] = Unit::get_class()::where('status', UnitsStatus::Vendido)->count();
        $ans['available_units'] = Unit::get_class()::where('status', UnitsStatus::Disponible)->count();
        $ans['total_quotes'] = Quotation::get_class()::count();
        $ans['new_quotes'] = Quotation::get_class()::
            whereBetween('created_at', [now()->startOfMonth()->format('Y-m-d'), now()->endOfMonth()->format('Y-m-d')])
            ->count();
        return $ans;
    }
}
