@extends('tenant.components.master')
@section('title', 'DASHBOARD')

@section('container')
    <div class="page-heading">
        <h3>Welcome Tenant {{ empty($outlet[0]) ? '0' : $outlet[0]->tenant_name }}</h3>
        <p>All System are running smothly! you have 3 unread <span style="color:aqua">alert!</span> </p>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
                <div class="row">
                    {{-- @if (auth()->user()->roles == 'kantin') --}}
                    <div class="col-6 col-lg-3 col-md-6">
                        <a href="{{ route('laporan') }}">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                            <div class="stats-icon purple mb-2">
                                                <i class="iconly-boldShow"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                            <h6 class="text-muted font-semibold">
                                                Number of Omzet
                                            </h6>
                                            <h6 class="font-extrabold mb-0">
                                                {{ !empty($total_order) ? number_format($total_order, 2, ',', '.') : '0' }}
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <a href="{{ route('laporan') }}">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                            <div class="stats-icon blue mb-2">
                                                <i class="iconly-boldProfile"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                            <h6 class="text-muted font-semibold">Number of Orders</h6>
                                            <h6 class="font-extrabold mb-0">{{ $today_order }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>

                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <a href="{{ auth()->user()->roles == 'admin' ? route('tenant-control') : route('menu') }}">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                            <div class="stats-icon purple mb-2">
                                                <i class="iconly-boldShow"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                            <h6 class="text-muted font-semibold">
                                                {{ auth()->user()->roles == 'kantin' ? 'Number of Category' : 'Number of active tenants' }}
                                            </h6>
                                            <h6 class="font-extrabold mb-0">
                                                @if (auth()->user()->roles == 'kantin')
                                                    {{ empty($total_category) ? '0' : $total_category }}
                                                @else
                                                    empty($active_tenant)
                                                    ? '0'
                                                    : $active_tenant
                                                @endif
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <a href="{{ auth()->user()->roles == 'admin' ? route('tenant-control') : route('menu') }}">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                            <div class="stats-icon blue mb-2">
                                                <i class="iconly-boldProfile"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                            <h6 class="text-muted font-semibold">
                                                {{ auth()->user()->roles == 'kantin' ? 'Number of Menu' : 'Number of inactive tenants' }}
                                            </h6>
                                            <h6 class="font-extrabold mb-0">
                                                @if (auth()->user()->roles == 'kantin')
                                                    {{ empty($total_menu) ? '0' : $total_menu }}
                                                @endif
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    {{-- @endif --}}
                    {{-- <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon green mb-2">
                                            <i class="iconly-boldAdd-User"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Number of Users</h6>
                                        <h6 class="font-extrabold mb-0">BELUM</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon red mb-2">
                                            <i class="iconly-boldBookmark"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Number of Reservations</h6>
                                        <h6 class="font-extrabold mb-0">BELUM</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
                {{-- <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Profile Visit</h4>
                            </div>
                            <div class="card-body">
                                <div id="area"></div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div class="row">
                    <div class="col-12 col-xl-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Order Details</h4>
                                <p>The total number of sessions within the date range. It is the period time a user is
                                    actively engaged with your website, page or app, etc</p>
                            </div>
                            <div class="card-body">
                                {{-- <div class="row">
                                    <div class="col-6">
                                        <div class="d-flex align-items-center">
                                            <svg class="bi text-primary" width="32" height="32" fill="blue"
                                                style="width: 10px">
                                                <use xlink:href="assets/images/bootstrap-icons.svg#circle-fill" />
                                            </svg>
                                            <h5 class="mb-0 ms-3">Europe</h5>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <h5 class="mb-0">862</h5>
                                    </div>
                                    <div class="col-12">
                                        <div id="chart-europe"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="d-flex align-items-center">
                                            <svg class="bi text-success" width="32" height="32" fill="blue"
                                                style="width: 10px">
                                                <use xlink:href="assets/images/bootstrap-icons.svg#circle-fill" />
                                            </svg>
                                            <h5 class="mb-0 ms-3">America</h5>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <h5 class="mb-0">375</h5>
                                    </div>
                                    <div class="col-12">
                                        <div id="chart-america"></div>
                                    </div>
                                </div> --}}
                                <div class="row">
                                    {{-- <div class="col-6 d-flex">
                                        <h5 class="mb-0" style="margin-right: 10px">Order Value 1025</h5>
                                        <h5 class="mb-0" style="margin-right: 10px">Orders 1025</h5>
                                        <h5 class="mb-0" style="margin-right: 10px">Users 1025</h5>
                                        <h5 class="mb-0" style="margin-right: 10px">Sales 1025</h5>
                                    </div> --}}
                                    <div class="col-12">
                                        <div id="chart-order"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-6">
                        <div class="card">

                            <div class="card-header">
                                <h4>{{ auth()->user()->roles == 'kantin' ? 'Top Product' : 'Top Tenant' }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-lg">
                                        @if (auth()->user()->roles == 'kantin')
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Price</th>
                                                    <th>Order</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {{-- @foreach ($total_product as $row) --}}
                                                @foreach ($top_product as $item)
                                                    <tr>
                                                        <td class="col-3">
                                                            <div class="d-flex align-items-center">
                                                                <p class="font-bold ms-3 mb-0">{{ $item->name }}</p>
                                                            </div>
                                                        </td>
                                                        <td class="col-auto">
                                                            <p class="mb-0">
                                                                Rp.{{ number_format($item->original_price) }}
                                                            </p>
                                                        </td>
                                                        <td>
                                                            <div class="col-auto">
                                                                <p class="mb-0">{{ $item->total }}</p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    {{-- @endforeach --}}
                                                @endforeach
                                            </tbody>
                                        @else
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Total Order</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {{-- @foreach ($total_product as $row) --}}
                                                @foreach ($top_tenant as $item)
                                                    <tr>
                                                        <td class="col-3">
                                                            <div class="col-auto">
                                                                <p class="font-bold mb-0">{{ $item->name }}</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-auto">
                                                                <p class="mb-0">{{ $item->total_order }}</p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    {{-- @endforeach --}}
                                                @endforeach
                                            </tbody>
                                        @endif
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @php
                // dd(json_encode($order_grafik), json_encode($bulan_grafik));
            @endphp
            @push('scripts')
                <script src="{{ asset('assets/extensions/apexcharts/apexcharts.min.js') }}"></script>
                {{-- <script src="{{ asset('assets/js/pages/dashboard.js') }}"></script> --}}
                @if (auth()->user()->roles == 'kantin')
                    <script>
                        // console.log(json_encode($order_grafik), json_encode($bulan_grafik))
                        var areaOptions = {
                            series: [{
                                    name: "Order",
                                    // data: {!! json_encode($bulan_grafik) !!},
                                    data: {
                                        !!json_encode($order_grafik) !!
                                    },
                                },
                                // {
                                //     name: "series2",
                                //     data: [11, 32, 45, 32, 34, 52, 41],
                                // },
                            ],
                            chart: {
                                height: 350,
                                type: "area",
                            },
                            dataLabels: {
                                enabled: false,
                            },
                            stroke: {
                                curve: "smooth",
                            },
                            xaxis: {
                                type: "datetime",
                                categories: {
                                    !!json_encode($bulan_grafik) !!
                                },
                            },
                            tooltip: {
                                x: {
                                    format: "dd/MM/yy HH:mm",
                                },
                            },
                        };

                        var area = new ApexCharts(document.querySelector("#chart-order"), areaOptions);

                        area.render();
                    </script>
                @endif
            @endpush
        </section>
    </div>
@endsection
