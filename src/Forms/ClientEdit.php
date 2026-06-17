<?php

namespace Ro749\FullListingTemplate\Forms;

use Ro749\SharedUtils\Forms\BaseForm;
use Ro749\SharedUtils\Forms\Field;
use Ro749\SharedUtils\Forms\InputType;
use Ro749\SharedUtils\Forms\Selector;
use Ro749\FullListingTemplate\Enums\Options as OptionsEnum;
use Ro749\FullListingTemplate\Models\Client;
use Illuminate\Support\Facades\Request;
class ClientEdit extends BaseForm
{
    public function __construct()
    {
        parent::__construct(
            model_class: Client::get_class(),
            submit_text: "",
            fields: [
                'id'=>new Field(
                    type: InputType::HIDDEN,
                ),
                'name' => new Field(
                    type: InputType::TEXT,
                ),
                'mail' => new Field(
                    type: InputType::EMAIL,
                ),
                'phone' => new Field(
                    type: InputType::PHONE,
                    required: true,
                    unique: true,
                    error_messages: [
                        'unique' => 'El teléfono tiene que ser unico',
                        'required' => 'El teléfono es obligatorio',
                        'phone' => 'El teléfono tiene que un numero valido'
                    ]
                ),
                'short_comment' => new Field(
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

    public function get_default_args(){
        $client = Client::first();
        return ['request' => Request::create('/', 'POST',[
            'id' => $client->id,
            'phone' => $client->phone
        ])];
    }
}
