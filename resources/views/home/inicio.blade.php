@extends('layouts.app')
@section('css')

@endsection

@section('content')
    <!--begin::Row-->
    <div class="row g-5 gx-xl-10 mb-5 mb-xl-10">

        <div class="col-xxl-12">
            <div class="card card-flush h-md-100">
                <div class="card-body d-flex flex-column justify-content-between mt-9 bgi-no-repeat bgi-size-cover bgi-position-x-center pb-0"
                    style="background-position: 100% 50%; background-image:url('assets/media/stock/900x600/42.png')">
                    <div class="mb-10">
                        <div class="fs-2hx fw-bold text-gray-800 text-center mb-13">
                            <span class="me-2">Sistema de Control de Studio Fotografico
                                <br />
                                <span class="position-relative d-inline-block text-danger">
                                    <span
                                        class="position-absolute opacity-15 bottom-0 start-0 border-4 border-danger border-bottom w-100"></span>
                                </span></span> :)
                        </div>
                    </div>

                    <!--begin::Content-->
                    <div id="kt_app_content" class="app-content flex-column-fluid">
                        <!--begin::Content container-->
                        <div id="kt_app_content_container" class="app-container container-fluid">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-md-3">
                                    <!--begin::Card widget 20-->
                                    <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end"
                                        style="background-color: #F1416C;background-image:url('assets/media/patterns/vector-1.png');">
                                        <!--begin::Header-->
                                        <div class="card-header pt-5">
                                            <!--begin::Title-->
                                            <div class="card-title d-flex flex-column">
                                                <!--begin::Amount-->
                                                <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ $cantidadUsuario }}</span>
                                                <!--end::Amount-->
                                                <!--begin::Subtitle-->
                                                <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Usuarios Registrados</span>
                                                <!--end::Subtitle-->
                                            </div>
                                            <!--end::Title-->
                                        </div>
                                        <!--end::Header-->
                                        <!--begin::Card body-->
                                        <div class="card-body d-flex align-items-end pt-0">
                                            <!--begin::Progress-->
                                            <div class="d-flex align-items-center flex-column mt-3 w-100">
                                                <div
                                                    class="d-flex justify-content-between fw-bold fs-6 text-white opacity-75 w-100 mt-auto mb-2">
                                                    {{-- <span>43 Pending</span>
                                                <span>72%</span> --}}
                                                </div>
                                                <div class="h-8px mx-3 w-100 bg-white bg-opacity-50 rounded">
                                                    <div class="bg-white rounded h-8px" role="progressbar"
                                                        style="width: 72%;" aria-valuenow="50" aria-valuemin="0"
                                                        aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <!--end::Progress-->
                                        </div>
                                        <!--end::Card body-->
                                    </div>
                                    <!--end::Card widget 20-->
                                </div>
                                <!--end::Col-->

                                <!--begin::Col-->
                                <div class="col-md-3">
                                    <!--begin::Card widget 20-->
                                    <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end"
                                        style="background-color: #4d41f1;background-image:url('assets/media/patterns/vector-1.png');">
                                        <!--begin::Header-->
                                        <div class="card-header pt-5">
                                            <!--begin::Title-->
                                            <div class="card-title d-flex flex-column">
                                                <!--begin::Amount-->
                                                <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">0</span>
                                                <!--end::Amount-->
                                                <!--begin::Subtitle-->
                                                <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Registros</span>
                                                <!--end::Subtitle-->
                                            </div>
                                            <!--end::Title-->
                                        </div>
                                        <!--end::Header-->
                                        <!--begin::Card body-->
                                        <div class="card-body d-flex align-items-end pt-0">
                                            <!--begin::Progress-->
                                            <div class="d-flex align-items-center flex-column mt-3 w-100">
                                                <div
                                                    class="d-flex justify-content-between fw-bold fs-6 text-white opacity-75 w-100 mt-auto mb-2">
                                                    {{-- <span>43 Pending</span>
                                                <span>72%</span> --}}
                                                </div>
                                                <div class="h-8px mx-3 w-100 bg-white bg-opacity-50 rounded">
                                                    <div class="bg-white rounded h-8px" role="progressbar"
                                                        style="width: 41%;" aria-valuenow="50" aria-valuemin="0"
                                                        aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <!--end::Progress-->
                                        </div>
                                        <!--end::Card body-->
                                    </div>
                                    <!--end::Card widget 20-->
                                </div>
                                <!--end::Col-->

                                <!--begin::Col-->
                                <div class="col-md-3">
                                    <!--begin::Card widget 20-->
                                    <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end"
                                        style="background-color: #f18241;background-image:url('assets/media/patterns/vector-1.png');">
                                        <!--begin::Header-->
                                        <div class="card-header pt-5">
                                            <!--begin::Title-->
                                            <div class="card-title d-flex flex-column">
                                                <!--begin::Amount-->
                                                <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">0</span>
                                                <!--end::Amount-->
                                                <!--begin::Subtitle-->
                                                <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Registros</span>
                                                <!--end::Subtitle-->
                                            </div>
                                            <!--end::Title-->
                                        </div>
                                        <!--end::Header-->
                                        <!--begin::Card body-->
                                        <div class="card-body d-flex align-items-end pt-0">
                                            <!--begin::Progress-->
                                            <div class="d-flex align-items-center flex-column mt-3 w-100">
                                                <div
                                                    class="d-flex justify-content-between fw-bold fs-6 text-white opacity-75 w-100 mt-auto mb-2">
                                                    {{-- <span>43 Pending</span>
                                                <span>72%</span> --}}
                                                </div>
                                                <div class="h-8px mx-3 w-100 bg-white bg-opacity-50 rounded">
                                                    <div class="bg-white rounded h-8px" role="progressbar"
                                                        style="width: 20%;" aria-valuenow="50" aria-valuemin="0"
                                                        aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <!--end::Progress-->
                                        </div>
                                        <!--end::Card body-->
                                    </div>
                                    <!--end::Card widget 20-->
                                </div>
                                <!--end::Col-->


                                <!--begin::Col-->
                                <div class="col-md-3">
                                    <!--begin::Card widget 20-->
                                    <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end"
                                        style="background-color: #3e7213;background-image:url('assets/media/patterns/vector-1.png');">
                                        <!--begin::Header-->
                                        <div class="card-header pt-5">
                                            <!--begin::Title-->
                                            <div class="card-title d-flex flex-column">
                                                <!--begin::Amount-->
                                                <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">0</span>
                                                <!--end::Amount-->
                                                <!--begin::Subtitle-->
                                                <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Registros</span>
                                                <!--end::Subtitle-->
                                            </div>
                                            <!--end::Title-->
                                        </div>
                                        <!--begin::Card body-->
                                        <div class="card-body d-flex align-items-end pt-0">
                                            <!--begin::Progress-->
                                            <div class="d-flex align-items-center flex-column mt-3 w-100">
                                                <div
                                                    class="d-flex justify-content-between fw-bold fs-6 text-white opacity-75 w-100 mt-auto mb-2">
                                                    {{-- <span>43 Pending</span>
                                                <span>72%</span> --}}
                                                </div>
                                                <div class="h-8px mx-3 w-100 bg-white bg-opacity-50 rounded">
                                                    <div class="bg-white rounded h-8px" role="progressbar"
                                                        style="width: 80%;" aria-valuenow="50" aria-valuemin="0"
                                                        aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <!--end::Progress-->
                                        </div>
                                        <!--end::Card body-->
                                    </div>
                                    <!--end::Card widget 20-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-bordered">
                                        <div class="card-body">
                                            <div id="kt_apexcharts_1" style="height: 350px;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Content container-->
                    </div>
                    <!--end::Content-->
                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
    {{-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> --}}
    <script>
        $(document).ready(function() {
            // // initChartsWidget4();

            // google.charts.load('current', {
            //     packages: ['corechart']
            // });
            // google.charts.setOnLoadCallback(dibujarGraficos);

            // $(window).resize(function() {
            //     // dibujarGraficos();
            // });


            var element = document.getElementById('kt_apexcharts_1');

            var height = parseInt(KTUtil.css(element, 'height'));
            var labelColor = '#ff8712';
            var borderColor = '#ab1542';
            var baseColor = '#ff6384';
            var secondaryColor = '#36a2eb';

            if (!element) {
                return;
            }

            var options = {
                series: @json($series),
                chart: {
                    fontFamily: 'inherit',
                    type: 'bar',
                    height: height,
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: ['30%'],
                        endingShape: 'rounded'
                    },
                },
                legend: {
                    show: false
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: ['Ene','Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic' ],
                    axisBorder: {
                        show: false,
                    },
                    axisTicks: {
                        show: false
                    },
                    labels: {
                        style: {
                            colors: labelColor,
                            fontSize: '12px'
                        }
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: labelColor,
                            fontSize: '12px'
                        }
                    }
                },
                fill: {
                    opacity: 1
                },
                states: {
                    normal: {
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    },
                    hover: {
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    },
                    active: {
                        allowMultipleDataPointsSelection: false,
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    }
                },
                tooltip: {
                    style: {
                        fontSize: '12px'
                    },
                    y: {
                        formatter: function (val) {
                            return val + ' Bs'
                        }
                    }
                },
                colors: [baseColor, secondaryColor],
                grid: {
                    borderColor: borderColor,
                    strokeDashArray: 4,
                    yaxis: {
                        lines: {
                            show: true
                        }
                    }
                }
            };

            var chart = new ApexCharts(element, options);
            chart.render();


        });

        // var initChartsWidget4 = function() {
        // function initChartsWidget4() {

        //     var element = document.getElementById("kt_charts_widget_2_chart");

        //     if (!element) {
        //         return;
        //     }

        //     var chart = {
        //         self: null,
        //         rendered: false
        //     };

        //     // Init chart
        //     initChart();

        //     // Update chart on theme mode change
        //     KTThemeMode.on("kt.thememode.change", function() {
        //         if (chart.rendered) {
        //             chart.self.destroy();
        //         }

        //         initChart();
        //     });

        // }

        // let chartLlamas1, chartLlamas2, chartllamas3;
    </script>
@endsection
