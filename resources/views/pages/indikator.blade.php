@extends('layouts.app')

@section('title', 'Indikator RS')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/prismjs/themes/prism.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Daftar Indikator <br> RSUD Karsa Husada Batu</h1>
                @if ( Auth::user()->role == "superadmin" || Auth::user()->role == "admin")
                    <div class="section-header-button">
                        <a href="javascript:void(0)" id="show-indikator" data-label="Create New Indikator" data-toggle="modal" data-target="#ModalCreateIndikator" data-backdrop="static" class="btn btn-primary">{{ __('Add New') }}</a>
                    </div>
                @endif
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
                                <h4>Indikator Unit</h4>
                                <select name="sel-unit" id="sel-unit" class="form-control" style="width: 300px; position: relative;
                                cursor: pointer; !important;">
                                @if ( Auth::user()->role == "superadmin" || Auth::user()->role == "admin")
                                    @foreach ($unitList as $item)
                                        <option id="val-id" value="{{ $item->id }}">{{ $item->unit }}</option>
                                    @endforeach
                                @else
                                    <option id="val-id" value="{{ Auth::user()->unit_id }}">{{ Auth::user()->unit->unit }}</option>
                                @endif
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
                                        <thead style="text-align:center">
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
                                {{-- <div class="float-right">
                                    <nav>
                                        <ul class="pagination">
                                            {{ $indikatorList->withQueryString()->links() }}
                                        </ul>
                                    </nav>
                                </div> --}}
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
    {{-- <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('library/prismjs/prism.js') }}"></script> --}}
    {{-- <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script> --}}

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script>
    <script src="{{ asset('js/page/bootstrap-modal.js') }}"></script>
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
    {{-- <script src="{{ asset('js/page/modules-chartjs.js') }}"></script> --}}

    <script type="text/javascript">
        $(document).ready(function() {
            var id = document.getElementById('val-id').value;
            console.log("unit_id : " + id);

            $.ajax({
                    url: 'indikatorbyunit/'+id,
                    type: 'GET',
                    dataType: 'JSON',
                    success: function(data){
                        console.log(data);
                        var table = document.getElementById("tabIndikator");
                        var html1 = "";
                        for (let i = 0; i < data.length; i++) {
                            var pengukuran = "";
                            if(data[i].satuan_pengukuran=="%"){
                                pengukuran = "Persentase(%)";
                            }else{
                                pengukuran = data[i].satuan_pengukuran;
                            }
                            html1 += `<tr>
                                        <td>${i+1}</td>
                                        <td>
                                            <a href="javascript:void(0)" id="show-unit"
                                                data-url1="indikator-show/${data[i].id}"
                                                data-url2="penilaian-show/${data[i].id}"
                                                data-toggle="modal" data-target="#ModalCreatePengisian"
                                                data-backdrop="static">${data[i].indikator}
                                            </a>
                                        </td>
                                        <td style="text-align:center">${data[i].jenis_indikator}</td>
                                        <td style="text-align:center">${data[i].nilai_standar}</td>
                                        <td style="text-align:center">${pengukuran}</td>
                                        <td style="text-align:center"><div class="badge badge-success">${data[i].status}</div></td>
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

            var table = '';
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
                        var unitID = id;
                        for (let i = 0; i < data.length; i++) {
                            var pengukuran = "";
                            if(data[i].satuan_pengukuran=="%"){
                                pengukuran = "Persentase(%)";
                            }else{
                                pengukuran = data[i].satuan_pengukuran;
                            }
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
                                                <a href="javascript:void(0)" id="edit-indikator"
                                                            data-label="Edit Indikator"
                                                            data-tombol="Update"
                                                            data-idindikator="${data[i].id}"
                                                            data-indikator="${data[i].indikator}"
                                                            data-unitid="${unitID}"
                                                            data-standar="${data[i].nilai_standar}"
                                                            data-toggle="modal"
                                                            data-target="#ModalCreateIndikator"
                                                            data-backdrop="static">Edit</a>
                                                <div class="bullet"></div>
                                                <a href="#" type="button" class="text-danger">Delete</a>
                                            </div>
                                        </td>
                                        <td style="text-align:center">${data[i].jenis_indikator}</td>
                                        <td style="text-align:center">${data[i].nilai_standar}</td>
                                        <td style="text-align:center">${pengukuran}</td>
                                        <td style="text-align:center"><div class="badge badge-success">${data[i].status}</div></td>
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

            $('body').on('click', '#showSelectedBtn', function() {
                console.log("Pilih kategori");
                const checkboxes = document.getElementsByName('valuechecked');
                const selectedItems = [];

                checkboxes.forEach((checkbox) => {
                    if (checkbox.checked) {
                        selectedItems.push(checkbox.value);
                    }
                });

                if (selectedItems.length > 0) {
                    const kategori = 'Selected Items: ' + selectedItems.join(', ');
                    alert(kategori);
                } else {
                    alert('No items selected.');
                }
            });

            $('body').on('click', '#show-unit', function() {
                var unitURL = $(this).data('url1');
                //var penilaianURL = $(this).data('url2');

                console.log(unitURL);
                //console.log(penilaianURL);
                $.get(unitURL, function(data) {
                    const date = new Date();

                    let day = date.getDate();
                    let month = ("0" + (date.getMonth() + 1)).slice(-2);
                    let year = date.getFullYear();
                    let currentDate = `${year}-${month}`;

                    $('#sel-bln').val(currentDate)
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
                    gettabel(currentDate)
                    getChart(currentDate)
                })

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            });

            $('body').on('click', '#show-indikator', function() {
                clearInputNewIndikator()
                var label = $(this).data('label');
                console.log(label);
                $('#ModalLabel').text(label);
            });

            $('body').on('click', '#edit-indikator', function() {
                var label = $(this).data('label');
                var tombol = $(this).data('tombol');
                var idindikator = $(this).data('idindikator');
                var indikator = $(this).data('indikator');
                var unitId = $(this).data('unitid');
                var standar = $(this).data('standar');
                console.log(idindikator);
                $('#ModalLabel').text(label);
                $('#simpan-indikator').text(tombol);
                $('#indikator').text(indikator);
                $('#nilai_standar').val(standar);
                getUnit(unitId,idindikator);
            });

            $('body').on('change', '#sel-bln', function() {
                var bln = $(this).val();
                gettabel(bln);
                getChart(bln);
            });

            function gettabel(bln){
                // var bln = $(this).val();
                var id = document.getElementById('indikator-id').value;
                console.log(id);
                console.log(bln);
                console.log('penilaian-show/' + document.getElementById('indikator-id').value);

                // DataTable
                $('#mytab1').DataTable({
                    processing: true,
                    serverSide: true,
                    bDestroy: true,
				    ordering: true,
                    ajax:{
                        type: "GET",
                        url: "{{route('penilaian.show')}}",
                        data:{
                                data1: id,
                                data2: bln
                            },
                    },
                    deferRender: true,
				    aLengthMenu: [
                                    [5, 25, 50, 100],
                                    [5, 25, 50, 100]
				                ],
                    columns: [
                        { data: 'tanggal',width: '15%', className: "text-center"},
                        { data: 'numerator',width: '15%', className: "text-center" },
                        { data: 'denumerator',width: '15%', className: "text-center" },
                        { data: 'hasil',width: '15%', className: "text-center" },
                        { data: 'keterangan',width: '15%', className: "text-center" },
                        { data: 'action', name: 'action', orderable: false, searchable: false, className: "text-center" },
                    ],
                    columnDefs: [{
                                    targets: 5, // kolom ke-4 (kolom action)
                                    render: function(data, type, row, meta) {
                                        var html =
                                            '<a href="url/to/edit/page/' + row.id + '" class="btn btn-info fa fa-pen"></a>' +
                                            '<span>&nbsp;</span>'+
                                            '<a href="url/to/delete/' + row.id + '" class="btn btn-danger fa fa-trash"></a>';
                                    return html;
                                    }
                                }]
                });
            }

            function getChart(bln){
                var id = document.getElementById('indikator-id').value;

                const date = new Date();
                let day = date.getDate();
                var bln1 = new Date(bln+'-'+day);
                const nameBln = bln1.toLocaleString('id-ID', { month: 'long' });
                console.log(nameBln);

                $.ajax({
                    url: "{{route('chart')}}",
                    type: 'GET',
                    processing: true,
                    serverSide: true,
                    bDestroy: true,
                    ordering: true,
                    dataType: 'JSON',
                    data:{
                        data1: id,
                        data2: bln
                    },
                    success: function(item){
                        console.log(item)
                        const labels =  item.labels;
                        const datas =  item.datas;
                        console.log(labels)

                        const hasil = {
                            labels: labels,
                            datasets: [{
                                label: 'Hasil',
                                data: datas,
                                backgroundColor: 'rgb(255, 99, 132)',
                                borderColor: 'rgb(255, 99, 132)',
                            }]
                        };

                        const config = {
                            type: 'line',
                            data: hasil,
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'top',
                                    },
                                    title: {
                                        display: true,
                                        text: 'Grafik Penilaian Unit Bulan '+nameBln,
                                    }
                                }
                            }
                        };

                        var my_Chart = $('#myChart').get(0).getContext('2d');
                        if (typeof myChartDraw != 'undefined') {
                            myChartDraw.destroy();
                        }
                        myChartDraw = new Chart(my_Chart, config);


                    }
                });
            }
        });



        function getUnit(unit,id){
            console.log("Fungsi getUnit : "+unit+" "+id);

            $.ajax({
                url: 'indikator-edit',
                method: "GET",
                dataType: 'json',
                data:{
                        id: id
                    },
                success: function(data) {
                    // console.log(data['units']);
                    var html = '';
                    var html1 = '';
                    var html2 = '';
                    var i;
                    var select = "" ;
                    for (i = 0; i < data['units'].length; i++) {
                        // console.log(data['units'][i].id);
                        if(unit==data['units'][i].id){
                            select = "selected";
                        }else{
                            select="";
                        }
                        html +=
                        '<option '+select+' value="'+data['units'][i].id+'">'+data['units'][i].unit+'</option>';
                    }

                    console.log(data['indikators'][0].status);
                    if (data['indikators'][0].satuan_pengukuran=="%") {
                        select = "selected";
                        html1 +='<option '+select+' value="%">Persentase (%)</option><option value="menit">Menit</option>';
                    }else{
                        select = "selected";
                        html1 +='<option value="%">Persentase (%)</option><option '+select+' value="menit">Menit</option>';
                    }

                    if (data['indikators'][0].status=="Active") {
                        select = "selected";
                        html2 +='<option '+select+' value="Active">Active</option><option value="Non Active">Non Active</option>';
                    }else{
                        select = "selected";
                        html2 +='<option value="Active">Active</option><option '+select+' value="Non Active">Non Active</option>';
                    }

                    $('#unit_id').html(html);
                    $('#unit_id').selectric({
                        maxHeight: 400
                    });
                    $('#satuan_pengukuran').html(html1);
                    $('#satuan_pengukuran').selectric({
                        maxHeight: 200
                    });
                    $('#status').html(html2);
                    $('#status').selectric({
                        maxHeight: 200
                    });
                }
            });
        }

        function clearInputNewIndikator() {
            document.getElementById("indikator").value = '';
            document.getElementById("nilai_standar").value = '';

            const checkboxes = document.getElementsByName('valuechecked');
            Array.from(checkboxes).forEach((checkbox) => {
                checkbox.checked = false;
            });
        }

        function clearInput() {
            // Reset the value of the input field
            document.getElementById("num").value = '';
            document.getElementById("denum").value = '';
            document.getElementById("indikator-id").value = '';
            document.getElementById("hasil").value = '';
        }

        function percentage() {
            var txtNumValue = document.getElementById('num').value;
            var txtDenumValue = document.getElementById('denum').value;

            if(txtNumValue==null || txtDenumValue==null){
                document.getElementById('hasil').value = "";
            }else{
                if(txtNumValue==0 && txtDenumValue==0){
                    document.getElementById('hasil').value = "0%";
                }else{
                    var result = (parseInt(txtNumValue) / parseInt(txtDenumValue)) * 100 / 100;
                    if (!isNaN(result)) {
                        if(!isFinite(result)){
                            document.getElementById('hasil').value = "0%";
                        }else{
                            document.getElementById('hasil').value = result.toFixed(2) + "%";
                        }
                    }
                }
            }
        }
    </script>
@endpush
