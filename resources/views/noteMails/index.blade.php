@extends('layouts.app', ['title' => __('project.title')])

@section('css')
<link rel="stylesheet" href="{{ asset('vendor/sweetalert2/dist/sweetalert2.min.css') }}"/>
<link rel="stylesheet" href="{{ asset('vendor/quill/quill.snow.css') }}"/>
<link rel="stylesheet" href="{{ asset('vendor/flatpickr/dist/flatpickr.min.css') }}"/>
@endsection

@section('content')
<div class="row h-100">
    <div class="col-4">
        <div class="table-reponsive"></div>
    </div>
    <div class="col-8">
        <form class="card">
            <fieldset class="card-header">
                Notifikasi
            </fieldset>
            <fieldset class="card-body">
                <div class="input-group input-group-dynamic">
                    <label class="form-label">{{ __('Subjek') }}</label>
                    <input type="text" class="form-control font-weight-light" name="notice-name">
                </div>
                <div class="input-group input-group-dynamic mt-4">
                    <label class="form-label">{{ __('Proyek') }}</label>
                    <input type="text" class="form-control font-weight-light" name="notice-project">
                </div>
                <div class="mt-4">
                    <label class="form-label">{{ __('Isi') }}</label>
                    <textarea type="text" class="form-control font-weight-light" name="notice-content" rows="5"></textarea>
                </div>
            </fieldset>
            <fieldset class="card-footer"></fieldset>
        </form>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('vendor/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('vendor/quill/quill.min.js') }}"></script>
<script src="{{ asset('vendor/flatpickr/dist/flatpickr.min.js') }}"></script>
<script src="{{ asset('js/pages/notification.js') }}"></script>

@endsection