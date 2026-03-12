<x-layout>
    <div style="display: flex; justify-content: center; align-items: center; height: 100vh; flex-direction: column;">
    <p>{{ $name }}, tu NIP fue reseteado, establece uno nuevo</p>
    <x-smartForm :form="$form" style="display: flex; flex-direction: column; align-items: center; gap: 6px;" />
    </div>
</x-layout>