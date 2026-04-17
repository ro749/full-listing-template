<?php

namespace Ro749\FullListingTemplate\Forms;

use Illuminate\Http\Request;
use Ro749\SharedUtils\Forms\BaseForm;
use Ro749\SharedUtils\Forms\Field;
use Ro749\SharedUtils\Forms\Selector;
use Ro749\SharedUtils\Forms\InputType;
use Ro749\FullListingTemplate\Models\Unit;
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
                'asesor' => Selector::fromDB(
                    id: 'asesor',
                    table: 'asesors',
                    label_column: 'name',
                ),
                'client'=>Selector::fromDB(
                    id: 'client',
                    table: 'clients',
                    label_column: 'name',
                    hot_reload: route('clients-asesor')
                ),
                'sale_date' => new Field(
                    type: InputType::DATE,
                ),
            ],
        );
    }
    public function get_default_args(){
        $unit = Unit::first();
        return ['request' => Request::create('/', 'POST',[
            'final_price' => $unit->final_price,
            'asesor' => $unit->asesor,
            'client' => $unit->client,
            'sale_date' => $unit->sale_date
        ])];
    } 
}
