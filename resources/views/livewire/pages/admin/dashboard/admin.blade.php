@extends('livewire.pages.components.main')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-home"></i>
                </span> Dashboard
            </h3>
            {{-- <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">
                        <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                    </li>
                </ul>
            </nav> --}}
        </div>
        <div class="row">
            @php
                $recipes =app('\App\Http\Controllers\DashboardController')->getstatus();

            @endphp
            <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-primary card-img-holder text-white text-center">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center" style="height: 200px; position: relative;">
                        {{-- <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" /> --}}
                        <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                        {{-- <h4 class="font-weight-normal mb-3">Weekly Sales <i --}}
                                {{-- class="mdi mdi-chart-line mdi-24px float-end"></i>
                        </h4> --}}
                        <h2 class="mb-2 card-text" style="font-size: 35px;">{{ $recipes['total_recipes'] }}</h2>
                        <h6 class="card-text ">All Recipes</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-info card-img-holder text-white text-center">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center" style="height: 200px; position: relative;">
                        {{-- <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" /> --}}
                        <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                        {{-- <h4 class="font-weight-normal mb-3">Weekly Orders <i --}}
                                {{-- class="mdi mdi-bookmark-outline mdi-24px float-end"></i>
                        </h4> --}}
                        <h2 class="mb-2 card-text" style="font-size: 35px;">{{  $recipes['category_recipes'] }}</h2>
                        <h6 class="card-text">Category Recipes</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-success card-img-holder text-white text-center">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center" style="height: 200px; position:relative">
                        <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                        {{-- <h4 class="font-weight-normal mb-3">Visitors Online <i
                                class="mdi mdi-diamond mdi-24px float-end"></i>
                        </h4> --}}
                        <h2 class="mb-2 card-text" style="font-size: 35px;">{{  $recipes['accepted_recipes'] }}</h2>
                        <h6 class="card-text">Accepted Recipes</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card ">
                <div class="card">
                    <div class="card-body ">
                        {{-- dropdown  --}}
                        <div class="d-flex justify-content-end mb-2">
                             <div class="btn-group" role="group" aria-label="Filter">
                                <button type="button" class="btn btn-outline-primary" onclick="updateChart('day')">Day</button>
                                <button type="button" class="btn btn-outline-primary" onclick="updateChart('week')">Week</button>
                                <button type="button" class="btn btn-outline-primary" onclick="updateChart('month')">Month</button>
                            </div>
                        </div>
{{-- <canvas id="recipeChart" height="100"></canvas> --}}
                        <div class="clearfix">
                            <h4 class="card-title float-start">Recipes Uploaded by Users</h4>
                            <div id="chartdiv" style="width: 100%; height: 500px;" class="mb-2">
                        </div>

                        </div>

                        {{-- <canvas id="chartdiv" class="mt-4 mb-3"> </canvas> --}}


<!-- Chart amCharts -->
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>

<script>
    let chart, series, root;

    am5.ready(function () {
        root = am5.Root.new("chartdiv");

        root.setThemes([
            am5themes_Animated.new(root)
        ]);

        chart = root.container.children.push(am5xy.XYChart.new(root, {
            panX: true,
            panY: true,
            wheelX: "none",
            wheelY: "none",
            pinchZoomX: true
        }));

        let xAxis = chart.xAxes.push(am5xy.DateAxis.new(root, {
            baseInterval: { timeUnit: "day", count: 1 },
            renderer: am5xy.AxisRendererX.new(root, {}),
            tooltip: am5.Tooltip.new(root, {})
        }));

        let yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
            renderer: am5xy.AxisRendererY.new(root, {})
        }));

        series = chart.series.push(am5xy.LineSeries.new(root, {
            name: "Recipes",
            xAxis: xAxis,
            yAxis: yAxis,
            valueYField: "value",
            valueXField: "date",
            tooltip: am5.Tooltip.new(root, {
                labelText: "{valueY}"
            })
        }));

        series.data.processor = am5.DataProcessor.new(root, {
            dateFormat: "yyyy-MM-dd",
            dateFields: ["date"]
        });


        updateChart('day');

        chart.set("cursor", am5xy.XYCursor.new(root, {
            xAxis: xAxis
        }));

        chart.appear(1000, 100);
    });

function updateChart(type) {
    fetch(/dashboard/chart-data/${type})
        .then(response => response.json())
        .then(data => {

            series.data.setAll(data);
        })
        .catch(error => {
            console.error('Error fetching chart data:', error);
        });
}

</script>





                    </div>
                </div>
            </div>
            {{-- <div class="col-md-5 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Traffic Sources</h4>
                        <div class="doughnutjs-wrapper d-flex justify-content-center">
                            <canvas id="traffic-chart"></canvas>
                        </div>
                        <div id="traffic-chart-legend" class="rounded-legend legend-vertical legend-bottom-left pt-4"></div>
                    </div>
                </div>
            </div> --}}
        </div>
        {{-- <div class="row">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Recent Tickets</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th> Assignee </th>
                                        <th> Subject </th>
                                        <th> Status </th>
                                        <th> Last Update </th>
                                        <th> Tracking ID </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <img src="assets/images/faces/face1.jpg" class="me-2" alt="image"> David
                                            Grey
                                        </td>
                                        <td> Fund is not recieved </td>
                                        <td>
                                            <label class="badge badge-gradient-success">DONE</label>
                                        </td>
                                        <td> Dec 5, 2017 </td>
                                        <td> WD-12345 </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <img src="assets/images/faces/face2.jpg" class="me-2" alt="image"> Stella
                                            Johnson
                                        </td>
                                        <td> High loading time </td>
                                        <td>
                                            <label class="badge badge-gradient-warning">PROGRESS</label>
                                        </td>
                                        <td> Dec 12, 2017 </td>
                                        <td> WD-12346 </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <img src="assets/images/faces/face3.jpg" class="me-2" alt="image"> Marina
                                            Michel
                                        </td>
                                        <td> Website down for one week </td>
                                        <td>
                                            <label class="badge badge-gradient-info">ON HOLD</label>
                                        </td>
                                        <td> Dec 16, 2017 </td>
                                        <td> WD-12347 </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <img src="assets/images/faces/face4.jpg" class="me-2" alt="image"> John Doe
                                        </td>
                                        <td> Loosing control on server </td>
                                        <td>
                                            <label class="badge badge-gradient-danger">REJECTED</label>
                                        </td>
                                        <td> Dec 3, 2017 </td>
                                        <td> WD-12348 </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
@endsection


{{-- @section('scripts') --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let chart;

    const chartData = {
        day: {
            labels: ['01 Jun', '02 Jun', '03 Jun', '04 Jun', '05 Jun', '06 Jun', '07 Jun'],
            datasets: [
                {
                    label: 'Social',
                    data: [50, 60, 70, 80, 60, 90, 100],
                    borderColor: '#6C63FF',
                    backgroundColor: 'rgba(108, 99, 255, 0.2)',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Email',
                    data: [40, 80, 100, 90, 120, 150, 160],
                    borderColor: '#00C292',
                    backgroundColor: 'rgba(0, 194, 146, 0.2)',
                    tension: 0.4,
                    fill: true
                }
            ]
        },
        week: {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            datasets: [
                {
                    label: 'Social',
                    data: [200, 300, 400, 500],
                    borderColor: '#6C63FF',
                    backgroundColor: 'rgba(108, 99, 255, 0.2)',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Email',
                    data: [180, 250, 380, 450],
                    borderColor: '#00C292',
                    backgroundColor: 'rgba(0, 194, 146, 0.2)',
                    tension: 0.4,
                    fill: true
                }
            ]
        },
        month: {
            labels: ['03 Jan', '10 Jan', '17 Jan', '24 Jan', '31 Jan'],
            datasets: [
                {
                    label: 'Social',
                    data: [0, 150, 250, 300, 450],
                    borderColor: '#6C63FF',
                    backgroundColor: 'rgba(108, 99, 255, 0.2)',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Email',
                    data: [200, 180, 350, 400, 600],
                    borderColor: '#00C292',
                    backgroundColor: 'rgba(0, 194, 146, 0.2)',
                    tension: 0.4,
                    fill: true
                }
            ]
        }
    };

    function renderChart(type = 'month') {
        const ctx = document.getElementById('visit-sale-chart').getContext('2d');

        if (chart) {
            chart.destroy();
        }

        chart = new Chart(ctx, {
            type: 'line', // ini sudah benar untuk grafik garis
            data: {
                labels: chartData[type].labels,
                datasets: chartData[type].datasets
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                        }
                    },
                    title: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    function updateChart(type) {
        renderChart(type);
        document.querySelectorAll('.btn-group .btn').forEach(btn => btn.classList.remove('active'));
        // Perbaikan di sini pakai backtick dan selector string
        document.querySelector(.btn-group .btn[onclick="updateChart('${type}')"]).classList.add('active');
    }

    document.addEventListener("DOMContentLoaded", () => {
        renderChart('month');
    });
</script> --}}
{{-- @endsection --}}



<!-- Chart amCharts -->
{{-- <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>

<script>
am5.ready(function () {
    var root = am5.Root.new("chartdiv");

    root.setThemes([
        am5themes_Animated.new(root)
    ]);

    var chart = root.container.children.push(am5xy.XYChart.new(root, {
        panX: true,
        panY: true,
        wheelX: "panX",
        wheelY: "zoomX",
        pinchZoomX: true
    }));

    var xAxis = chart.xAxes.push(am5xy.DateAxis.new(root, {
        baseInterval: { timeUnit: "day", count: 1 },
        renderer: am5xy.AxisRendererX.new(root, {}),
        tooltip: am5.Tooltip.new(root, {})
    }));

    var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
        renderer: am5xy.AxisRendererY.new(root, {})
    }));

    var series = chart.series.push(am5xy.LineSeries.new(root, {
        name: "Recipes",
        xAxis: xAxis,
        yAxis: yAxis,
        valueYField: "value",
        valueXField: "date",
        tooltip: am5.Tooltip.new(root, {
            labelText: "{valueY}"
        })
    }));

    series.data.processor = am5.DataProcessor.new(root, {
        dateFormat: "yyyy-MM-dd",
        dateFields: ["date"]
    });

    series.data.setAll([
        { date: "2025-06-01", value: 5 },
        { date: "2025-06-02", value: 8 },
        { date: "2025-06-03", value: 4 },
        { date: "2025-06-04", value: 10 },
        { date: "2025-06-05", value: 6 },
    ]);

    chart.set("cursor", am5xy.XYCursor.new(root, {
        xAxis: xAxis
    }));

    chart.appear(1000, 100);
});
</script> --}}
