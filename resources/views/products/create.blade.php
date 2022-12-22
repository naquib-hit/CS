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
            <div class="card fadeIn3 fadeInBottom">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                      <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">{{ __('product.form.title') }}</h4>
                    </div>
                  </div>
                <div class="card-body">
                    <form action="{{ url('products') }}" class="d-flex flex-column" method="post">
                        @csrf
                        <span class="input-group input-group-outline">
                            <label class="form-label">{{ __('product.form.fields.name') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('product_name') is-invalid @enderror" name="product_name"/>
                        </span>
                        @error('product_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <span class="input-group input-group-outline mt-4">
                            <label class="form-label">{{ __('product.form.fields.price') }} <span class="text-danger">*</span></label>
                            <input type="number" min="0" class="form-control @error('product_name') is-invalid @enderror" name="product_price"/>
                        </span>
                        @error('product_price')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <span class="d-flex flex-nowrap mt-5 w-100">
                            <a href="{{ route('products.index') }}"  class="btn btn-primary p-0 btn-circle">
                                <i class="fas fa-hand-point-left font-reset"></i>
                            </a>
                            <span class="ms-auto">
                            <button type="submit" class="btn btn-secondary"><i class="fas fa-redo"></i>&nbsp;{{ __('template.form.reset') }}</button>
                            <button type="submit" class="btn btn-primary ms-1"><i class="fas fa-save"></i>&nbsp;{{ __('template.form.save') }}</button>
                            </span>
                        </span>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection