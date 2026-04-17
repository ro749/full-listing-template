@php
    $items = [
        ['label' => 'Inicio', 'url' => '/client-login'],
        ['label' => 'Clientes', 'url' => '/clients'],
        ['label' => 'Cotizaciones', 'url' => '/cotizaciones'],
        ['label' => 'Cerrar Sesión', 'url' => '/logout'],
    ];
    $user = Auth::guard('asesor')->user();
    $form = Ro749\FullListingTemplate\Forms\ProfileImageEdit::instanciate();
@endphp

@include('shared-utils::components.sidebar', [
    'items' => $items,
    'logo' => ''
])


<div class="navbar-header" style="display:flex; align-items: center; justify-content: space-between;">
    <button type="button" class="sidebar-mobile-toggle">
            <iconify-icon icon="heroicons:bars-3-solid" class="icon"></iconify-icon>
    </button>
    @if(!empty($user))
    <div style="display:flex; align-items: center; gap: 8px;">
        <p>{{ $user->name }}</p>
        <x-form :form="$form" />
    </div>
    @endif
    
</div>