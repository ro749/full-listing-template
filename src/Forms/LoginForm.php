<?php

namespace Ro749\FullListingTemplate\Forms;

use Ro749\SharedUtils\Forms\Field;
use Ro749\SharedUtils\Forms\InputType;
use Ro749\LoginTemplate\Forms\LoginForm as LoginFormBase;
use Illuminate\Support\Facades\Request;
use Illuminate\Session\Store;
use Illuminate\Session\ArraySessionHandler;

class LoginForm extends LoginFormBase
{
    public function __construct()
    {
        parent::__construct();
        $this->fields = [
            "number" => new Field(
                type: InputType::TEXT,
                placeholder:"Número de asesor", 
                icon: "bx bx-user",
                max: 4
            ),
            "password" => new Field(
                placeholder:"Nip",
                type: InputType::PASSWORD,
                icon: "bx bx-lock-alt",
                max: 4
            ),
        ];
    }

    public function get_default_args(){
        $request = Request::create('/', 'POST',['number' => '1111', 'password' => '1111']);
        $session = new Store('test', new ArraySessionHandler(10));
        $request->setLaravelSession($session);
        return ['request' => $request];
    }
}
