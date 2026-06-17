<?php

namespace Ro749\FullListingTemplate\Forms;

use Illuminate\Http\Request;
use Ro749\SharedUtils\Forms\BaseForm;
use Ro749\SharedUtils\Forms\FileUploader;
use Ro749\SharedUtils\Readers\DbUpdater;
use Ro749\FullListingTemplate\Models\Unit;
use Ro749\FullListingTemplate\Tables\PreviewTable;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
class UpdatePrices extends BaseForm
{
    public function __construct()
    {
        parent::__construct(
            submit_text: "Guardar",
            reload: false,
            success_msg: "Datos actualizados correctamente",
            fields: [
                'file' => new FileUploader(
                    accept: '.csv',
                    autosave: false,
                    reader: new DbUpdater(
                        model_class: Unit::get_class(),
                        public_id: 'unit',
                        required_columns: ['unit','price','status']
                    ),
                    cancel: function(){
                        $unit_class = Unit::get_class();
                        $unit_class::query()->update([
                            'new_price' => null,
                            'new_status' => null
                        ]);
                    },
                    save: function(){
                        Unit::instance()->whereNotNull('new_price')->update([
                            'price' => DB::raw('new_price')
                        ]);
                        Unit::instance()->whereNotNull('new_status')->update([
                            'status' => DB::raw('new_status')
                        ]);
                        Unit::instance()->query()->update([
                            'new_price' => null,
                            'new_status' => null
                        ]);
                    },
                    preview_table: PreviewTable::instance(),
                ),
            ],
        );
    }

    public function get_default_args(){
        $unit = Unit::instance()->first();
        $csvContent = "unit,price,status\n".$unit->unit.",".$unit->price.",".$unit->status;
        $tmpFile = tmpfile();
        fwrite($tmpFile, $csvContent);
        $tmpPath = stream_get_meta_data($tmpFile)['uri'];
        $csv = new UploadedFile(
            path: $tmpPath,
            originalName: 'data.csv',
            mimeType: 'text/csv',
            error: null
        );
        return ['request' => Request::create('/', 'POST',[],[],['file' => $csv])];
    } 
}
