<?php

namespace Ro749\FullListingTemplate\Tables;

use Ro749\SharedUtils\Tables\BaseTable;
use Ro749\SharedUtils\Getters\BaseGetter;
use Ro749\SharedUtils\Tables\Column;
use Ro749\SharedUtils\Filters\BackendFilters\UserFilter;
use Ro749\SharedUtils\Models\Modifier;
use Ro749\SharedUtils\Models\LogicModifiers\ForeignKey;
use Ro749\SharedUtils\Models\LogicModifiers\MultiForeignKey;
use Ro749\SharedUtils\Models\LogicModifiers\ForeingKeyColumn;
use Ro749\SharedUtils\Models\LogicModifiers\ForeingKeyValue;
use Ro749\SharedUtils\Models\LogicModifiers\Options;
use Ro749\SharedUtils\Tables\ColumnOrder;
use Ro749\SharedUtils\Tables\View;
use Ro749\FullListingTemplate\Enums\Options as OptionsEnum;
use Ro749\FullListingTemplate\Forms\QuotationEdit;
use Ro749\FullListingTemplate\Models\Quotation;
use Ro749\FullListingTemplate\Models\Client;
use Ro749\FullListingTemplate\Models\Unit;
class Quotations extends BaseTable
{
    public function __construct(){
        parent::__construct(
            getter: new BaseGetter(
                model_class: Quotation::get_class(),
                columns : [
                    'client_id'=>new Column(
                        display:"Cliente",
                        logic_modifier: new ForeignKey(
                            model_class: Client::get_class(),
                            column: 'name',
                        )
                    ),
                    'medium' => new Column(
                        display:"Medio",
                        logic_modifier: new MultiForeignKey (
                            key_column: "client_id",
                            table: "clients",
                            columns: [
                                new ForeingKeyColumn("phone"),
                                new ForeingKeyValue("Correo"),
                                new ForeingKeyValue("Link")
                            ],
                        ),
                    ),
                    'unit_id'=>new Column(
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
                    new UserFilter(
                        id: 'client',
                        column: 'quotations.asesor_id',
                        guard: 'asesor'
                    ),
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