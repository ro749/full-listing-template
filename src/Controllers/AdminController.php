<?php

namespace Ro749\FullListingTemplate\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ro749\SharedUtils\Controllers\Controller;
use Ro749\FullListingTemplate\Forms\ClientComment;
use Ro749\FullListingTemplate\Tables\ClientsAdmin;
use Ro749\FullListingTemplate\Tables\QuotationsAdmin;
use Ro749\FullListingTemplate\Tables\Ventas;
use Ro749\FullListingTemplate\Tables\TorreAdmin;
use Ro749\FullListingTemplate\Tables\ClientProfileTable;
use Ro749\FullListingTemplate\Forms\UpdatePrices;
use Ro749\FullListingTemplate\Tables\PreviewTable;
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
}
