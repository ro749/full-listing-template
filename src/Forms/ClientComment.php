<?php

namespace Ro749\FullListingTemplate\Forms;

use Ro749\SharedUtils\Forms\BaseForm;
use Ro749\SharedUtils\Forms\FormField;
use Ro749\SharedUtils\Forms\TextArea;
use Ro749\SharedUtils\Forms\InputType;
use Ro749\FullListingTemplate\Models\Client;
class ClientComment extends BaseForm
{
    public function __construct()
    {
        parent::__construct(
            model_class: Client::class,
            submit_text: "Guardar",
            reload: false,
            success_msg: "Comentario guardado correctamente",
            fields: [
                'long_comment' => new TextArea(),
                'id' => new FormField(
                    type: InputType::HIDDEN,
                ),
            ],
        );
    }
}
