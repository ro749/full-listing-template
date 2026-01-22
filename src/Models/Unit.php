<?php

namespace Ro749\FullListingTemplate\Models;

use Ro749\SharedUtils\Models\Model;

use Illuminate\Support\Facades\DB;
use Ro749\SharedUtils\Tables\Column;
use Ro749\SharedUtils\Models\Modifier;
use Ro749\SharedUtils\Models\LogicModifiers\Options;
use Ro749\FullListingTemplate\Enums\Options as OptionsEnum;
class Unit extends Model
{
    static function get(string $column,string $id){
        return DB::table('units')->where($column,$id)->first();
    }
    protected static function allColumns(): array
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
        'asesor',
        'client',
        'final_price',
        'sale_date'
    ];
}
