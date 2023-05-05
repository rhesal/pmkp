@extends('layouts.app')

@section('title', 'Home')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Homepage</h1>
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
                            <div class="table-responsive">
                                <table class="table-striped table" id="mytab1" width='100%' style='border-collapse: collapse;'>
                                <thead>
                                    <th>#</th>
                                    <th>Unit</th>
                                    <th>Nilai</th>
                                    <th>Progress</th>
                                </thead>
                                <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>10 Rata-Rata Tertinggi Pernilaian Mutu Per Unit</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="pieTertinggi"></canvas>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4>10 Rata-Rata Terendah Pernilaian Mutu Per Unit</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="pieTerendah"></canvas>
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
            console.log("TESS");

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

            $('#mytab1').DataTable({
                    processing: true,
                    serverSide: true,
                    bDestroy: true,
				    ordering: true,
                    ajax:{
                        type: "GET",
                        url: "{{route('unit.listHome')}}",
                        // data:{
                        //         data1: id,
                        //         data2: bln
                        //     },
                    },
                    deferRender: true,
				    aLengthMenu: [
                                    [15, 25, 50, 100],
                                    [15, 25, 50, 100]
				                ],
                    columns: [
                        { data: 'id',name: 'id',width: '10%', orderable: false, searchable: false, className: "text-center"},
                        // { data: 'unit',name: 'unit',width: '15%', className: "text-left"},
                        { render: function (data, type, row, meta) {
                                    var persen = 25;
                                    var html = '<a href="">'+row.unit+'</a>';
                                    return html;
                                }
                        },
                        { data: 'nilai',name: 'nilai', width: '15%', orderable: false, searchable: false, className: "text-center" },
                        { data: 'progess',name: 'progess', width: '20%', orderable: false, searchable: false, className: "text-center" },
                    ],
                    columnDefs: [
                                {
                                    targets: 0,
                                    render: function (data, type, row, meta) {
                                        return meta.row + meta.settings._iDisplayStart + 1;
                                    }
                                },
                                {
                                    targets: 2,
                                    render: function (data, type, row, meta) {
                                        return 0;
                                    }
                                },
                                {
                                    targets: 3,
                                    render: function (data, type, row, meta) {
                                        var persen = 25;
                                        var html = '<div class="progress" data-height="2" data-toggle="tooltip" title="70%">'+
                                                        '<div class="progress-bar bg-warning" role="progressbar" data-width="70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:'+persen+'%"></div>'+
                                                    '</div>';
                                        return html;
                                    }
                                },]
                });
        }

        function gettabel(){
                // var bln = $(this).val();
                // console.log(id);
                // alert("GETTABLE");
                // DataTable

            }
    </script>
    <!-- Page Specific JS File -->
@endpush
