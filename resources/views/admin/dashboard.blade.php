@extends('layouts.admin')
@section('style')
    <style>
        .icon-dashboard {
            font-size: 60px;
        }
    </style>
@endsection
@section('admin')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Dashboard</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row dash">
            <!-- Column -->
            <div class="col-lg-12">
                <div class="row">
                    <!-- column 1 start -->
                    <div class="col-lg-3">
                        <div class="card card-chart">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="icon">
                                        <i class="icon-location-pin icon-dashboard"></i>
                                    </div>
                                    <div class="txt ml-3">
                                        <h2 class="mb-1 font-medium"> {{ $numberDestinations }} </h2>
                                        <h4 class="mb-0 font-medium"> Điểm đến </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- column 1 end -->

                    <!-- column 2 start -->
                    <div class="col-lg-3">
                        <div class="card card-chart">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="icon">
                                        <i class="icon-tag icon-dashboard"></i>
                                    </div>
                                    <div class="txt ml-3">
                                        <h2 class="mb-1 font-medium"> {{ $numberTypes }} </h2>
                                        <h4 class="mb-0 font-medium"> Thể loại </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- column 2 end -->
                    <!-- column 3 start -->
                    <div class="col-lg-3">
                        <div class="card card-chart">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="icon">
                                        <i class="icon-bag icon-dashboard"></i>
                                    </div>
                                    <div class="txt ml-3">
                                        <h2 class="mb-1 font-medium"> {{ $numberTours }} </h2>
                                        <h4 class="mb-0 font-medium"> Tours </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- column 3 end -->

                    <!-- column 4 start -->
                    <div class="col-lg-3">
                        <div class="card card-chart">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="icon">
                                        <i class="icon-calender icon-dashboard"></i>
                                    </div>
                                    <div class="txt ml-3">
                                        <h2 class="mb-1 font-medium"> {{ $numberBookings }} </h2>
                                        <h4 class="mb-0 font-medium"> Đặt tour </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- column 4 end -->

                </div>

            </div>

        </div>

        {{-- Booking chart --}}
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body analytics-info">
                        <h4 class="card-title"> Số lượng đặt tours </h4>
                        <div class="row">
                            <div class="col-md-10">
                                <div class='input-group mb-3'>
                                    <input type='text' id="bookingChartDate" class="form-control daterange"/>
                                    <div class="input-group-append">
                                    <span class="input-group-text">
                                        <span class="ti-calendar"></span>
                                    </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class='input-group mb-3'>
                                    <select name="bookingChart" id="optionBookingChart" class="form-control">
                                        <option value="line">Line</option>
                                        <option value="bar">Bar</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div id="bookingArea" style="height:400px;"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('js')
    {{--    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>--}}
    {{--    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>--}}
    {{--    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>--}}
    <script src="{{ asset('admins/assets/libs/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('admins/assets/libs/daterangepicker/daterangepicker.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('admins/assets/libs/daterangepicker/daterangepicker.css') }}">
    <script src="{{ asset('admins/assets/libs/echarts/dist/echarts-en.min.js') }}"></script>
    <script>
        function initChart(idRangeDate, ajaxGetData) {
            let start = moment().subtract(29, 'days');
            let end = moment();
            let today = new Date();
            ajaxGetData(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
            $(idRangeDate).daterangepicker({
                startDate: start,
                endDate: end,
                maxDate: today,
                locale: {
                    format: 'DD/MM/YYYY'
                },
                ranges: {
                    '7 ngày': [moment().subtract(6, 'days'), moment()],
                    'Tháng này': [moment().startOf('month'), moment().endOf('month')],
                    'Tháng trước': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                }
            }, function (start, end) {
                ajaxGetData(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
            });
        }

        function getOptions(color, xAxis, legend, data, typeChart) {
            let seriesData = [];
            let boundaryGap = false;
            if (typeChart === 'bar') {
                boundaryGap = true;
            }

            legend.forEach(function (value, i) {
                seriesData.push({
                    name: value,
                    type: typeChart,
                    areaStyle: {},
                    data: data[i],
                    markPoint: {
                        data: [
                            {type: 'max', name: 'Max'},
                            {type: 'min', name: 'Min'}
                        ]
                    },
                    lineStyle: {
                        normal: {
                            width: 3,
                            shadowColor: 'rgba(0,0,0,0.1)',
                            shadowBlur: 10,
                            shadowOffsetY: 10
                        }
                    },
                });
            });

            return {
                // Setup grid
                grid: {
                    left: '1%',
                    right: '2%',
                    bottom: '3%',
                    containLabel: true
                },

                // Add Tooltip
                tooltip: {
                    trigger: 'axis'
                },

                // Add Legend
                legend: {
                    data: legend
                },

                // Add custom colors
                color: color,

                // Enable drag recalculate
                calculable: true,

                // Horizontal Axiz
                xAxis: [
                    {
                        type: 'category',
                        boundaryGap: boundaryGap,
                        data: xAxis
                    }
                ],

                // Vertical Axis
                yAxis: [
                    {
                        type: 'value',
                        axisLabel: {
                            formatter: '{value}'
                        }
                    }
                ],

                // Add Series
                series: seriesData,
            };
        }

        function formatDateChart(date) {
            return date.map(function (item) {
                let current = new Date(item);
                let month = (current.getMonth() + 1).toString().padStart(2, '0');
                let day = current.getDate().toString().padStart(2, '0');

                return month + '-' + day;
            });
        }

        // Chart revenue booking
        let dataBooking = null;

        function getDataBooking(startDate, endDate) {
            $.ajax({
                type: "GET",
                url: `{{ route('bookings.chart') }}`,
                data: {
                    startDate: startDate,
                    endDate: endDate
                },
                success: function (response) {
                    dataBooking = response;
                    bookingChart(response);
                }
            });
        }

        function bookingChart(response) {
            let bookingMarket = response.booking_market
            let responseDate = bookingMarket.date;
            let success = bookingMarket.success;
            let reject = bookingMarket.reject;
            let other = bookingMarket.other;
            let typeChart = $('#optionBookingChart').val();
            let chartBooking = echarts.init(document.getElementById('bookingArea'));
            let date = formatDateChart(responseDate);

            let color = ['#ABC4A0', '#DD9A9A', '#A4E0F7'];
            let legend = [
                'Hoàn thành',
                'Hủy',
                'Chưa hoàn thành',
            ];
            let dataChart = [
                success,
                reject,
                other
            ];
            chartBooking.setOption(getOptions(color, date, legend, dataChart, typeChart));
        }

        // Init chart
        $(function () {
            initChart('#bookingChartDate', getDataBooking)
        });

        $('#optionBookingChart').on('change', function () {
            bookingChart(dataBooking);
        })
    </script>
@endsection
