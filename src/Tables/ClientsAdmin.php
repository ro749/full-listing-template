<?php

namespace Ro749\FullListingTemplate\Tables;

use Ro749\SharedUtils\Tables\BaseTable;
use Ro749\SharedUtils\Getters\BaseGetter;
use Ro749\SharedUtils\Tables\Column;
use Ro749\SharedUtils\Models\Modifier;
use Ro749\SharedUtils\Models\LogicModifiers\Options;
use Ro749\SharedUtils\Models\LogicModifiers\ForeignKey;
use Ro749\SharedUtils\Tables\View;
use Ro749\SharedUtils\Statistics\StatisticType;
use Ro749\SharedUtils\Statistics\Statistic;
use Ro749\SharedUtils\Statistics\StatisticColumn;
use Ro749\SharedUtils\Filters\Filters;
use Ro749\SharedUtils\Filters\Filter;
use Ro749\FullListingTemplate\Enums\Options as OptionsEnum;
use Ro749\FullListingTemplate\Enums\ClientCategories;
use Ro749\FullListingTemplate\Forms\ClientEditAdmin;
use Ro749\FullListingTemplate\Models\Client;
use Ro749\FullListingTemplate\Models\Quotation;
use Ro749\FullListingTemplate\Models\Asesor;
use Ro749\SharedUtils\Filters\BackendFilters\BasicFilter;
class ClientsAdmin extends BaseTable
{
    public function __construct(){
        parent::__construct(
            view: new View(
                url: route('admin-client-profile'),
                param: 'id',
                name: 'id'
            ),
            form: ClientEditAdmin::instanciate(),
            filters: [
                'cartera'=>new Filters(
                    id: 'cartera',
                    display: 'Cartera',
                    filters: [
                        'abierta'=>new Filter(
                            display: 'Abierta'
                        ),
                        'cerrada'=>new Filter(
                            display: 'Cerrada'
                        ),
                    ]
                )
            ],
            getter: new BaseGetter(
                model_class: Client::get_class(),
                statistics: [
                    'quotation_stats'=>new Statistic(
                        model_class: Quotation::get_class(),
                        group_column: 'client_id',
                        columns: [
                            'quotes_count'=>new StatisticColumn(
                                type: StatisticType::COUNT
                            ),
                        ]
                    )
                ],
                columns : [
                    'name'=>new Column(
                        display:"Nombre",
                    ),
                    'phone'=>new Column(
                        display:"Teléfono",
                    ),
                    'created_at'=>new Column(
                        display:"Fecha de Registro",
                        modifier: Modifier::DATE
                    ),
                    'quotes_count'=>new Column(
                        display:"Cotizaciones",
                        logic_modifier: new ForeignKey(
                            table: 'quotation_stats',
                            column: 'quotes_count',
                        ),
                    ),
                    'asesor_id'=>new Column(
                        display:"Asesor",
                        logic_modifier: new ForeignKey(
                            model_class: Asesor::get_class(),
                            column: 'name',
                            text_on_null: 'No asignado'
                        )
                    ),
                    'short_comment'=>new Column(
                        display:"Comentario"
                    ),
                    'category'=>new Column(
                        display:"Categoría",
                        logic_modifier: new Options (options: OptionsEnum::ClientCategories),
                    ),
                    'priority'=>new Column(
                        display:"Prioridad",
                        logic_modifier: new Options (options: OptionsEnum::ClientPriorities),
                    ),
                ],
                backend_filters: [
                    new BasicFilter(
                        id: 'cartera',
                        filter: function ($query,$data) {
                            if(!isset($data['cartera'])) return;
                            if($data['cartera'] == 'abierta'){
                                $query->where('clients.category','!=', ClientCategories::Cerrado->value);
                            }
                            else if($data['cartera'] == 'cerrada'){
                                $query->where('clients.category',ClientCategories::Cerrado->value);
                            }
                        }
                    )
                ],
                //debug: true
            )
        );
    }
}