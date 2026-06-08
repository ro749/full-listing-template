@php
    $items = [
        ['label' => 'Unidades', 'url' => '/admin/unidades'],
        ['label' => 'Ventas', 'url' => '/admin/ventas'],
        ['label' => 'Registro de Asesor', 'url' => '/admin/register-asesor'],
        ['label' => 'Registro de Clientes', 'url' => '/admin/register-client'],
        ['label' => 'Asesores', 'url' => '/admin/asesors'],
        ['label' => 'Clientes', 'url' => '/admin/clients'],
        ['label' => 'Cotizaciones', 'url' => '/admin/cotizaciones'],
        ['label' => 'Cargar Clientes', 'url' => route('cargar-clientes')],
        ...(!empty(config('listing.ulpoadcvs')) ? [['label' => 'Cargar Precios', 'url' => route('actualizar-precios')],] : []),
        ...(!empty(config('listing.dashboard')) ? [['label' => 'Dashboard', 'url' => '/admin/dashboard']] : []),
        ['label' => 'Logout', 'url' => '/logout'],
    ];
@endphp

@include('shared-utils::components.sidebar', [
    'items' => $items,
    'logo' => ''
])
@include('shared-utils::components.navbar')
