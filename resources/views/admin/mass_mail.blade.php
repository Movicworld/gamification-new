@extends('layouts.main.master')
@section('style')
<script src="https://cdn.tiny.cloud/1/d8iwvjd0vuxf9luaztf5x2ejuhnudtkzhxtnbh3gjjrgw4yx/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
@endsection

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Mass Communication</h1>
            <nav class="flex-shrink-0 my-2 my-sm-0 ms-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Mass</li>
                    <li class="breadcrumb-item active" aria-current="page">Communication</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="content">
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Send Broadcast Message</h3>
        </div>
        <div class="block-content">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('send.mass.communication') }}" method="POST" id="massCommForm">
                @csrf

                <!-- Audience Filters -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label>Audience Type</label>
                        <select class="form-control filter-input" name="type" required>
                            <option value="registered">All Registered Users</option>
                            <option value="verified">Account Verified Users</option>
                            <option value="email_verified">Email Verified Users</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>Date Range</label>
                        <select class="form-control filter-input" name="days">
                            <option value="">All Time</option>
                            <option value="7">Last 7 Days</option>
                            <option value="14">Last 14 Days</option>
                            <option value="30">Last 30 Days</option>
                            <option value="60">Last 60 Days</option>
                            <option value="90">Last 90 Days</option>
                            <option value="180">Last 180 Days</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>Country</label>
                        <select class="form-control filter-input" name="country">
                            <option value="">All Countries</option>
                            @foreach($countries as $country)
                                <option value="{{ $country }}">{{ $country }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Preview Section -->
                <div class="alert alert-info mb-4" id="previewSection">
                    <strong>Audience Preview:</strong>
                    <div id="previewContent" class="mt-2">
                        <span class="text-muted">Loading...</span>
                    </div>
                </div>

                <!-- Communication Type -->
                <div class="mb-4">
                    <label>Send Via</label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="send_email" id="sendEmail" value="1" checked>
                            <label class="form-check-label" for="sendEmail">Email</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="send_sms" id="sendSMS" value="1">
                            <label class="form-check-label" for="sendSMS">SMS</label>
                        </div>
                    </div>
                </div>

                <!-- Email Fields -->
                <div id="emailFields">
                    <div class="mb-4">
                        <label>Email Subject</label>
                        <input type="text" class="form-control" name="subject" value="{{ old('subject') }}">
                    </div>
                    <div class="mb-4">
                        <label>Email Message</label>
                        <textarea id="js-ckeditor5-classic" name="message">{{ old('message') }}</textarea>
                    </div>
                </div>

                <!-- SMS Fields -->
                <div id="smsFields" style="display:none;">
                    <div class="mb-4">
                        <label>SMS Message <small class="text-muted">(160 chars recommended)</small></label>
                        <textarea class="form-control" name="sms_message" rows="3" maxlength="500">{{ old('sms_message') }}</textarea>
                    </div>
                </div>

                <button class="btn btn-primary" type="submit">
                    <i class="fa fa-paper-plane"></i> Send Communication
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('src/assets/js/plugins/ckeditor5-classic/build/ckeditor.js')}}"></script>
<script src="{{asset('src/assets/js/plugins/ckeditor/ckeditor.js')}}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>Dashmix.helpersOnLoad(['js-ckeditor5']);</script>

<script>
$(document).ready(function() {
    // Update preview when filters change
    $('.filter-input').on('change', updatePreview);

    // Toggle email/sms fields
    $('#sendEmail, #sendSMS').on('change', function() {
        $('#emailFields').toggle($('#sendEmail').is(':checked'));
        $('#smsFields').toggle($('#sendSMS').is(':checked'));
    });

    function updatePreview() {
        $.ajax({
            url: '{{ route("preview.audience") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                type: $('select[name="type"]').val(),
                days: $('select[name="days"]').val(),
                country: $('select[name="country"]').val()
            },
            success: function(data) {
                $('#previewContent').html(`
                    <strong>${data.total}</strong> total users<br>
                    <strong>${data.with_email}</strong> with email<br>
                    <strong>${data.with_phone}</strong> with phone
                `);
                $('#previewSection').show();
            }
        });
    }

    // Initial preview
    updatePreview();
});
</script>
@endsection
