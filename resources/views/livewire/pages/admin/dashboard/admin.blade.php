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
                $recipes = app('\App\Http\Controllers\DashboardController')->getstatus();

            @endphp
            <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-primary card-img-holder text-white text-center">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center"
                        style="height: 200px; position: relative;">
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
                    <div class="card-body d-flex flex-column justify-content-center align-items-center"
                        style="height: 200px; position: relative;">
                        <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />

                        <h2 class="mb-2 card-text" style="font-size: 35px;">{{ $recipes['category_recipes'] }}</h2>
                        <h6 class="card-text">Category Recipes</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-success card-img-holder text-white text-center">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center"
                        style="height: 200px; position:relative">
                        <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />

                        <h2 class="mb-2 card-text" style="font-size: 35px;">{{ $recipes['accepted_recipes'] }}</h2>
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
                        <div class="clearfix">
                            <h4 class="card-title float-start">Recipes Uploaded by Users</h4>
                            <div class="chart-controls mb-3 justify-end flex mx-4">
                                <button class="btn btn-sm btn-outline-primary chart-period active m-1" data-type="day">7
                                    Days</button>
                                <button class="btn btn-sm btn-outline-primary chart-period m-1" data-type="week">4
                                    Weeks</button>
                                <button class="btn btn-sm btn-outline-primary chart-period m-1" data-type="month">12
                                    Months</button>
                            </div>
                            <div class="chart-container" style="position: relative; height:500px; width:100%">
                                <canvas id="recipeChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
<script>
    let recipeChart = null;

    document.addEventListener('DOMContentLoaded', function() {
        loadChartData('day');
        document.querySelectorAll('.chart-period').forEach(button => {
            button.addEventListener('click', function() {

                document.querySelectorAll('.chart-period').forEach(btn => {
                    btn.classList.remove('active');
                });
                this.classList.add('active');
                const type = this.dataset.type;
                loadChartData(type);
            });
        });
    });

    function initChart(labels, data) {
        const ctx = document.getElementById('recipeChart').getContext('2d');

        if (recipeChart) {
            recipeChart.destroy();
        }

        recipeChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Number of Recipes',
                    data: data,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2,
                    tension: 0.1,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            
                            callback: function(value) {
                                if (Number.isInteger(value)) {
                                    return value;
                                }
                            },
                            stepSize: 1
                        },
                        title: {
                            display: true,
                            text: 'Number of Recipes'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.parsed.y} recipes on ${context.label}`;
                            }
                        }
                    }
                }
            }
        });
    }

    function loadChartData(type) {
        fetch(`/get-chart-data/${type}`)
            .then(response => response.json())
            .then(apiData => {
                const labels = apiData.map(item => item.date);
                const data = apiData.map(item => item.value);
                initChart(labels, data);
            })
            .catch(error => {
                console.error('Error loading chart data:', error);
            });
    }
</script>
