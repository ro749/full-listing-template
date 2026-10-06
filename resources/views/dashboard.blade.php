<x-layout id="dashboard">
    @include(config('overrides.views.header-admin'))
    <div style="height: 60px"></div>
    <div style="padding: 1.5rem">
        <div
            data-widget="dashboard"
            data-config='@json($data)'
            data-asesorsChart='@json($asesors_chart)'
            data-clientsChart='@json($clients_chart)'
            data-soldUnitsChart='@json($sold_units_chart)'
            data-availableUnitsChart='@json($available_units_chart)'
            data-quotesChart='@json($quotes_chart)'
            data-salesChart='@json($sales_chart)'
            data-modelsChart='@json($models_chart)'
            data-modelsQuotesChart='@json($models_quotes_chart)'
            data-asesoresTable='@json($asesores_table)'
            data-asesorsquoteschart='@json($asesors_quotes_chart)'
        ></div>
    </div>
</x-layout>
