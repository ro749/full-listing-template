<?php

namespace Ro749\FullListingTemplate\Tables;

use Ro749\SharedUtils\Tables\BaseTable;
use Ro749\SharedUtils\Getters\BaseGetter;
use Ro749\SharedUtils\Tables\Column;
use Ro749\SharedUtils\Filters\BackendFilters\UserFilter;
use Ro749\SharedUtils\Models\Modifier;
use Ro749\SharedUtils\Models\LogicModifiers\ForeignKey;
use Ro749\SharedUtils\Filters\Filters;
use Ro749\SharedUtils\Filters\Filter;
use Ro749\SharedUtils\Models\LogicModifiers\Options;
use Ro749\SharedUtils\Tables\ColumnOrder;
use Ro749\SharedUtils\Tables\View;
use Ro749\SharedUtils\Filters\BackendFilters\BasicFilter;
use Ro749\FullListingTemplate\Enums\Options as OptionsEnum;
use Ro749\FullListingTemplate\Forms\QuotationEdit;
use Ro749\FullListingTemplate\Models\Quotation;
use Ro749\FullListingTemplate\Models\Client;
use Ro749\FullListingTemplate\Models\Unit;
use Ro749\FullListingTemplate\Enums\UnitsStatus;
class Quotations extends BaseTable
{
    public function __construct(){
        parent::__construct(
            filters: [
                'filtro'=>new Filters(
                    id: 'filtro',
                    display: 'Filtro',
                    filters: [
                        'disponibles'=>new Filter(
                            display: 'Disponibles'
                        ),
                        'todas'=>new Filter(
                            display: 'Todas'
                        ),
                    ],
                    default: 'disponibles'
                )
            ],
            getter: new BaseGetter(
                model_class: Quotation::get_class(),
                
                columns : [
                    'client'=>new Column(
                        display:"Cliente",
                        logic_modifier: new ForeignKey(
                            model_class: Client::get_class(),
                            column: 'name',
                        )
                    ),
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
                    ),
                    'last_viewed_at'=>new Column(
                        display:"Última vez visto",
                        modifier: Modifier::TIME_SINCE
                    )

                ],
                backend_filters: [
                    new UserFilter(
                        id: 'client',
                        column: 'quotations.asesor_id',
                        guard: 'asesor'
                    ),
                    new BasicFilter(
                        id: 'cartera',
                        filter: function ($query,$data) {
                            if(!isset($data['filtro'])) return;
                            if($data['filtro'] == 'disponibles'){
                                $query->where(Unit::instance()->getTable().'.status', UnitsStatus::Disponible->value);
                            }
                        }
                    )
                ]
            ),
            view: new View(
                url: route('client-view'),
                param: 'id',
                name: 'id'
            ),
            form: QuotationEdit::instanciate(),
        );
    }
}