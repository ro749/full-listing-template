<?php

namespace Ro749\FullListingTemplate\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Ro749\SharedUtils\Controllers\Controller;
use Ro749\FullListingTemplate\Senders\CotizationSender;
use Ro749\FullListingTemplate\Models\Unit;
use Ro749\FullListingTemplate\Models\Asesor;
use Ro749\FullListingTemplate\Models\Quotation;
use Ro749\FullListingTemplate\Models\Client;
use Ro749\FullListingTemplate\Tables\Torre;
use Ro749\FullListingTemplate\Enums\QuotationStatus;
use Ro749\FullListingTemplate\Enums\UnitsStatus;
class DispoController extends Controller
{
    function index() {
        $imp = config()->get('overrides.image_map_pro')::instance();
        $plans = config()->get('overrides.plans')::instance();
        $cotization =  config()->get('overrides.sender')::instance();
        $client_id = session()->get('client_id');
        $client = null;
        if(!empty($client_id)){
            $client = Client::where('id', $client_id)->value('name');
        }
        $asesor = Auth::guard('asesor')->user();
        return view('disponibilidad',[
            'plans'=>$plans->get(),
            'imp'=>$imp,
            'sender'=>$client!=null?$cotization:null,
            'client'=>$client,
            'asesor'=>$asesor->name,
            'unit'=>null,
            'menu'=>true,
            'asesor_area'=>$asesor,
        ]);
    }

    function client(Request $request) {
        $id = $request->input('id');
        $cotization = Quotation::where('id', $id)->first();
        if(!Auth::guard('asesor')->check() && !Auth::guard('web')->check()){
            $cotization->n_open += 1;
            $cotization->save();
        }
        $unit = Unit::get('id', $cotization->unit);
        $asesor = Asesor::where('id', $cotization->asesor)->first();
        if(
            $unit->status != UnitsStatus::Disponible->value && (
            $cotization->status == QuotationStatus::Pendiente->value ||
            $cotization->status == QuotationStatus::Rechazado->value)
        ){
            return view('unavailable',['asesor'=>$asesor]);
        }
        $plans = config()->get('overrides.plans')::instance();
        return view('disponibilidad',[
            'plans'=>$plans->get(),
            'unit'=>$unit,
            'asesor_area'=>$asesor,
        ]);
    }

    function torre(Request $request){
        $torre = Torre::instance();
        $client_id = session()->get('client_id');
        if(!$client_id) return redirect()->route('client-login');
        $client = Client::where('id', $client_id)->first()->name;
        return view('torre',[
            'table'=>$torre,
            'client'=>$client,
            'asesor'=>Auth::guard('asesor')->user()->name,
            'menu'=>true
        ]);
    }

    function asesor(Request $request){
        $id = $request->input('id');
        $unit = Unit::get('id', $id);
        $plans = config()->get('overrides.plans')::instance();
        $cotization =  config()->get('overrides.sender')::instance();
        $client_id = session()->get('client_id');
        return view('disponibilidad',[
            'plans'=>$plans->get(),
            'unit'=>$unit,
            'sender'=>$client_id!=null?$cotization:null,
            'menu'=>true
        ]);
    }
}
