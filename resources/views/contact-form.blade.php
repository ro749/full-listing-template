<x-form :form="$form" style="margin: 1rem; margin-top:3rem; display: flex; flex-direction: column; gap: 1rem; align-items: center;">
    <div><p style="font-size: 3rem;"><b>Contáctanos</b></p></div>
    <div style="display:flex; flex-direction:row; gap: 1rem; width: 100%;">
        <x-field name="name" :form="$form"/>
        <x-field name="unit" :form="$form"/>
    </div>
    <div style="display:flex; flex-direction:row; gap: 1rem; width: 100%;">
        <x-field name="email" :form="$form"/>
        <x-field name="phone" :form="$form"/>
    </div>
    
    <x-field name="message" :form="$form"/>
    <button class="btn btn-light" @click="submit">
        {{ $form->submit_text }}
    </button>
</x-form>