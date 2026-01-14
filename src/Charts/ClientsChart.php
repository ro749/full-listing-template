<?php

namespace Ro749\FullListingTemplate\Charts;

use Ro749\SharedUtils\Charts\BaseChart;
use Ro749\SharedUtils\Getters\TimeGetter;
use Ro749\FullListingTemplate\Models\Client;
use Ro749\SharedUtils\Statistics\Chart;
use Ro749\SharedUtils\Statistics\StatisticType;
use Ro749\SharedUtils\Statistics\StatisticColumn;
use Ro749\SharedUtils\Statistics\ChartTime;
use Ro749\SharedUtils\Tables\Column;
use Ro749\SharedUtils\Models\LogicModifiers\ForeignKey;
class ClientsChart extends BaseChart
{
    public function __construct()
    {
        parent::__construct(
            data_column: 'clients',
            label_column: 'label_date',
            getter: new TimeGetter(
                columns: [
                    'clients'=>new Column(
                        display:"Clientes",
                        logic_modifier: new ForeignKey(
                            table: 'clients_count',
                            column: 'clients',
                        )
                    ),
                    'label_date'=>new Column(
                        display:"Fechas",
                    ),
                ],
                statistics: [
                    'clients_count' => new Chart(
                        model_class: Client::get_class(),
                        columns: [
                            'clients'=>new StatisticColumn(
                                type: StatisticType::COUNT,
                            )
                        ],
                        interval: ChartTime::MONTH,
                        number: 12,
                        cumulative: true
                    ),
                ],
            )
        );
    }
}