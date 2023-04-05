@extends('layouts.app')

@section('title', 'Indikator RS')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Daftar Indikator <br> RSUD Karsa Husada Batu</h1>
                <div class="section-header-button">
                    <a href="" data-toggle="modal" data-target="#ModalCreateIndikator" class="btn btn-primary"
                        onclick="create()">{{ __('Add New') }}</a>
                </div>
            </div>
            @if (Session::has('status'))
                <div class="alert alert-success text-center" role="alert">
                    {{ Session::get('message') }}
                </div>
            @endif

            <div class="section-body">
                <h2 class="section-title">List Indikator</h2>
                <p class="section-lead">
                    You can manage all indikator, such as editing, deleting and more.
                </p>
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Indikator</h4>
                                <select name="sel-unit" id="sel-unit">
                                @foreach ($unitList as $item)
                                    <option value="{{ $item->id }}">{{ $item->unit }}</option>
                                @endforeach
                                </select>
                            </div>
                            <div class="card-body">
                                <div class="float-right">
                                    <form method="GET">
                                        <div class="input-group">
                                            <input name="search" type="text" class="form-control" placeholder="Search">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="clearfix mb-3"></div>

                                <div class="table-responsive">
                                    <table class="table table-striped" id="tabIndikator">
                                        <thead>
                                            <th>No</th>
                                            <th>Indikator</th>
                                            <th>Jenis Indikator</th>
                                            <th>Nilai Standar</th>
                                            <th>Satuan Pengukuran</th>
                                            <th>Status</th>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                                <div class="float-right">
                                    <nav>
                                        <ul class="pagination">
                                            {{ $indikatorList->withQueryString()->links() }}
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @include('modal.create-indikator')
    @include('modal.create-pengisian-mutu')
@endsection
@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/cleave.js/dist/cleave.min.js') }}"></script>
    <script src="{{ asset('library/cleave.js/dist/addons/cleave-phone.us.js') }}"></script>
    <script src="{{ asset('library/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('library/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script>
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('body').on('change', '#sel-unit', function() {
                var id = $(this).val();
                console.log(id);

                $.ajax({
                    url: 'indikatorbyunit/'+id,
                    type: 'GET',
                    dataType: 'JSON',
                    success: function(data){
                        console.log(data);
                        var table = document.getElementById("tabIndikator");
                        var html1 = "";
                        for (let i = 0; i < data.length; i++) {
                            html1 += `<tr>
                                        <td>${i+1}</td>
                                        <td>${data[i].indikator}
                                            <div class="table-links">
                                                <a href="javascript:void(0)" id="show-unit"
                                                            data-url1="indikator-show/${data[i].id}"
                                                            data-url2="penilaian-show/${data[i].id}"
                                                            data-toggle="modal" data-target="#ModalCreatePengisian"
                                                            data-backdrop="static">Penilaian</a>
                                                <div class="bullet"></div>
                                                <a href="${data[i].id}">Edit</a>
                                                <div class="bullet"></div>
                                                <a href="#" type="button" class="text-danger">Delete</a>
                                            </div>
                                        </td>
                                        <td>${data[i].jenis_indikator}</td>
                                        <td>${data[i].nilai_standar}</td>
                                        <td>${data[i].satuan_pengukuran}</td>
                                        <td>${data[i].status}</td>
                                    </tr>`;
                        }
                        table.getElementsByTagName('tbody')[0].innerHTML = html1;
                    }
                });

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            });

            $('body').on('click', '#show-unit', function() {
                var unitURL = $(this).data('url1');
                //var penilaianURL = $(this).data('url2');

                console.log(unitURL);
                //console.log(penilaianURL);
                $.get(unitURL, function(data) {
                    $('#ModalCreatePengisian').modal('show');
                    $('#unit-name').text(data.unit.unit)
                    $('#unit-indikator').text(data.indikator)
                    $('#jenis-indikator').text(data.jenis_indikator)
                    $('#nilai-standar').text(data.nilai_standar)
                    $('#satuan-pengukuran').text(data.satuan_pengukuran)
                    $('#penanggung-jawab').text(data.penanggung_jawab)
                    $('#numerator').text(data.numerator)
                    $('#denumerator').text(data.denumerator)

                    document.getElementById('indikator-id').value = data.id
                })

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            });

            $('body').on('change', '#sel-bln', function() {
                var bln = $(this).val();
                var id = document.getElementById('indikator-id').value;
                console.log(bln);
                console.log('penilaian-show/' + document.getElementById('indikator-id').value);

                $.ajax({
                    type: "GET",
                    url: 'penilaian-show/',
                    data:{
                            data1: id,
                            data2: bln
                        },
                    dataType: "JSON",
                    success: function(data) {
                        var table = document.getElementById("mytab1");
                        var html1 = "";
                        for (let i = 0; i < data.length; i++) {
                            html1 += `<tr>
                                        <td>${data[i].tanggal}</td>
                                        <td>${data[i].numerator}</td>
                                        <td>${data[i].denumerator}</td>
                                        <td>${data[i].hasil}</td>
                                        <td>-</td>
                                        <td>
                                            <div class="form-group">
                                                <a href="" type="button" class="btn btn-info fa fa-pen"></a>
                                                <a href="" type="button" class="btn btn-danger fa fa-trash"></a>
                                            </div>
                                        </td>
                                    </tr>`;
                        }
                        table.getElementsByTagName('tbody')[0].innerHTML = html1;
                    }
                });

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

            });
        });

        function percentage() {
            var txtNumValue = document.getElementById('num').value;
            var txtDenumValue = document.getElementById('denum').value;
            var result = (parseInt(txtNumValue) / parseInt(txtDenumValue)) * 100 / 100;
            if (!isNaN(result)) {
                document.getElementById('hasil').value = result.toFixed(2) + "%";
            }
        }
    </script>
@endpush
