<x-layout id="client-login">
    @include(config('overrides.views.header-admin'))
    <div style="display: flex; justify-content: center; align-items: center; margin-top: 2rem; flex-direction: column;">
        <div class="card login-card" style="padding:1.5rem;">
            @if(isset($image))
            <div style="display: flex; justify-content: center; width: 100%; margin-bottom: 2rem;">
                <img src="{{ $image }}" style="width: 12rem">
            </div>
            @endif
            <p class="title">Registrar Cliente</p>
            <x-form :form="$form" style="display: flex; flex-direction: column; align-items: center; gap: 6px;" />
        </div>
    </div>
</x-layout>