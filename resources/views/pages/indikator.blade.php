@extends('layouts.app')

@section('title', 'Indikator RS')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Daftar Indikator <br> RSUD Karsa Husada Batu</h1>
            <div class="section-header-button">
                <a href="#" data-toggle="modal" data-target="#ModalCreateIndikator"
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
                                    <th>Satuan Pengukuran</th>
                                    <th>Nilai Standar</th>
                                    <th>Status</th>
                                </tr>
                                <tr>
                                    <td colspan="7" class="bg-danger text-center text-white">No Data Found</td>
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
@include('modal.create-indikator')
@endsection
@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script>
@endpush
