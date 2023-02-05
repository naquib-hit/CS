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
                            <input type="radio" name="selected_by" class="form-check-input" value="product">
                            <label class="form-check-label mb-1">{{ __('product.title') }}</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="selected_by" class="form-check-input" value="product">
                            <label class="form-check-label">{{ __('customer.title') }}</label>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <p class="mb-1">Periode</p>
                    <div class="col-5">
                        <div class="input-group input-group-outline">
                            <label class="form-label">Dari</label>
                            <input type="text" class="form-control" name="periode_from">
                        </div>
                    </div>
                    <div class="d-none d-lg-flex col-2 justify-content-center align-items-center">-</div>
                    <div class="col-5">
                        <div class="input-group input-group-outline">
                            <label class="form-label">Sampai</label>
                            <input type="text" class="form-control" name="periode_to">
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12 d-flex flex-nowrap justify-content-end pt-3">
                        <button type="reset" class="btn btn-secondary me-1"><i class="fas fa-undo"></i> {{ __('template.form.reset') }} </button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ __('template.form.save') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="col-8">
        <div class="card px-0">
            <div class="card-body px-0">
                <div class="table-responsive">
                    <table id="tbl-main" class="table table-sm">
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
                    <div class="col-12 px-3 mt-2 d-flex flex-nowrap justify-content-end align-items-center">
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
<script src="{{ asset('js/pages/report.js') }}"></script>
@endsection