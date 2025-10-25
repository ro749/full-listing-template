<?php

namespace Ro749\FullListingTemplate\Forms;

use Ro749\SharedUtils\Forms\BaseForm;
use Ro749\SharedUtils\Forms\FormField;
use Ro749\SharedUtils\Forms\Selector;
use Ro749\SharedUtils\Forms\InputType;
use Ro749\FullListingTemplate\Models\Unit;
class VentaEdit extends BaseForm
{
    public function __construct()
    {
        parent::__construct(
            model_class: Unit::class,
            submit_text: "",
            fields: [
                'id' => new FormField(
                    type: InputType::HIDDEN
                ),
                'final_price' => new FormField(
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
                'sale_date' => new FormField(
                    type: InputType::DATE,
                ),
            ],
        );
    }
}
