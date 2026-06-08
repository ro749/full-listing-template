<?php

// config for Ro749/FullListingTemplate
return [
    'overrides'=>[
        'forms'=>[
            'AdminLogin'=>\Ro749\FullListingTemplate\Forms\AdminLogin::class,
            'ClientComment'=>\Ro749\FullListingTemplate\Forms\ClientComment::class,
            'ClientEdit'=>\Ro749\FullListingTemplate\Forms\ClientEdit::class,
            'ClientEditAdmin'=>\Ro749\FullListingTemplate\Forms\ClientEditAdmin::class,
            'EditUser'=>\Ro749\FullListingTemplate\Forms\EditUser::class,
            'LoginForm'=>\Ro749\FullListingTemplate\Forms\LoginForm::class,
            'ProfileImageEdit'=>\Ro749\FullListingTemplate\Forms\ProfileImageEdit::class,
            'QuotationEdit'=>\Ro749\FullListingTemplate\Forms\QuotationEdit::class,
            'RegisterClient'=>\Ro749\FullListingTemplate\Forms\RegisterClient::class,
            'RegisterUser'=>\Ro749\FullListingTemplate\Forms\RegisterUser::class,
            'SelectClient'=>\Ro749\FullListingTemplate\Forms\SelectClient::class,
            'UnitEdit'=>\Ro749\FullListingTemplate\Forms\UnitEdit::class,
            'VentaEdit'=>\Ro749\FullListingTemplate\Forms\VentaEdit::class,
            'UpdatePrices'=>\Ro749\FullListingTemplate\Forms\UpdatePrices::class,
            'Contact'=>\Ro749\FullListingTemplate\Forms\Contact::class,
            'RegisterClientAdmin'=>\Ro749\FullListingTemplate\Forms\RegisterClientAdmin::class,
            'UploadClients'=>\Ro749\FullListingTemplate\Forms\UploadClients::class,
        ],
        'tables'=>[
            'ClientProfileTable'=>\Ro749\FullListingTemplate\Tables\ClientProfileTable::class,
            'Clients'=>\Ro749\FullListingTemplate\Tables\Clients::class,
            'ClientsAdmin'=>\Ro749\FullListingTemplate\Tables\ClientsAdmin::class,
            'Quotations'=>\Ro749\FullListingTemplate\Tables\Quotations::class,
            'QuotationsAdmin'=>\Ro749\FullListingTemplate\Tables\QuotationsAdmin::class,
            'Torre'=>\Ro749\FullListingTemplate\Tables\Torre::class,
            'TorreAdmin'=>\Ro749\FullListingTemplate\Tables\TorreAdmin::class,
            'Users'=>\Ro749\FullListingTemplate\Tables\Users::class,
            'Ventas'=>\Ro749\FullListingTemplate\Tables\Ventas::class,
            'PreviewTable'=>\Ro749\FullListingTemplate\Tables\PreviewTable::class,
            'ClientPreviewTable'=>\Ro749\FullListingTemplate\Tables\ClientPreviewTable::class,
            'AsesorsDashboard'=>\Ro749\FullListingTemplate\Tables\AsesorsDashboard::class
        ],
        'models'=>[
            'Asesor'=>\Ro749\FullListingTemplate\Models\Asesor::class,
            'Client'=>\Ro749\FullListingTemplate\Models\Client::class,
            'Quotation'=>\Ro749\FullListingTemplate\Models\Quotation::class,
            'Unit'=>\Ro749\FullListingTemplate\Models\Unit::class,  
            'Model'=>\Ro749\FullListingTemplate\Models\Model::class,  
            'Plan'=>\Ro749\FullListingTemplate\Models\Plan::class,
            'PlanLine'=>\Ro749\FullListingTemplate\Models\PlanLine::class,
        ],
        'controllers'=>[
            'AdminController'=>\Ro749\FullListingTemplate\Controllers\AdminController::class,
            'AsesorController'=>\Ro749\FullListingTemplate\Controllers\AsesorController::class,
            'DispoController'=>\Ro749\FullListingTemplate\Controllers\DispoController::class,
            'AdminLoginController'=>\Ro749\FullListingTemplate\Controllers\AdminLoginController::class
        ],
        'views'=>[
            'actualizar-precios'=>'full-listing-template::actualizar-precios',
            'asesor-area'=>'full-listing-template::asesor-area',
            'client-login'=>'full-listing-template::client-login',
            'client-profile-admin'=>'full-listing-template::client-profile-admin',
            'client-profile'=>'full-listing-template::client-profile',
            'disponibilidad'=>'full-listing-template::disponibilidad',
            'head'=>'full-listing-template::head',
            'header-admin'=>'full-listing-template::header-admin',
            'header-asesor'=>'full-listing-template::header-asesor',
            'header'=>'full-listing-template::header',
            'pfp'=>'full-listing-template::pfp',
            'popup-reseted'=>'full-listing-template::popup-reseted',
            'register-asesor'=>'full-listing-template::register-asesor',
            'register-client'=>'full-listing-template::register-client',
            'reset-password'=>'full-listing-template::reset-password',
            'sales-table'=>'full-listing-template::sales-table',
            'scripts'=>'full-listing-template::scripts',
            'simple-login'=>'full-listing-template::simple-login',
            'simple-table'=>'full-listing-template::simple-table',
            'table-asesor'=>'full-listing-template::table-asesor',
            'title'=>'full-listing-template::title',
            'torre-admin'=>'full-listing-template::torre-admin',
            'torre'=>'full-listing-template::torre',
            'unavailable'=>'full-listing-template::unavailable',
            'footer'=>'full-listing-template::footer',
            'dashboard'=>'full-listing-template::dashboard',
            'cargar-clientes'=>'full-listing-template::cargar-clientes',
        ],
        'datas'=>[
            'Dashboard'=>\Ro749\FullListingTemplate\Data\Dashboard::class,
            'UnitData'=>\Ro749\FullListingTemplate\Data\UnitData::class,
        ],
        'charts'=>[
            'AsesorsChart'=>\Ro749\FullListingTemplate\Charts\AsesorsChart::class,
        ],
        'image_map_pro'=>\Ro749\ListingUtils\ImageMapPro\SingleImageMapPro::class,
        'plans'=>\Ro749\ListingUtils\Plans\PlansBase::class,
        'sender'=>\Ro749\ListingUtils\Sender\CotizationSenderBase::class
    ],
    'login'=>[
        'guard'=>'asesor',
        'admin_guard'=>'asesor',
        'table'=>'asesors',
        'model'=>Ro749\FullListingTemplate\Models\Asesor::class,
        'default_password'=>'0000',
        'redirect'=>'/client-login',
    ],
    'options'=>[
        "UnitsStatus" => [
            "Disponible",
            "Vendido",
            "Apartado",
            "Bloqueado"
        ],
        "AsesorCategories" => [
            "Interno",
            "Externo",
            "Inmobiliario"
        ],
        "ClientCategories" => [
            "Nuevo",
            "Perfilado",
            "Negociacion",
            "Cerrado"
        ],
        "ClientPriorities" => [
            "Baja",
            "Media",
            "Alta"
        ],
        "QuotationStatus"=> [
            "Pendiente",
            "Aprobado",
            "Rechazado",
            "Cerrado"
        ],
        "AsesorStatus"=> [
            "Activo",
            "Inactivo"
        ]
    ],
    'auth'=>[
        'guards' => [
            'asesor' => [
                'driver' => 'session',
                'provider' => 'asesors',
            ],
        ],
        'providers' => [
            'asesors' => [
                'driver' => 'eloquent',
                'model' => \Ro749\FullListingTemplate\Models\Asesor::class,
            ],
        ],
    ]
];
