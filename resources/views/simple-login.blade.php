<!DOCTYPE html>
<html>
<head>
    @include('listing-utils::head')
    @push('styles')
    <style>
        .login-card{
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        #{{ $form->get_id() }}{
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }
    </style>
    @endpush
    @stack('styles')
</head>


<body>
    <div style="display: flex; justify-content: center; align-items: center; height: 100vh;">
        <div class="card login-card" style="padding:1.5rem;">
            <img src="" id="logo" style="margin-bottom:1.5rem; width: 9em">
            <x-smartForm :form="$form" style="display: flex; flex-direction: column; align-items: center; gap: 6px;" />
        </div>
    </div>
    @stack('script-includes')
    @stack('scripts')
</body>
</html>