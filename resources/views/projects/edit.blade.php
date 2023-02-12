@extends('layouts.app', ['title' => __('project.title')])

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
                      <h4 class="text-white font-weight-bolder text-center my-0">{{ __('project.form.title') }}</h4>
                    </div>
                  </div>
                <div class="card-body">
                    <form name="form-input" action="{{ route('projects.update', ['project' => $project]) }}" class="d-flex flex-column" method="post">
                        @csrf
                        @method('PUT')
                        <span class="input-group input-group-outline @error('project_name') is-invalid @enderror">
                            <label class="form-label">{{ __('project.form.fields.name') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="project_name" value="{{ old('project_name') ?? $project->project_name }}" @error('project_name') autofocus @enderror/>
                        </span>
                        @error('project_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <span id="customer-input" class="input-group input-group-outline @error('project_customer') is-invalid @enderror mt-4">
                            <label class="form-label">{{ __('project.form.fields.customer') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control pe-3" name="project_customer_text" value="{{ old('project_customer_text') ?? $project->customers->customer_name }}" @error('project_customer_text')  @enderror/>
                            <button type="button" class="bg-transparent input-group-text pe-1" data-bs-toggle="dropdown" data-bs-target="#customer-input"><i class="fas fa-caret-down"></i></button>
                            <input type="number" class="d-none" name="project_customer" value="{{ old('project_customer') ?? $project->customer_id }}" @error('project_customer') @enderror/>
                        </span>
                        @error('project_customer')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror


                        <span class="d-flex flex-nowrap mt-5 w-100">
                            <a href="{{ route('projects.index') }}"  class="btn btn-primary p-0 btn-circle">
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

<script type="module">
    import { Autocomplete } from "{{ asset('vendor/autocomplete/autocomplete.js') }}";
    
    // Autocomplte
    const customerElement = document.getElementsByName('project_customer_text')[0];
    const autocomplete = new Autocomplete(customerElement, {
        threshold: 1,
        onSelectItem: e => {
            document.querySelector('input[name="project_customer"]').value = e.value;
        }
    });

    const customers = async () => {
        try
        {
            const f = await fetch("{{ route('projects.customer') }}");
            const j = await f.json();
            
            return j.map(x => ({'label': x.customer_name, 'value': x.id}));
        }
        catch(err)
        {
            console.log(err);
        }
    }

    (async() => {
        autocomplete.setData(await customers());

    })();
    // end autcomplte
</script>
@endsection