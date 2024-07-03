<x-main-layout>
    @canView('company')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-7">
                            <div class="card-body">
                                <h5 class="card-title text-primary">{{__('page.congratulations')." ".auth()->user()->name}} ! 🎉</h5>
                                <p class="mb-4">
                                    {{__('page.you_are_login_as')}} <span class="fw-bold">supper admin</span>
                                </p>

                                <a href="javascript:;" class="btn btn-sm btn-outline-primary">View Badges</a>
                            </div>
                        </div>
                        <div class="col-sm-5 text-center text-sm-left">
                            <div class="card-body pb-0 px-0 px-md-4">
                                <img
                                    src="{{asset('assets/img/illustrations/man-with-laptop-light.png')}}"
                                    height="140"
                                    alt="View Badge User"
                                    data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                    data-app-light-img="illustrations/man-with-laptop-light.png"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-6 mb-4">
                <div class="card">
                    <div class="card-body" style="min-height: 180px">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0 mb-2">
                                <i style="font-size: 30px" class="bi bi-window"></i>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-2">{{__('page.companies')}}</span>
                        <h3 class="card-title mb-2">{{$total_company}}</h3>
                        {{--                                <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +72.80%</small>--}}
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-6 mb-4">
                <div class="card">
                    <div class="card-body" style="min-height: 180px">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0 mb-2">
                                <i style="font-size: 30px" class="bi bi-building-gear"></i>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-2">{{__('page.hotel')}}</span>
                        <h3 class="card-title text-nowrap mb-1">{{$total_hotel}}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-6 mb-4">
                <div class="card">
                    <div class="card-body" style="min-height: 180px">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0 mb-2">
                                <i style="font-size: 30px" class="bi bi-people"></i>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-2">{{__('page.guest')}}</span>
                        <h3 class="card-title text-nowrap mb-1">{{$total_guest}}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-6 mb-4">
                <div class="card">
                    <div class="card-body" style="min-height: 180px">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0 mb-2">
                                <i style="font-size: 30px" class="bi bi-list-check"></i>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-2">{{__('page.complete_orders')}}</span>
                        <h3 class="card-title text-nowrap mb-1">{{$total_complete_order}}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-6 mb-4">
                <div class="card">
                    <div class="card-body" style="min-height: 180px">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0 mb-2">
                                <i style="font-size: 30px" class="bi bi-list-stars"></i>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-2">{{__('page.today_orders')}}</span>
                        <h3 class="card-title text-nowrap mb-1">{{$total_today_order}}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-6 mb-4">
                <div class="card">
                    <div class="card-body" style="min-height: 180px">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0 mb-2">
                                <i style="font-size: 30px" class="bi bi-cart"></i>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-2">{{__('page.next_7_days_orders')}}</span>
                        <h3 class="card-title text-nowrap mb-1">{{$next7days_total_order}}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>

    @endCanView
</x-main-layout>

<script>
    const xValues = [];
    const dataSets = [];
    const color = ['red', 'green', 'blue', 'purple', 'pink', 'yellow', 'skyblue']
    @foreach($next7days_date as $date)
        xValues.push('{{$date}}');
    @endforeach
    @foreach($next7days_main_meal_system_data as $key => $meal_system_data)
    dataSets.push({
        label: '{{$meal_system_data->label}}',
        data: @php echo json_encode($meal_system_data->data) @endphp,
        borderColor: color[{{$key}}],
        fill: false,
        borderWidth: 2
    });
    @endforeach


    new Chart("myChart", {
        type: "line",
        data: {
            labels: xValues,
            datasets: dataSets
        },
        options: {
            title: {
                display: true,
                text: "{{__('page.this_week_meal_chart')}}"
            },
            legend: {
                display: true
            }
        }
    });





    {{--var densityCanvas = document.getElementById("myChart");--}}



    {{--Chart.defaults.global.defaultFontFamily = "Lato";--}}
    {{--Chart.defaults.global.defaultFontSize = 18;--}}

    {{--var datasetA = {--}}
    {{--    label: '{{__('admin::dashboard.breakfast')}}',--}}
    {{--    data: [1,2,3,4,5,6,7],--}}
    {{--    backgroundColor: '#36a2eb',--}}
    {{--    borderWidth: 0,--}}
    {{--    yAxisID: "y-axis-A"--}}
    {{--};--}}

    {{--var datasetB = {--}}
    {{--    label: '{{__('admin::dashboard.lunch')}}',--}}
    {{--    data: [8,9,10,11,12,13,14],--}}
    {{--    backgroundColor: '#9966ff',--}}
    {{--    borderWidth: 0,--}}
    {{--    yAxisID: "y-axis-B"--}}
    {{--};--}}

    {{--var datasetC = {--}}
    {{--    label: '{{__('admin::dashboard.lunch')}}',--}}
    {{--    data: [15,16,17,18,19, 10],--}}
    {{--    backgroundColor: '#ffcd56',--}}
    {{--    borderWidth: 0,--}}
    {{--    yAxisID: "y-axis-C"--}}
    {{--};--}}
    {{--var datasetD = {--}}
    {{--    label: '{{__('admin::dashboard.total_meal')}}',--}}
    {{--    data: [8,3,4,5,3,4,5],--}}
    {{--    backgroundColor: '#ff6384',--}}
    {{--    borderWidth: 0,--}}
    {{--    yAxisID: "y-axis-D"--}}
    {{--};--}}


    {{--var categoryData = {--}}
    {{--    labels:  [],--}}
    {{--    datasets: [datasetA, datasetB, datasetC, datasetD]--}}
    {{--};--}}

    {{--var chartOptions = {--}}
    {{--    scales: {--}}
    {{--        animations: {--}}
    {{--            tension: {--}}
    {{--                duration: 1000,--}}
    {{--                easing: 'linear',--}}
    {{--                from: 1,--}}
    {{--                to: 0,--}}
    {{--                loop: true--}}
    {{--            }--}}
    {{--        },--}}
    {{--        xAxes: [{--}}
    {{--            barPercentage: 1,--}}
    {{--            categoryPercentage: 0.6--}}
    {{--        }],--}}
    {{--        yAxes: [{--}}
    {{--            id: "y-axis-A",--}}
    {{--        }, {--}}
    {{--            id: "y-axis-B"--}}
    {{--        },--}}
    {{--            {--}}
    {{--                id: "y-axis-C"--}}
    {{--            },--}}
    {{--            {--}}
    {{--                id: "y-axis-D"--}}
    {{--            }--}}
    {{--        ]--}}
    {{--    }--}}
    {{--};--}}

    {{--var barChart = new Chart(densityCanvas, {--}}
    {{--    type: 'bar',--}}
    {{--    data: categoryData,--}}
    {{--    options: chartOptions--}}
    {{--});--}}
</script>

