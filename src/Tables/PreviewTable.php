<?php

namespace Ro749\FullListingTemplate\Tables;

use Ro749\SharedUtils\Tables\BaseTable;
use Ro749\SharedUtils\Getters\BaseGetter;
use Ro749\SharedUtils\Tables\Column;
use Ro749\SharedUtils\Models\Modifier;
use Ro749\SharedUtils\Filters\BackendFilters\BasicFilter;
use Ro749\SharedUtils\Tables\Texts\TableTexts;
use Ro749\SharedUtils\Models\LogicModifiers\Options;
use Ro749\FullListingTemplate\Models\Unit;
use Ro749\FullListingTemplate\Enums\Options as OptionsEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
class PreviewTable extends BaseTable
{
    public function __construct(){
        parent::__construct(
            page_length: 50,
            texts: new TableTexts(
                lengthMenu: '_MENU_  &nbsp;Departamentos por página',
                info: '',
                zeroRecords: 'Ningun cambio detectado'
            ),
            getter: new BaseGetter(
                model_class: Unit::class,
                columns : [
                    'unit'=>new Column(
                        display:"Unidad",
                    ),
                    'price'=>new Column(
                        display:"Precio",
                        modifier: Modifier::MONEY,
                    ),
                    'new_price'=>new Column(
                        display:"Nuevo Precio",
                        modifier: Modifier::MONEY
                    ),
                    'status'=>new Column(
                        display:"Estado",
                        logic_modifier: new Options (options: OptionsEnum::UnitsStatus),
                    ),
                    'new_status'=>new Column(
                        display:"Nuevo Estado",
                        logic_modifier: new Options (options: OptionsEnum::UnitsStatus)
                    ),
                ],
                backend_filters: [
                    new BasicFilter(
                        id: "id",
                        filter: function(Builder $query,array $data) {
                            $query->whereNotNull('new_price')->orWhereNotNull('new_status');
                        }
                    )
                ]
            )
        );
    }

    public function get($start = 0, $length = 10, $search = '',$order = [],$filters = [],$start_date = null, $end_date = null): mixed
    {
        $data = $this->getter->get($start, $length, $search,$order,$filters);
        foreach($data['data'] as $key => &$value){
            if($value->new_price === null ){
                $value->price = null;
            }
            if($value->new_status === null){
                $value->status = null;
            }
        }
        return $data;
    }
}