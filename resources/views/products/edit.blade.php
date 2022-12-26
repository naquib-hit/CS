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
    
    <div class="row h-100 justify-content-center align-items-center">
        <div class="col-12 col-md-8 col-lg-5">
            @if(session()->has('error'))
            <div class="alert alert-danger">
                <h4>{{ session('error') }}</h4>
            </div>
            @endif
            <div class="card fadeIn3 fadeInBottom">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                      <h4 class="text-white font-weight-bolder text-center my-0">{{ __('product.form.title') }}</h4>
                    </div>
                  </div>
                <div class="card-body">
                    <form action="{{ route('products.update', ['product' => $product]) }}" class="d-flex flex-column" method="post">
                        @csrf
                        @method('PUT')
                        <span class="input-group input-group-outline @error('product_name') is-invalid @enderror">
                            <label class="form-label">{{ __('product.form.fields.name') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="product_name" value="{{ old('product_name') ?? $product->product_name }}" placeholder=" "/>
                        </span>
                        @error('product_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <span class="input-group input-group-outline @error('product_price') is-invalid @enderror mt-4">
                            <label class="form-label">{{ __('product.form.fields.price') }} <span class="text-danger">*</span></label>
                            <input type="number" min="0" step="0.01" class="form-control" name="product_price" value="{{ old('product_price') ?? $product->product_price }}" placeholder=" "/>
                        </span>
                        @error('product_price')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <span class="d-flex flex-nowrap mt-5 w-100">
                            <a href="{{ route('products.index') }}"  class="btn btn-primary p-0 btn-circle">
                                <i class="fas fa-hand-point-left font-reset"></i>
                            </a>
                            <span class="ms-auto">
                            <button type="reset" class="btn btn-secondary"><i class="fas fa-redo"></i>&nbsp;{{ __('template.form.reset') }}</button>
                            <button type="submit" class="btn btn-primary ms-1"><i class="fas fa-save"></i>&nbsp;{{ __('template.form.save') }}</button>
                            </span>
                        </span>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection