@extends('layouts.app', ['title' => __('tax.title')])

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
                  <h4 class="text-white font-weight-bolder text-center my-0">{{ __('tax.form.title') }}</h4>
                </div>
              </div>
            <div class="card-body">
                <form name="form-input" action="{{ route('taxes.store') }}" class="d-flex flex-column" method="post">
                    @csrf
                    <span class="input-group input-group-outline @error('tax_name') is-invalid @enderror mt-3">
                        <label class="form-label">{{ __('tax.form.fields.name') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="tax_name" value="{{ old('tax_name') }}" @error('tax_name') autofocus @enderror/>
                    </span>
                    @error('tax_name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                    <span class="input-group input-group-outline @error('tax_amount') is-invalid @enderror mt-3">
                        <label class="form-label">{{ __('tax.form.fields.amount') }} <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="tax_amount" value="{{ old('tax_amount') }}" @error('tax_amount') autofocus @enderror/>
                    </span>
                    @error('tax_amount')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                  
                    <span class="d-flex flex-nowrap mt-5 w-100">
                        <a href="{{ route('taxes.index') }}"  class="btn btn-primary p-0 btn-circle">
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
     const form = document.forms['form-input'];

   
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
@endsection

