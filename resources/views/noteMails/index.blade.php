@extends('layouts.app', ['title' => 'Notifikasi'])

@section('css')
<link rel="stylesheet" href="{{ asset('vendor/sweetalert2/dist/sweetalert2.min.css') }}"/>
<link rel="stylesheet" href="{{ asset('vendor/quill/quill.snow.css') }}"/>
<link rel="stylesheet" href="{{ asset('vendor/flatpickr/dist/flatpickr.min.css') }}"/>

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
    <div class="col-4">
        <div class="table-reponsive"></div>
    </div>
    <div class="col-8">
        <form class="card" method="POST" action="{{ route('noteMails.store') }}">
            @csrf
            <fieldset class="card-header">
                <h4>Notifikasi</h4>
            </fieldset>
            <fieldset class="card-body">
                <input type="number" class="d-none" name="notice-id" value="{{ old('notice-id') }}">
                <div class="input-group input-group-dynamic @error('notice-name') is-invalid @enderror">
                    <label class="form-label">{{ __('Subjek') }}</label>
                    <input type="text" class="form-control font-weight-light" name="notice-name" value="{{ old('notice-name') }}">
                    @error('notice-name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="input-group input-group-dynamic @error('notice-project') is-invalid @enderror mt-4">
                    <input type="number" class="d-none" name="notice-project" value="{{ old('notice-project') }}">
                    <label class="form-label">{{ __('Proyek') }}</label>
                    <input type="text" class="form-control font-weight-light" name="notice-project_text" autocomplete="off" value="{{ old('notice-project_text') }}">
                    @error('notice-project')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="@error('notice-project') border border-danger @enderror mt-4">
                    <label class="form-label mb-0">{{ __('Isi') }}</label>
                    <textarea type="text" class="form-control font-weight-light" name="notice-content" rows="5" value="{{ old('notice-content') }}"></textarea>
                    @error('notice-content')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </fieldset>
            <fieldset class="card-footer w-100 d-flex flex-nowrap justify-content-end">
                <button type="reset" class="btn btn-secondary"><i class="fas fa-sync font-reset"></i> Ulangi</button>
                <button type="submit" class="btn btn-primary ms-2"><i class="fas fa-save font-reset"></i> Simpan</button>
            </fieldset>
        </form>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('vendor/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('vendor/quill/quill.min.js') }}"></script>
<script src="{{ asset('vendor/flatpickr/dist/flatpickr.min.js') }}"></script>

@if(session()->has('success'))
<script>
    Swal.fire({
        title: '<h4 class="text-success">SUCCESS</h4>',
        html: '<h5 class="text-success">{{ session('success') }}</h5>',
        icon: 'success',
        timer: 1200,
        timerProgressBar: true,
        showConfirmButton: false
    })
</script>
@endif

@if(session()->has('error'))
<script>
    Swal.fire({
        title: '<h4 class="text-danger">ERROR</h4>',
        html: '<h5 class="text-danger">{{ session('error') }}</h5>',
        icon: 'error',
        timer: 1200,
        timerProgressBar: true,
        showConfirmButton: false
    })
</script>
@endif

<script type="module">
import { Autocomplete } from "{{ asset('vendor/autocomplete/autocomplete.js') }}";
'use strict';

const editor = new Quill('textarea[name="notice-content"]', {
    theme: 'snow'
});

@php($notes = old('notice-content'))
@if (!empty($notes))
    editor.root.innerHTML = "{!! $notes !!}";
    document.querySelector('textarea[name="notice-content"]').innerHTML = "{!! $notes !!}";
@endif

const autocomplete = new Autocomplete(document.querySelector('input[name="notice-project_text"]'), {
    threshold: 1,
    onSelectItem: e => {
        document.querySelector('input[name="notice-project"]').value = e.value;
    }
});

const getProjects = async () => {

    try
    {
        const f = await fetch(`${window.location.href}/projects`);
        const j = await f.json();
        const _map = j.map(x => ({'value': x.id, 'label': x.project_name}));
        autocomplete.setData(_map);
    }
    catch(err)
    {

    }
}

(async () => {
    await getProjects();
})();

</script>

@endsection
