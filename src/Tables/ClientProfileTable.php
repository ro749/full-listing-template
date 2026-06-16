<?php

namespace Ro749\FullListingTemplate\Tables;

use Illuminate\Database\Eloquent\Builder;
use Ro749\SharedUtils\Tables\BaseTable;
use Ro749\SharedUtils\Getters\BaseGetter;
use Ro749\SharedUtils\Tables\Column;
use Ro749\SharedUtils\Models\LogicModifiers\ForeignKey;
use Ro749\SharedUtils\Models\LogicModifiers\Options;
use Ro749\SharedUtils\Tables\ColumnOrder;
use Ro749\SharedUtils\Models\Modifier;
use Ro749\SharedUtils\Filters\BackendFilters\BasicFilter;
use Ro749\SharedUtils\Tables\View;
use Ro749\FullListingTemplate\Enums\Options as OptionsEnum;
use Ro749\FullListingTemplate\Forms\QuotationEdit;
use Ro749\FullListingTemplate\Models\Quotation;
use Ro749\FullListingTemplate\Models\Client;
use Ro749\FullListingTemplate\Models\Unit;

class ClientProfileTable extends BaseTable
{
    public function __construct(){
        parent::__construct(
            view: new View(
                url: route('client-view'),
                param: 'id',
                name: 'id'
            ),
            form: QuotationEdit::instanciate(),
            getter: new BaseGetter(
                model_class: Quotation::get_class(),
                columns : [
                    'unit'=>new Column(
                        display:"Unidad",
                        logic_modifier: new ForeignKey(
                            model_class: Unit::get_class(),
                            column: 'unit',
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
                            model_class: Unit::get_class(),
                            column: 'price',
                        )
                    ),
                    'created_at'=>new Column(
                        display:"Fecha",
                        modifier: Modifier::DATE,
                        order: ColumnOrder::DESC
                    ),
                    'status'=>new Column(
                        display:"Status",
                        logic_modifier: new Options(
                            options: OptionsEnum::QuotationStatus
                        )
                    ),
                    'n_open'=>new Column(
                        display:"Vistas",
                    )
                ],
                backend_filters: [
                    new BasicFilter(
                        id: "id",
                        filter: function(Builder $query,array $data) {
                            $query->where('quotations.client_id', $data['id']);
                        }
                    )
                ]
            )
        );
    }

    public function get_default_args(){
        return ['filters' => ['id'=>Quotation::first()->client_id]];
    }
}