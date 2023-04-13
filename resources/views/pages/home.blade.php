@extends('layouts.app')

@section('title', 'Home')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Homepage</h1>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="far fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Unit</h4>
                        </div>
                        <div class="card-body" id="totalUnit">
                            <span id="unit"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="far fa-newspaper"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Indikator</h4>
                        </div>
                        <div class="card-body">
                            <span id="indikator"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="far fa-file"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Sensus Penilaian</h4>
                        </div>
                        <div class="card-body">
                            <span id="reports"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-body">
        </div>
    </section>
</div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script type="text/javascript">
        $(document).ready(function() {
          // Make an AJAX request to your server
            console.log("TESS");

            nilai();
        });

        function nilai(){

            $.ajax({
            url: "/homes", // Replace with your data URL
            type: "GET",
            dataType: "json",
            success: function(data) {
                console.log(data);
                $('#unit').html(data.unit)
                $('#indikator').html(data.indikator)
                $('#reports').html(data.sensus)
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // Handle error response from server
            }
            });
        }
    </script>
    <!-- Page Specific JS File -->
@endpush
