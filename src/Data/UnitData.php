<?php

namespace Ro749\FullListingTemplate\Data;
use Illuminate\Support\Facades\Log;
use Ro749\SharedUtils\Data\Data;
use Illuminate\Support\Facades\DB;
use Ro749\FullListingTemplate\Models\Unit;

class UnitData extends Data
{
    public string $column;
    public string $id;
    public function __construct(string $column,string $id){
        parent::__construct(dynamic: false);
        $this->column = $column;
        $this->id = $id;
    }

    public function init_data($request = null){
        $query = Unit::instance()->where($this->column,$this->id);
        return $query->first();
    }
}