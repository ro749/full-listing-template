<?php

namespace Ro749\FullListingTemplate\Models;

use Ro749\SharedUtils\Models\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Plan extends Model
{
    public function lines(): HasMany {
        return $this->hasMany(PlanLine::get_class());
    }
}
