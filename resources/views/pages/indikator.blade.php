@extends('layouts.app')

@section('title', 'Indikator RS')
@push('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
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
                                            <th>Kategori</th>
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
    <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>
    {{-- <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('library/prismjs/prism.js') }}"></script> --}}
    {{-- <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script> --}}

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script>
    <script src="{{ asset('js/page/bootstrap-modal.js') }}"></script>
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
    <script src="{{ asset('js/page/modules-sweetalert.js') }}"></script>
    {{-- <script src="{{ asset('js/page/modules-chartjs.js') }}"></script> --}}

    <script type="text/javascript">
        $(document).ready(function() {
            var id = document.getElementById('val-id').value;
            console.log("idunit : " + id);

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
                                        <a href="javascript:void(0)" id="show-penilaian"
                                            data-url1="indikator-show/${data[i].id}"
                                            data-url2="penilaian-show/${data[i].id}"
                                            data-toggle="modal" data-target="#ModalCreatePengisian"
                                            data-backdrop="static">${data[i].indikator}
                                        </a>
                                    </td>
                                    <td style="text-align:center">${data[i].kategori}</td>
                                    <td style="text-align:center">${data[i].nilai_standar}</td>
                                    <td style="text-align:center">${pengukuran}</td>
                                    <td style="text-align:center"><div class="badge badge-success">${data[i].status}</div></td>
                                </tr>`;
                    }
                    table.getElementsByTagName('tbody')[0].innerHTML = html1;
                }
            });

            // $.ajaxSetup({
            //     headers: {
            //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //     }
            // });

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
                            html1 += `<tr id="index_${data[i].id}">
                                        <td>${i+1}</td>
                                        <td>${data[i].indikator}
                                            <div class="table-links">
                                                <a href="javascript:void(0)" id="show-penilaian"
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
                                                            data-kategori="${data[i].kategori}"
                                                            data-toggle="modal"
                                                            data-target="#ModalCreateIndikator"
                                                            data-backdrop="static">Edit</a>
                                                <div class="bullet"></div>
                                                <a href="javascript:void(0)" id="delete-indikator" data-id="${data[i].id}" type="button" class="text-danger">Delete</a>
                                            </div>
                                        </td>
                                        <td style="text-align:center">${data[i].kategori}</td>
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

            $('body').on('click', '#show-indikator', function() {
                clearInputNewIndikator()
                var label = $(this).data('label');
                console.log(label);
                $('#ModalLabel').text(label);
            });

            $('body').on('click', '#edit-indikator', function() {
                clearInputNewIndikator()
                var label = $(this).data('label');
                var tombol = $(this).data('tombol');
                var idindikator = $(this).data('idindikator');
                var indikator = $(this).data('indikator');
                var unitId = $(this).data('unitid');
                var standar = $(this).data('standar');
                var kategori  = $(this).data('kategori');
                console.log(idindikator);
                $('#ModalLabel').text(label);
                $('#simpan-indikator').text(tombol);
                $('#indikator').val(indikator);
                $('#idindikator').val(idindikator);
                $('#nilai_standar').val(standar);
                getUnit(unitId,idindikator);
                getKategoriEdit(kategori);
            });

            function getKategoriEdit(items){
                const checkboxes = document.getElementsByName('valuechecked');
                console.log("kategori "+items);
                if  (items == null){
                    return
                }else{
                    const kategori = items.split(", ");
                    var txt = "";
                    console.log(kategori);

                    checkboxes.forEach((checkbox) => {
                        // console.log(checkbox.value);
                        for (let i = 0; i < kategori.length; i++) {
                            switch(kategori[i]) {
                                case "INM":
                                    txt = "INM"
                                    break;
                                case "SKP":
                                    txt = "SKP"
                                    break;
                                case "Mutu Prioritas":
                                    txt = "Mutu Prioritas"
                                    break;
                                case "SPM":
                                    txt = "SPM"
                                    break;
                                case "Lainnya":
                                    txt = "Lainnya"
                                    break;
                                default:
                                    txt = ""
                            }
                            // console.log(txt);
                            if (checkbox.value == txt) {
                                checkbox.checked = true;
                            }
                        }
                    });
                }
                // return kategori;
            }
        });

        function clicksimpan(){
            var btntext = document.getElementById("simpan-indikator").innerText;
            var idindikator = document.getElementById("idindikator").value;
            var indikator = document.getElementById("indikator").value;
            var idunit = document.getElementById("idunit").value;
            var nilai_standar = document.getElementById("nilai_standar").value;
            var satuan_pengukuran = document.getElementById("satuan_pengukuran").value;
            var status = document.getElementById("status").value;
            var kategori = getkategori();
            if(btntext == "Save"){
                //Save/store
                var data = {
                    indikator: indikator,
                    unit_id: idunit,
                    kategori: kategori,
                    nilai_standar: nilai_standar,
                    satuan_pengukuran: satuan_pengukuran,
                    status: status,
                };
                // simpantes(data)
                simpandata(data, idunit);
            }else{
                //update
                var data = {
                    indikator: indikator,
                    unit_id: idunit,
                    kategori: kategori,
                    nilai_standar: nilai_standar,
                    satuan_pengukuran: satuan_pengukuran,
                    status: status,
                };
                // console.log(idunit);
                updatedata(data, idindikator, idunit);
            }
        }

        function getkategori() {
            // console.log("Pilih kategori");
            const checkboxes = document.getElementsByName('valuechecked');
            const selectedItems = [];
            var kategori = "";

            checkboxes.forEach((checkbox) => {
                if (checkbox.checked) {
                    selectedItems.push(checkbox.value);
                }
            });

            if (selectedItems.length > 0) {
                kategori = selectedItems.join(', ');
                // alert(kategori);
            } else {
                console.log('No items selected.');
            }

            return kategori;
        }

        function updatedata(data, id, idunit){
            console.log("updatedata : "+id+"-"+JSON.stringify(data));
            $.ajax({
                url: 'indikator-update/'+id,
                method: 'PUT',
                dataType: 'json',
                data: data,
                success: function(data) {
                    var table = document.getElementById('tabIndikator');
                    var url = 'indikatorbyunit/'+idunit; // Replace with your actual backend URL

                    var xhr = new XMLHttpRequest();
                    xhr.open('GET', url);
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === XMLHttpRequest.DONE) {
                            if (xhr.status === 200) {
                                // Update the table with the new data
                                var items = JSON.parse(xhr.responseText);
                                var html = "";
                                var unitID = idunit;
                                console.log("total data : "+items.length);
                                for (let i = 0; i < items.length; i++) {
                                    var pengukuran = "";
                                    if(items[i].satuan_pengukuran=="%"){
                                        pengukuran = "Persentase(%)";
                                    }else{
                                        pengukuran = items[i].satuan_pengukuran;
                                    }
                                    html += `<tr id="index_${items[i].id}">
                                                <td>${i+1}</td>
                                                <td>${items[i].indikator}
                                                    <div class="table-links">
                                                        <a href="javascript:void(0)" id="show-penilaian"
                                                                    data-url1="indikator-show/${items[i].id}"
                                                                    data-url2="penilaian-show/${items[i].id}"
                                                                    data-toggle="modal" data-target="#ModalCreatePengisian"
                                                                    data-backdrop="static">Penilaian</a>
                                                        <div class="bullet"></div>
                                                        <a href="javascript:void(0)" id="edit-indikator"
                                                                    data-label="Edit Indikator"
                                                                    data-tombol="Update"
                                                                    data-idindikator="${items[i].id}"
                                                                    data-indikator="${items[i].indikator}"
                                                                    data-unitid="${unitID}"
                                                                    data-standar="${items[i].nilai_standar}"
                                                                    data-kategori="${items[i].kategori}"
                                                                    data-toggle="modal"
                                                                    data-target="#ModalCreateIndikator"
                                                                    data-backdrop="static">Edit</a>
                                                        <div class="bullet"></div>
                                                        <a href="javascript:void(0)" id="delete-indikator" data-id="${items[i].id}" type="button" class="text-danger">Delete</a>
                                                    </div>
                                                </td>
                                                <td style="text-align:center">${items[i].kategori}</td>
                                                <td style="text-align:center">${items[i].nilai_standar}</td>
                                                <td style="text-align:center">${pengukuran}</td>
                                                <td style="text-align:center"><div class="badge badge-success">${items[i].status}</div></td>
                                            </tr>`;

                                }
                                table.getElementsByTagName('tbody')[0].innerHTML = html;
                                Swal.fire('Good job!','Data update successfully!','success')
                                // console.log(tes[0].indikator);
                            } else {
                                console.error('Error: ' + xhr.status);
                                Swal.fire('Oopss!',xhr.status,'error')
                            }
                        }
                    };
                    xhr.send();
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    console.error(error);
                }
            });
            // clearInputNewIndikator()
        }

        function simpandata(data, idunit){
            console.log("simpandata : "+JSON.stringify(data));
            $.ajax({
                url: '/indikator-store',
                method: 'GET',
                dataType: 'json',
                // data: data,
                data: data,
                success: function(data) {
                    var table = document.getElementById('tabIndikator');
                    var url = 'indikatorbyunit/'+idunit; // Replace with your actual backend URL

                    var xhr = new XMLHttpRequest();
                    xhr.open('GET', url);
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === XMLHttpRequest.DONE) {
                            if (xhr.status === 200) {
                                // Update the table with the new data
                                var items = JSON.parse(xhr.responseText);
                                var html = "";
                                var unitID = idunit;
                                console.log("total data : "+items.length);
                                for (let i = 0; i < items.length; i++) {
                                    var pengukuran = "";
                                    if(items[i].satuan_pengukuran=="%"){
                                        pengukuran = "Persentase(%)";
                                    }else{
                                        pengukuran = items[i].satuan_pengukuran;
                                    }
                                    html += `<tr id="index_${items[i].id}">
                                                <td>${i+1}</td>
                                                <td>${items[i].indikator}
                                                    <div class="table-links">
                                                        <a href="javascript:void(0)" id="show-penilaian"
                                                                    data-url1="indikator-show/${items[i].id}"
                                                                    data-url2="penilaian-show/${items[i].id}"
                                                                    data-toggle="modal" data-target="#ModalCreatePengisian"
                                                                    data-backdrop="static">Penilaian</a>
                                                        <div class="bullet"></div>
                                                        <a href="javascript:void(0)" id="edit-indikator"
                                                                    data-label="Edit Indikator"
                                                                    data-tombol="Update"
                                                                    data-idindikator="${items[i].id}"
                                                                    data-indikator="${items[i].indikator}"
                                                                    data-unitid="${unitID}"
                                                                    data-standar="${items[i].nilai_standar}"
                                                                    data-kategori="${items[i].kategori}"
                                                                    data-toggle="modal"
                                                                    data-target="#ModalCreateIndikator"
                                                                    data-backdrop="static">Edit</a>
                                                        <div class="bullet"></div>
                                                        <a href="javascript:void(0)" id="delete-indikator" data-id="${items[i].id}" type="button" class="text-danger">Delete</a>
                                                    </div>
                                                </td>
                                                <td style="text-align:center">${items[i].kategori}</td>
                                                <td style="text-align:center">${items[i].nilai_standar}</td>
                                                <td style="text-align:center">${pengukuran}</td>
                                                <td style="text-align:center"><div class="badge badge-success">${items[i].status}</div></td>
                                            </tr>`;

                                }
                                table.getElementsByTagName('tbody')[0].innerHTML = html;
                                Swal.fire('Good job!','Data successfully added!','success')
                                // console.log(tes[0].indikator);
                            } else {
                                console.error('Error: ' + xhr.status);
                                Swal.fire('Oopss!',xhr.status,'error')
                            }
                        }
                    };
                    xhr.send();
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    console.error(error);
                }
            });
        }

        $('body').on('click', '#delete-indikator', function () {
            let idindikator = $(this).data('id');
            let token   = $("meta[name='csrf-token']").attr("content");

            Swal.fire({
                title: 'Apakah Kamu Yakin?',
                text: "ingin menghapus data ini!",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'TIDAK',
                confirmButtonText: 'YA, HAPUS!'
            }).then((result) => {
                if (result.isConfirmed) {
                    //fetch to delete data
                    $.ajax({
                        url: `/indikator-destroy/${idindikator}`,
                        type: "DELETE",
                        cache: false,
                        data: {
                            "_token": token
                        },
                        success: function(data) {
                            console.log(data);
                            $(`#index_${idindikator}`).remove();
                            // window.location.reload();
                            Swal.fire('Deleted!', data.message, 'success');
                        },
                        error: function(xhr, status, error) {
                            // Handle error response
                            // console.error(error);
                            Swal.fire('Error!', 'An error occurred while deleting the data.', 'error');
                        }
                    });
                }
            })
        });

        function getUnit(unit,id){
            // console.log("Fungsi getUnit : "+unit+" "+id);
            $.ajax({
                url: 'indikator-edit',
                method: 'GET',
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

                    $('#idunit').html(html);
                    $('#idunit').selectric({
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
                    type: 'GET',
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
                                targets: 0, // kolom ke-4 (kolom action)
                                render: function(data, type, row, meta) {
                                    var html = '<p style="font-size: 14px;font-weight: 800;">'+ row.tanggal +'</p>';
                                return html;
                                }
                            },
                            {
                                targets: 1, // kolom ke-4 (kolom action)
                                render: function(data, type, row, meta) {
                                    var html = '<p style="font-size: 14px;font-weight: 800;">'+ row.numerator +'</p>';
                                return html;
                                }
                            },
                            {
                                targets: 2, // kolom ke-4 (kolom action)
                                render: function(data, type, row, meta) {
                                    var html = '<p style="font-size: 14px;font-weight: 800;">'+ row.denumerator +'</p>';
                                return html;
                                }
                            },
                            {
                                targets: 3, // kolom ke-4 (kolom action)
                                render: function(data, type, row, meta) {
                                    var html = '<p style="font-size: 14px;font-weight: 800;">'+ row.hasil +'</p>';
                                return html;
                                }
                            },
                            {
                                targets: 4, // kolom ke-4 (kolom action)
                                render: function(data, type, row, meta) {
                                    var html = '<p style="font-size: 14px;font-weight: 800;">'+ row.keterangan +'</p>';
                                return html;
                                }
                            },
                            {
                                targets: 5, // kolom ke-4 (kolom action)
                                render: function(data, type, row, meta) {
                                    var html =
                                        '<a href="javascript:void(0)"'+
                                            'data-id="'+ row.id +'"'+
                                            'data-tanggal="'+ row.tanggal +'"'+
                                            'data-num="'+ row.numerator +'"'+
                                            'data-denum="'+ row.denumerator +'"'+
                                            'id="edit-penilaian"'+
                                            'class="btn btn-info fa fa-pen"></a>' +
                                        '<span id="nilai_id_' + row.id + '">&nbsp;</span>'+
                                        '<a href="javascript:void(0)" data-id="'+ row.id +'" id="delete-penilaian" class="btn btn-danger fa fa-trash"></a>';
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
                            fill: true,
                            backgroundColor: 'rgb(255, 99, 132, 0.7)',
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

        function validateInputs() {
            var num = document.getElementById('num');
            var denum = document.getElementById('denum');
            var hasil = document.getElementById('hasil');

            if (num.value.trim() === '') {
                num.classList.add('warning');
                document.getElementById('warningMessage').innerText = 'Input cannot be null';
            } else {
                num.classList.remove('warning');
                document.getElementById('warningMessage').innerText = '';
            }

            if (denum.value.trim() === '') {
                denum.classList.add('warning');
                document.getElementById('warningMessage').innerText = 'Input cannot be null';
            } else {
                denum.classList.remove('warning');
                document.getElementById('warningMessage').innerText = '';
            }

            if (hasil.value.trim() === '') {
                hasil.classList.add('warning');
                document.getElementById('warningMessage').innerText = 'Input cannot be null';
            } else {
                hasil.classList.remove('warning');
                document.getElementById('warningMessage').innerText = '';
            }
        }

        $('body').on('click', '#show-penilaian', function() {
            var unitURL = $(this).data('url1');
            //var penilaianURL = $(this).data('url2');

            //console.log(unitURL);
            //console.log(penilaianURL);
            $.get(unitURL, function(data) {
                const date = new Date();

                let day = date.getDate();
                let month = ("0" + (date.getMonth() + 1)).slice(-2);
                let year = date.getFullYear();
                let currentDate = `${year}-${month}`;

                $('#sel-bln').val(currentDate)
                $('#ModalCreatePengisian').modal('show');
                $('#simpan-penilaian').text('Save');
                $('#unit-name').text(data.unit.unit)
                $('#unit-indikator').text(data.indikator)
                $('#kategori').text(data.kategori)
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

        $('body').on('click', '#edit-penilaian', function () {
            var idnilai = $(this).data('id');
            var tanggal = $(this).data('tanggal');
            var num = $(this).data('num');
            var denum = $(this).data('denum');
            console.log(tanggal+" "+num+" "+denum);
            $('#simpan-penilaian').text("Update");
            $('#nilai-id').val(idnilai);
            $('#tanggal').val(tanggal);
            $('#num').val(num);
            $('#denum').val(denum);

            var result = (parseInt(num) / parseInt(denum)) * 100 / 100;
            if (!isNaN(result)) {
                if(!isFinite(result)){
                    $('#hasil').val("0%");
                }else{
                    $('#hasil').val(result.toFixed(2) + "%");
                }
            }
        });

        function simpan_penilaian(){
            validateInputs()
            var btntext = document.getElementById("simpan-penilaian").innerText;
            var idnilai = document.getElementById("nilai-id").value;
            if(btntext == "Save"){
                var data = {
                    indikator_id: document.getElementById("indikator-id").value,
                    tanggal: document.getElementById("tanggal").value,
                    numerator: document.getElementById("num").value,
                    denumerator: document.getElementById("denum").value,
                    hasil: document.getElementById("hasil").value,
                };
                simpannilai(data);
            }else{
                var data = {
                    tanggal: document.getElementById("tanggal").value,
                    numerator: document.getElementById("num").value,
                    denumerator: document.getElementById("denum").value,
                    hasil: document.getElementById("hasil").value,
                };
                updatenilai(data,idnilai);
            }
        }

        function simpannilai(data){
            console.log("simpannilai : "+JSON.stringify(data));
            $.ajax({
                url: 'penilaian-store',
                method: 'POST',
                dataType: 'json',
                data: data,
                success: function(data) {
                    console.log(data);
                    $('#mytab1').DataTable().ajax.reload();
                    getChart(document.getElementById('sel-bln').value);
                    Swal.fire('Stored!', data.message, 'success');
                    // window.location.reload();
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    console.error(status);
                    Swal.fire('Error!', 'An error occurred while storing the data.', 'error');
                }
            });
        }

        function updatenilai(data, id){
            console.log("updatenilai : "+id+"-"+JSON.stringify(data));
            $.ajax({
                url: 'penilaian-update/'+id,
                method: 'PUT',
                dataType: 'json',
                data: data,
                success: function(data) {
                    console.log(data);
                    $('#mytab1').DataTable().ajax.reload();
                    $('#simpan-penilaian').text("Save");
                    getChart(document.getElementById('sel-bln').value);
                    Swal.fire('Updated!', data.message, 'success');
                    // window.location.reload();
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    // console.error(error);
                    Swal.fire('Error!', 'An error occurred while updating the data.', 'error');
                }
            });
        }

        $('body').on('click', '#delete-penilaian', function () {
            console.log(document.getElementById('sel-bln').value);
            let idnilai = $(this).data('id');
            let token   = $("meta[name='csrf-token']").attr("content");
            // console.log(idindikator);
            Swal.fire({
                title: 'Apakah Kamu Yakin?',
                text: "ingin menghapus data ini!",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'TIDAK',
                confirmButtonText: 'YA, HAPUS!'
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log('test');
                    //fetch to delete data
                    $.ajax({
                        url: `/penilaian-destroy/${idnilai}`,
                        type: "DELETE",
                        cache: false,
                        data: {
                            "_token": token
                        },
                        success: function(data) {
                            console.log(data);
                            $('#mytab1').DataTable().ajax.reload();
                            getChart(document.getElementById('sel-bln').value);
                            Swal.fire('Deleted!', data.message, 'success');
                            // window.location.reload();
                        },
                        error: function(xhr, status, error) {
                            // Handle error response
                            // console.error(error);
                            Swal.fire('Error!', 'An error occurred while deleting the data.', 'error');
                        }
                    });
                }
            })
        });
    </script>
@endpush
