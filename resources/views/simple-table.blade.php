<x-layout>
    @include(config('overrides.views.header-admin'))
    <div style="height: 60px"></div>
    <div style="padding: 1.5rem">
        <div data-widget="table" data-config='@json($table->get_info())'></div>
    </div>
</x-layout>