<?php

namespace Ro749\FullListingTemplate\Forms;

use Illuminate\Http\Request;
use Ro749\SharedUtils\Forms\BaseForm;
use Ro749\SharedUtils\Forms\Field;
use Ro749\SharedUtils\Forms\Selector;
use Ro749\SharedUtils\Forms\SelectorDB;
use Ro749\SharedUtils\Forms\InputType;
use Ro749\FullListingTemplate\Models\Unit;
use Ro749\FullListingTemplate\Models\Asesor;
use Ro749\FullListingTemplate\Models\Client;
class VentaEdit extends BaseForm
{
    public function __construct()
    {
        parent::__construct(
            model_class: Unit::get_class(),
            fields: [
                'final_price' => new Field(
                    type: InputType::NUMBER,
                ),
                'asesor' => new SelectorDB(
                    id: 'asesor',
                    model_class: Asesor::get_class(),
                    label_column: 'name',
                ),
                'client'=> new SelectorDB(
                    id: 'client',
                    model_class: Client::get_class(),
                    label_column: 'name',
                    hot_reload: 'asesor',
                    query_modifier: function ($query, $request = null) {
                        if ($request!=null && $request->has('asesor')) {
                            return $query->where('asesor_id', $request->input('asesor'));
                        }
                        return $query;
                    }
                ),
                'sale_date' => new Field(
                    type: InputType::DATE,
                ),
            ],
        );
    }
    public function get_default_args(){
        $unit = Unit::instance()->first();
        return ['request' => Request::create('/', 'POST',[
            'final_price' => $unit->final_price,
            'asesor' => $unit->asesor_id,
            'client' => $unit->client_id,
            'sale_date' => $unit->sale_date
        ])];
    } 
}
