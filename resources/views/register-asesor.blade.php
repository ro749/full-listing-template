<!DOCTYPE html>
<html>
<head>
    @include('shared-utils::components.head')
    @push('styles')
        <style>
            #form-field-category{
                width: 100% !important;
            }
        </style>
    @endpush
    @stack('styles')
</head>


<body>
    @include('header-admin')
    <div style="display: flex; justify-content: center; align-items: center; height: 100vh;">
        <div class="card login-card" style="padding:1.5rem;">
            <p style="text-align:center; font-size:3vw;">Registro</p>
            <x-smartForm :form="$form" style="display: flex; flex-direction: column; align-items: center; gap: 6px;" />
        </div>
    </div>
    @stack('script-includes')
    @stack('scripts')
</body>
</html>