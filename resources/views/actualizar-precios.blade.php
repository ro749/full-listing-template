<!DOCTYPE html>
<html>
<head>
    @include('listing-utils::head')
    @push('styles')
    <style>
        #file-container{
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100% !important;
        }
        .btn{
            background-color: var(--success-600) !important;
            color: white !important;
        }
        #file{
            padding: 1rem;
        }
        #PreviewTable_wrapper{
            width: 100% !important;
        }
    </style>
    @endpush
    @stack('styles')
</head>


<body>
    @include(config('overrides.views.header-admin'))
    <div style="padding: 1.5rem">
    <h1 style="color: black; text-align: center; padding: 1rem; margin-bottom: 0;">Carga de CSV de precios y disponibilidad</h1>
    <x-smartForm :form="$form" style="display: flex; flex-direction: column; align-items: center;" />
    
    </div>
    @stack('script-includes')
    @stack('scripts')
</body>
</html>