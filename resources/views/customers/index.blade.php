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
            <div class="card-body position-relative mx-0 px-0 pt-3 pb-0 h-100">
                <div class="row ">
                    <div class="col-12 px-4">
                        <div class="btn-group btn-group-sm btn-group-primary">
                            <a href="{{ route('customers.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus-circle font-reset"></i>&nbsp;
                                {{__('template.toolbar.add')}}
                            </a>
                            <div class="btn-group btn-group-sm btn-group-primary">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                                    <i class="fas fa-download font-reset"></i> Download
                                </button>
                                <div class="dropdown-menu">
                                    <a role="button" class="dropdown-item" href="{{ asset('files/download/customer_template.xlsx') }}" download>Unduh berkas excel</a>
                                    <a role="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-import">Unggah data dari excel</a>
                                </div>
                            </div>
                           
                            <button type="button" class="btn btn-primary" id="delete-all">
                                <i class="fas fa-trash font-reset"></i>&nbsp;
                                {{__('template.toolbar.delete_all')}}
                            </button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive position-relative">
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
                        <tbody>
                            {{-- @foreach ($customers as $customer)
                            <tr data-id="{{ $customer->id}}">
                                <td class="ps-1">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input check-row" id="row_{{ $customer->id }}" name="row[]" value="{{ $customer->id }}">
                                        <label for="row_{{ $customer->id }}" class="form-check-label"></label>
                                    </div>
                                </td>
                                <td data-name="id" class="d-none">{{ $customer->id }}</td>
                                <td data-name="customer_name" class="ps-1">{{ $customer->customer_name }}</td>
                                <td data-name="customer_email" class="ps-1">{{ $customer->customer_email }}</td>
                                <td data-name="customer_phone" class="ps-1">{{ $customer->customer_phone}}</td>
                                <td class="ps-1">
                                    <span class="d-flex flex-nowrap flex-grow-0 align-items-center">
                                        <a type="button" class="btn btn-sm btn-info btn-circle p-0 m-0 edit_data" data-bs-toggle="tooltip" data-bs-title="Edit" href="{{ route('customers.edit', ['customer' => $customer]) }}">
                                            <i class="fas fa-edit font-reset"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger btn-circle p-0 m-0 ms-1 delete_data" data-bs-toggle="tooltip" data-bs-title="Delete" onclick="deleteConfirmation(event)">
                                            <i class="fas fa-trash font-reset"></i>
                                        </button>
                                    </span>
                                </td>
                            </tr>
                            @endforeach --}}
                        </tbody>
                    </table>
                    <div id="loading-table" class="position-absolute top-50 start-50 translate-middle bg-white opacity-10 z-3 rounded shadow d-none" style="height: 6rem;width: 12rem">
                        <div class="w-100 h-100 d-flex flex-nowrap justify-content-center align-items-center">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row px-4 py-1 position-relative bottom-0 w-100">
                    <div class="col-12 d-flex flex-nowrap justify-content-end align-items-center">
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
    <div class="col-12 col-lg-4 offcanvas-sm offcanvas-end" id="filter-panel">
        <button type="button" class="btn-close btn-close-white d-lg-none mt-1 mt-lg-0" data-bs-dismiss="offcanvas" data-bs-target="#filter-panel" aria-label="Close"></button>
        <div class="card mt-4 mt-lg-0">
            <div class="card-header mb-1 py-2">
                <h4 class="mb-0">Filter</h4>
            </div>
            <div class="card-body">
                <form name="search-form">
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
        
    </div>
</div>

<div id="modal-import" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white mb-0">Unggah Berkas Excel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="modal-body" method="POST" name="form-import" action="{{ route('customers.import') }}" enctype="multipart/form-data">
                @csrf
                <ul>
                    <li>upload maksimal 4000</li>
                </ul>
                <div class="input-group">
                    <input type="file" name="file-import" class="form-control form-control-sm" id="file-import">
                </div>
                <div class="mt-4 pt-2 border-top w-100 d-flex justify-content-end flex-nowrap">
                    <button type="reset" class="btn btn-sm btn-secondary"><i class="fas fa-redo"></i>&nbsp;{{ __('template.form.reset') }}</button>
                    <button type="submit" id="btn-submit" class="btn btn-sm btn-primary ms-1"><i class="fas fa-save"></i>&nbsp;{{ __('template.form.save') }}</button>
                </div>
            </form>

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

<script src="{{ asset('js/pages/customer.js') }}"></script>
@endsection