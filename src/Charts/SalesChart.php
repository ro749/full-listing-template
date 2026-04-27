<?php

namespace Ro749\FullListingTemplate\Charts;

use Ro749\SharedUtils\Charts\TimeChart;
use Ro749\SharedUtils\Getters\TimeGetter;
use Ro749\SharedUtils\Tables\Column;
use Ro749\SharedUtils\Models\LogicModifiers\ForeignKey;
use Ro749\FullListingTemplate\Models\Unit;
use Ro749\SharedUtils\Statistics\Chart;
use Ro749\SharedUtils\Statistics\StatisticColumn;
use Ro749\SharedUtils\Statistics\StatisticType;
use Ro749\SharedUtils\Statistics\ChartTime;
use Ro749\SharedUtils\Filters\BackendFilters\BasicFilter;
use Ro749\FullListingTemplate\Enums\UnitsStatus;
class SalesChart extends TimeChart{
    public function __construct(){
        parent::__construct(
            data_column: 'final_price',
            label_column: 'label_date',
            getter: new TimeGetter(
                columns: [
                    'final_price'=>new Column(
                        display:"Ingresos",
                        logic_modifier: new ForeignKey(
                            table: 'sales_per_month',
                            column: 'final_price'
                        )
                    ),
                    'label_date'=>new Column(
                        display:"Fechas",
                    ),
                ],
                statistics:[
                    'sales_per_month' => new Chart(
                        model_class: Unit::get_class(),
                        columns: [
                            'final_price'=>new StatisticColumn(
                                type: StatisticType::SUM,
                            )
                        ],
                        interval: ChartTime::MONTH,
                        number: 12,
                        backend_filters: [
                            'status' => new BasicFilter(
                                id:'status',
                                filter: function ($query,$data) {
                                    return $query->where('status', '=', UnitsStatus::Vendido->value);
                                }
                            )
                        ],
                        group_column:'sale_date'
                    ),
                ]
                //debug: true
            ),
        );
    }
}