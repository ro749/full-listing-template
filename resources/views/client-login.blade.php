<!DOCTYPE html>
<html>
<head>
    @include(config('overrides.views.head'))
    @push('styles')
        <style>
            #form-field-category{
                width: 100% !important;
            }
            #RegisterClient{
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 1rem;
            }
            #SelectClient{
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 1rem;
            }
            .title{
                text-align: center;
                font-size: 2rem;
                margin-bottom: 2rem !important;
            }
            iconify-icon {
                font-size: 1rem;
            }

            .btn{
                background-color: #c5693b !important;
                color: white !important;
            }

            .login-card{
                background-color: #f1f1f1;
            }

            #RegisterClient .btn{
                margin-top: 1rem !important;
            }
            
        </style>
    @endpush
    @stack('styles')
</head>


<body>
    @include(config('overrides.views.header-asesor'))
    <div style="display: flex; justify-content: center; align-items: center; margin-top: 2rem; flex-direction: column;">
        @if(config('listing.not_force_client'))
        <a href="{{ route('disponibilidad') }}">
            <button class="btn btn-light" style="margin-bottom: 2rem">
                Ver disponibilidad
            </button>
        </a>
        @endif
        <div class="card login-card" style="padding:1.5rem;">
            <div style="display: flex; justify-content: center; width: 100%; margin-bottom: 2rem;">
                <img src="" style="width: 12rem">
            </div>
            
            <p class="title">Registrar Cliente</p>
            <x-smartForm :form="$form_register" style="display: flex; flex-direction: column; align-items: center; gap: 6px;" />
            <div style="height: 36px"></div>
            <p class="title">Seleccionar Cliente</p>
            <div style="height: 12px"></div>
            <x-smartForm :form="$form_select" style="display: flex; flex-direction: column; align-items: center; gap: 6px;" />
        </div>
    </div>
    @stack('script-includes')
    @stack('scripts')
</body>
</html>