<?php

namespace Ro749\FullListingTemplate\Forms;

use Ro749\SharedUtils\Forms\LoginForm;
use Ro749\SharedUtils\Forms\Field;
use Ro749\SharedUtils\Forms\InputType;
class AdminLogin extends LoginForm
{
    public function __construct()
    {
        parent::__construct(
            submit_text: "Entrar",
            redirect: route('admin-torre'),
            fields: [
                "name" => new Field(
                    placeholder:"Usuario",
                    type: InputType::TEXT, 
                    icon: "bx bx-user"
                ),
                "password" => new Field(
                    placeholder:"Contraseña",
                    type: InputType::PASSWORD,
                    icon: "bx bx-lock-alt"
                ),
            ],
        );
    }
}
