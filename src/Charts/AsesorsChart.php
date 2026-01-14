<?php

namespace Ro749\FullListingTemplate\Charts;

use Ro749\SharedUtils\Charts\BaseChart;
use Ro749\SharedUtils\Getters\TimeGetter;
use Ro749\FullListingTemplate\Models\Asesor;
use Ro749\SharedUtils\Statistics\Chart;
use Ro749\SharedUtils\Statistics\StatisticType;
use Ro749\SharedUtils\Statistics\StatisticColumn;
use Ro749\SharedUtils\Statistics\ChartTime;
use Ro749\SharedUtils\Tables\Column;
use Ro749\SharedUtils\Models\LogicModifiers\ForeignKey;
class AsesorsChart extends BaseChart
{
    public function __construct()
    {
        parent::__construct(
            data_column: 'asesors',
            label_column: 'label_date',
            getter: new TimeGetter(
                columns: [
                    'asesors'=>new Column(
                        display:"Asesores",
                        logic_modifier: new ForeignKey(
                            table: 'asesors_count',
                            column: 'asesors',
                        )
                    ),
                    'label_date'=>new Column(
                        display:"Fechas",
                    ),
                ],
                statistics: [
                    'asesors_count' => new Chart(
                        model_class: Asesor::get_class(),
                        columns: [
                            'asesors'=>new StatisticColumn(
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