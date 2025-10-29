<?php

namespace Ro749\FullListingTemplate\Models;

use Ro749\SharedUtils\Models\Model;

use Illuminate\Support\Facades\DB;
class Unit extends Model
{
    static function get(string $column,string $id){
        return DB::table('units')->where($column,$id)->first();
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
