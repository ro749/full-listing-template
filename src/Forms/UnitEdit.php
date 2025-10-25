<?php

namespace Ro749\FullListingTemplate\Forms;

use Ro749\SharedUtils\Forms\BaseForm;
use Ro749\SharedUtils\Forms\FormField;
use Ro749\SharedUtils\Forms\Selector;
use Ro749\SharedUtils\Forms\InputType;
use Ro749\FullListingTemplate\Enums\Options as OptionsEnum;
use Ro749\FullListingTemplate\Models\Unit;
class UnitEdit extends BaseForm
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
                'price' => new FormField(
                    type: InputType::NUMBER,
                ),
                'status' => new Selector(
                    options: OptionsEnum::UnitsStatus
                )
            ],
        );
    }
}
