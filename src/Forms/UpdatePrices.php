<?php

namespace Ro749\FullListingTemplate\Forms;

use Ro749\SharedUtils\Forms\BaseForm;
use Ro749\SharedUtils\Forms\FileUploader;
use Ro749\SharedUtils\Readers\DbUpdater;
use Ro749\FullListingTemplate\Models\Unit;
use Ro749\FullListingTemplate\Tables\PreviewTable;
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
                    updater: new DbUpdater(
                            model_class: Unit::class,
                            public_id: 'unit',
                            required_columns: ['unit','price','status']
                    ),
                    preview_table: PreviewTable::instance()
                ),
            ],
        );
    }
}
