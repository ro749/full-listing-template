<x-layout>
    <div style="display: flex; justify-content: center; align-items: center; height: 100vh; flex-direction: column;">
        <p>{{ $name }}, tu NIP fue reseteado, establece uno nuevo</p>
        <div data-widget="form" data-config='@json($form->get_info())'></div>
    </div>
</x-layout>