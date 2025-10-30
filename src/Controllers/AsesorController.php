<?php

namespace Ro749\FullListingTemplate\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Ro749\SharedUtils\Controllers\Controller;
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
        $client = DB::table('clients')->where('id', $request->input('id'))->first();
        $form = ClientComment::instanciate();
        $form->initial_data = ['long_comment'=>$client->long_comment];
        return view(config('overrides.views.client-profile'), [
            'client'=>$client,
            'form'=>$form,
            'table'=>ClientProfileTable::instance()
        ]);
    }

    public function update_profile(Request $request){
        $file = $request->file('pfp');
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('uploads', $filename, 'public');
        $asesor =  Auth::guard('asesor')->user();
        if ($asesor->pfp != '') {
            Storage::disk('public')->delete('uploads/' . $asesor->pfp);
        }
        DB::table('asesors')
            ->where('id', $asesor->id)
            ->update(values: [
                'pfp'=>$filename
            ]);
    }
}
