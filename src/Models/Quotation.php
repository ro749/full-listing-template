<?php

namespace Ro749\FullListingTemplate\Models;

use Ro749\SharedUtils\Models\Model;
use Ro749\SharedUtils\Models\HasRandomId;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;



class Quotation extends Model
{
    use HasRandomId;
    protected $fillable = [
        'client_id',
        'asesor_id',
        'medium',
        'unit_id',
        'status',
        'quoted_price',
        'n_open'
    ];

    public function personalPlan(): HasOne{
        return $this->hasOne(PersonalPlan::get_class());
    }
    public function unit(): BelongsTo{
        return $this->belongsTo(Unit::get_class());
    }
    public function client(): BelongsTo{
        return $this->belongsTo(Client::get_class());
    }

    public function asesor(): BelongsTo{
        return $this->belongsTo(Asesor::get_class());
    }
    
    public function get_default_model(){
        return [
                'asesor_id' => Asesor::instance()->value('id'),
                'client_id' => Client::instance()->value('id'),
                'unit_id' => Unit::instance()->where('status', '0')->first()->id,
                'status' => 0,
            ];
    }
}
