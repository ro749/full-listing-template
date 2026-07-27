<?php

namespace Ro749\FullListingTemplate\Tables;
use Ro749\SharedUtils\Tables\Column;
use Ro749\SharedUtils\Models\LogicModifiers\Options;
use Ro749\FullListingTemplate\Enums\Options as OptionsEnum;
use Ro749\LoginTemplate\Tables\Users as UsersBase;
use Ro749\FullListingTemplate\Enums\Attributes\AsesorAttr;
class Users extends UsersBase
{
    public function __construct(){
        parent::__construct();
        $this->getter->columns = [
            AsesorAttr::NAME->value =>new Column(
                display:"Nombre",
            ),
            AsesorAttr::MAIL->value =>new Column(
                display:"Email",
            ),
            AsesorAttr::PHONE->value =>new Column(
                display:"Teléfono",
            ),
            AsesorAttr::NUMBER->value =>new Column(
                display:"Numero",
            ),
            AsesorAttr::CATEGORY->value =>new Column(
                display:"Categoría",
                logic_modifier: new Options(options: OptionsEnum::AsesorCategories),
            ),
            AsesorAttr::STATUS->value =>new Column(
                display:"Status",
                logic_modifier: new Options(options: OptionsEnum::AsesorStatus),
            ),
        ];
    }
}