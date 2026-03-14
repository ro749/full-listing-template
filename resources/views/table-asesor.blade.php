<x-layout>
    <style>
        .filter-on{
            background-color: gray;
        }
    </style>
    @include(config('overrides.views.header-asesor'))
    <div style="height: 60px"></div>
    <div style="padding: 1.5rem">
    @include('sharedutils::components.tables.smartTable', ['table' => $table])
    </div>
</x-layout>