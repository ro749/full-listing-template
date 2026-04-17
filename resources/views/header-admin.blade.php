@php
    $items = [
        ['label' => 'Unidades', 'url' => '/admin/unidades'],
        ['label' => 'Ventas', 'url' => '/admin/ventas'],
        ['label' => 'Registrar Asesor', 'url' => '/admin/register-asesor'],
        ['label' => 'Asesores', 'url' => '/admin/asesors'],
        ['label' => 'Clientes', 'url' => '/admin/clients'],
        ['label' => 'Cotizaciones', 'url' => '/admin/cotizaciones'],
        ...(!empty(config('listing.dashboard')) ? [['label' => 'Dashboard', 'url' => '/admin/dashboard']] : []),
        ['label' => 'Logout', 'url' => '/logout'],
    ];
@endphp

@include('shared-utils::components.sidebar', [
    'items' => $items,
    'logo' => ''
])
@include('shared-utils::components.navbar')
