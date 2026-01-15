<!DOCTYPE html>
<html>
<head>
    @include('shared-utils::components.head')
    @stack('styles')
</head>


<body>
    @include(config('overrides.views.header-admin'))
    <div style="height: 60px">
    </div>
    <x-data :data="$data">
        <div class="row gy-4">
            <div class="row gy-4">
                <div class="col-xxl-8">
                    <div class="row gy-4">
                        <div class="col-xxl-4 col-sm-6">
                            <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-1">
                                <div class="card-body p-0">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                        <div class="d-flex align-items-center gap-2">
                                            <span style="align-items: end !important" class="mb-0 w-48-px h-48-px bg-primary-600 flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0">
                                                <iconify-icon icon="mingcute:user-follow-fill" class="icon"></iconify-icon>  
                                            </span>
                                            <div>
                                                <span class="mb-2 fw-medium text-secondary-light text-sm">Asesores</span>
                                                <h6 class="fw-semibold"><x-f-text id="total_asesores" :data="$data"></x-f-text></h6>
                                            </div>
                                        </div>
                                        <x-chart :chart="$asesors_chart" color="#487fff" ></x-chart>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-4 col-sm-6">
                            <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-2">
                                <div class="card-body p-0">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                        <div class="d-flex align-items-center gap-2">
                                            <span style="align-items: end !important" class="mb-0 w-48-px h-48-px bg-success-main flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0">
                                                <iconify-icon icon="mingcute:user-follow-fill" class="icon"></iconify-icon>  
                                            </span>
                                            <div>
                                                <span class="mb-2 fw-medium text-secondary-light text-sm">Clientes</span>
                                                <h6 class="fw-semibold"><x-f-text id="total_clients" :data="$data"></x-f-text></h6>
                                            </div>
                                        </div>
                                        <x-chart :chart="$clients_chart" color="#45b369" ></x-chart>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-4 col-sm-6">
                            <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-3">
                                <div class="card-body p-0">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                        <div class="d-flex align-items-center gap-2">
                                            <span style="align-items: end !important" class="mb-0 w-48-px h-48-px bg-yellow flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0">
                                                <iconify-icon icon="iconamoon:discount-fill" class="icon"></iconify-icon>
                                            </span>
                                            <div>
                                                <span class="mb-2 fw-medium text-secondary-light text-sm">Unidades Vendidas</span>
                                                <h6 class="fw-semibold"><x-f-text id="sold_units" :data="$data"></x-f-text></h6>
                                            </div>
                                        </div>
                                        <x-chart :chart="$sold_units_chart" color="#f4941e" ></x-chart>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-4 col-sm-6">
                            <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-4">
                                <div class="card-body p-0">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                        <div class="d-flex align-items-center gap-2">
                                            <span style="align-items: end !important" class="mb-0 w-48-px h-48-px bg-purple flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0">
                                                <iconify-icon icon="mdi:message-text" class="icon"></iconify-icon>
                                            </span>
                                            <div>
                                                <span class="mb-2 fw-medium text-secondary-light text-sm">Unidades Vendidas</span>
                                                <h6 class="fw-semibold"><x-f-text id="available_units" :data="$data"></x-f-text></h6>
                                            </div>
                                        </div>
                                        <x-chart :chart="$available_units_chart" color="#8252e9" ></x-chart>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4">
                    <div class="card h-100 radius-8 border">
                        <div class="card-body p-24">
                            <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                                <div>
                                    <h6 class="mb-2 fw-bold text-lg">Cotizaciones</h6>
                                    <span class="text-sm fw-medium text-secondary-light">Mensuales</span>
                                </div>
                                <div class="text-end">
                                    <h6 class="mb-2 fw-bold text-lg">
                                        <x-f-text id="total_quotes" :data="$data"></x-f-text>
                                    </h6>
                                    <span class="bg-success-focus ps-12 pe-12 pt-2 pb-2 rounded-2 fw-medium text-success-main text-sm">
                                        +<x-f-text id="new_quotes" :data="$data"></x-f-text>
                                    </span>
                                </div>
                            </div>
                            <x-chart2 :chart="$quotes_chart" color="#487fff" ></x-chart2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-8">
                <div class="card h-100 radius-8 border-0">
                    <div class="card-body p-24">
                        <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                            <div>
                                <h6 class="mb-2 fw-bold text-lg">Ventas</h6>
                            </div>
                        </div>

                        <x-chart3 :chart="$sales_chart" color="#487fff" ></x-chart3>
                    </div>
                </div>
            </div>

            <div class="col-xxl-4">
                <div class="row gy-4">
                    <div class="col-xxl-12 col-sm-6">
                        <div class="card h-100 radius-8 border-0">
                            <div class="card-body p-24">
                                <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                                    <h6 class="mb-2 fw-bold text-lg">Unidades</h6>
                                </div>

                                <div class="mt-3">

                                    <div class="d-flex align-items-center justify-content-between gap-3 mb-12">
                                        <div class="d-flex align-items-center">
                                            <span class="text-xxl line-height-1 d-flex align-content-center flex-shrink-0 text-orange">
                                                <iconify-icon icon="majesticons:mail" class="icon"></iconify-icon>
                                            </span>
                                            <span class="text-primary-light fw-medium text-sm ps-12">Disponibles</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2 w-100">
                                            <div class="w-100 max-w-66 ms-auto">
                                                <div class="progress progress-sm rounded-pill" role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                                    <x-f-div class="progress-bar bg-orange rounded-pill" style-data="width: percent_available;" :data="$data"></x-f-div>
                                                </div>
                                            </div>
                                            <span class="text-secondary-light font-xs fw-semibold">
                                                <x-f-text id="percent_available" :data="$data"></x-f-text>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-between gap-3 mb-12">
                                        <div class="d-flex align-items-center">
                                            <span class="text-xxl line-height-1 d-flex align-content-center flex-shrink-0 text-success-main">
                                                <iconify-icon icon="eva:globe-2-fill" class="icon"></iconify-icon>
                                            </span>
                                            <span class="text-primary-light fw-medium text-sm ps-12">Apartadas</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2 w-100">
                                            <div class="w-100 max-w-66 ms-auto">
                                                <div class="progress progress-sm rounded-pill" role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                                    <x-f-div  class="progress-bar bg-success-main rounded-pill" style-data="width: percent_apartado;" :data="$data"></x-f-div>
                                                </div>
                                            </div>
                                            <span class="text-secondary-light font-xs fw-semibold">
                                                <x-f-text id="percent_apartado" :data="$data"></x-f-text>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-between gap-3 mb-12">
                                        <div class="d-flex align-items-center">
                                            <span class="text-xxl line-height-1 d-flex align-content-center flex-shrink-0 text-info-main">
                                                <iconify-icon icon="fa6-brands:square-facebook" class="icon"></iconify-icon>
                                            </span>
                                            <span class="text-primary-light fw-medium text-sm ps-12">Vendidas</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2 w-100">
                                            <div class="w-100 max-w-66 ms-auto">
                                                <div class="progress progress-sm rounded-pill" role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                                    <x-f-div class="progress-bar bg-info-main rounded-pill" style-data="width: percent_sold;" :data="$data"></x-f-div>
                                                </div>
                                            </div>
                                            <span class="text-secondary-light font-xs fw-semibold">
                                                <x-f-text id="percent_sold" :data="$data"></x-f-text>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-12 col-sm-6">
                        <div class="card h-100 radius-8 border-0 overflow-hidden">
                            <div class="card-body p-24">
                                <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                                    <h6 class="mb-2 fw-bold text-lg">Customer Overview</h6>
                                    <div class="">
                                        <select class="form-select form-select-sm w-auto bg-base border text-secondary-light">
                                            <option>Yearly</option>
                                            <option>Monthly</option>
                                            <option>Weekly</option>
                                            <option>Today</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap align-items-center mt-3">
                                    <ul class="flex-shrink-0">
                                        <li class="d-flex align-items-center gap-2 mb-28">
                                            <span class="w-12-px h-12-px rounded-circle bg-success-main"></span>
                                            <span class="text-secondary-light text-sm fw-medium">Total: 500</span>
                                        </li>
                                        <li class="d-flex align-items-center gap-2 mb-28">
                                            <span class="w-12-px h-12-px rounded-circle bg-warning-main"></span>
                                            <span class="text-secondary-light text-sm fw-medium">New: 500</span>
                                        </li>
                                        <li class="d-flex align-items-center gap-2">
                                            <span class="w-12-px h-12-px rounded-circle bg-primary-600"></span>
                                            <span class="text-secondary-light text-sm fw-medium">Active: 1500</span>
                                        </li>
                                    </ul>
                                    <div id="donutChart" class="flex-grow-1 apexcharts-tooltip-z-none title-style circle-none"></div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-data>
    @stack('script-includes')
    @stack('scripts')
</body>
</html>