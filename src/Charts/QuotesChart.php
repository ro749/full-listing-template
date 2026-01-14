<?php

namespace Ro749\FullListingTemplate\Charts;

use Ro749\SharedUtils\Charts\BaseChart;
use Ro749\SharedUtils\Getters\TimeGetter;
use Ro749\FullListingTemplate\Models\Quotation;
use Ro749\SharedUtils\Statistics\Chart;
use Ro749\SharedUtils\Statistics\StatisticType;
use Ro749\SharedUtils\Statistics\StatisticColumn;
use Ro749\SharedUtils\Statistics\ChartTime;
use Ro749\SharedUtils\Tables\Column;
use Ro749\SharedUtils\Models\LogicModifiers\ForeignKey;
class QuotesChart extends BaseChart
{
    public function __construct()
    {
        parent::__construct(
            data_column: 'quotations',
            label_column: 'label_date',
            getter: new TimeGetter(
                columns: [
                    'quotations'=>new Column(
                        display:"Cotizaciones",
                        logic_modifier: new ForeignKey(
                            table: 'quotations_count',
                            column: 'quotations',
                        )
                    ),
                    'label_date'=>new Column(
                        display:"Fechas",
                    ),
                ],
                statistics: [
                    'quotations_count' => new Chart(
                        model_class: Quotation::get_class(),
                        columns: [
                            'quotations'=>new StatisticColumn(
                                type: StatisticType::COUNT,
                            )
                        ],
                        interval: ChartTime::MONTH,
                        number: 12,
                    ),
                ],
            )
        );
    }
}