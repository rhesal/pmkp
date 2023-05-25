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
                    <div class="card-icon bg-dash-1">
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
                    <div class="card-icon bg-dash-2">
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
                    <div class="card-icon bg-dash-3">
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
                            <div class="">
                                <input type="month" class="form-control col-md-3" id="sel-bln" name="sel-bln">
                            </div>
                            <div class="card-body">
                                <canvas id="myChart" height="200"></canvas>
                            </div>
                        </div>
                </div>
                <div class="col-4">
                    <div class="">
                        <div class="card">
                            <div class="card-body">
                                <canvas id="myChart2" height="170"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div class="card" hidden>
                            <div class="card-body">
                            </div>
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
            const date = new Date();
            let day = date.getDate();
            let month = ("0" + (date.getMonth() + 1)).slice(-2);
            let year = date.getFullYear();
            let currentDate = `${year}-${month}`;
            $('#sel-bln').val(currentDate)
            nilai();
            getchart();
            getchart2();
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
            const judul = [
                'Kepatuhan Kebersihan Tangan',
                'Kepatuhan Penggunaan APD',
                'Kepatuhan Identifikasi Pasien',
                'Waktu Tanggap Seksio Sesarea Emergensi',
                'Waktu Tunggu Rawat Jalan',
                'Penundaan Operasi Elektif',
                'Kepatuhan Waktu Visite Dokter',
                'Pelaporan Hasil Kritis Laboratorium',
                'Kepatuhan Penggunaan Formularium Nasional/Formularium RS',
                'Kepatuhan Terhadap Clinical Pathway',
                'Kepatuhan Upaya Pencegahan Risiko Pasien Jatuh',
                'Kecepatan Respon Terhadap Komplain',
                'Kepuasan Pasien'
            ]
            const labels = ['1','2','3','4','5','6','7','8','9','10','11','12','13'];
            const data = {
                labels: labels,
                datasets: [
                    {
                        label: 'Nilai Standar',
                        backgroundColor: 'rgb(255, 50, 50, 1)',
                        borderColor: 'rgb(2255, 50, 50)',
                        borderWidth: 1,
                        barThickness: 18,
                        data: [85, 100, 100, 80, 80, 5, 80, 100, 80, 80, 100, 80, 76],
                    },
                    {
                        label: 'Hasil',
                        backgroundColor: 'rgb(54, 162, 235, 1)',
                        borderColor: 'rgb(54, 162, 235)',
                        borderWidth: 1,
                        barThickness: 18,
                        data: [90, 100, 80, 90, 80, 3, 80, 97, 85, 93, 99, 75, 80],
                    },
                ]
            };

            const config = {
                type: 'bar',
                data: data,
                options: {
                    indexAxis: 'x',
                    responsive: true,
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Capaian Indikator Nasional Mutu'
                        },
                        tooltip: {
                            callbacks: {
                                title: function(context) {
                                    return `${context[0].label} : ${judul[context[0].dataIndex]}`;
                                }
                            }
                        }
                    }
                },
            };

            new Chart(
                document.getElementById('myChart'),
                config
            );
        }

        function getchart2(){
            const labels = ['IGD','Rawat Jalan','Amarilis','Perinatologi','Laboratorium'];
            const data = {
                labels: labels,
                datasets: [
                    {
                        label: 'Nilai Capaian',
                        backgroundColor: [
                            'rgb(255, 50, 50, 0.8)',
                            'rgb(155, 50, 100, 0.8)',
                            'rgb(100, 255, 100, 0.8)',
                            'rgb(255, 50, 255, 0.8)',
                            'rgb(40, 50, 225, 0.8)'],
                        borderWidth: 1,
                        barThickness: 18,
                        data: [85, 100, 100, 80, 80],
                    },
                ]
            };

            const config = {
                type: 'polarArea',
                data: data,
                options: {
                    indexAxis: 'x',
                    responsive: true,
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: '5 Rata-Rata Tertinggi Indikator Mutu'
                        },
                        tooltip: {
                            callbacks: {
                                title: function(context) {
                                    return `${context[0].label}`;
                                }
                            }
                        }
                    }
                },
            };

            new Chart(
                document.getElementById('myChart2'),
                config
            );
        }
    </script>
    <!-- Page Specific JS File -->
@endpush
