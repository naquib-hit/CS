@extends('layouts.app')

@section('content')
<div class="row h-100">
    <div class="col-12 col-lg-8">
        <div class="card h-100">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">{{ __('product.title') }}</h6>
                </div>
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
<script src="{{ asset('js/products.js') }}"></script>
@endsection