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
                            <span class="text-sm fw-medium text-secondary-light">Yearly earning overview</span>
                        </div>
                        <div class="">
                            <select class="form-select form-select-sm w-auto bg-base border text-secondary-light">
                                <option>Yearly</option>
                                <option>Monthly</option>
                                <option>Weekly</option>
                                <option>Today</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-20 d-flex justify-content-center flex-wrap gap-3">

                        <div class="d-inline-flex align-items-center gap-2 p-2 radius-8 border pe-36 br-hover-primary group-item">
                            <span class="bg-neutral-100 w-44-px h-44-px text-xxl radius-8 d-flex justify-content-center align-items-center text-secondary-light group-hover:bg-primary-600 group-hover:text-white">
                                <iconify-icon icon="fluent:cart-16-filled" class="icon"></iconify-icon>
                            </span>
                            <div>
                                <span class="text-secondary-light text-sm fw-medium">Sales</span>
                                <h6 class="text-md fw-semibold mb-0">$200k</h6>
                            </div>
                        </div>

                        <div class="d-inline-flex align-items-center gap-2 p-2 radius-8 border pe-36 br-hover-primary group-item">
                            <span class="bg-neutral-100 w-44-px h-44-px text-xxl radius-8 d-flex justify-content-center align-items-center text-secondary-light group-hover:bg-primary-600 group-hover:text-white">
                                <iconify-icon icon="uis:chart" class="icon"></iconify-icon>
                            </span>
                            <div>
                                <span class="text-secondary-light text-sm fw-medium">Income</span>
                                <h6 class="text-md fw-semibold mb-0">$200k</h6>
                            </div>
                        </div>

                        <div class="d-inline-flex align-items-center gap-2 p-2 radius-8 border pe-36 br-hover-primary group-item">
                            <span class="bg-neutral-100 w-44-px h-44-px text-xxl radius-8 d-flex justify-content-center align-items-center text-secondary-light group-hover:bg-primary-600 group-hover:text-white">
                                <iconify-icon icon="ph:arrow-fat-up-fill" class="icon"></iconify-icon>
                            </span>
                            <div>
                                <span class="text-secondary-light text-sm fw-medium">Profit</span>
                                <h6 class="text-md fw-semibold mb-0">$200k</h6>
                            </div>
                        </div>
                    </div>

                    <x-chart3 :chart="$sales_chart" color="#487fff" ></x-chart3>
                </div>
            </div>
        </div>
    </x-data>
    @stack('script-includes')
    @stack('scripts')
</body>
</html>