<?php

namespace Ro749\FullListingTemplate\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ro749\SharedUtils\Controllers\Controller;
use Ro749\FullListingTemplate\Models\Client;
use Ro749\FullListingTemplate\Forms\RegisterClient;
use Ro749\FullListingTemplate\Forms\SelectClient;
use Ro749\FullListingTemplate\Forms\ClientComment;
use Ro749\FullListingTemplate\Tables\Clients;
use Ro749\FullListingTemplate\Tables\Quotations;
use Ro749\FullListingTemplate\Tables\ClientProfileTable;

class AsesorController extends Controller
{
    public function index() {
        DB::table('sessions')
            ->where('id', session()->getId())
            ->update([
                'guard' => 'asesor',
            ]);
        $form_register = RegisterClient::instanciate();
        $form_select = SelectClient::instanciate();
        return view(config('overrides.views.client-login'), [
            'form_register'=>$form_register, 
            'form_select'=>$form_select
        ]);
    }

    public function clients(){
        $table = Clients::instance();
        return view(config('overrides.views.table-asesor'), ['table'=>$table]);
    }

    public function quotations(){
        $table = Quotations::instance();
        return view(config('overrides.views.table-asesor'), ['table'=>$table]);
    }

    public function profile(Request $request){
        $client = Client::where('id', $request->input('id'))->first();
        $form = ClientComment::instanciate();
        $form->initial_data = ['long_comment'=>$client->long_comment];
        return view(config('overrides.views.client-profile'), [
            'client'=>$client,
            'form'=>$form,
            'table'=>ClientProfileTable::instance()
        ]);
    }

    public function get_default_args($function){
        switch ($function) {
            case 'profile':
                return ['request' => Request::create('/asesor/profile', 'GET',['id'=>Client::first()->id])];
            case 'update_profile':
                return ['request' => Request::create('/asesor/update_profile', 'POST')];
            default:
                return [];
        }
    }
}
