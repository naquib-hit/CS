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
@endsection

@section('content')
<div class="row h-100">
    <div class="col-4">
        <div class="card h-100">
            <div class="card-body">
                <p class="fs-5 text-decoration-underline">{{ __('transaction.fields.title') }}</p>
                <div class="row">
                    <div class="col-12">
                        <div class="input-group input-group-static">
                            <label class="form-label">{{ __('transaction.fields.filtered_by') }}</label>
                            <select class="form-control">
                                <option value="product">{{ __('product.title') }}</option>
                                <option value="">{{ __('product.title') }}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-8"></div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/pages/transaction.js') }}"></script>
@endsection