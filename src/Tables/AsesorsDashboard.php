<?php

namespace Ro749\FullListingTemplate\Tables;

use Ro749\SharedUtils\Tables\BaseTable;
use Ro749\SharedUtils\Getters\BaseGetter;
use Ro749\FullListingTemplate\Models\Asesor;
use Ro749\SharedUtils\Tables\Column;
use Ro749\SharedUtils\Statistics\Statistic;
use Ro749\SharedUtils\Statistics\StatisticColumn;
use Ro749\SharedUtils\Statistics\StatisticType;
use Ro749\FullListingTemplate\Models\Client;
use Ro749\FullListingTemplate\Models\Quotation;
use Ro749\SharedUtils\Models\LogicModifiers\ForeignKey;
use Ro749\SharedUtils\Models\LogicModifiers\Options;
use Ro749\SharedUtils\Models\Modifier;
use Ro749\FullListingTemplate\Enums\Options as OptionsEnum;

class AsesorsDashboard extends BaseTable
{
    public function __construct(){
        parent::__construct(
            getter: new BaseGetter(
                model_class: Asesor::get_class(),
                columns : [
                    'name'=>new Column(
                        display:"Asesor",
                    ),
                    'clients_count'=>new Column(
                        display:"Número de Clientes",
                        logic_modifier: new ForeignKey(
                            table: 'clients_stats',
                            column: 'clients_count'
                        )
                    ),
                    'quotes_count'=>new Column(
                        display:"Número de Cotizaciones",
                        logic_modifier: new ForeignKey(
                            table: 'quotes_stats',
                            column: 'quotes_count'
                        )
                    ),
                    'quoted_price'=>new Column(
                        display:"Promedio Cotizaciones",
                        logic_modifier: new ForeignKey(
                            table: 'quotes_stats',
                            column: 'quoted_price'
                        ),
                        modifier: Modifier::MONEY
                    ),
                    'last_session_register'=>new Column(
                        display:"Última Sesión",
                        modifier: Modifier::TIME_SINCE
                    ),
                    'status'=>new Column(
                        display:"Tipo",
                        logic_modifier: new Options(
                            options: OptionsEnum::AsesorCategories
                        )
                    ),
                ],
                statistics: [
                    'clients_stats'=>new Statistic(
                        model_class: Client::get_class(),
                        group_column: 'asesor_id',
                        columns: [
                            'clients_count'=>new StatisticColumn(
                                type: StatisticType::COUNT
                            ),
                        ]
                    ),
                    'quotes_stats'=>new Statistic(
                        model_class: Quotation::get_class(),
                        group_column: 'asesor_id',
                        columns: [
                            'quotes_count'=>new StatisticColumn(
                                type: StatisticType::COUNT
                            ),
                            'quoted_price'=>new StatisticColumn(
                                type: StatisticType::AVERAGE
                            ),
                        ]
                    ),
                ]
            )
        );
        
    }
}