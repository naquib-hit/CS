@extends('layouts.app', ['title' => __('sales.title')])

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
    
    <div class="row h-100 justify-content-center align-items-center">
        <div class="col-12 col-md-8 col-lg-5">
            <div class="card fadeIn3 fadeInBottom">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                      <h4 class="text-white font-weight-bolder text-center my-0">{{ __('sales.form.title') }}</h4>
                    </div>
                  </div>
                <div class="card-body">
                    <form action="{{ route('sales.update', $sale) }}" class="d-flex flex-column" method="post">
                        @csrf
                        @method('PUT')
                        <span class="input-group input-group-outline @error('sales_code') is-invalid @enderror">
                            <label class="form-label">{{ __('sales.form.fields.code') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="sales_code" value="{{ old('sales_code') ?? $sale->sales_code }}" @error('sales_code') autofocus @enderror/>
                        </span>
                        <span class="input-group input-group-outline mt-3 @error('sales_name') is-invalid @enderror">
                            <label class="form-label">{{ __('sales.form.fields.name') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="sales_name" value="{{ old('sales_name') ?? $sale->sales_name }}" @error('sales_name') autofocus @enderror/>
                        </span>
                        @error('sales_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <span class="input-group input-group-outline @error('sales_email') is-invalid @enderror mt-3">
                            <label class="form-label">{{ __('sales.form.fields.email') }} <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="sales_email" value="{{ old('sales_email') ?? $sale->sales_email }}" @error('sales_email') autofocus @enderror/>
                        </span>
                        @error('sales_email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                       
                        <span class="d-flex flex-nowrap mt-5 w-100">
                            <a href="{{ route('sales.index') }}"  class="btn btn-primary p-0 btn-circle">
                                <i class="fas fa-hand-point-left font-reset"></i>
                            </a>
                            <span class="ms-auto">
                            <button type="reset" class="btn btn-secondary"><i class="fas fa-redo"></i>&nbsp;{{ __('template.form.reset') }}</button>
                            <button type="submit" id="btn-submit" class="btn btn-primary ms-1"><i class="fas fa-save"></i>&nbsp;{{ __('template.form.save') }}</button>
                            </span>
                        </span>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script src="{{ asset('vendor/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>

<script>

    @if(session()->has('error'))
        Swal.fire({
            title: `<h4 class="text-danger">Error</h4>`,
            html: '<h6 class="text-danger">{{ session('error') }}</h6>',
            icon: 'error',
            timer: 1800
        });
    @endif

    const loading = () => {
        Swal.fire({
            html: 	'<div class="d-flex flex-column align-items-center">'
            + '<span class="spinner-border text-primary"></span>'
            + '<h3 class="mt-2">Loading...</h3>'
            + '<div>',
            showConfirmButton: false,
            width: '14rem'
        });
    }

    document.getElementById('btn-submit').addEventListener('click', e => {
        loading();
    });
</script>
@endsection