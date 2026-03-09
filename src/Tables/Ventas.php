<?php

namespace Ro749\FullListingTemplate\Tables;

use Ro749\SharedUtils\Tables\BaseTable;
use Ro749\SharedUtils\Getters\BaseGetter;
use Ro749\SharedUtils\Tables\Column;
use Ro749\SharedUtils\Models\LogicModifiers\ForeignKey;
use Ro749\SharedUtils\Models\Modifier;
use Ro749\SharedUtils\Filters\BackendFilters\BasicFilter;
use Ro749\FullListingTemplate\Forms\VentaEdit;
use Ro749\FullListingTemplate\Enums\UnitsStatus;
use Ro749\FullListingTemplate\Models\Unit;
class Ventas extends BaseTable
{
    public function __construct(){
        parent::__construct(
            form: VentaEdit::instanciate(),
            getter: new BaseGetter(
                model_class: Unit::get_class(),
                columns : [
                    'unit'=>new Column(
                        display:"Unidad",
                    ),
                    'final_price'=>new Column(
                        display:"Precio Final",
                        modifier: Modifier::MONEY,
                    ),
                    'asesor'=>new Column(
                        display:"Asesor",
                        logic_modifier: new ForeignKey(
                            table: 'asesors',
                            column: 'name',
                        )
                    ),
                    'client'=>new Column(
                        display:"Cliente",
                        logic_modifier: new ForeignKey(
                            table: 'clients',
                            column: 'name',
                        )
                    ),
                    'sale_date'=>new Column(
                        display:"Fecha de venta",
                        modifier: Modifier::DATE,
                    ),
                ],
                backend_filters: [
                    new BasicFilter(
                        id:'status',
                        filter: function ($query,$data) {
                            return $query->where('status', '=', UnitsStatus::Vendido->value);
                        }
                    ),
                ]
            ),
        );
    }
}