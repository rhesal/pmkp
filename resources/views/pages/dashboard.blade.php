@extends('layouts.app')

@section('title', 'Dashboard')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="far fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Unit</h4>
                        </div>
                        <div class="card-body" id="totalUnit">
                            <span id="unit"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="far fa-newspaper"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Indikator</h4>
                        </div>
                        <div class="card-body">
                            <span id="indikator"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="far fa-file"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Sensus Penilaian</h4>
                        </div>
                        <div class="card-body">
                            <span id="reports"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-8">
                        <div class="card">
                            <div class="card-body">
                                <canvas id="myChart" height="75"></canvas>
                            </div>
                        </div>
                </div>
                <div class="col-4">
                        <div class="card">
                            <div class="card-body">

                            </div>
                        </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
          // Make an AJAX request to your server
            nilai();
            gettabel();
        });

        function nilai(){
            $.ajax({
            url: "/homes", // Replace with your data URL
            type: "GET",
            dataType: "json",
            success: function(data) {
                console.log(data);
                $('#unit').html(data.unit)
                $('#indikator').html(data.indikator)
                $('#reports').html(data.sensus)
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // Handle error response from server
            }
            });
        }

        function getchart(){
            const DATA_COUNT = 13;
            const NUMBER_CFG = {count: DATA_COUNT, min: 0, max: 100};

            const labels = {1,2,3,4,5,6,7,8,9,10,11,12,13};
            const data = {
            labels: labels,
            datasets: [
                {
                label: 'Nilai Standar',
                data: Utils.numbers(NUMBER_CFG),
                borderColor: Utils.CHART_COLORS.red,
                backgroundColor: Utils.transparentize(Utils.CHART_COLORS.red, 0.5),
                },
                {
                label: 'hasil',
                data: Utils.numbers(NUMBER_CFG),
                borderColor: Utils.CHART_COLORS.blue,
                backgroundColor: Utils.transparentize(Utils.CHART_COLORS.blue, 0.5),
                }
            ]
            };

            const actions = [
            {
                name: 'Randomize',
                handler(chart) {
                chart.data.datasets.forEach(dataset => {
                    dataset.data = Utils.numbers({count: chart.data.labels.length, min: 0, max: 100});
                });
                chart.update();
                }
            }];

            const config = {
                type: 'bar',
                data: data,
                options: {
                    responsive: true,
                    plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Capaian Indikator Nasional Mutu'
                    }
                    }
                },
            };
        }
    </script>
    <!-- Page Specific JS File -->
@endpush
