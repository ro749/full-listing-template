<?php

namespace Ro749\FullListingTemplate\Charts;

use Ro749\SharedUtils\Charts\BaseChart;
use Ro749\SharedUtils\Getters\BaseGetter;
use Ro749\SharedUtils\Models\LogicModifiers\ForeignKey;
use Ro749\SharedUtils\Statistics\Statistic;
use Ro749\FullListingTemplate\Models\Quotation;
use Ro749\FullListingTemplate\Models\Asesor;
use Ro749\SharedUtils\Statistics\StatisticColumn;
use Ro749\SharedUtils\Statistics\StatisticType;
use Ro749\SharedUtils\Statistics\StatisticLink;
use Ro749\SharedUtils\Tables\Column;

class AsesorsQuotesChart extends BaseChart
{
    public function __construct()
    {
        parent::__construct(
            data_column: 'asesors',
            label_column: 'label_date',
            getter: new BaseGetter(
                columns: [
                    'quote_count'=> new Column(
                        display:"Cotizaciones",
                        logic_modifier: new ForeignKey(
                            table: 'quote_stats',
                            column: 'quote_count'
                        ))
                ],
                statistics:
                [
                    'quotes'=>new Statistic(
                        model_class: Quotation::get_class(),
                        group_column: 'status',
                        columns: [
                            'quote_count'=>new StatisticColumn(
                                type: StatisticType::COUNT
                            ),
                        ],
                        link: new StatisticLink(
                            model_class: Asesor::get_class(),
                            column: 'asesor',
                        )
                    )
                ]
            )
        );
    }
}