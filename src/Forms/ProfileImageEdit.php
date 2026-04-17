<?php

namespace Ro749\FullListingTemplate\Forms;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Ro749\SharedUtils\Forms\BaseForm;
use Ro749\SharedUtils\Forms\ImageUploader;
use Ro749\FullListingTemplate\Models\Asesor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
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

    public function prosses(Request $request)
    {
        $file = $request->file('pfp');
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('uploads', $filename, 'public');
        $asesor =  Auth::guard('asesor')->user();
        if ($asesor->pfp != '') {
            Storage::disk('public')->delete('uploads/' . $asesor->pfp);
        }
        DB::table('asesors')
        ->where('id', $asesor->id)
        ->update(values: [
            'pfp'=>$filename
        ]);
    }

    public function get_default_args(){
        $image = UploadedFile::fake()->image('avatar.jpg', 200, 200);
        $request = Request::create('/', 'POST',[],[],['pfp' => $image]);
        return ['request' => $request];
    } 
}
