<?php

namespace Ro749\FullListingTemplate\Models;

use Ro749\SharedUtils\Models\Model;

use Ro749\SharedUtils\Tables\Column;
use Ro749\SharedUtils\Models\Modifier;
use Ro749\SharedUtils\Models\LogicModifiers\Options;
use Ro749\FullListingTemplate\Enums\Options as OptionsEnum;
class Unit extends Model
{
    public static function allColumns(): array
    {
        return [
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
        ];
    }

    protected $fillable = [
        'price',
        'status',
        'asesor_id',
        'client_id',
        'final_price',
        'sale_date'
    ];
}
