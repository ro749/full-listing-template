<?php

namespace Ro749\FullListingTemplate\Charts;

use Ro749\SharedUtils\Charts\TimeChart;
use Ro749\SharedUtils\Getters\TimeGetter;
use Ro749\FullListingTemplate\Models\Unit;
use Ro749\SharedUtils\Statistics\Chart;
use Ro749\SharedUtils\Statistics\StatisticType;
use Ro749\SharedUtils\Statistics\StatisticColumn;
use Ro749\SharedUtils\Statistics\ChartTime;
use Ro749\SharedUtils\Tables\Column;
use Ro749\SharedUtils\Models\LogicModifiers\ForeignKey;
use Ro749\SharedUtils\Filters\BackendFilters\BasicFilter;
use Ro749\FullListingTemplate\Enums\UnitsStatus;
class AvailableUnitsChart extends TimeChart
{
    public function __construct()
    {
        parent::__construct(
            data_column: 'units',
            label_column: 'label_date',
            inverted: Unit::instance()->count(),
            getter: new TimeGetter(
                columns: [
                    'units'=>new Column(
                        display:"Unidades",
                        logic_modifier: new ForeignKey(
                            table: 'units_count',
                            column: 'units',
                        )
                    ),
                    'label_date'=>new Column(
                        display:"Fechas",
                    ),
                ],
                statistics: [
                    'units_count' => new Chart(
                        model_class: Unit::get_class(),
                        columns: [
                            'units'=>new StatisticColumn(
                                type: StatisticType::COUNT,
                            )
                        ],
                        interval: ChartTime::MONTH,
                        number: 12,
                        backend_filters: [
                            'status' => new BasicFilter(
                                id:'status',
                                filter: function ($query,$data) {
                                    return $query->where('status', '!=', UnitsStatus::Disponible->value);
                                }
                            )
                        ],
                        cumulative: true,
                        group_column:'sale_date'
                    ),
                ],
            )
        );
    }
}