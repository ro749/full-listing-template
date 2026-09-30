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
                'salesChart' => $sales_chart
            ];
        @endphp
        <div
            data-widget="dashboard"
            data-config='@json($data)'
            data-charts='@json($chartsData)'
        ></div>
    </div>
</x-layout>
