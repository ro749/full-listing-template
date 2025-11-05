<?php

namespace Ro749\FullListingTemplate\Forms;

use Illuminate\Support\Facades\DB;
use Ro749\SharedUtils\Forms\Field;
use Ro749\SharedUtils\Forms\InputType;
use Ro749\SharedUtils\Forms\Selector;
use Ro749\FullListingTemplate\Enums\Options;
use Ro749\FullListingTemplate\Enums\AsesorStatus;
use Ro749\LoginTemplate\Forms\EditUser as EditUserBase;
class EditUser extends EditUserBase
{
    public function __construct()
    {
        parent::__construct();
        $this->fields = [
            'id'=>new Field(
                type: InputType::HIDDEN,
            ),
            'name'=>new Field(
                type: InputType::TEXT,
                label: "Nombre",
                placeholder: "Escriba el nombre",
                required: true,
                icon: "f7:person"
            ),
            'mail'=>new Field(
                type: InputType::EMAIL,
                label:"Email",
                placeholder:"Escriba el email",
                required: true,
                icon: "mage:email"
            ),
            'phone'=>new Field(
                type: InputType::PHONE,
                label:"Teléfono",
                placeholder:"Escriba el teléfono",
                required: true,
                icon: "solar:phone-calling-linear"
            ),
            'number'=>new Field(
                type: InputType::TEXT,
                label:"Numero",
                placeholder:"Escriba el numero",
                required: true,
                unique: true,
                icon: "solar:phone-calling-linear"
            ),
            'category'=>new Selector(
                label:"Categoría",
                options: Options::AsesorCategories,
                required: true,
            ),
            'status'=>new Selector(
                label:"Status",
                options: Options::AsesorStatus,
                required: true,
            ),
        ];
    }

    public function after_process($model){
        if($model->status == AsesorStatus::Inactivo->value){
            DB::table('sessions')
            ->where('user_id', $model->id)
            ->where('guard', 'asesor')
            ->delete();
        }
    }
}
