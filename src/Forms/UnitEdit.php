<?php

namespace Ro749\FullListingTemplate\Forms;

use Illuminate\Http\Request;
use Ro749\SharedUtils\Forms\BaseForm;
use Ro749\SharedUtils\Forms\Field;
use Ro749\SharedUtils\Forms\Selector;
use Ro749\SharedUtils\Forms\InputType;
use Ro749\FullListingTemplate\Enums\Options as OptionsEnum;
use Ro749\FullListingTemplate\Models\Unit;
class UnitEdit extends BaseForm
{
    public function __construct()
    {
        parent::__construct(
            model_class: Unit::get_class(),
            submit_text: "",
            fields: [
                'id' => new Field(
                    type: InputType::HIDDEN
                ),
                'price' => new Field(
                    type: InputType::NUMBER,
                ),
                'status' => new Selector(
                    options: OptionsEnum::UnitsStatus
                )
            ],
        );
    }

    public function get_default_args(){
        $unit = Unit::instance()->first();
        return ['request' => Request::create('/', 'POST',[
            'id' => $unit->id,
            'price' => $unit->price,
            'status' => $unit->status
        ])];
    } 
}
