<?php

namespace Ro749\FullListingTemplate\Forms;

use Ro749\SharedUtils\Forms\FormField;
use Ro749\SharedUtils\Forms\InputType;
use Ro749\SharedUtils\Forms\Selector;
use Ro749\SharedUtils\Enums\Icon;
use Ro749\FullListingTemplate\Enums\Options;
use Ro749\LoginTemplate\Forms\RegisterUser as RegisterUserBase;

class RegisterUser extends RegisterUserBase
{
    public function __construct()
    {
        parent::__construct();
        $this->success_msg = 'Asesor registrado exitosamente. El NIP por defecto es 0000.';
        $this->fields = [
            'name'=>new FormField(
                type: InputType::TEXT,
                label: "Nombre",
                placeholder: "Escriba el nombre",
                required: true,
                icon: "f7:person"
            ),
            'mail'=>new FormField(
                type: InputType::EMAIL,
                label:"Email",
                placeholder:"Escriba el email",
                required: true,
                icon: "mage:email"
            ),
            'phone'=>new FormField(
                type: InputType::PHONE,
                label:"Teléfono",
                placeholder:"Escriba el teléfono",
                required: true,
                icon: "solar:phone-calling-linear"
            ),
            'number'=>new FormField(
                type: InputType::TEXT,
                label:"Numero",
                placeholder:"Escriba el numero",
                required: true,
                unique: true,
                icon: Icon::HASH->value
            ),
            'category'=>new Selector(
                label:"Categoría",
                placeholder:"Seleccione una categoría",
                options: Options::AsesorCategories,
                required: true,
            ),
        ];
    }
}
