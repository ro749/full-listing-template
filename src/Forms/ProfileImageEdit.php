<?php

namespace Ro749\FullListingTemplate\Forms;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Ro749\SharedUtils\Forms\BaseForm;
use Ro749\SharedUtils\Forms\ImageUploader;
use Ro749\FullListingTemplate\Models\Asesor;
class ProfileImageEdit extends BaseForm
{
    public function __construct()
    {
        parent::__construct(
            model_class: Asesor::get_class(),
            submit_text: "",
            reload: true,
            db_id: Auth::guard('asesor')->user()->id,
            fields: [
                'pfp' => new ImageUploader(
                    route: 'uploads/',
                    view: config('overrides.views.pfp'),
                    view_data: ['user' => DB::table('asesors')->where('id', auth()->guard('asesor')->user()->id)->first()],
                    autosave: true
                ),
            ],
        );
    }
}
