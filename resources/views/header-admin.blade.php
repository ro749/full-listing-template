@php
    $items = [
        ['label' => 'Unidades', 'url' => '/admin/unidades'],
        ['label' => 'Ventas', 'url' => '/admin/ventas'],
        ['label' => 'Registrar Asesor', 'url' => '/admin/register-asesor'],
        ['label' => 'Asesores', 'url' => '/admin/asesors'],
        ['label' => 'Clientes', 'url' => '/admin/clients'],
        ['label' => 'Cotizaciones', 'url' => '/admin/cotizaciones'],
        ['label' => 'Logout', 'url' => '/logout'],
    ];
@endphp

@include('shared-utils::components.sidebar', [
    'items' => $items,
    'logo' => ''
])
@include('shared-utils::components.navbar')
