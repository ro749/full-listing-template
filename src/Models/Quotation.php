<?php

namespace Ro749\FullListingTemplate\Models;

use Ro749\SharedUtils\Models\Model;
class Quotation extends Model
{
    protected $fillable = [
        'client',
        'medium',
        'asesor',
        'unit',
        'status',
        'quoted_price',
        'n_open'
    ];
}
