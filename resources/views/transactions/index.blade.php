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
                        <a role="button" class="btn btn-primary btn-sm">
                            <i class="fas fa-sync font-reset"></i>               
                            &nbsp;{{__('Refresh')}}
                        </a>
                        <a role="button" class="btn btn-primary btn-sm">
                            <i class="fas fa-sync font-reset"></i>
                            &nbsp;{{__('Refresh')}}
                        </a>
                    </div>
                </div>
                <div class="table-responsive">
                    
                    <table id="tbl-main" class="table table-striped">
                        <thead class="bg-danger text-white">
                            <tr>
                                <th class="d-none">ID</th>
                                <th>{{ __('transaction.table.code') }}</th>
                                <th class="d-none">Customer ID</th>
                                <th>{{ __('transaction.table.customer') }}</th>
                                <th class="d-none">product ID</th>
                                <th>{{ __('transaction.table.product') }}</th>
                                <th class="d-none"></th>
                                <th>{{ __('transaction.table.sales') }}</th>
                                <th>{{ __('transaction.table.start_date') }}</th>
                                <th>{{ __('transaction.table.expiration_date') }}</th>
                                <th>{{ __('transaction.table.opt') }}</th>
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
@endsection

@section('js')
<script src="{{ asset('js/pages/transaction.js') }}"></script>
@endsection