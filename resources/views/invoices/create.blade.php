@extends('layouts.app', ['title' => __('customer.title')])

@section('css')
<style>
    :root {
        --fas-custom-size: .85rem;
    }
    .font-reset {
        font-size: var(--fas-custom-size) !important;
    }

    .input-group > input[type="date"]::before
    { 
        content: ' ';
        width: 100%;
    }


    input[type="date"]:focus::before,
    .input-group.is-filled > input[type="date"]::before
    { 
        display: none 
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
                              <h4 class="text-white font-weight-bolder ms-3 my-0">{{ __('invoice.form.title') }}</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="input-group input-group-outline">
                                <label class="form-label">{{ __('invoice.form.fields.no') }}</label>
                                <input type="text" class="form-control" name="invoice_no">
                            </div>
                            <div class="input-group input-group-outline mt-3">
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
                    <div class="card fadeIn3 fadeInBottom mt-5">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                              <h4 class="text-white font-weight-bolder ms-3 my-0">{{ __('invoice.form.fields.discount') }}</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8">
                                    <div class="input-group input-group-outline">
                                        <label class="form-label">{{ __('invoice.form.fields.discount') }}</label>
                                        <input type="number" min="0" class="form-control" name="invoice_tax">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="input-group input-group-outline">
                                        <select class="form-control" name="tax_type">
                                            <option value="percent">%</option>
                                            <option value="number">Rp.</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-8">
                    <div class="card fadeIn3 fadeInBottom">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1 d-flex flex-nowrap align-items-center">
                              <h4 class="text-white font-weight-bolder ms-3 my-0">{{ __('invoice.form.fields.item') }}</h4>
                              <div class="ms-auto me-2">
                                <button type="button" class="btn btn-sm btn-primary mb-0" id="add-item">
                                    <span class="font-weight-bolder me-1">+</span>
                                    {{ __('template.toolbar.add') }}
                                </button>
                              </div>
                            </div>
                        </div>
                        <div class="card-body" id="items-container">
                            <div class="row align-items-baseline">
                                <div class="col-12 col-md-8">
                                    <div class="input-group input-group-outline mt-3">
                                        <label class="form-label"></label>
                                        <input type="text" class="form-control item-name" placeholder="{{ __('invoice.form.fields.item') }}" name="invoice_item[0][name]">
                                    </div>
                                    
                                </div>
                                <div class="col-12 col-md-2">
                                    <div class="input-group input-group-outline mt-3">
                                        <label class="form-label"></label>
                                        <input type="number" min="0" step="0.01" class="form-control item-total" placeholder="{{ __('invoice.form.fields.total') }}" name="invoice_item[0][total]">
                                    </div>
                                </div>
                                <div class="col-12 col-md-2">
                                    <button type="button" class="btn btn-circle btn-danger m-0 p-0 clear-row"><i class="fas fa-trash font-reset"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- PAJAK -->
                    <div class="card fadeIn3 fadeInBottom mt-5">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1 d-flex flex-nowrap align-items-center">
                              <h4 class="text-white font-weight-bolder ms-3 my-0">{{ __('invoice.form.fields.tax') }}</h4>
                              <div class="ms-auto me-2">
                                <button type="button" class="btn btn-sm btn-primary mb-0" id="add-item">
                                    <span class="font-weight-bolder me-1">+</span>
                                    {{ __('template.toolbar.add') }}
                                </button>
                              </div>
                            </div>
                        </div>
                        <div class="card-body" id="tax-container">

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
    // End autompolete

    // Items Group
    const itemContainer = document.getElementById('items-container'),
          btnAddItem = document.getElementById('add-item');
    let elemIndex = 0,
        lastIndex = document.getElementsByClassName('item-name').length - 1;
    
    console.log(lastIndex);
    
    const createItem = () => {
        // new row
        const row = document.createElement('div');
        row.classList.add('row', 'mt-3', 'align-items-baseline');
        // col-left 
        const colLeft = document.createElement('div');
        colLeft.classList.add('col-12', 'col-md-8');
        // col-middle
        const colMiddle = document.createElement('div');
        colMiddle.classList.add('col-12', 'col-md-2');
        // col-right
        const colRight = document.createElement('div');
        colRight.classList.add('col-12', 'col-md-2');
        // input-group-left
        const inputGroupLeft = document.createElement('div');
        inputGroupLeft.classList.add('input-group', 'input-group-outline');
        // input-group-middlw (sengaja beda biar classListNya beda)
        const inputGroupMiddle = document.createElement('div');
        inputGroupMiddle.classList.add('input-group', 'input-group-outline');
        // clear-row (sengaja beda biar classListNya beda)
        const clearRow = document.createElement('button');
        clearRow.type = 'button';
        clearRow.onclick = async e => await deleteItemRow(e);
        clearRow.classList.add('btn', 'btn-circle', 'btn-danger', 'm-0', 'p-0', 'clear-row');
       // input text
        const inputText = document.createElement('input');
        inputText.type = 'text';
        inputText.classList.add('form-control', 'item-name');
        // input number
        const inputNumber = document.createElement('input');
        inputNumber.type = 'number';
        inputNumber.classList.add('form-control');
        // trash icon
        const faTrash = document.createElement('i');
        faTrash.onclick = () => false;
        faTrash.classList.add('fas', 'fa-trash', 'font-reset');

        // LEFT
        inputText.placeholder = "{{ __('invoice.form.fields.item') }}";
        inputText.name = "invoice_items["+ (+lastIndex + 1) +"][name]";
        //inputGroupLeft.appendChild(labelLeft);
        inputGroupLeft.appendChild(inputText);
        colLeft.appendChild(inputGroupLeft);
        row.appendChild(colLeft);
        // MIDDLE
        //labelRight.innerText = '';
        inputNumber.placeholder = "{{ __('invoice.form.fields.total') }}";
        inputNumber.name= "invoice_items["+ (+lastIndex + 1) +"][total]";
        inputNumber.min = 0;
        inputNumber.step = 0.01;
        //inputGroupRight.appendChild(labelRight);
        inputGroupMiddle.appendChild(inputNumber);
        colMiddle.appendChild(inputGroupMiddle);
        row.appendChild(colMiddle);
        // RIGHT
        clearRow.appendChild(faTrash);
        colRight.appendChild(clearRow);
        row.appendChild(colRight);

        return row;
    }
    // check if window is changed
    const deleteItemRow = async e => {
        e = e || window.event;
        e.stopPropagation();
        const row = e.target.parentNode.closest('div.row');
        row.remove();
    }
    //observer.disconnect();
    // End Items Group

    (async () => {
        await getCustomer();

        btnAddItem.addEventListener('click', e => {
            e.preventDefault();
            lastIndex = document.getElementsByClassName('item-name').length - 1;

            itemContainer.appendChild(createItem());

           
        });

       

        document.querySelectorAll('.clear-row').forEach(item => {
            console.log(item);
            item.addEventListener('click', e => {
                e.stopPropagation();

                console.log(e.target.parentNode.closest('.row'))
            }, false);
        });

    })();
</script>
@endsection