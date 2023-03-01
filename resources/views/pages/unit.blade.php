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
                <a href="#" data-toggle="modal" data-target="#ModalCreateUnit"
                    class="btn btn-primary" onclick="create()" >{{ __('Add New') }}</a>
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
                                                <a href="#">View</a>
                                                <div class="bullet"></div>
                                                <a href="#">Edit</a>
                                                <div class="bullet"></div>
                                                <a href="/unit-destroy/{{ $data->id }}" type="button" class="text-danger">Delete</a>
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
    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script>
    <script type="text/javascript">

        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        
            /*------------------------------------------
            --------------------------------------------
            When click user on Show Button
            --------------------------------------------
            --------------------------------------------*/
            $('body').on('click', '#delete-unit', function () {
                var userURL = $(this).data('url');
                var trObj = $(this);
                if(confirm("Are you sure you want to remove this unit ?") == true){
                    $.ajax({
                        url: userURL,
                        type: 'DELETE',
                        dataType: 'json',
                        success: function(data) {
                            alert(data.success);
                            trObj.parents("tr").remove();
                        }
                    });
                }
            });   
        });      
    </script>
@endpush
