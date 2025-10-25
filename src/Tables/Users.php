<?php

namespace Ro749\FullListingTemplate\Tables;
use Ro749\SharedUtils\Tables\Column;
use Ro749\SharedUtils\Models\LogicModifiers\Options;
use Ro749\FullListingTemplate\Enums\Options as OptionsEnum;
use Ro749\LoginTemplate\Tables\Users as UsersBase;
class Users extends UsersBase
{
    public function __construct(){
        parent::__construct();
        $this->getter->columns = [
            'name'=>new Column(
                display:"Nombre",
            ),
            'mail'=>new Column(
                display:"Email",
            ),
            'phone'=>new Column(
                display:"Teléfono",
            ),
            'number'=>new Column(
                display:"Numero",
            ),
            'category'=>new Column(
                display:"Categoría",
                logic_modifier: new Options(options: OptionsEnum::AsesorCategories),
            ),
            'status'=>new Column(
                display:"Status",
                logic_modifier: new Options(options: OptionsEnum::AsesorStatus),
            ),
        ];
    }
}