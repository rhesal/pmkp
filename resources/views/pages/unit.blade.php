@extends('layouts.app')

@section('title', 'Unit RS')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Units</h1>
                <div class="section-header-button">
                    <a href="#" data-toggle="modal" data-target="#ModalCreate"
                        class="btn btn-primary">{{ __('Add New') }}</a>
                </div>
        </div>

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
                                    <th>No</th>
                                    <th>Nama Unit</th>
                                    <th>Status</th>
                                </tr>
                                {{-- @forelse ($unit as $index => $data)
                                    <tr>
                                        <td>{{ $index + $unit -> firstItem() }}</td>
                                        <td>{{ $data->name }}
                                            <div class="table-links">
                                                <a href="#">View</a>
                                                <div class="bullet"></div>
                                                <a href="#">Edit</a>
                                                <div class="bullet"></div>
                                                <a href="#" class="text-danger">Delete</a>
                                            </div>
                                        </td>
                                        <td>
                                            @if ($data->email_verified_at != null)
                                                <div class="badge badge-success">Active</div>
                                            @else
                                                <div class="badge badge-warning">Non Active</div>
                                            @endif
                                        </td>    
                                    </tr>    
                                @empty
                                    <tr>
                                        <td colspan="5" class="bg-danger text-justify text-white">No Data Found</td>
                                    </tr>    
                                @endforelse --}}
                                    <tr>
                                        <td colspan="5" class="bg-danger text-white text-center">No Data Found</td>
                                    </tr>
                            </table>
                        </div>
                        <div class="float-right">
                            {{-- <nav>
                                <ul class="pagination">
                                    {{ $user->withQueryString()->links() }}
                                </ul>
                            </nav> --}}
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

    <!-- Page Specific JS File -->
@endpush
