<?php

namespace Ro749\FullListingTemplate\Models;

use Ro749\SharedUtils\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Client extends Model
{
    protected $fillable = [
        'name',
        'mail',
        'phone',
        'asesor_id',
        'category',
        'priority',
        'short_comment',
        'long_comment',
    ];

    public function asesor(): BelongsTo{
        return $this->belongsTo(Asesor::get_class());
    }

    public function quotations(): HasMany{
        return $this->hasMany(Quotation::get_class());
    }
}
