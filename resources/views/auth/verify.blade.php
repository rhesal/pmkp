@extends('layouts.auth')

@section('title', 'Verify E-Mail')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet"
        href="{{ asset('library/bootstrap-social/bootstrap-social.css') }}">
@endpush

@section('main')
    <div class="card card-primary">
        <div class="card-header">
            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 font-medium text-sm text-green-600">
                    <h4>A new email verification link has been emailed to you!</h4>
                </div>               
            @else
                <div class="mb-4 font-medium text-sm text-green-600">
                    <h4>A new email verification link has been emailed to you!!!</h4>
                </div> 
            @endif
        </div>

        <div class="card-body">      
            <form method="POST" action="{{ route('verification.send') }}" class="needs-validation" novalidate="">
                @csrf  
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                        Resend Verification Email
                    </button>
                </div>
            </form>  
        </div>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->

    <!-- Page Specific JS File -->
@endpush
