@extends('layouts.app')

@section('title', 'Penilaian Mutu')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Rekapitulasi Penilaian Mutu</h1>
        </div>
        @if (Session::has('status'))
                <div class="alert alert-success text-center" role="alert">
                    {{ Session::get('message') }}
                </div>
        @endif

        <div class="section-body">
            <h2 class="section-title">
                <form action="" id="rekap" method="POST" class="form-horizontal">
                    @csrf
                    <div class="row mt-4">
                        <div class="col-4">
                            <p>Unit :</p>
                            <select name="sel-unit" id="sel-unit" class="@error('unit_id') is-invalid @enderror selectric" style="width: 50%; border: none; border-color: transparent; background: transparent;">
                            <option value="">Pilih Unit</option>
                            @foreach ($unitList as $item)
                            @php
                                $select = "";
                                if($item->id==$id){
                                    $select="selected";
                                }else{
                                    $select="";
                                }
                            @endphp
                                <option {{ $select }} value="{{ $item->id }}">{{ $item->unit }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="col-3">
                            <p>Periode :</p>
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-calendar"></i>
                                    </div>
                                </div>
                                <input name="sel-bln" id="sel-bln" type="month" class="form-control datepicker align-top">
                            </div>
                        </div>
                        <div class="col-4">
                            <p>&nbsp;</p>
                            <div class="form-actions">
                                <button type="submit" name="caripenilaian" class="btn btn-success">Rekap</button>
                            </div>
                        </div>
                    </div>
                </form>
            </h2>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
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
                        <form action="" method="POST">
                            <div class="table-responsive">
                                <table class="table-striped table" style='border-collapse: collapse; width:100%'>
                                    <thead>
                                        <th>#</th>
                                        <th style="width:70%">Indikator</th>
                                        <th>Kategori</th>
                                        <th>Standar</th>
                                        @for ($tanggal_table = 1; $tanggal_table <= 31; $tanggal_table++)
                                            <th>{{$tanggal_table}}</th>
                                        @endfor
                                    </thead>
                                    <tbody>
                                    @foreach ($indikators as $index => $data)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $data->indikator }}</td>
                                            <td>{{ $data->kategori }}</td>
                                            <td>{{ $data->nilai_standar }}</td>

                                                @php
                                                $hasil=0;
                                                $arr_tgl[][] = array();
                                                $arr_val[][] = array();
                                                for ($j=0; $j <count($nilais[$index]) ; $j++) {

                                                    $tanggal=$nilais[$index][$j]['tanggal'];

                                                    $ambil_tgl = explode("-", $tanggal);
                                                    $ambil_tgl[2] = (int)$ambil_tgl[2];

                                                    $nomor2 = $ambil_tgl[2] + 1;
                                                    $sisa_td = 31 - $nomor2;
                                                    $hasil = $nilais[$index][$j]->hasil;

                                                    $arr_tgl[$index][$ambil_tgl[2]] = $ambil_tgl[2];
                                                    $arr_val[$index][$ambil_tgl[2]] = $hasil;
                                                }
                                                @endphp
                                                @for ($tanggal_tables = 1; $tanggal_tables < 31; $tanggal_tables++)
                                                @php
                                                    if (array_key_exists($tanggal_tables,$arr_tgl[$index])){
                                                        echo '<td>'.$arr_val[$index][$tanggal_tables].'</td>';
                                                    }else{
                                                        echo '<td>-</td>';
                                                    }
                                                @endphp

                                            @endfor
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </form>

                        <div class="float-right">
                            <nav>
                                {{-- <ul class="pagination">
                                    {{ $unitList->withQueryString()->links() }}
                                </ul> --}}
                            </nav>
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
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script>
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            const date = new Date();
            let day = date.getDate();
            let month = ("0" + (date.getMonth() + 1)).slice(-2);
            let year = date.getFullYear();
            let currentDate = `${year}-${month}`;
            $('#sel-bln').val(currentDate);
            console.log(currentDate);
            getJmlHari();

            $('body').on('change', '#sel-bln', function() {
                var unit = document.getElementById('sel-unit').value;
                //var bln = $(this).val();
                getJmlHari();
                // gettabel(unit)
            });

            $('body').on('change', '#sel-unit', function() {
                var id = document.getElementById('sel-unit').value;
                var routeUrl = "{{ route('penilaian.rekapitulasi', 'id') }}";
                var formAction = routeUrl.replace('id', id);
                console.log(formAction);
                document.getElementById('rekap').action = formAction;
            });

            function getJmlHari(){
                var tanggal = new Date(document.getElementById('sel-bln').value);
                var tahun = tanggal.getFullYear();
                var bulan = tanggal.getMonth() + 1;
                var jmlHari = new Date(tahun, bulan, 0).getDate();
                console.log(jmlHari);
            }
        });
    </script>
@endpush
