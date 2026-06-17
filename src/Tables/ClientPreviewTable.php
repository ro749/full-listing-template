<?php

namespace Ro749\FullListingTemplate\Tables;

use Ro749\SharedUtils\Tables\BaseTable;
use Ro749\SharedUtils\Getters\BaseGetter;
use Ro749\SharedUtils\Tables\Column;
use Ro749\SharedUtils\Models\Modifier;
use Ro749\SharedUtils\Filters\BackendFilters\BasicFilter;
use Ro749\SharedUtils\Tables\Texts\TableTexts;
use Ro749\SharedUtils\Models\LogicModifiers\Options;
use Ro749\FullListingTemplate\Models\Client;
use Ro749\FullListingTemplate\Enums\Options as OptionsEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
class ClientPreviewTable extends BaseTable
{
    public function __construct(){
        parent::__construct(
            page_length: 50,
            texts: new TableTexts(
                lengthMenu: '_MENU_  &nbsp;Clientes por página',
                info: '',
                zeroRecords: 'Ningun cambio detectado'
            ),
            getter: new BaseGetter(
                model_class: Client::get_class(),
                columns : [
                    'name'=>new Column(
                        display:"Nombre",
                    ),
                    'phone'=>new Column(
                        display:"Telefono",
                    ),
                    'mail'=>new Column(
                        display:"Correo",
                    ),
                ],
                backend_filters: [
                    new BasicFilter(
                        id: "id",
                        filter: function(Builder $query,array $data) {
                            $query->withoutGlobalScope('client')->where('new', true);
                        }
                    )
                ]
            )
        );
    }
}