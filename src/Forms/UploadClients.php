<?php

namespace Ro749\FullListingTemplate\Forms;

use Illuminate\Http\Request;
use Ro749\SharedUtils\Forms\BaseForm;
use Ro749\SharedUtils\Forms\FileUploader;
use Ro749\SharedUtils\Readers\DbReader;
use Ro749\FullListingTemplate\Models\Client;
use Ro749\FullListingTemplate\Tables\ClientPreviewTable;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
class UploadClients extends BaseForm
{
    public function __construct()
    {
        parent::__construct(
            submit_text: "Guardar",
            reload: false,
            success_msg: "Clientes cargados correctamente",
            fields: [
                'file' => new FileUploader(
                    accept: '.csv',
                    autosave: false,
                    reader: new DbReader(
                        model_class: Client::get_class(),
                        required_columns: ['name','mail','phone']
                    ),
                    preview_table: ClientPreviewTable::instance(),
                    cancel: function(){
                        Client::where('new', true)->delete();
                    }
                ),
            ],
        );
    }

    public function get_default_args(){
        $client = Client::instance()->first();
        $csvContent = "name,mail,phone\n".$client->name.",".$client->mail.",".$client->phone."\n";
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
