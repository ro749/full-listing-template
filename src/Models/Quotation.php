<?php

namespace Ro749\FullListingTemplate\Models;

use Ro749\SharedUtils\Models\Model;
use Ro749\SharedUtils\Models\HasRandomId;
class Quotation extends Model
{
    use HasRandomId;
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
