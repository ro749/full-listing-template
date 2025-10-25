<?php

namespace Ro749\FullListingTemplate\Forms;

use Ro749\SharedUtils\Forms\BaseForm;
use Ro749\SharedUtils\Forms\FormField;
use Ro749\SharedUtils\Forms\InputType;
use Ro749\FullListingTemplate\Models\Client;
class RegisterClient extends BaseForm
{
    public function __construct($fields = [])
    {
        parent::__construct(
            model_class: Client::class,
            submit_text: "Registrar",
            redirect: route('disponibilidad'),
            user: 'asesor',
            guard: 'asesor',
            fields: [
                'name' => new FormField(
                    type: InputType::TEXT,
                    label: "Nombre",
                    placeholder: "Escriba el nombre",
                    required: true,
                    icon: "f7:person"
                ),
                'mail' => new FormField(
                    type: InputType::EMAIL,
                    label:"Email",
                    placeholder:"Escriba el email",
                    //rules: ["required"],
                    icon: "mage:email"
                ),
                'phone' => new FormField(
                    type: InputType::PHONE,
                    label:"Teléfono",
                    placeholder:"Escriba el teléfono",
                    required: true,
                    unique: true,
                    icon: "solar:phone-calling-linear"
                )
            ]);
    }

    public function after_process($model){
        session()->put('client_id', $model->id);
    }
}
