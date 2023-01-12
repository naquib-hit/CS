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

    #tax-container, #items-container {
        overflow-y: auto !important;
        height: 200px !important;
    }
</style>

<link rel="stylesheet" href="{{ asset('vendor/sweetalert2/dist/sweetalert2.min.css') }}"/>
<link rel="stylesheet" href="{{ asset('vendor/quill/quill.snow.css') }}"/>
@endsection


@section('content')
    
    <div class="row h-100 justify-content-center">
        <form class="col-12" 
              autocomplete="off" name="form-input"
              action="{{ route('invoices.store') }}"
              method="POST"
              enctype="multipart/form-data">
           @csrf
            <fieldset class="row">
                <div class="col-12 col-lg-4">
                    <div class="card fadeIn3 fadeInBottom">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg py-2 pe-1">
                              <h4 class="text-white font-weight-bolder ms-3 my-0">{{ __('invoice.form.title') }}</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="input-group input-group-outline @error('invoice_no') is-invalid @enderror">
                                <label class="form-label">{{ __('invoice.form.fields.no') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="invoice_no" >
                            </div>
                            @error('invoice_no')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            <div class="input-group input-group-outline @error('invoice_customer') is-invalid @enderror mt-3">
                                <label class="form-label">{{ __('invoice.form.fields.customer') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="invoice_customer_text" id="customer_input" autofocus="">
                                <input type="text" name="invoice_customer" hidden>
                            </div>
                            @error('invoice_customer')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            <div class="input-group input-group-outline @error('invoice_date') is-invalid @enderror mt-3">
                                <label class="form-label">{{ __('invoice.form.fields.date') }} <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="invoice_date">
                            </div>
                            @error('invoice_date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            <div class="input-group input-group-outline @error('invoice_due') is-invalid @enderror mt-3">
                                <label class="form-label">{{ __('invoice.form.fields.due_date') }}<span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="invoice_due">
                            </div>
                            @error('invoice_due')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="card fadeIn3 fadeInBottom mt-5">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg py-2 pe-1">
                              <h4 class="text-white font-weight-bolder ms-3 my-0">{{ __('invoice.form.fields.discount') }}</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8">
                                    <div class="input-group input-group-outline @error('invoice_discount') is-invalid @enderror">
                                        <label class="form-label">{{ __('invoice.form.fields.discount') }}</label>
                                        <input type="number" min="0" class="form-control" name="invoice_discount">
                                    </div>
                                    @error('invoice_discount')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
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
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="card fadeIn3 fadeInBottom">
                                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                    <div class="bg-gradient-primary shadow-primary border-radius-lg py-2 pe-1 d-flex flex-nowrap align-items-center">
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
                                        <div class="col-12 col-md-6 pe-1">
                                            <div class="input-group input-group-outline @error('invoice_items.0.value') is-invalid @enderror mt-3">
                                                <label class="form-label">{{ __('invoice.form.fields.item') }}<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control item-name" name="invoice_items[0][name]">
                                                <input type="text" class="d-none" name="invoice_items[0][value]">
                                            </div>
                                            @error('invoice_items.0.value')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-md-4 px-1">
                                            <div class="input-group input-group-outline @error('invoice_items.0.total') is-invalid @enderror mt-3">
                                                <label class="form-label">{{ __('invoice.form.fields.total') }}<span class="text-danger">*</span></label>
                                                <input type="number" min="0" step="1" class="form-control item-total"  name="invoice_items[0][total]">
                                            </div>
                                        </div>
                                        {{-- <div class="col-12 col-md-2 ps-1">
                                            <button type="button" class="btn btn-circle btn-danger m-0 p-0 clear-row" onclick="deleteItemRow(event)"><i class="fas fa-trash font-reset"></i></button>
                                        </div> --}}
                                    </div>

                                    @if (!empty(old('invoice_items')) && count(old('invoice_items')) > 1)
                                        
                                        @for ($i=1;$i<=count(old('invoice_items'));$i++)
                                            <div class="row align-items-baseline">
                                                <div class="col-12 col-md-6 pe-1">
                                                    <div class="input-group input-group-outline @error('invoice_items.'.$i.'.value') is-invalid @enderror mt-3">
                                                        <label class="form-label">{{ __('invoice.form.fields.item') }}<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control item-name" name="invoice_items[{{ $i }}][name]">
                                                        <input type="text" class="d-none" name="invoice_items[{{ $i }}][value]">
                                                    </div>
                                                    @error('invoice_items.'.$i.'.value')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-4 px-1">
                                                    <div class="input-group input-group-outline @error('invoice_items.'.$i.'.total') is-invalid @enderror mt-3">
                                                        <label class="form-label">{{ __('invoice.form.fields.total') }}<span class="text-danger">*</span></label>
                                                        <input type="number" min="0" step="1" class="form-control item-total"  name="invoice_items[{{ $i }}][total]">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-2 ps-1">
                                                    <button type="button" class="btn btn-circle btn-danger m-0 p-0 clear-row" onclick="deleteItemRow(event)"><i class="fas fa-trash font-reset"></i></button>
                                                </div>
                                            </div>
    
                                        @endfor

                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                             <!-- PAJAK -->
                            <div class="card fadeIn3 fadeInBottom">
                                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                    <div class="bg-gradient-primary shadow-primary border-radius-lg py-2 pe-1 d-flex flex-nowrap align-items-center">
                                    <h4 class="text-white font-weight-bolder ms-3 my-0">{{ __('invoice.form.fields.tax') }}</h4>
                                    <div class="ms-auto me-2">
                                        <button type="button" class="btn btn-sm btn-primary mb-0" id="add-tax">
                                            <span class="font-weight-bolder me-1">+</span>
                                            {{ __('template.toolbar.add') }}
                                        </button>
                                    </div>
                                    </div>
                                </div>
                                <div class="card-body" id="tax-container">
                                    <div class="row align-items-baseline">
                                        <div class="col-12 col-md-9 pe-1">
                                            <div class="input-group input-group-outline mt-3">
                                                <label class="form-label">{{ __('invoice.form.fields.tax') }}<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control tax-name" value="PPN" name="invoice_tax[0][name]">
                                            </div>
                                            
                                        </div>
                                        <div class="col-12 col-md-2 ps-1">
                                            <button type="button" class="btn btn-circle btn-danger m-0 p-0 clear-row" onclick="deleteItemRow(event)"><i class="fas fa-trash font-reset"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row pt-5">
                        <div class="col-12">
                            <div class="card fadeIn3 fadeInBottom">
                                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                    <div class="bg-gradient-primary shadow-primary border-radius-lg py-2 pe-1 d-flex flex-nowrap align-itesm-center">
                                      <h4 class="text-white font-weight-bolder ms-3 my-0">{{ __('invoice.form.fields.notes') }}</h4>
                                </div>
                                <div class="card-body">
                                    <textarea id="notes-editor" class="form-control" name="invoice_notes"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
            <fieldset class="row">
                <div class="col-12 d-flex flex-nowrap justify-content-end pt-3">
                    <button type="reset" class="btn btn-secondary me-1"><i class="fas fa-undo"></i> {{ __('template.form.reset') }} </button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ __('template.form.save') }}</button>
                </div>
            </fieldset>
        </form>
    </div>
@endsection

@section('js')
<script src="{{ asset('vendor/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('vendor/quill/quill.min.js') }}"></script>
<script>
    const deleteItemRow = e => {
        e = e || window.event;
        e.stopPropagation();
        const row = e.target.parentNode.closest('div.row');
        row.remove();
    }
</script>
<script type="module" defer>
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

    // Customers
    const customerElement = document.getElementById('customer_input');
    const autocomplete = new Autocomplete(customerElement, {
        threshold: 1,
        onSelectItem: e => {
            document.querySelector('input[name="invoice_customer"]').value = e.value;
        }
    });

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

    // Products
    const getProducts = async () => {
        try 
        {
            const f = await fetch("{{ route('invoices.products') }}");
            const j = await f.json();

            return j.map(x => ({'label': x.product_name, 'value': x.id}));

        } 
        catch (error) 
        {
            console.error(error);
        }
    }

    // buat first product autocomplete
    const itemContainer = document.getElementById('items-container'),
          btnAddItem = document.getElementById('add-item');
    
    async function firstProductAutoComplete() { 
        const datas = await getProducts();
        const names = itemContainer.getElementsByClassName('item-name');
        // const item = document.querySelector('input[name="invoice_items[0][name]"]'),
        //       value = document.querySelector('input[name="invoice_items[0][value]"]');
        
        Array.from(names, (item, idx) => {

            const value = document.querySelector('input[name="invoice_items['+idx+'][value]"]');
            
            new Autocomplete(item, {
                data: datas,
                threshold: 1,
                onInput: str => {
                    if(str.length == 0)
                        value.value = null;
                },
                onSelectItem: val => {
                    value.value = val.value;
                }
            });
        });
    }
    // END Products

    // Tax
    const taxContainer = document.getElementById('tax-container'),
          btnAddTax = document.getElementById('add-tax');

    async function taxAutocomplete()
    {
        try {
            const f = await fetch("{{ route('invoices.taxes') }}");
            const j = await f.json();

            const map = j.map(x => ({'label': x.tax_name, 'value': x.id}));
            const names = taxContainer.getElementsByClassName('tax-name');

            Array.from(names, (item, idx) => {

                const value = document.querySelector('input[name="invoice_tax['+idx+'][value]"]');

                new Autocomplete(item, {
                    data: map,
                    threshold: 1,
                    onInput: str => {
                        if(str.length == 0)
                            value.value = null;
                    },
                    onSelectItem: val => {
                        value.value = val.value;
                    }
                });
            });

        } catch (error) {
            console.log(error);
        }
    }

    
    // End Tax

    // Observer
    const observerConfig = {attributes: true, childList: true, subtree: true};
    const observer = new MutationObserver(async elem => {
        const element = elem[0];

        if(element.target.id === 'items-container')
            await firstProductAutoComplete();

        if(element.target.id === 'tax-container')
            await taxAutocomplete();
    });
    // End Observer

    // Items Group
    
    let lastIndex = document.getElementsByClassName('item-name').length - 1;
    
    
    const createItem = () => {
        // new row
        const row = document.createElement('div');
        row.classList.add('row', 'mt-3', 'align-items-baseline');
        // col-left 
        const colLeft = document.createElement('div');
        colLeft.classList.add('col-12', 'col-md-6', 'pe-1');
        // col-middle
        const colMiddle = document.createElement('div');
        colMiddle.classList.add('col-12', 'col-md-4','px-1');
        // col-right
        const colRight = document.createElement('div');
        colRight.classList.add('col-12', 'col-md-2', 'ps-1');
        // input-group-left
        const inputGroupLeft = document.createElement('div');
        inputGroupLeft.classList.add('input-group', 'input-group-outline');
        // input-group-middlw (sengaja beda biar classListNya beda)
        const inputGroupMiddle = document.createElement('div');
        inputGroupMiddle.classList.add('input-group', 'input-group-outline');
        // clear-row 
        const clearRow = document.createElement('button');
        clearRow.type = 'button';
        clearRow.onclick = e => deleteItemRow(e);
        clearRow.classList.add('btn', 'btn-circle', 'btn-danger', 'm-0', 'p-0', 'clear-row');
        // label buat text
        const labelLeft = document.createElement('label');
        labelLeft.classList.add('form-label');
        // label buat number
        const labelMiddle = document.createElement('label');
        labelMiddle.classList.add('form-label');
       // input text
        const inputText = document.createElement('input');
        inputText.type = 'text';
        inputText.classList.add('form-control', 'item-name');
       // input text value
        const inputTextValue = document.createElement('input');
        inputTextValue.type = 'text';
        inputTextValue.classList.add('d-none', 'item-name-value');
        // input number
        const inputNumber = document.createElement('input');
        inputNumber.type = 'number';
        inputNumber.step = 1;
        inputNumber.classList.add('form-control');
        // trash icon
        const faTrash = document.createElement('i');
        faTrash.onclick = () => false;
        faTrash.classList.add('fas', 'fa-trash', 'font-reset');

        // LEFT
        labelLeft.innerHTML = "{{ __('invoice.form.fields.item') }} <span class=\"text-danger\">*</span>";
        inputText.name = "invoice_items["+ (+lastIndex + 1) +"][name]";
        inputTextValue.name = 'invoice_items['+ (+lastIndex + 1) +'][value]'
        inputText.onfocus = async e => await inputOnFocus(e);
        inputText.onblur = async e => await inputOnFocusOut(e);
        inputText.onkeyup = async e => await inputOnKeyup(e);
        inputGroupLeft.appendChild(labelLeft);
        inputGroupLeft.appendChild(inputText);
        inputGroupLeft.appendChild(inputTextValue);
        colLeft.appendChild(inputGroupLeft);
        row.appendChild(colLeft);
        // MIDDLE
        //labelMiddle.innerText = '';
        labelMiddle.innerHTML = "{{ __('invoice.form.fields.total') }} <span class=\"text-danger\">*</span>";
        inputNumber.name= "invoice_items["+ (+lastIndex + 1) +"][total]";
        inputNumber.onfocus = async e => await inputOnFocus(e);
        inputNumber.onblur = async e => await inputOnFocusOut(e);
        inputNumber.onkeyup = async e => await inputOnKeyup(e);
        inputNumber.min = 0;
        inputGroupMiddle.appendChild(labelMiddle);
        inputGroupMiddle.appendChild(inputNumber);
        colMiddle.appendChild(inputGroupMiddle);
        row.appendChild(colMiddle);
        // RIGHT
        clearRow.appendChild(faTrash);
        colRight.appendChild(clearRow);
        row.appendChild(colRight);

        return row;
    }
    observer.observe(itemContainer, observerConfig);

    // end item group

    // tax group
   
    let lastTaxIndex = document.getElementsByClassName('tax-name').length - 1;
    
    const createTax = () => {
        // new row
        const row = document.createElement('div');
        row.classList.add('row', 'mt-3', 'align-items-baseline');
        // col-left 
        const colLeft = document.createElement('div');
        colLeft.classList.add('col-12', 'col-md-9', 'pe-1');
        // col-right
        const colRight = document.createElement('div');
        colRight.classList.add('col-12', 'col-md-2', 'ps-1');
        // input-group-left
        const inputGroupLeft = document.createElement('div');
        inputGroupLeft.classList.add('input-group', 'input-group-outline');
        // input-group-middlw (sengaja beda biar classListNya beda)
        const inputGroupMiddle = document.createElement('div');
        inputGroupMiddle.classList.add('input-group', 'input-group-outline');
        // clear-row 
        const clearRow = document.createElement('button');
        clearRow.type = 'button';
        clearRow.onclick = e => deleteItemRow(e);
        clearRow.classList.add('btn', 'btn-circle', 'btn-danger', 'm-0', 'p-0', 'clear-row');
        // label buat text
        const labelLeft = document.createElement('label');
        labelLeft.classList.add('form-label');
        // label buat number
        const labelMiddle = document.createElement('label');
        labelMiddle.classList.add('form-label');
       // input text
        const inputText = document.createElement('input');
        inputText.type = 'text';
        inputText.classList.add('form-control', 'tax-name');
        // input number
        const inputNumber = document.createElement('input');
        inputNumber.type = 'number';
        inputNumber.classList.add('form-control');
        // trash icon
        const faTrash = document.createElement('i');
        faTrash.onclick = () => false;
        faTrash.classList.add('fas', 'fa-trash', 'font-reset');

        // LEFT
        labelLeft.innerHTML = "{{ __('invoice.form.fields.tax') }} <span class=\"text-danger\"></span>";
        inputText.name = "invoice_tax["+ (+lastTaxIndex + 1) +"][name]";
        inputText.onfocus = async e => await inputOnFocus(e);
        inputText.onblur = async e => await inputOnFocusOut(e);
        inputText.onkeyup = async e => await inputOnKeyup(e);
        inputGroupLeft.appendChild(labelLeft);
        inputGroupLeft.appendChild(inputText);
        colLeft.appendChild(inputGroupLeft);
        row.appendChild(colLeft);
        // MIDDLE
        //labelMiddle.innerText = '';
        // labelMiddle.innerHTML = "{{ __('invoice.form.fields.total') }} <span class=\"text-danger\"></span>";
        // inputNumber.name= "invoice_tax["+ (+lastIndex + 1) +"][total]";
        // inputNumber.onfocus = async e => await inputOnFocus(e);
        // inputNumber.onblur = async e => await inputOnFocusOut(e);
        // inputNumber.onkeyup = async e => await inputOnKeyup(e);
        // inputNumber.min = 0;
        // inputNumber.step = 1;
        // inputGroupMiddle.appendChild(labelMiddle);
        // inputGroupMiddle.appendChild(inputNumber);
        // colMiddle.appendChild(inputGroupMiddle);
        // row.appendChild(colMiddle);
        // RIGHT
        clearRow.appendChild(faTrash);
        colRight.appendChild(clearRow);
        row.appendChild(colRight);

        return row;
    }
    observer.observe(taxContainer, observerConfig);
    //end tax group
    

    // check if window is changed
    

    const inputOnFocus = async e => {
        e = e || window.event;
        e.srcElement.parentElement.classList.add('is-filled');
    }

    const inputOnKeyup = async e => {
        e = e || window.event;
        const el = e.srcElement;
        const parent = el.parentElement;

        if(el.value)
            parent.classList.add('is-filled');
        else
            parent.classList.remove('is-filled');
    }

    const inputOnFocusOut = async e =>  {
        e = e || window.event;
        if(!e.target.value)
            e.target.parentElement.classList.remove('is-filled');
    }
    //observer.disconnect();
    // End Items Group

    // editor
    const editor = new Quill('#notes-editor', {
        theme: 'snow'
    });
    // end editor group


    // form submit

    const formInvoice = async e => {
        e.preventDefault();

        try 
        {
            const formData = new FormData(e.target);

            const f = await fetch("{{ route('invoices.store') }}", {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            });
            const j = await f.json();

            if(!j.success)
            {
                Swal.fire({
                    
                });
                return false;
            }
        } 
        catch (error) 
        {
            console.log(error.reponse);    
        }
    }
    // end form submit

    (async () => {
        await getCustomer();
        await firstProductAutoComplete();
        await taxAutocomplete();

        btnAddItem.addEventListener('click', e => {
            e.preventDefault();
            lastIndex = document.getElementsByClassName('item-name').length - 1;
            itemContainer.appendChild(createItem());

            
        });

       btnAddTax.addEventListener('click', e => {
            e.preventDefault();
            lastIndex = document.getElementsByClassName('tax-name').length - 1;
            taxContainer.appendChild(createTax());
       });

       //form.addEventListener('submit', async e => await formInvoice(e));

    })();
</script>
@endsection