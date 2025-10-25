<?php

namespace Ro749\FullListingTemplate\Forms;

use Ro749\SharedUtils\Forms\BaseForm;
use Ro749\SharedUtils\Forms\FormField;
use Ro749\SharedUtils\Forms\InputType;
use Ro749\SharedUtils\Forms\Selector;
use Ro749\FullListingTemplate\Enums\Options as OptionsEnum;
use Ro749\FullListingTemplate\Models\Client;
class ClientEdit extends BaseForm
{
    public function __construct()
    {
        parent::__construct(
            model_class: Client::class,
            submit_text: "",
            fields: [
                'id' => new FormField(
                    type: InputType::HIDDEN
                ),
                'name' => new FormField(
                    type: InputType::TEXT,
                ),
                'mail' => new FormField(
                    type: InputType::EMAIL,
                ),
                'phone' => new FormField(
                    type: InputType::PHONE,
                    required: true,
                    unique: true,
                ),
                'short_comment' => new FormField(
                    type: InputType::TEXT,
                ),
                'category' => new Selector(
                    options: OptionsEnum::ClientCategories
                ),
                'priority' => new Selector(
                    options: OptionsEnum::ClientPriorities
                ),
            ],
        );
    }
}
