<?php

namespace Ro749\FullListingTemplate\Forms;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Ro749\SharedUtils\Forms\BaseForm;
use Ro749\SharedUtils\Forms\Selector;
use Ro749\FullListingTemplate\Models\Client;

class SelectClient extends BaseForm
{
    public function __construct()
    {
        parent::__construct(
            submit_text: "Entrar",
            redirect: route('disponibilidad'),
            fields: [
                "client" => Selector::fromDB(
                    id: "client",
                    table: "clients",
                    label_column: "name",
                    query_modifier: function ($query) {
                        return $query->where('asesor', Auth::guard('asesor')->user()->id)->orderBy('id', 'desc');
                    }
                )
            ],
        );
    }

    public function prosses(Request $request): string
    {
        if(empty($request->input('client'))){
            return '';
        }
        session()->put('client_id', $request->input('client'));
        return $this->redirect;
    }

    public function get_default_args(){
        return ['request' => Request::create('/', 'POST',[
            'client' => Client::first()->id
        ])];
    } 
}
