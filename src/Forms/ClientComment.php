<?php

namespace Ro749\FullListingTemplate\Forms;

use Ro749\SharedUtils\Forms\BaseForm;
use Ro749\SharedUtils\Forms\Field;
use Ro749\SharedUtils\Forms\TextArea;
use Ro749\SharedUtils\Forms\InputType;
use Ro749\FullListingTemplate\Models\Client;
use Illuminate\Support\Facades\Request;
class ClientComment extends BaseForm
{
    public function __construct()
    {
        parent::__construct(
            model_class: Client::get_class(),
            submit_text: "Guardar",
            reload: false,
            reset: false,
            success_msg: "Comentario guardado correctamente",
            fields: [
                'long_comment' => new TextArea(),
                'id' => new Field(
                    type: InputType::HIDDEN,
                ),
            ],
        );
    }

    public function get_default_args(){
        
        return ['request' => Request::create('/', 'POST',[
            'long_comment' => 'test', 
            'id' => Client::first()->id
            ])];
    }
}
