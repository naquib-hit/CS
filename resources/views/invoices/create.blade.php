@extends('layouts.app', ['title' => __('customer.title')])

@section('css')
<style>
    :root {
        --fas-custom-size: .85rem;
    }
    .font-reset {
        font-size: var(--fas-custom-size) !important;
    }

    input[type="date"]::-webkit-datetime-edit {
        color: transparent; 
    }

    input[type="date"]:focus::-webkit-datetime-edit {
        color: inherit !important;
    }
</style>

<link rel="stylesheet" href="{{ asset('vendor/sweetalert2/dist/sweetalert2.min.css') }}"/>
@endsection


@section('content')
    
    <div class="row h-100 justify-content-center">
        <form class="col-12" autocomplete="off">
           
            <fieldset class="row">
                <div class="col-12 col-lg-4">
                    <div class="card fadeIn3 fadeInBottom">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                              <h4 class="text-white font-weight-bolder text-center my-0">{{ __('invoice.form.title') }}</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="input-group input-group-outline">
                                <label class="form-label">{{ __('invoice.form.fields.no') }}</label>
                                <input type="text" class="form-control" name="invoice_no">
                            </div>
                            <div class="input-group input-group-outline mt-3" role="combobox">
                                <label class="form-label">{{ __('invoice.form.fields.customer') }}</label>
                                <input type="text" class="form-control" name="invoice_customer" id="customer">
                            </div>
                            <div class="input-group input-group-outline mt-3">
                                <label class="form-label">{{ __('invoice.form.fields.date') }}</label>
                                <input type="date" class="form-control" name="invoice_dates">
                            </div>
                            <div class="input-group input-group-outline mt-3">
                                <label class="form-label">{{ __('invoice.form.fields.due_date') }}</label>
                                <input type="date" class="form-control" name="invoice_due">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-8">
                    <div class="card fadeIn3 fadeInBottom">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                              <h4 class="text-white font-weight-bolder text-center my-0">{{ __('invoice.form.fields.tax') }}</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="input-group input-group-outline">
                                <label class="form-label">{{ __('invoice.form.fields.no') }}</label>
                                <input type="text" class="form-control" name="invoice_no">
                            </div>
                            <div class="input-group input-group-outline mt-3" role="combobox">
                                <label class="form-label">{{ __('invoice.form.fields.customer') }}</label>
                                <input type="text" class="form-control" name="invoice_customer" id="customer">
                            </div>
                            <div class="input-group input-group-outline mt-3">
                                <label class="form-label">{{ __('invoice.form.fields.date') }}</label>
                                <input type="date" class="form-control" name="invoice_dates">
                            </div>
                            <div class="input-group input-group-outline mt-3">
                                <label class="form-label">{{ __('invoice.form.fields.due_date') }}</label>
                                <input type="date" class="form-control" name="invoice_due">
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>

        </form>
    </div>
@endsection

@section('js')
<script src="{{ asset('vendor/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>

<script type="module">
import { Autocomplete } from "{{ asset('vendor/autocomplete/autocomplete.js') }}";

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

    // document.getElementById('btn-submit').addEventListener('click', e => {
    //     loading();
    // });

    // Autocomplete
    


    const customerElement = document.getElementById('customer');
    const autocomplete = new Autocomplete(customerElement);
    const getCustomer = async () => {
        try
        {
            const f = await fetch(`{{ route('invoices.customers') }}`);
            const j = await f.json();
            const cs = j.map(x => ({'label': x.customer_name, 'value': x.id}));

            autocomplete.setData(cs);
        }
        catch(err)
        {
            console.log(err);
        }
    }
    
    (async () => {
        await getCustomer();
    })();

    // End autompolete
</script>
@endsection