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
            <h1>Penilaian Mutu</h1>
        </div>
        @if (Session::has('status'))
                <div class="alert alert-success text-center" role="alert">
                    {{ Session::get('message') }}
                </div>
        @endif

        <div class="section-body">
            <h2 class="section-title">
                Penilaian Mutu Unit
                <span></span>
                <select name="sel-unit" id="sel-unit" class="@error('unit_id') is-invalid @enderror" style="width: 15%; border: none; border-color: transparent; background: transparent;">
                    <option value="">....</option>
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
            </h2>
            <p class="section-lead">
                Periode :
                <input type="month" style="border: none; border-color: transparent; background: transparent;" id="sel-bln" name="sel-bln">
                {{-- <a href="" type="button" id="my-button" class="btn btn-primary">Klik saya</a> --}}
            </p>
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

                        <div class="table-responsive">
                            <table class="table-striped table" id="mytab1" width='100%' style='border-collapse: collapse;'>
                                <thead>
                                    <th>#</th>
                                    <th>Indikator</th>
                                    <th>Kategori</th>
                                    <th>Standar</th>
                                    @php
                                        $start_date = new DateTime('2023-03-01');
                                        $end_date = new DateTime('2023-04-01');
                                        $interval = DateInterval::createFromDateString('1 day');
                                        $period = new DatePeriod($start_date, $interval, $end_date);
                                    @endphp
                                    @foreach ($period as $date)
                                    <th>{{$date->format('d')}}</th>
                                    @endforeach
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <div class="float-right">
                            <nav>
                                {{-- <ul class="pagination">
                                    {{ $unitList->withQueryString()->links() }}
                                </ul> --}}
                            </nav>
                        </div>
                        <div>
                            <div class="input-group-append float-right" style=": 50px">
                                <button class="btn btn-primary">Print</button>
                            </div>
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
            gettabel({{ $id }});

            $('body').on('change', '#sel-bln', function() {
                var unit = document.getElementById('sel-unit').value;
                //var bln = $(this).val();
                gettabel(unit)
            });

            function getJmlHari(){
                var tanggal = new Date(document.getElementById('sel-bln').value);
                var tahun = tanggal.getFullYear();
                var bulan = tanggal.getMonth() + 1;
                var jmlHari = new Date(tahun, bulan, 0).getDate();
                return jmlHari;
            }

            function gettabel(unit){
                //alert("No_ID : "+unit+" Periode :"+bln);

                $('#mytab1').DataTable({
                    processing: true,
                    serverSide: true,
                    bDestroy: true,
				    ordering: true,
                    ajax:{
                        type: "GET",
                        url: "{{route('penilaian.rekapitulasi')}}",
                        data:{
                                data1: unit
                            },
                    },
                    deferRender: true,
				    aLengthMenu: [
                                    [5, 25, 50, 100],
                                    [5, 25, 50, 100]
				                ],
                    columns: [

                    ],
                    columnDefs: [
                                    {
                                        targets: 0,
                                        render: function (data, type, row, meta) {
                                            var no = meta.row + meta.settings._iDisplayStart + 1;
                                            var html = '<p>'+no+'</p>';
                                            return html;
                                        }
                                    },
                                    {
                                        targets: 1, data: 'indikator',
                                        render: function (data, type, row, meta) {
                                            var html = '<a href="">'+data+'</a>';
                                            return html;
                                        }
                                    },
                                    {targets: 2, data: 'kategori', width: '15%', className: "text-center"},
                                    {targets: 3, data: 'nilai_standar', width: '15%', className: "text-center"},
                                ]
                });
            }
        });
    </script>
@endpush
