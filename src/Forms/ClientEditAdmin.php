<?php

namespace Ro749\FullListingTemplate\Forms;

use Ro749\SharedUtils\Forms\BaseForm;
use Ro749\SharedUtils\Forms\Field;
use Ro749\SharedUtils\Forms\InputType;
use Ro749\SharedUtils\Forms\Selector;
use Ro749\FullListingTemplate\Enums\Options as OptionsEnum;
use Ro749\FullListingTemplate\Models\Client;
use Illuminate\Support\Facades\Request;
use Ro749\SharedUtils\Forms\SelectorDB;
use Ro749\FullListingTemplate\Models\Asesor;
use Illuminate\Support\Facades\Log;
class ClientEditAdmin extends BaseForm
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
                'phone' => new Field(
                    type: InputType::PHONE,
                    required: true,
                    unique: true,
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
                'asesor' => new SelectorDB(
                    label:"Asesor",
                    id:'asesor_id',
                    model_class: Asesor::get_class(), 
                    label_column: 'name'
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
