@extends('layouts.app')

@section('css')

@endsection

@section('content')
<div class="row h-100">
    <div class="col-12 col-md-8 col-lg-6 d-flex justify-content-center align-items-center">

        <div class="card fadeIn3 fadeInBottom">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                  <h4 class="text-white font-weight-bolder text-center my-0">{{ __('companyProfile.title') }}</h4>
                </div>
            </div>
            <div class="card-body">
                <form name="form-input" action="{{ route('companys.store') }}" class="d-flex flex-column" method="post">
                    @csrf
                    <span class="input-group input-group-outline @error('company_name') is-invalid @enderror">
                        <label class="form-label">{{ __('company.name') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="company_name" value="{{ old('company_name') }}" @error('company_name') autofocus @enderror/>
                    </span>
                    @error('company_name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                    <span class="input-group input-group-outline @error('company_email') is-invalid @enderror mt-4">
                        <label class="form-label">{{ __('company.email') }} <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="company_email" value="{{ old('company_email') }}" @error('company_email') autofocus @enderror/>
                    </span>
                    @error('company_email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                    <span class="input-group input-group-outline @error('company_phone') is-invalid @enderror mt-4">
                        <label class="form-label">{{ __('company.phone') }} <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" name="company_phone" value="{{ old('company_phone') }}" @error('company_phone') autofocus @enderror/>
                    </span>
                    @error('company_phone')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                    <span class="input-group input-group-outline @error('company_address') is-invalid @enderror mt-4">
                        <label class="form-label">{{ __('company.address') }} </label>
                        <textarea  class="form-control" name="company_address" value="{{ old('company_address') }}"></textarea>
                    </span>
                    @error('company_address')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                    <span class="d-flex flex-nowrap mt-5 w-100">
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

@endsection

