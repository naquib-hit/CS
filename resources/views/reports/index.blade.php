@extends('layouts.app', ['title' => __('transaction.title')])

@section('css')
<style>
    :root {
        --fas-custom-size: .85rem;
    }
    .font-reset {
        font-size: var(--fas-custom-size) !important;
    }

    .input-group.input-group-static.is-focused .form-label, 
    .input-group.input-group-static.is-filled.is-focused .form-label, 
    .input-group.input-group-static.is-filled .form-label {
        position: relative;
        top: 0 !important;
        font-size: .875rem !important;
    }

</style>

<link href="{{ asset('vendor/flatpickr/dist/flatpickr.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('vendor/sweetalert2/dist/sweetalert2.min.css') }}"/>

@endsection

@section('content')
<div class="row h-100">
    <div class="col-4">
        <div class="card h-100">
            <form class="card-body" name="form-search">
                <p class="fs-5 text-decoration-underline">{{ __('transaction.fields.title') }}</p>
                <div class="row">
                    <p class="fs-6 mb-1">{{ __('transaction.fields.filtered_by') }}</p>
                    <div class="col-12">
                        <div class="form-check mb-1">
                            <input type="radio" name="selected_by" class="form-check-input" value="product" checked>
                            <label class="form-check-label mb-1">{{ __('product.title') }}</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="selected_by" class="form-check-input" value="customer">
                            <label class="form-check-label">{{ __('customer.title') }}</label>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <p class="mb-1">Periode</p>
                    <div class="col-5 pe-1">
                        <div class="input-group input-group-outline is-filled">
                            <label class="form-label">Dari</label>
                            <input type="text" class="form-control" name="periode_from">
                        </div>
                    </div>
                    <div class="d-none d-lg-flex col-2 justify-content-center align-items-center px-0 mx-0">-</div>
                    <div class="col-5 ps-1">
                        <div class="input-group input-group-outline is-filled">
                            <label class="form-label">Sampai</label>
                            <input type="text" class="form-control" name="periode_to">
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12 d-flex flex-nowrap justify-content-end pt-3">
                        <button type="reset" class="btn btn-secondary me-1"><i class="fas fa-undo"></i> {{ __('transaction.button.reset') }} </button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ __('transaction.button.generate') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="col-8">
        <div class="card px-0">
            <div class="card-body px-0">
                <div id="download-row" class="row px-3 d-none">
                    <div class="col-12">
                        <div class="dropdown">
                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-download font-reset"></i>
                                {{ __('transaction.button.download') }}
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" role="button" id="to_pdf" href="javascript:void(0);">PDF</a></li>
                                <li><a class="dropdown-item" role="button" href="javascript:void(0);">Excel</a></li>
                                <li><a class="dropdown-item" role="button" href="javascript:void(0);">CSV</a></li>
                              </ul>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="tbl-main" class="table table-striped">
                        <thead></thead>
                        <tbody></tbody>
                    </table>
                    <div id="loading-table" class="position-absolute top-50 start-50 translate-middle bg-white opacity-10 z-3 rounded shadow d-none" style="height: 6rem;width: 12rem">
                        <div class="w-100 h-100 d-flex flex-nowrap justify-content-center align-items-center">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 pe-4 mt-2 d-flex flex-nowrap justify-content-end align-items-center">
                        <a type="button" href="javascript:void(0);" class="btn btn-sm btn-primary mb-0 btn-circle" id="previous-page">
                            <i class="fas fa-arrow-left font-reset"></i>
                        </a>
                        <div class="px-2 d-flex flex-nowrap align-items-baseline">
                            <span id="page_no"></span>
                            <span>/</span>
                            <span id="total_pages"></span>
                        </div>
                        <a type="button" href="javascript:void(0);" class="btn btn-sm btn-primary mb-0 btn-circle" id="next-page">
                            <i class="fas fa-arrow-right font-reset"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('vendor/flatpickr/dist/flatpickr.min.js') }}"></script>
<script src="{{ asset('vendor/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>

@if(session()->has('success'))
<script>
    Swal.fire({
        title: '<h4 class="text-success">SUCCESS</h4>',
        html: '<h5 class="text-success">{{ session('success') }}</h5>',
        icon: 'success',
        timer: 1200,
        timerProgressBar: true,
        showConfirmButton: false
    })
</script>
@endif

@if(session()->has('error'))
<script>
    Swal.fire({
        title: '<h4 class="text-danger">Error</h4>',
        html:  '<h6 class="text-danger">{{ session('error') }}</h6>',
        icon: 'error',
        timer: 1500
    });

</script>
@endif

<script src="{{ asset('js/pages/report.js') }}"></script>
@endsection