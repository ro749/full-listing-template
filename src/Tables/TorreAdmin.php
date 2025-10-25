<?php

namespace Ro749\FullListingTemplate\Tables;

use Ro749\SharedUtils\Tables\BaseTable;
use Ro749\SharedUtils\Getters\BaseGetter;
use Ro749\SharedUtils\Tables\Column;
use Ro749\SharedUtils\Models\Modifier;
use Ro749\SharedUtils\Models\LogicModifiers\Options;
use Ro749\FullListingTemplate\Enums\Options as OptionsEnum;
use Ro749\FullListingTemplate\Forms\UnitEdit;
use Ro749\FullListingTemplate\Models\Unit;
class TorreAdmin extends BaseTable
{
    public function __construct(){
        parent::__construct(
            form: UnitEdit::instanciate(),
            getter: new BaseGetter(
                model_class: Unit::class,
                columns : [
                    'unit'=>new Column(
                        display:"Unidad",
                    ),
                    'price'=>new Column(
                        display:"Precio",
                        modifier: Modifier::MONEY,
                    ),
                    'status'=>new Column(
                        display:"Estado",
                        logic_modifier: new Options (options: OptionsEnum::UnitsStatus),
                    ),
                ],
                filters: [],
                backend_filters: []
            )
        );
    }
}