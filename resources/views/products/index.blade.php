@extends('layouts.app', ['title' => __('product.title')])

@section('css')
<style>
    :root {
        --fas-custom-size: .85rem;
    }
    .font-reset {
        font-size: var(--fas-custom-size) !important;
    }
</style>
<link rel="stylesheet" href="{{ asset('vendor/sweetalert2/dist/sweetalert2.min.css') }}"/>
@endsection

@section('content')
<div class="row h-100">
    <div class="col-12 col-lg-8">
        <div class="card h-100">
            <div class="card-body mx-0 px-0 h-100">
                <div class="row ">
                    <div class="col-12 px-4">
                        <div class="btn-group btn-group-sm btn-group-primary">
                            <a href="{{ route('products.create') }}" class="btn btn-primary">
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
                    <table id="tbl-product" class="table rounded-lg">
                        <thead class="border-bottom bg-warning text-white">
                            <tr>
                                <th class="ps-1">
                                    <div class="form-check">
                                        <input type="checkbox" name="check-all" id="check-all" class="form-check-input"/>
                                        <label class="form-check-label"></label>
                                    </div>
                                </th>
                                <th class="d-none">ID</th>
                                <th class="ps-1">{{__('product.table.name')}}</th>
                                <th class="ps-1">{{__("product.table.price")}}</th>
                                <th class="ps-1">{{__("product.table.option")}}</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="row px-4 position-absolute bottom-0 w-100">
                    <div class="col-12 d-flex flex-nowrap justify-content-end align-items-center">
                        <span class="d-flex flex-nowrap">
                            <button type="button" class="btn btn-sm btn-primary btn-circle">
                                <i class="fas fa-arrow-left font-reset"></i>
                            </button>
                            <span></span>
                            <button type="button" class="btn btn-sm btn-primary btn-circle">
                                <i class="fas fa-arrow-right font-reset"></i>
                            </button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-4">

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

<script src="{{ asset('js/pages/product.js') }}"></script>
@endsection