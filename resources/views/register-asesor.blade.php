<x-layout>
    @push('styles')
        <style>
            #form-field-category{
                width: 100% !important;
            }
        </style>
    @endpush
    @stack('styles')
    @include(config('overrides.views.header-admin'))
    <div style="display: flex; justify-content: center; align-items: center; height: 100vh;">
        <div class="card login-card" style="padding:1.5rem;">
            <p style="text-align:center; font-size:3vw;">Registro</p>
            <div data-widget="form" data-config='@json($form->get_info())'></div>
        </div>
    </div>
</body>
</x-layout>