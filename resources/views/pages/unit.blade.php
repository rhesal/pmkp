@extends('layouts.app')

@section('title', 'Unit RS')
@push('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Daftar Unit</h1>
            <div class="section-header-button">
                <span href="javascript:void(0)" id="show-unit" data-label="Create New Unit" data-tombol="Save" data-toggle="modal" data-target="#ModalCreateUnit"
                    class="btn btn-primary" data-backdrop="static">{{ __('Add New') }}</span>
            </div>
        </div>
        @if (Session::has('status'))
                <div class="alert alert-success text-center" role="alert">
                    {{ Session::get('message') }}
                </div>
        @endif
        <div class="section-body">
            <h2 class="section-title">Unit Pelayanan</h2>
            <p class="section-lead">
                You can manage all units, such as editing, deleting and more.
            </p>
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                    <div class="card-header">
                        <h4>All Units</h4>
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
                                    <th class="col-sm-1">No</th>
                                    <th>Nama Unit</th>
                                    <th class="col-4">Status</th>
                                </tr>
                                @forelse ($unitList as $index => $data)
                                    <tr>
                                        <td class="col-sm-1">{{ $index + $unitList -> firstItem() }}</td>
                                        {{-- <td class="col-sm-1">{{ $loop->iteration }}</td> --}}
                                        <td>{{ $data->unit }}
                                            <div class="table-links">
                                                <a href="#" hidden>View</a>
                                                <div class="bullet" hidden></div>
                                                <a href="javascript:void(0)"
                                                    id="edit-unit"
                                                    data-label="Edit Unit"
                                                    data-tombol="Update"
                                                    data-idunit="{{ $data->id }}"
                                                    data-unit="{{ $data->unit }}"
                                                    data-status="{{ $data->status }}"
                                                    data-toggle="modal" data-target="#ModalCreateUnit" data-backdrop="static">Edit</a>
                                                <div class="bullet"></div>
                                                <a href="" id="delete-unit" data-idunit="{{ $data->id }}" type="button" class="text-danger">Delete</a>
                                            </div>
                                        </td>
                                        <td class="col-4">
                                            @if ($data->status == "Active")
                                                <div class="badge badge-success">Active</div>
                                            @else
                                                <div class="badge badge-warning">Non Active</div>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="bg-danger text-center text-white">No Data Found</td>
                                    </tr>
                                @endforelse
                            </table>
                        </div>
                        <div class="float-right">
                            <nav>
                                <ul class="pagination">
                                    {{ $unitList->withQueryString()->links() }}
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
@include('modal.create-unit')
@endsection
@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script>
    <script src="{{ asset('js/page/modules-sweetalert.js') }}"></script>
    <script type="text/javascript">

        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('body').on('click', '#delete-unit', function () {
                var idunit = $(this).data('idunit');
                var trObj = $(this);
                if(confirm("Are you sure you want to remove this unit ?") == true){
                    $.ajax({
                        url: 'unit-destroy/'+idunit,
                        type: 'DELETE',
                        dataType: 'json',
                        success: function(data) {
                            alert(data.success);
                            trObj.parents("tr").remove();
                        }
                    });
                }
            });

            $('body').on('click', '#show-unit', function() {
                var label = $(this).data('label');
                var tombol = $(this).data('tombol');
                // console.log(label);
                $('#ModalLabel').text(label);
                $('#simpan-unit').text(tombol);
            });

            $('body').on('click', '#edit-unit', function() {
                var label = $(this).data('label');
                var tombol = $(this).data('tombol');
                var idunit = $(this).data('idunit');
                var unit = $(this).data('unit');
                // console.log(idunit+" "+unit);
                $('#ModalLabel').text(label);
                $('#simpan-unit').text(tombol);
                $('#idunit').val(idunit);
                $('#unit').val(unit);
                getStatus(idunit);
            });
        });

        function getStatus(idunit){
            // console.log("Fungsi getStatus : "+idunit);
            $.ajax({
                url: 'unit-edit',
                method: "GET",
                dataType: 'json',
                data:{
                        id: idunit
                    },
                success: function(data) {
                    console.log(data);
                    var html = '';
                    var select = "" ;

                    console.log(data[0].status);

                    if (data[0].status=="Active") {
                        select = "selected";
                        html +='<option '+select+' value="Active">Active</option><option value="Non Active">Non Active</option>';
                    }else{
                        select = "selected";
                        html +='<option value="Active">Active</option><option '+select+' value="Non Active">Non Active</option>';
                    }

                    $('#status').html(html);
                    $('#status').selectric({
                        maxHeight: 200
                    });
                }
            });
        }

        function clicksimpan(){
            var btntext = document.getElementById("simpan-unit").innerText;
            var idunit = document.getElementById("idunit").value;
            var unit = document.getElementById("unit").value;
            var status = document.getElementById("status").value;
            if(btntext == "Save"){
                //Save/store
                var data = {
                    unit: unit,
                    status: status,
                };
                simpandata(data);
            }else{
                //update
                var data = {
                    unit: unit,
                    status: status,
                };
                // console.log(idunit);
                updatedata(data, idunit);
            }
        }

        function updatedata(data, id){
            $.ajax({
                url: 'unit-update/'+id,
                method: "PUT",
                dataType: 'json',
                data: data,
                success: function(data) {
                    console.log(data);
                    // console.log(response.message);
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    console.error(error);
                }
            });
            clearInput()
        }

        function simpandata(data){
            $.ajax({
                url: 'unit-store',
                method: "POST",
                dataType: 'json',
                data: data,
                success: function(data) {
                    // console.log(data);
                    console.log(data);
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    console.error(error);
                }
            });
            clearInput()
        }

        function clearInput() {
            // Reset the value of the input field
            var html = '';
            document.getElementById("idunit").value = '';
            document.getElementById("unit").value = '';
            html +='<option selected value="">Select One</option><option value="Active">Active</option><option value="Non Active">Non Active</option>';

            $('#status').html(html);
            $('#status').selectric({
                maxHeight: 200
            });
        }
    </script>
@endpush
