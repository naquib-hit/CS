@extends('layouts.app', ['title' => __('project.title')])

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
                            <a href="{{ route('projects.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus-circle font-reset"></i>&nbsp;
                                {{__('template.toolbar.add')}}
                            </a>
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
                                <th class="ps-1">{{__('project.table.name')}}</th>
                                <th class="d-none">CUstomer ID</th>
                                <th class="ps-1">{{__("project.table.customer")}}</th>
                                <th class="ps-1">{{__("project.table.option")}}</th>
                            </tr>
                        </thead>
                        <tbody>
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
                        <label class="form-label">{{ __('project.filter.fields.name') }} </label>
                        <input type="text" class="form-control" name="s_project_name" value="{{ old('s_project_name') }}" />
                    </span>
                    <span class="input-group input-group-dynamic mt-3">
                        <label class="form-label">{{ __('project.filter.fields.customer') }} </label>
                        <input type="text" class="form-control" name="s_project_customer" value="{{ old('s_project_customer') }}" />
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

<script src="{{ asset('js/pages/project.min.js') }}"></script>
@endsection