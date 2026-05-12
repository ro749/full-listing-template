<?php

namespace Ro749\FullListingTemplate\Forms;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Ro749\SharedUtils\Forms\BaseForm;
use Ro749\SharedUtils\Forms\Field;
use Ro749\SharedUtils\Forms\Selector;
use Ro749\SharedUtils\Forms\InputType;
use Ro749\SharedUtils\Forms\TextArea;
use Ro749\FullListingTemplate\Mail\ContactMail;
use Ro749\FullListingTemplate\Enums\UnitsStatus;
use Ro749\FullListingTemplate\Models\Unit;

class Contact extends BaseForm
{
    public string $mail_to = '';
    public function __construct(
        string $unit_column = 'unit',
        string $status_column = 'status',
    )
    {
        parent::__construct(
            submit_text: "Enviar",
            uploading_message: "Enviando...",
            success_msg: "¡Gracias por contactarnos! Nos pondremos en contacto contigo pronto.",
            fields: [
                'name' => new Field(
                    type: InputType::TEXT,
                    label: 'Nombre',
                    required: true,
                ),
                'email' => new Field(
                    type: InputType::EMAIL,
                    label: 'Correo electrónico',
                    required: true,
                ),
                'phone' => new Field(
                    type: InputType::PHONE,
                    label: 'Teléfono',
                    required: true,
                ),
                'unit' => Selector::fromDB(
                    id: 'unitselector',
                    model_class: Unit::get_class(),
                    label_column: $unit_column,
                    label: "Unidad de interés",
                    required: true,
                    query_modifier: function ($query) use ($status_column) {
                        $query->where($status_column, UnitsStatus::Disponible->value);
                    }

                ),
                'message' => new TextArea(
                    label: 'Mensaje',
                    rows: 3
                ),

            ],
        );
        $this->mail_to = env('MAIL_TO', 'rorivera200@gmail.com');
    }

    public function prosses(Request $request): string
    {
        $data = $request->validate($this->rules($request));
        $mail = new ContactMail(
            $data['name'],
            $data['phone'],
            $data['email'],
            $data['unit'],
            $data['message']??""
        );
        if($this->mail_to == '') return $this->redirect;
        Mail::to($this->mail_to)->send($mail);
        return $this->redirect;
    }

    public function render(): string
    {
        return view(config('overrides.views.contact-form'), [
            'form' => $this
        ]);
    }

    public function get_default_args(){
        return ['request' => Request::create('/', 'POST',[
            'name' => 'test',
            'phone' => '3337811749',
            'email' => 'a@a.com',
            'unit' => Unit::instance()->first()->id
        ])];
    }
}
