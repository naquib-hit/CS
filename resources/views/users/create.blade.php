@extends('layouts.app')

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
                  <h4 class="text-white font-weight-bolder text-center my-0">{{ __('FORM PENGGUNA') }}</h4>
                </div>
              </div>
            <div class="card-body">
                <form name="form-input" action="{{ route('users.store') }}" class="d-flex flex-column" method="post">
                    @csrf
                    <span class="input-group input-group-outline @error('username') is-invalid @enderror">
                        <label class="form-label">{{ __('Username') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="username" value="{{ old('username') }}" @error('username') autofocus @enderror/>
                    </span>
                    @error('username')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                    <span class="input-group input-group-outline @error('password') is-invalid @enderror mt-3">
                        <label class="form-label">{{ __('Password') }} <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="password" value="{{ old('password') }}" @error('password') autofocus @enderror/>
                    </span>
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                    <span class="input-group input-group-outline @error('password_confirm') is-invalid @enderror mt-3">
                        <label class="form-label">{{ __('Konfirmasi Password') }} <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}" @error('password_confirmation') autofocus @enderror/>
                    </span>
                    @error('password_confirm')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                    <span class="input-group input-group-outline @error('email') is-invalid @enderror mt-3">
                        <label class="form-label">{{ __('Email') }} <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}" @error('email') autofocus @enderror/>
                    </span>
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror

                    <span class="input-group input-group-outline @error('fullname') is-invalid @enderror mt-3">
                        <label class="form-label">{{ __('Nama') }}</label>
                        <input type="text" class="form-control" name="fullname" value="{{ old('fullname') }}" @error('fullname') autofocus @enderror/>
                    </span>
                    @error('fullname')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                   
                    <span class="d-flex flex-nowrap mt-5 w-100">
                        <a href="{{ route('users.index') }}"  class="btn btn-primary p-0 btn-circle">
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
    title: '<h4 class="text-danger">ERROR</h4>',
    html: '<h5 class="text-danger">{{ session('error') }}</h5>',
    icon: 'error',
    timer: 1800,
    timerProgressBar: true,
    showConfirmButton: false
});
@endif

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
</script>
@endsection

