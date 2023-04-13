@extends('layouts.app')

@section('title', 'Penilaian Mutu')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet"
        href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/selectric/public/selectric.css') }}">
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
                <select name="unit_id" id="unit_id" class="@error('unit_id') is-invalid @enderror" style="width: 15%; border: none; border-color: transparent; background: transparent;">
                    <option value="">....</option>
                    {{-- @foreach ($unitList as $item)
                    <option value="{{ $item->id }}">{{ $item->unit }}</option>
                    @endforeach --}}
                </select>
            </h2>
            <p class="section-lead">
                Periode :
                <input type="month" style="border: none; border-color: transparent; background: transparent;" id="bulan" name="bulan">
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
                            <table class="table table-striped">
                                <tr>
                                    <th class="col-sm-1">No</th>
                                    <th>Indikator</th>
                                    <th>Jenis</th>
                                    <th>Standar</th>
                                    @php
                                        $start_date = new DateTime('2023-03-01');
                                        $end_date = new DateTime('2023-04-01');
                                        $interval = DateInterval::createFromDateString('1 day');
                                        $period = new DatePeriod($start_date, $interval, $end_date);
                                    @endphp
                                    @foreach ($period as $date)
                                    <th>{{ $date->format('d') }}</th>
                                    @endforeach
                                </tr>
                                {{-- @forelse ($penilaianList as $data)
                                <tr>
                                    <td class="col-sm-1">{{ $loop->iteration }}</td>
                                    <td>{{ $data->indikator }}</td>
                                    <td>{{ $data->jenis_indikator }}</td>
                                    <td>{{ $data->nilai_standar }}{{ $data->satuan_pengukuran }}</td>
                                    @foreach ($data->hasil as $item)
                                        <td>{{ $item }}</td>
                                    @endforeach
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="bg-danger text-center text-white">No Data Found</td>
                                </tr>
                                @endforelse --}}

                            </table>
                        </div>
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
    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script>

    <script>
        document.getElementById('my-button').addEventListener('click', function() {
        // Get the data you want to send to the controller
            var myData = { name: 'John', email: 'john@example.com' };
            console.log(myData);
            // Send an AJAX request to the controller
            $.ajax({
                type: 'POST',
                url: 'penilaian.myMethod',
                data: myData,
                success: function(response) {
                    // Tangani respons dari kontroler
                }
            });
        });
    </script>
@endpush
