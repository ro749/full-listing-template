<x-layout>
    @include(config('overrides.views.header'))
    <div style="padding: 1.5rem">
        <div data-widget="table" data-config='@json($table->get_info())'></div>
    </div>
</x-layout>