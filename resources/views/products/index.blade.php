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
@endsection

@section('content')
<div class="row h-100">
    <div class="col-12 col-lg-8">
        <div class="card h-100">
            <div class="card-body mx-0 px-0 h-100">
                <div class="row ">
                    <div class="col-12 px-4">
                        <div class="btn-group btn-group-sm btn-group-primary">
                            <button type="button" class="btn btn-primary">
                                <i class="fas fa-plus-circle font-reset"></i>&nbsp;
                                {{__('template.add')}}
                            </button>
                            <button type="button" class="btn btn-primary">
                                <i class="fas fa-trash font-reset"></i>&nbsp;
                                {{__('template.delete_all')}}
                            </button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="tbl-product" class="table table-striped rounded-lg">
                        <thead>
                            <tr>
                                <th>{{__('product.table.name')}}</th>
                                <th>{{__("product.table.price")}}</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                            <td>

                            </td>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-4">

    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/pages/product.js') }}"></script>
@endsection