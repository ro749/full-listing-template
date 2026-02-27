<?php

namespace Ro749\FullListingTemplate\Tables;

use Illuminate\Database\Eloquent\Builder;
use Ro749\SharedUtils\Tables\BaseTable;
use Ro749\SharedUtils\Getters\BaseGetter;
use Ro749\SharedUtils\Tables\Column;
use Ro749\SharedUtils\Models\Modifier;
use Ro749\SharedUtils\Tables\View;
use Ro749\SharedUtils\Filters\BackendFilters\BasicFilter;
use Ro749\SharedUtils\Tables\Texts\TableTexts;
use Ro749\FullListingTemplate\Enums\UnitsStatus;
use Ro749\FullListingTemplate\Models\Unit;
use Illuminate\Support\Facades\Log;
class Torre extends BaseTable
{
    public function __construct(){
        Log::info('Torre');
        parent::__construct(
            page_length: 50,
            view: new View(
                url: route('view-asesor'),
                param: 'id',
                name: 'id',
                full_row: true
            ),
            texts: new TableTexts(
                lengthMenu: '_MENU_  &nbsp;Departamentos por página',
                info: 'Mostrando _START_ a _END_ de _TOTAL_ Departamentos Disponibles',
            ),
            getter: new BaseGetter(
                model_class: Unit::get_class(),
                columns : Unit::get_columns(['unit','price']),
                backend_filters: [
                    new BasicFilter(
                        id:'status',
                        filter: function (Builder $query,$data) {
                            return $query->where('status', '=', UnitsStatus::Disponible->value);
                        }
                    ),
                ],
                debug: true
            )
        );
    }
}