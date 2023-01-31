@extends('layouts.app', ['title' => __('transaction.title')])

@section('css')
<style>
    :root {
        --fas-custom-size: .85rem;
    }
    .font-reset {
        font-size: var(--fas-custom-size) !important;
    }
</style>
@endsection

@section('content')
<div class="row h-100">
    <div class="col-12">

        <div class="card h-100">
            <div class="card-body px-0 h-100">
                <div class="px-3">
                    <div class='btn-group'>
                        <a role="button" class="btn btn-primary btn-sm" href="{{ route('invoices.create') }}">
                            <i class="fas fa-plus-circle font-reset"></i>               
                            &nbsp;{{__('template.toolbar.add')}}
                        </a>
                        <a role="button" class="btn btn-primary btn-sm" href="#filter-offcanvas" data-bs-toggle="offcanvas">
                            <i class="fas fa-search font-reset"></i>
                            &nbsp;{{__('template.toolbar.filter')}}
                        </a>
                        <a role="button" class="btn btn-primary btn-sm">
                            <i class="fas fa-download font-reset"></i>
                            &nbsp;{{__('template.toolbar.download')}}
                        </a>
                    </div>
                </div>
                <div class="table-responsive">
                    
                    <table id="tbl-main" class="table table-striped">
                        <thead class="bg-danger text-white">
                            <tr>
                                <th class="d-none">ID</th>
                                <th>{{ __('invoice.table.invoice_no') }}</th>
                                <th class="d-none">Customer ID</th>
                                <th>{{ __('invoice.table.customer') }}</th>
                                <th>{{ __('invoice.table.email_status') }}</th>
                                <th>{{ __('Products') }}</th>
                                <th>{{ __('invoice.table.opt') }}</th>
                            </tr>
                        </thead>
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

<div id="filter-offcanvas" class="offcanvas offcanvas-end">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">{{ __('template.toolbar.filter') }}</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form name="form-search">
            <span class="input-group input-group-dynamic">
                <label class="form-label">{{ __('transaction.fields.code') }} </label>
                <input type="text" class="form-control" name="trans_code" value="{{ old('trans_code') }}" />
            </span>
            <span class="input-group input-group-dynamic mt-3">
                <label class="form-label">{{ __('transaction.fields.customer') }} </label>
                <input type="text" class="form-control" name="trans_customer" value="{{ old('trans_customer') }}" />
            </span>
            <span class="input-group input-group-dynamic mt-3">
                <label class="form-label">{{ __('transaction.fields.product') }} </label>
                <input type="text" class="form-control" name="trans_product" value="{{ old('trans_product') }}" />
            </span>
            <span class="input-group input-group-dynamic mt-3">
                <label class="form-label">{{ __('transaction.fields.sales') }} </label>
                <input type="text" class="form-control" name="trans_sales" value="{{ old('trans_sales') }}" />
            </span>
            <span class="mt-5 d-flex flex-nowrap justify-content-end w-100 ps-3">
                <button type="reset" class="btn btn-secondary" id="reset-search">
                    <i class="fas fa-redo"></i>
                    {{ __('template.form.reset') }}
                </button>
                <button type="submit" class="btn btn-primary ms-1" id="btn-search">
                    <i class="fas fa-search"></i>
                    {{ __('template.form.search') }} 
                </button>
            </span>
        </form>
    </div>
</div>
@endsection

@section('js')
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

<script src="{{ asset('js/pages/invoice.js') }}"></script>
@endsection