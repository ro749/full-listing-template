<?php

namespace Ro749\FullListingTemplate\Tables;

use Illuminate\Database\Eloquent\Builder;
use Ro749\SharedUtils\Tables\BaseTable;
use Ro749\SharedUtils\Getters\BaseGetter;
use Ro749\SharedUtils\Tables\Column;
use Ro749\SharedUtils\Models\LogicModifiers\ForeignKey;
use Ro749\SharedUtils\Models\Modifier;
use Ro749\SharedUtils\Models\LogicModifiers\Options;
use Ro749\SharedUtils\Filters\BackendFilters\BasicFilter;
use Ro749\FullListingTemplate\Models\Quotation;
class ProfileAdmin extends BaseTable
{
    public function __construct(){
        parent::__construct(
            getter: new BaseGetter(
                model_class: Quotation::get_class(),
                columns : [
                    'unit'=>new Column(
                        display:"Unidad",
                        logic_modifier: new ForeignKey(
                            table: 'units',
                            column: 'name',
                        )
                    ),
                    'quoted_price'=>new Column(
                        display:"Precio Cotizado",
                        modifier: Modifier::MONEY,
                    ),
                    'actual_price'=>new Column(
                        display:"Precio Actual",
                        modifier: Modifier::MONEY,
                        logic_modifier: new ForeignKey(
                            table: 'units',
                            column: 'price',
                        )
                    ),
                    'created_at'=>new Column(
                        display:"Fecha",
                        modifier: Modifier::DATE
                    ),
                    'status'=>new Column(
                        display:"Status",
                        logic_modifier: new Options(
                            options: 'QuotationStatus'
                        )
                    ),
                    'n_open'=>new Column(
                        display:"Vistas",
                    )
                ],
                backend_filters: [
                    new BasicFilter(
                        id: 'client',
                        filter: function(Builder $query,string $data) {
                            $query->where('client', $data);
                        }
                    ),
                ]
            )
        );
    }
}