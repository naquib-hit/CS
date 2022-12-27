@extends('layouts.app', ['title' => __('customer.title')])

@section('css')
<style>
    :root {
        --fas-custom-size: .85rem;
    }
    .font-reset {
        font-size: var(--fas-custom-size) !important;
    }

    .table tr th:first-child, 
    .table td:first-child,
    .table tr th:nth-child(2),
    .table td:nth-child(2) {
        position: sticky !important;
        z-index: 5 !important;
    }
</style>
<link rel="stylesheet" href="{{ asset('vendor/sweetalert2/dist/sweetalert2.min.css') }}"/>
@endsection

@section('content')
<div class="row h-100">
    <div class="col-12 col-lg-8">
        <div class="card h-100">
            <div class="card-body mx-0 px-0 pt-3 pb-0 h-100">
                <div class="row ">
                    <div class="col-12 px-4">
                        <div class="btn-group btn-group-sm btn-group-primary">
                            <a href="{{ route('customers.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus-circle font-reset"></i>&nbsp;
                                {{__('template.toolbar.add')}}
                            </a>
                            <button type="button" class="btn btn-primary">
                                <i class="fas fa-trash font-reset"></i>&nbsp;
                                {{__('template.toolbar.delete_all')}}
                            </button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="tbl-main" class="table rounded-lg">
                        <thead class="border-bottom bg-warning text-white">
                            <tr>
                                <th class="ps-1">
                                    <div class="form-check">
                                        <input type="checkbox" name="check-all" id="check-all" class="form-check-input"/>
                                        <label class="form-check-label"></label>
                                    </div>
                                </th>
                                <th class="d-none">ID</th>
                                <th class="ps-1">{{__('customer.table.name')}}</th>
                                <th class="ps-1">{{__("customer.table.email")}}</th>
                                <th class="ps-1">{{__("customer.table.phone")}}</th>
                                <th class="ps-1">{{__("customer.table.option")}}</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="row px-4 py-1 position-relative bottom-0 w-100">
                    <div class="col-12 d-flex flex-nowrap justify-content-end align-items-end">
                        <div class="d-flex flex-nowrap">
                            <button type="button" class="btn btn-sm btn-primary btn-circle" id="previous-page">
                                <i class="fas fa-arrow-left font-reset"></i>
                            </button>
                            <div class="px-1">

                            </div>
                            <button type="button" class="btn btn-sm btn-primary btn-circle" id="next-page">
                                <i class="fas fa-arrow-right font-reset"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-4">
        <div class="card">
            <div class="card-header mb-1 py-2">
                <h4 class="mb-0">Filter</h4>
            </div>
            <div class="card-body">
                <span class="input-group input-group-dynamic">
                    <label class="form-label">{{ __('customer.filter.fields.name') }} </label>
                    <input type="text" class="form-control" name="s_customer_name" value="{{ old('s_customer_name') }}" />
                </span>
                <span class="input-group input-group-dynamic mt-3">
                    <label class="form-label">{{ __('customer.filter.fields.email') }} </label>
                    <input type="text" class="form-control" name="s_customer_email" value="{{ old('s_customer_email') }}" />
                </span>
                <span class="input-group input-group-dynamic mt-3">
                    <label class="form-label">{{ __('customer.filter.fields.phone') }} </label>
                    <input type="text" class="form-control" name="s_customer_phone" value="{{ old('s_customer_phone') }}" />
                </span>
                
                </div>
                
                <span class="mt-5 d-flex flex-nowrap justify-content-end w-100 px-3">
                    <button type="button" class="btn btn-secondary" id="reset-search">
                        <i class="fas fa-redo"></i>
                        {{ __('template.form.reset') }}
                    </button>
                    <button type="button" class="btn btn-primary ms-1" id="btn-search">
                        <i class="fas fa-search"></i>
                        {{ __('template.form.search') }} 
                    </button>
                </span>
               
            </div>           
        </div>
        
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

<script src="{{ asset('js/pages/customer.js') }}"></script>
@endsection