@extends('layouts.app')

@section('title', 'Indikator RS')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet"
        href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Daftar Indikator <br> RSUD Karsa Husada Batu</h1>
            <div class="section-header-button">
                <a href="" data-toggle="modal" data-target="#ModalCreateIndikator"
                    class="btn btn-primary" onclick="create()" >{{ __('Add New') }}</a>
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
                        <h4>All Indikator</h4>
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
                            <table class="table table-striped">
                                <tr>
                                    <th>No</th>
                                    <th>Unit</th>
                                    <th>Indikator</th>
                                    <th>Jenis Indikator</th>
                                    <th>Nilai Standar</th>
                                    <th>Satuan Pengukuran</th>
                                    <th>Status</th>
                                </tr>
                                @forelse ($indikatorList as $index => $data)
                                    <tr class="text-center">
                                        <td>{{ $index + $indikatorList -> firstItem() }}</td>
                                        {{-- <td>{{ $loop->iteration }}</td> --}}
                                        <td class="col-1">{{ $data->unit->unit }}</td>
                                        <td class="col-5 text-left">{{ $data->indikator }}
                                            <div class="table-links">
                                                <a href="javascript:void(0)" id="show-unit" data-url="{{ route('indikator.show', $data->id) }}" data-toggle="modal" data-target="#ModalCreatePengisian" data-backdrop="static">View</a>
                                                {{-- <a href="javascript:void(0)" id="show-unit" onclick="fung_data({{ $data->id }})" data-toggle="modal" data-target="#ModalCreatePengisian">View</a> --}}
                                                <div class="bullet"></div>
                                                <a href="#">Edit</a>
                                                <div class="bullet"></div>
                                                <a href="/indikator-destroy/{{ $data->id }}" type="button" class="text-danger">Delete</a>
                                            </div>
                                        </td>
                                        <td>{{ $data->jenis_indikator }}</td>                               
                                        <td>{{ $data->nilai_standar }}</td>
                                        <td>
                                            @if ($data->satuan_pengukuran == "%")
                                                Persentase (%)
                                            @else
                                                <span class="text-capitalize">{{ $data->satuan_pengukuran }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($data->status == "Active")
                                                <div class="badge badge-success">Active</div>
                                            @else
                                                <div class="badge badge-warning">Non Active</div>
                                            @endif
                                        </td>    
                                    </tr>    
                                @empty
                                    <tr>
                                        <td colspan="7" class="bg-danger text-center text-white">No Data Found</td>
                                    </tr>       
                                @endforelse
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
    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function (){
            $('body').on('click','#show-unit', function () {
                var unitURL = $(this).data('url');
                console.log(unitURL);
                $.get(unitURL, function (data) {
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
            });
        });

        // function fung_data(id){
        //     $('#unit-id').text(id)
        // }

        // var num = document.penilaian.numerator.value;
        // document.Penilaian.hasil.value = num;

        // var denum = document.penilaian.denumerator.value;
        // document.penilaian.hasil.value = denum;
        // function OnChange(value){
        //     var num = parseFloat(document.penilaian.numerator.value);
        //     var denum = parseFloat(document.penilaian.denumerator.value);

        //     var total = (num / denum) * (100) ;
        //     console.log(parseFloat(total).toFixed(2) + "%");
        //     return document.penilaian.hasil.value = parseFloat(total).toFixed(2) + "%";
        // }

        function percentage(){
            var txtNumValue = document.getElementById('num').value;
            var txtDenumValue = document.getElementById('denum').value;
            var result = (parseInt(txtNumValue) / parseInt(txtDenumValue)) * 100/100;
            if(!isNaN(result)){
                document.getElementById('hasil').value = result.toFixed(2) + "%";
            }
        }
    </script>
@endpush
