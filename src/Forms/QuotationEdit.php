<?php

namespace Ro749\FullListingTemplate\Forms;

use Ro749\SharedUtils\Forms\BaseForm;
use Ro749\SharedUtils\Forms\Field;
use Ro749\SharedUtils\Forms\Selector;
use Ro749\SharedUtils\Forms\InputType;
use Ro749\FullListingTemplate\Enums\Options as OptionsEnum;
use Ro749\FullListingTemplate\Models\Quotation;
class QuotationEdit extends BaseForm
{
    public function __construct()
    {
        parent::__construct(
            model_class: Quotation::get_class(),
            submit_text: "",
            fields: [
                'id' => new Field(
                    type: InputType::HIDDEN
                ),
                'status' => new Selector(
                    options: OptionsEnum::QuotationStatus
                )
            ],
        );
    }
}
