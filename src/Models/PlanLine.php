<?php

namespace Ro749\FullListingTemplate\Models;

use Ro749\SharedUtils\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class PlanLine extends Model
{
    public function plan(): BelongsTo {
        return $this->belongsTo(Plan::get_class());
    }
}
