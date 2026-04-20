<x-layout>
    <style>
        #{{ $form->get_id() }}-fields{
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
        }
    </style>
    <div style="display: flex; justify-content: center; align-items: center; height: 100vh;">
        <div class="card login-card" style="padding:1.5rem; display: flex; flex-direction: column; align-items: center;">
            <img src="{{ $image }}" id="logo" style="margin-bottom:1.5rem; width: 9em">
            <x-form :form="$form" style="display: flex; flex-direction: column; align-items: center; gap: 6px;" />
        </div>
    </div>
</x-layout>