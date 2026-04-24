<?php

namespace Ro749\FullListingTemplate\Models;

use Ro749\SharedUtils\Models\Model;

class PersonalPlan extends Model
{
    public function quotation(){
        return $this->belongsTo(Quotation::get_class());
    }
}
