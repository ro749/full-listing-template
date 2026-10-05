<x-layout id="dashboard">
    @include(config('overrides.views.header-admin'))
    <div style="height: 60px"></div>
    <div style="padding: 1.5rem">
        @php
            $chartsData = [
                'asesorsChart' => $asesors_chart,
                'clientsChart' => $clients_chart,
                'soldUnitsChart' => $sold_units_chart,
                'availableUnitsChart' => $available_units_chart,
                'quotesChart' => $quotes_chart,
                'salesChart' => $sales_chart,
                'modelsChart'=>$models_chart,
                'modelsQuotesChart'=>$models_quotes_chart
            ];
        @endphp
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
        ></div>
    </div>
</x-layout>
