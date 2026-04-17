<?php

namespace Ro749\FullListingTemplate\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Ro749\SharedUtils\Controllers\Controller;
use Ro749\FullListingTemplate\Data\UnitData;
use Ro749\FullListingTemplate\Models\Asesor;
use Ro749\FullListingTemplate\Models\Quotation;
use Ro749\FullListingTemplate\Models\Client;
use Ro749\FullListingTemplate\Models\Unit;
use Ro749\FullListingTemplate\Tables\Torre;
use Ro749\FullListingTemplate\Enums\QuotationStatus;
use Ro749\FullListingTemplate\Enums\UnitsStatus;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
class DispoController extends Controller
{
    function index() {
        $imp = config()->get('overrides.image_map_pro')::instance();
        $plans = config()->get('overrides.plans')::instance();
        $senderClass = config('overrides.sender');
        $sender = new $senderClass($plans);
        $client_id = session()->get('client_id');
        $client = null;
        if(!empty($client_id)){
            $client = Client::where('id', $client_id)->value('name');
        }
        $asesor = Auth::guard('asesor')->user();
        return view(config('overrides.views.disponibilidad'),[
            'plans'=>$plans,
            'imp'=>$imp,
            'sender'=>$client!=null?$sender:null,
            'client'=>$client,
            'asesor'=>$asesor->name,
            'unit'=>null,
            'menu'=>true,
            'dispo_btns'=>true,
            'asesor_area'=>$asesor,
            'personal_plan'=>null
        ]);
    }

    function client(Request $request) {
        $id = $request->input('id');
        $quotation = Quotation::where('id', $id)->first();
        if(!Auth::guard('asesor')->check() && !Auth::guard('web')->check()){
            $quotation->n_open += 1;
            $quotation->save();
        }
        $data_class = UnitData::get_class();
        $data = new $data_class('id', $quotation->unit);
        $unit = $data->get_data();
        $asesor = Asesor::where('id', $quotation->asesor)->first();
        if(
            $unit->status != UnitsStatus::Disponible->value && (
            $quotation->status == QuotationStatus::Pendiente->value ||
            $quotation->status == QuotationStatus::Rechazado->value)
        ){
            return view(config('overrides.views.unavailable'),['asesor'=>$asesor]);
        }
        $client = Client::where('id', $quotation->client)->first()->name;
        $plans = config()->get('overrides.plans')::instance();
        $data = [
            'unit'=>$unit,
            'asesor_area'=>$asesor,
            'asesor'=>$asesor->name,
            'client'=>$client,
            'personal_plan'=>null,
        ];
        if(config()->has('listing.plans.personalized_plan')){
            $personal = DB::table('personal_plans')->where('quotation', $quotation->id)->first();
            if($personal){
                $data['personal_plan'] = $personal;
                $data['plans']=$plans;
            }
            else{
                //$data['plans']=$plans->get(needs_personal: false);
                $data['personal_plan'] = null;
                $data['plans']=$plans;
            }
        }
        else{
            $data['plans']=$plans;
        }
        return view(config('overrides.views.disponibilidad'),$data);
    }

    function torre(){
        $torre = Torre::instance();
        $client_id = session()->get('client_id');
        if(!$client_id) return redirect()->route('client-login');
        $client = Client::where('id', $client_id)->first()->name;
        return view(config('overrides.views.torre'),[
            'table'=>$torre,
            'client'=>$client,
            'asesor'=>Auth::guard('asesor')->user()->name,
            'menu'=>true,
            'dispo_btns'=>true,
        ]);
    }

    function asesor(Request $request){
        $id = $request->input('id');
        $data_class = UnitData::get_class();
        $data = new $data_class('id', $id);
        $unit = $data->get_data();
        $plans = config()->get('overrides.plans')::instance();
        $senderClass = config('overrides.sender');
        $sender = new $senderClass($plans);
        $client_id = session()->get('client_id');
        $client = null;
        if(!empty($client_id)){
            $client = Client::where('id', $client_id)->value('name');
        }
        $asesor = Auth::guard('asesor')->user();
        return view(config('overrides.views.disponibilidad'),[
            'plans'=>$plans,
            'unit'=>$unit,
            'sender'=>$client_id!=null?$sender:null,
            'menu'=>true,
            'dispo_btns'=>true,
            'client'=>$client,
            'asesor'=>$asesor->name,
            'asesor_area'=>$asesor,
            'personal_plan'=>null
        ]);
    }

    function unavailable(){
        return view(config('overrides.views.unavailable'),[
            $asesor=Auth::guard('asesor')->user()
        ]);
    }

    function open() {
        if(!config()->has(config()->has('listing.open'))) return;
        $imp = config()->get('overrides.image_map_pro')::instance();
        $plans = config()->get('overrides.plans')::instance();
        $form = config('overrides.forms.Contact')::instanciate();
        return view(config('overrides.views.disponibilidad'),[
            'plans'=>$plans,
            'imp'=>$imp,
            'unit'=>null,
            'personal_plan'=>null,
            'dispo_btns'=>true,
            'is_open'=>true,
            'form'=>$form,
        ]);
    }

    function listado(){
        if(!config()->has(config()->has('listing.open'))) return;
        $torre = Torre::instance();
        $torre->view->url = route('view');
        return view(config('overrides.views.torre'),[
            'table'=>$torre,
            'dispo_btns'=>true,
            'is_open'=>true,
        ]);
    }

    function view(Request $request){
        if(!config()->has(config()->has('listing.open'))) return;
        $id = $request->input('id');
        $data_class = UnitData::get_class();
        $data = new $data_class('id', $id);
        $unit = $data->get_data();
        $plans = config()->get('overrides.plans')::instance();
        return view(config('overrides.views.disponibilidad'),[
            'plans'=>$plans,
            'unit'=>$unit,
            'dispo_btns'=>true,
            'is_open'=>true,
        ]);
    }

    public function get_default_args($function){
        switch ($function) {
            case 'client':
                return ['request' => Request::create('/', 'GET',['id'=>Quotation::first()->id])];
            case 'asesor':
                return ['request' => Request::create('/', 'GET',['id'=>Unit::first()->id])];
            case 'view':
                return ['request' => Request::create('/', 'GET',['id'=>Unit::first()->id])];
            default:
                return [];
        }
    }
}
