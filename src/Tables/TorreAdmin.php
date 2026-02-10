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
            page_length: 50,
            form: UnitEdit::instanciate(),
            getter: new BaseGetter(
                model_class: Unit::get_class(),
                columns : Unit::get_columns(['unit','price','status']),
                filters: [],
                backend_filters: []
            )
        );
    }
}