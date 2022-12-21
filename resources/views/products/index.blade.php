@extends('layouts.app', ['title' => __('product.title')])

@section('css')
<style>
    .btn-circle {
        height: 3em;
        width: 3em;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
    }
</style>
@endsection

@section('content')
<div class="row h-100">
    <div class="col-12 col-lg-8">
        <div class="card h-100">
            <div class="card-header pb-1">
                <button class="btn btn-sm p-0 btn-circle btn-primary">
                    <i class="fas fa-plus-circle fa-lg" style="font-size: 22px"></i>
                </button>
            </div>
            <div class="card-body mx-0 px-0 h-100">
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