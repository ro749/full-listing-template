<?php

namespace Ro749\FullListingTemplate\Charts;

use Ro749\SharedUtils\Charts\BaseChart;
use Ro749\SharedUtils\Getters\CategoryGetter;
use Ro749\SharedUtils\Models\LogicModifiers\ForeignKey;
use Ro749\SharedUtils\Statistics\Statistic;
use Ro749\FullListingTemplate\Models\Quotation;
use Ro749\FullListingTemplate\Models\Asesor;
use Ro749\SharedUtils\Statistics\StatisticColumn;
use Ro749\SharedUtils\Statistics\StatisticType;
use Ro749\SharedUtils\Statistics\StatisticLink;
use Ro749\SharedUtils\Tables\Column;
use Ro749\FullListingTemplate\Enums\Options as OptionsEnum;

class AsesorsQuotesChart extends BaseChart
{
    public function __construct()
    {
        parent::__construct(
            data_column: 'quote_count',
            label_column: 'label',
            getter: new CategoryGetter(
                option_name: OptionsEnum::AsesorCategories->value,
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
                    'quote_stats'=>new Statistic(
                        model_class: Quotation::get_class(),
                        group_column: 'asesor_id',
                        columns: [
                            'quote_count'=>new StatisticColumn(
                                type: StatisticType::COUNT
                            ),
                        ],
                        links: [new StatisticLink(
                            model_class: Asesor::get_class(),
                            column: 'category',
                        )]
                    )
                ]
            )
        );
    }
}