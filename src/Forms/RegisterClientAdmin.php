<?php

namespace Ro749\FullListingTemplate\Forms;

use Illuminate\Http\Request;
use Ro749\SharedUtils\Forms\BaseForm;
use Ro749\SharedUtils\Forms\Field;
use Ro749\SharedUtils\Forms\InputType;
use Ro749\FullListingTemplate\Models\Client;
use Ro749\SharedUtils\Forms\SelectorDB;
use Ro749\FullListingTemplate\Models\Asesor;
class RegisterClientAdmin extends BaseForm
{
    public function __construct($fields = [])
    {
        parent::__construct(
            model_class: Client::get_class(),
            submit_text: "Registrar",
            success_msg: "Cliente registrado exitosamente",
            fields: [
                'name' => new Field(
                    type: InputType::TEXT,
                    label: "Nombre",
                    placeholder: "Escriba el nombre",
                    required: true,
                    icon: "f7:person"
                ),
                'mail' => new Field(
                    type: InputType::EMAIL,
                    label:"Email",
                    placeholder:"Escriba el email",
                    //rules: ["required"],
                    icon: "mage:email"
                ),
                'phone' => new Field(
                    type: InputType::PHONE,
                    label:"Teléfono",
                    placeholder:"Escriba el teléfono",
                    required: true,
                    unique: true,
                    icon: "solar:phone-calling-linear"
                ),
                'asesor' => new SelectorDB(
                    label:"Asesor",
                    id:'asesor_id',
                    model_class: Asesor::get_class(), 
                    label_column: 'name'
                ),
            ]);
    }

    public function get_default_args(){
        return ['request' => Request::create('/', 'POST',[
            'name' => 'test',
            'mail' => 'a@a.com',
            'phone' => '3337811748',
        ])];
    } 
}
