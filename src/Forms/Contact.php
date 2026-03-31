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
                    rules: ["required"]
                ),
                'email' => new Field(
                    type: InputType::EMAIL,
                    label: 'Correo electrónico',
                    rules: ["required"]
                ),
                'phone' => new Field(
                    type: InputType::PHONE,
                    label: 'Teléfono',
                    rules: ["required"]
                ),
                //'unit' => Selector::fromDB(
                //    id: 'unitselector',
                //    table: (new (config('overrides.models.Unit')))->getTable(),
                //    label_column: $unit_column,
                //    label: "Unidad de interés",
                //    rules: ["required"],
                //    query_modifier: function ($query) use ($status_column) {
                //        $query->where($status_column, UnitsStatus::Disponible->value);
                //    }
//
                //),
                'message' => new TextArea(
                    label: 'Mensaje',
                    rows: 3
                ),

            ],
        );
        $this->mail_to = config('listing.open.mail_to');
    }

    public function prosses(Request $rawRequest): string
    {
        $data = $rawRequest->validate($this->rules($rawRequest));
        $mail = new ContactMail(
            $data['name'],
            $data['phone'],
            $data['email'],
            $data['unit'],
            $data['message']??""
        );
        Mail::to($this->mail_to)->send($mail);
        return $this->redirect;
    }

    public function render(): string
    {
        return view(config('overrides.views.contact-form'), [
            'form' => $this
        ]);
    }
}
