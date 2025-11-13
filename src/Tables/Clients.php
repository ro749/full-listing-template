<?php

namespace Ro749\FullListingTemplate\Tables;

use Ro749\SharedUtils\Tables\BaseTable;
use Ro749\SharedUtils\Getters\BaseGetter;
use Ro749\SharedUtils\Tables\Column;
use Ro749\SharedUtils\Models\LogicModifiers\Options;
use Ro749\SharedUtils\Filters\BackendFilters\UserFilter;
use Ro749\SharedUtils\Filters\Filters;
use Ro749\SharedUtils\Filters\Filter;
use Ro749\SharedUtils\Tables\View;
use Ro749\SharedUtils\Statistics\Statistic;
use Ro749\SharedUtils\Statistics\StatisticColumn;
use Ro749\SharedUtils\Statistics\StatisticType;
use Ro749\SharedUtils\Models\LogicModifiers\ForeignKey;
use Ro749\FullListingTemplate\Enums\Options as OptionsEnum;
use Ro749\FullListingTemplate\Forms\ClientEdit;
use Ro749\FullListingTemplate\Enums\ClientCategories;
use Ro749\FullListingTemplate\Models\Client;
use Ro749\FullListingTemplate\Models\Quotation;
class Clients extends BaseTable
{
    public function __construct(){
        parent::__construct(
            view: new View(
                url: route('client-profile'),
                param: 'id',
                name: 'id'
            ),
            page_length: 50,
            form: ClientEdit::instanciate(),
            getter: new BaseGetter(
                model_class: Client::get_class(),
                statistics: [
                    'quotation_stats'=>new Statistic(
                        model_class: Quotation::get_class(),
                        group_column: 'client',
                        columns: [
                            'sent'=>new StatisticColumn(
                                type: StatisticType::COUNT,
                                filter: 'status = 0'
                            ),
                            'pending'=>new StatisticColumn(
                                type: StatisticType::COUNT,
                                filter: 'status = 1'
                            ),
                            'accepted'=>new StatisticColumn(
                                type: StatisticType::COUNT,
                                filter: 'status = 2'
                            ),
                            'cancelled'=>new StatisticColumn(
                                type: StatisticType::COUNT,
                                filter: 'status = 3'
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
                    'mail'=>new Column(
                        display:"Email",
                    ),
                    'sent'=>new Column(
                        display:"Enviadas",
                        logic_modifier: new ForeignKey(
                            table: 'quotation_stats',
                            column: 'sent',
                        ),
                    ),
                    'pending'=>new Column(
                        display:"Pendientes",
                        logic_modifier: new ForeignKey(
                            table: 'quotation_stats',
                            column: 'pending',
                        ),
                    ),
                    'accepted'=>new Column(
                        display:"Aceptadas",
                        logic_modifier: new ForeignKey(
                            table: 'quotation_stats',
                            column: 'accepted',
                        ),
                    ),
                    'cancelled'=>new Column(
                        display:"Canceladas",
                        logic_modifier: new ForeignKey(
                            table: 'quotation_stats',
                            column: 'cancelled',
                        ),
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
                filters: [
                    'cartera'=>new Filters(
                        id: 'cartera',
                        display: 'Cartera',
                        filters: [
                            'abierta'=>new Filter(
                                display: 'Abierta',
                                filter: function($query) {
                                    $query->where('clients.category','!=', ClientCategories::Cerrado->value);
                                }
                            ),
                            'cerrada'=>new Filter(
                                display: 'Cerrada',
                                filter: function($query) {
                                    $query->where('clients.category','=', ClientCategories::Cerrado->value);
                                }
                            ),
                        ]
                    )
                ],
                backend_filters: [
                    new UserFilter(
                        id: 'client',
                        column: 'asesor',
                        guard: 'asesor'
                    ),
                ]
            )
        );
    }
}