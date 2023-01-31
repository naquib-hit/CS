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
              action="{{ route('invoices.update', ['invoice' => $invoice['id']]) }}"
              method="POST"
              enctype="multipart/form-data">
           @csrf
           @method('PUT')
            <fieldset class="row">
                <div class="col-12">
                    <div class="card fadeIn3 fadeInBottom">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg py-2 pe-1">
                              <h4 class="text-white font-weight-bolder ms-3 my-0">{{ __('invoice.form.title') }}</h4>
                            </div>
                        </div>
                        <div class="card-body row">
                            <div class="col-12 col-lg-4">
                                <div class="input-group input-group-static @error('invoice_no') is-invalid @enderror mt-3">
                                    <label class="form-label">{{ __('invoice.form.fields.no') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="invoice_no" value="{{ old('invoice_no') ?? $invoice['invoice_no'] }}">
                                </div>
                                @error('invoice_no')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-12 col-lg-4">
                                <div class="input-group input-group-static @error('invoice_po') is-invalid @enderror mt-3">
                                    <label class="form-label">{{ __('invoice.form.fields.po') }}<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="invoice_po" value="{{ old('invoice_po') ?? $invoice['po_no'] }}">
                                </div>
                                @error('invoice_po')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-12 col-lg-4">
                                <div class="input-group input-group-static @error('invoice_customer') is-invalid @enderror mt-3">
                                    <label class="form-label">{{ __('invoice.form.fields.customer') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="invoice_customer_text" id="customer_input"  value="{{ old('invoice_customer_text') ?? $invoice['customers']['customer_name'] }}">
                                    <button class="input-group-text px-2 btn-open-customer" type="button"><i class="fas fa-caret-down"></i></button>
                                    <input type="text" name="invoice_customer" value="{{ old('invoice_customer') ?? $invoice['customers']['id'] }}" hidden>
                                </div>
                                @error('invoice_customer')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-12 col-lg-4">
                                <div class="input-group input-group-static @error('invoice_date') is-invalid @enderror mt-3">
                                    <label class="form-label">{{ __('invoice.form.fields.date') }} <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="invoice_date" value="{{ old('invoice_date') ?? $invoice['create_date'] }}">
                                </div>
                                @error('invoice_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-12 col-lg-4">
                                <div class="input-group input-group-static @error('invoice_due') is-invalid @enderror mt-3">
                                    <label class="form-label">{{ __('invoice.form.fields.due_date') }}<span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="invoice_due" value="{{ old('invoice_due') ?? $invoice['due_date'] }}">
                                </div>
                                @error('invoice_due')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-12 col-lg-4">
                                <div class="input-group input-group-static flex-nowrap flex-column @error('invoice_currency') is-invalid @enderror mt-3">
                                    <label class="form-label">{{ __('invoice.form.fields.currency') }}</label>
                                    <div class="d-flex flex-nowrap">
                                    <select class="form-control" name="invoice_currency" value="{{ old('invoice_currency') ?? $invoice['currency'] }}">
                                        <option value="IDR">IDR - INDONESIA</option>
                                        <option value="USD">USD - USA</option>
                                    </select>
                                    <label class="input-group-text"><i class="fas fa-caret-down"></i></label>
                                    </div>
                                </div>
                                @error('invoice_currency')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                           
                    </div>
                </div>
                <div class="col-12">
                    <div class="row mt-5">
                        <div class="col-12 col-lg-8">
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
                                    <div class="row align-items-end">
                                        <div class="col-12 col-md-8 pe-1">
                                            <div class="input-group input-group-static @error('invoice_items.0.value') is-invalid @enderror mt-3">
                                                <label class="form-label">{{ __('invoice.form.fields.item') }}<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control item-name" name="invoice_items[0][name]" value="{{ old('invoice_items.0.name') ?? $invoice['products'][0]['product_name'] }}">
                                                <input type="text" class="d-none" name="invoice_items[0][value]" value="{{ old('invoice_items.0.value') ?? $invoice['products'][0]['id'] }}">
                                            </div>
                                            @error('invoice_items.0.value')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-md-2 px-1">
                                            <div class="input-group input-group-static @error('invoice_items.0.total') is-invalid @enderror mt-3">
                                                <label class="form-label">{{ __('invoice.form.fields.total') }}<span class="text-danger">*</span></label>
                                                <input type="number" min="0" step="1" class="form-control item-total"  name="invoice_items[0][total]" value="{{ old('invoice_items.0.value') ?? $invoice['products'][0]['pivot']['quantity'] }}">
                                            </div>
                                        </div>
                                        {{-- <div class="col-12 col-md-2 ps-1">
                                            <button type="button" class="btn btn-circle btn-danger m-0 p-0 clear-row" onclick="deleteItemRow(event)"><i class="fas fa-trash font-reset"></i></button>
                                        </div> --}}
                                    </div>
                                    @php
                                        $itemCount = count($invoice['products']);
                                    @endphp
                                    @if (!empty(old('invoice_items')) && count(old('invoice_items')) > 1)
                                        @if (count(old('invoice_items')) > count($invoice['products']))
                                            @php($itemCount = count(old('invoice_items')));
                                        @endif
                                    @endif
                                    @if ($itemCount > 1)
                                        @for ($i=1;$i<=$itemCount;$i++)
                                        <div class="row align-items-baseline">
                                            <div class="col-12 col-md-6 pe-1">
                                                <div class="input-group input-group-static @error('invoice_items.'.$i.'.value') is-invalid @enderror mt-3">
                                                    <label class="form-label">{{ __('invoice.form.fields.item') }}<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control item-name" name="invoice_items[{{ $i }}][name]" 
                                                    value="{{ old('invoice_items.'.$i.'.name') ?? $invoice['products'][$i]['product_name'] }}">
                                                    <input type="text" class="d-none" name="invoice_items[{{ $i }}][value]" 
                                                    value="{{ old('invoice_items.'.$i.'.value') ?? $invoice['products'][$i]['id'] }}">
                                                </div>
                                                @error('invoice_items.'.$i.'.value')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="col-12 col-md-4 px-1">
                                                <div class="input-group input-group-static @error('invoice_items.'.$i.'.total') is-invalid @enderror mt-3">
                                                    <label class="form-label">{{ __('invoice.form.fields.total') }}<span class="text-danger">*</span></label>
                                                    <input type="number" min="0" step="1" class="form-control item-total"  name="invoice_items[{{ $i }}][total]" value="{{ old('invoice_items.'.$i.'.total') ?? $invoice['products'][$i]['pivot']['quantity'] }}">
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
                        <div class="col-12 col-lg-4">
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
                                    <div class="row align-items-end">
                                        <div class="col-12 col-md-9 pe-1">
                                            <div class="input-group input-group-static @error('invoice_tax.0.value') is-invalid @enderror mt-3">
                                                <label class="form-label">{{ __('invoice.form.fields.tax') }}<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control tax-name" name="invoice_tax[0][name]" 
                                                value="{{ old('invoice_tax.0.name') ?? $invoice['taxes'][0]['tax_name'] ?? 'PPN' }}">
                                                <input type="number" name="invoice_tax[0][value]" value="{{ old('invoice_tax.0.value') ?? $invoice['taxes'][0]['id'] ?? 1 }}" hidden>
                                            </div>
                                            @error('invoice_tax.0.value')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-md-2 ps-1">
                                            <button type="button" class="btn btn-circle btn-danger m-0 p-0 clear-row" onclick="deleteItemRow(event)"><i class="fas fa-trash font-reset"></i></button>
                                        </div>
                                    </div>
                                    @php($taxCount = count($invoice['taxes']))
                                    @if (!empty(old('invoice_tax')) && count(old('invoice_tax')) > 1)
                                        @if(count(old('invoice_tax')) > count($invoice['taxes']))
                                            @php($taxCount = count(old('invoice_tax'))))
                                        @endif
                                    @endif
                                    @if ($taxCount > 1)
                                        @for ($i=1;$i<=count(old('invoice_tax'));$i++)
                                            <div class="row align-items-baseline mt-3">
                                                <div class="col-12 col-md-9 pe-1">
                                                    <div class="input-group input-group-static">
                                                        <label class="form-label">{{ __('invoice.form.fields.tax') }}<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control tax-name" name="invoice_tax[{{ $i }}][name]" 
                                                        value="{{ old('invoice_tax.'.$i.'.name') ?? $invoice['taxes'][$i]['tax_name']  }}">
                                                        <input type="number" name="invoice_tax[{{ $i }}][value]" 
                                                        value="{{ old('invoice_tax.'.$i.'.value') ?? $invoice['taxes'][$i]['id'] }}" hidden>
                                                    </div>
                                                    @error('invoice_tax.'.$i.'.value')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
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
                    </div>
                </div>
            </fieldset>
            <fieldset class="row mt-5">
                <div class="col-12 col-md-8">
                    <div class="card fadeIn3 fadeInBottom">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg py-2 pe-1 d-flex flex-nowrap align-itesm-center">
                              <h4 class="text-white font-weight-bolder ms-3 my-0">{{ __('invoice.form.fields.notes') }}</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            {{-- <textarea id="notes-editor" class="form-control" name="invoice_notes">
                                {{ old('invoice_notes') ?? $invoice['notes'] }}
                            </textarea> --}}
                            <div id="notes-editor"></div>
                            <textarea class="d-none" name="invoice_notes"></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="card fadeIn3 fadeInBottom">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg py-2 pe-1">
                                <h4 class="text-white font-weight-bolder ms-3 my-0">{{ __('invoice.form.fields.discount') }}</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row align-items-end">
                                <div class="col-8">
                                    <div class="input-group input-group-static @error('invoice_discount') is-invalid @enderror">
                                        <label class="form-label">{{ __('invoice.form.fields.discount') }}</label>
                                        <input type="number" min="0" class="form-control" name="invoice_discount" value="{{ old('invoice_discount') ?? $invoice['discount_amount'] }}">
                                    </div>
                                    @error('invoice_discount')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <div class="input-group input-group-static">
                                        <select class="form-control" name="discount_unit" value="{{ old('discount_unit') ?? $invoice['discount_unit'] }}">
                                            <option value="percent">%</option>
                                            <option value="fixed">Rp.</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </fieldset>
            <fieldset class="row mt-5">
                <div class="col-12">

                    <div class="card fadeIn3 fadeInBottom">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg py-2 pe-1 d-flex flex-nowrap align-itesm-center">
                              <h4 class="text-white font-weight-bolder ms-3 my-0">{{ __('invoice.form.fields.additional.title') }}</h4>
                              <div class="ms-auto me-2">
                                    <button type="button" class="btn btn-sm btn-primary mb-0" id="btn-additional">
                                        <span class="font-weight-bolder me-1">+</span>
                                        {{ __('template.toolbar.add') }}
                                    </button>
                                </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm" id="table-additional">
                                <thead>
                                    <th>{{ __('invoice.form.fields.additional.name') }}</th>
                                    <th>{{ __('invoice.form.fields.additional.value') }}</th>
                                    <th>{{ __('invoice.form.fields.additional.unit') }}</th>
                                    <th>{{ __('invoice.form.fields.additional.operation') }}</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    <?php $addFieldCount = count($invoice['additional_field']) ?>
                                    @if (!empty(old('additional_input')) && count(old('additional_input')) > 0)
                                        @if(count($invoice['additional_field']) < count(old('additional_input')))
                                            @php($addFieldCount = count(old('additional_input')))
                                        @endif
                                    @endif
                                    @if ($addFieldCount > 0)
                                        @for ($i=0;$i<$addFieldCount;$i++)
                                        <tr>
                                            <td>
                                                <input type="text" name="additional_input[{{$i}}][name]" class="form-control form-control-sm border" 
                                                value="{{ old('additional_input.'.$i.'.name') ?? $invoice['additional_field'][$i]['field_name'] }}">
                                            </td>
                                            <td>
                                                <input type="number" name="additional_input[{{ $i }}][value]" class="form-control form-control-sm border" value="{{ old('additional_input.'.$i.'.value') ?? $invoice['additional_field'][$i]['field_value'] }}">
                                            </td>
                                            <td>
                                                <select name="additional_input[{{ $i }}][unit]" class="form-select form-select-sm" 
                                                        value="{{ old('additional_input.'.$i.'.unit') ?? $invoice['additional_field'][$i]['unit'] }}">
                                                    <option value="fixed">Rp.</option>
                                                    <option value="percent">%</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="additional_input[{{ $i }}][operation]" class="form-select form-select-sm" 
                                                value="{{ old('additional_input.'.$i.'.operation') ?? $invoice['additional_field'][$i]['operation'] }}">
                                                    <option value="+">+</option>
                                                    <option value="-">-</option>
                                                    <option value="x">x</option>
                                                    <option value="/">/</option>
                                                </select>
                                            </td>
                                            <td>
                                                <button type="button" onclick="deleteAddtionalFieldRow(event)" class="btn btn-danger btn-circle p-0"><i class="fas fa-trash font-reset"></i></button>
                                            </td>
                                        </tr>
                                        @endfor
                                    @endif
                                </tbody>
                            </table>
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
<script defer>
    const deleteItemRow = e => {
        e = e || window.event;
        e.stopPropagation();
        const row = e.target.parentNode.closest('div.row');
        row.remove();
    }

    const deleteAddtionalFieldRow = e => {
        e.preventDefault();

        const tr = e.target.parentElement.closest('tr');
        document.getElementById('table-additional').tBodies[0].deleteRow(tr.rowIndex - 1);
    }
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

</script>

<script type="application/json" id="currency-codes">
    [{"AlphabeticCode": "AFN", "Currency": "Afghani", "Entity": "AFGHANISTAN", "MinorUnit": "2", "NumericCode": 971.0, "WithdrawalDate": null},{"AlphabeticCode": "EUR", "Currency": "Euro", "Entity": "\u00c5LAND ISLANDS", "MinorUnit": "2", "NumericCode": 978.0, "WithdrawalDate": null},{"AlphabeticCode": "ALL", "Currency": "Lek", "Entity": "ALBANIA", "MinorUnit": "2", "NumericCode": 8.0, "WithdrawalDate": null},{"AlphabeticCode": "DZD", "Currency": "Algerian Dinar", "Entity": "ALGERIA", "MinorUnit": "2", "NumericCode": 12.0, "WithdrawalDate": null},{"AlphabeticCode": "USD", "Currency": "US Dollar", "Entity": "AMERICAN SAMOA", "MinorUnit": "2", "NumericCode": 840.0, "WithdrawalDate": null},{"AlphabeticCode": "EUR", "Currency": "Euro", "Entity": "ANDORRA", "MinorUnit": "2", "NumericCode": 978.0, "WithdrawalDate": null},{"AlphabeticCode": "AOA", "Currency": "Kwanza", "Entity": "ANGOLA", "MinorUnit": "2", "NumericCode": 973.0, "WithdrawalDate": null},{"AlphabeticCode": "XCD", "Currency": "East Caribbean Dollar", "Entity": "ANGUILLA", "MinorUnit": "2", "NumericCode": 951.0, "WithdrawalDate": null},{"AlphabeticCode": null, "Currency": "No universal currency", "Entity": "ANTARCTICA", "MinorUnit": null, "NumericCode": null, "WithdrawalDate": null},{"AlphabeticCode": "XCD", "Currency": "East Caribbean Dollar", "Entity": "ANTIGUA AND BARBUDA", "MinorUnit": "2", "NumericCode": 951.0, "WithdrawalDate": null},{"AlphabeticCode": "ARS", "Currency": "Argentine Peso", "Entity": "ARGENTINA", "MinorUnit": "2", "NumericCode": 32.0, "WithdrawalDate": null},{"AlphabeticCode": "AMD", "Currency": "Armenian Dram", "Entity": "ARMENIA", "MinorUnit": "2", "NumericCode": 51.0, "WithdrawalDate": null},{"AlphabeticCode": "AWG", "Currency": "Aruban Florin", "Entity": "ARUBA", "MinorUnit": "2", "NumericCode": 533.0, "WithdrawalDate": null},{"AlphabeticCode": "AUD", "Currency": "Australian Dollar", "Entity": "AUSTRALIA", "MinorUnit": "2", "NumericCode": 36.0, "WithdrawalDate": null},{"AlphabeticCode": "EUR", "Currency": "Euro", "Entity": "AUSTRIA", "MinorUnit": "2", "NumericCode": 978.0, "WithdrawalDate": null},{"AlphabeticCode": "AZN", "Currency": "Azerbaijan Manat", "Entity": "AZERBAIJAN", "MinorUnit": "2", "NumericCode": 944.0, "WithdrawalDate": null},{"AlphabeticCode": "BSD", "Currency": "Bahamian Dollar", "Entity": "BAHAMAS (THE)", "MinorUnit": "2", "NumericCode": 44.0, "WithdrawalDate": null},{"AlphabeticCode": "BHD", "Currency": "Bahraini Dinar", "Entity": "BAHRAIN", "MinorUnit": "3", "NumericCode": 48.0, "WithdrawalDate": null},{"AlphabeticCode": "BDT", "Currency": "Taka", "Entity": "BANGLADESH", "MinorUnit": "2", "NumericCode": 50.0, "WithdrawalDate": null},{"AlphabeticCode": "BBD", "Currency": "Barbados Dollar", "Entity": "BARBADOS", "MinorUnit": "2", "NumericCode": 52.0, "WithdrawalDate": null},{"AlphabeticCode": "BYN", "Currency": "Belarusian Ruble", "Entity": "BELARUS", "MinorUnit": "2", "NumericCode": 933.0, "WithdrawalDate": null},{"AlphabeticCode": "EUR", "Currency": "Euro", "Entity": "BELGIUM", "MinorUnit": "2", "NumericCode": 978.0, "WithdrawalDate": null},{"AlphabeticCode": "BZD", "Currency": "Belize Dollar", "Entity": "BELIZE", "MinorUnit": "2", "NumericCode": 84.0, "WithdrawalDate": null},{"AlphabeticCode": "XOF", "Currency": "CFA Franc BCEAO", "Entity": "BENIN", "MinorUnit": "0", "NumericCode": 952.0, "WithdrawalDate": null},{"AlphabeticCode": "BMD", "Currency": "Bermudian Dollar", "Entity": "BERMUDA", "MinorUnit": "2", "NumericCode": 60.0, "WithdrawalDate": null},{"AlphabeticCode": "INR", "Currency": "Indian Rupee", "Entity": "BHUTAN", "MinorUnit": "2", "NumericCode": 356.0, "WithdrawalDate": null},{"AlphabeticCode": "BTN", "Currency": "Ngultrum", "Entity": "BHUTAN", "MinorUnit": "2", "NumericCode": 64.0, "WithdrawalDate": null},{"AlphabeticCode": "BOB", "Currency": "Boliviano", "Entity": "BOLIVIA (PLURINATIONAL STATE OF)", "MinorUnit": "2", "NumericCode": 68.0, "WithdrawalDate": null},{"AlphabeticCode": "BOV", "Currency": "Mvdol", "Entity": "BOLIVIA (PLURINATIONAL STATE OF)", "MinorUnit": "2", "NumericCode": 984.0, "WithdrawalDate": null},{"AlphabeticCode": "USD", "Currency": "US Dollar", "Entity": "BONAIRE, SINT EUSTATIUS AND SABA", "MinorUnit": "2", "NumericCode": 840.0, "WithdrawalDate": null},{"AlphabeticCode": "BAM", "Currency": "Convertible Mark", "Entity": "BOSNIA AND HERZEGOVINA", "MinorUnit": "2", "NumericCode": 977.0, "WithdrawalDate": null},{"AlphabeticCode": "BWP", "Currency": "Pula", "Entity": "BOTSWANA", "MinorUnit": "2", "NumericCode": 72.0, "WithdrawalDate": null},{"AlphabeticCode": "NOK", "Currency": "Norwegian Krone", "Entity": "BOUVET ISLAND", "MinorUnit": "2", "NumericCode": 578.0, "WithdrawalDate": null},{"AlphabeticCode": "BRL", "Currency": "Brazilian Real", "Entity": "BRAZIL", "MinorUnit": "2", "NumericCode": 986.0, "WithdrawalDate": null},{"AlphabeticCode": "USD", "Currency": "US Dollar", "Entity": "BRITISH INDIAN OCEAN TERRITORY (THE)", "MinorUnit": "2", "NumericCode": 840.0, "WithdrawalDate": null},{"AlphabeticCode": "BND", "Currency": "Brunei Dollar", "Entity": "BRUNEI DARUSSALAM", "MinorUnit": "2", "NumericCode": 96.0, "WithdrawalDate": null},{"AlphabeticCode": "BGN", "Currency": "Bulgarian Lev", "Entity": "BULGARIA", "MinorUnit": "2", "NumericCode": 975.0, "WithdrawalDate": null},{"AlphabeticCode": "XOF", "Currency": "CFA Franc BCEAO", "Entity": "BURKINA FASO", "MinorUnit": "0", "NumericCode": 952.0, "WithdrawalDate": null},{"AlphabeticCode": "BIF", "Currency": "Burundi Franc", "Entity": "BURUNDI", "MinorUnit": "0", "NumericCode": 108.0, "WithdrawalDate": null},{"AlphabeticCode": "CVE", "Currency": "Cabo Verde Escudo", "Entity": "CABO VERDE", "MinorUnit": "2", "NumericCode": 132.0, "WithdrawalDate": null},{"AlphabeticCode": "KHR", "Currency": "Riel", "Entity": "CAMBODIA", "MinorUnit": "2", "NumericCode": 116.0, "WithdrawalDate": null},{"AlphabeticCode": "XAF", "Currency": "CFA Franc BEAC", "Entity": "CAMEROON", "MinorUnit": "0", "NumericCode": 950.0, "WithdrawalDate": null},{"AlphabeticCode": "CAD", "Currency": "Canadian Dollar", "Entity": "CANADA", "MinorUnit": "2", "NumericCode": 124.0, "WithdrawalDate": null},{"AlphabeticCode": "KYD", "Currency": "Cayman Islands Dollar", "Entity": "CAYMAN ISLANDS (THE)", "MinorUnit": "2", "NumericCode": 136.0, "WithdrawalDate": null},{"AlphabeticCode": "XAF", "Currency": "CFA Franc BEAC", "Entity": "CENTRAL AFRICAN REPUBLIC (THE)", "MinorUnit": "0", "NumericCode": 950.0, "WithdrawalDate": null},{"AlphabeticCode": "XAF", "Currency": "CFA Franc BEAC", "Entity": "CHAD", "MinorUnit": "0", "NumericCode": 950.0, "WithdrawalDate": null},{"AlphabeticCode": "CLP", "Currency": "Chilean Peso", "Entity": "CHILE", "MinorUnit": "0", "NumericCode": 152.0, "WithdrawalDate": null},{"AlphabeticCode": "CLF", "Currency": "Unidad de Fomento", "Entity": "CHILE", "MinorUnit": "4", "NumericCode": 990.0, "WithdrawalDate": null},{"AlphabeticCode": "CNY", "Currency": "Yuan Renminbi", "Entity": "CHINA", "MinorUnit": "2", "NumericCode": 156.0, "WithdrawalDate": null},{"AlphabeticCode": "AUD", "Currency": "Australian Dollar", "Entity": "CHRISTMAS ISLAND", "MinorUnit": "2", "NumericCode": 36.0, "WithdrawalDate": null},{"AlphabeticCode": "AUD", "Currency": "Australian Dollar", "Entity": "COCOS (KEELING) ISLANDS (THE)", "MinorUnit": "2", "NumericCode": 36.0, "WithdrawalDate": null},{"AlphabeticCode": "COP", "Currency": "Colombian Peso", "Entity": "COLOMBIA", "MinorUnit": "2", "NumericCode": 170.0, "WithdrawalDate": null},{"AlphabeticCode": "COU", "Currency": "Unidad de Valor Real", "Entity": "COLOMBIA", "MinorUnit": "2", "NumericCode": 970.0, "WithdrawalDate": null},{"AlphabeticCode": "KMF", "Currency": "Comorian Franc", "Entity": "COMOROS (THE)", "MinorUnit": "0", "NumericCode": 174.0, "WithdrawalDate": null},{"AlphabeticCode": "CDF", "Currency": "Congolese Franc", "Entity": "CONGO (THE DEMOCRATIC REPUBLIC OF THE)", "MinorUnit": "2", "NumericCode": 976.0, "WithdrawalDate": null},{"AlphabeticCode": "XAF", "Currency": "CFA Franc BEAC", "Entity": "CONGO (THE)", "MinorUnit": "0", "NumericCode": 950.0, "WithdrawalDate": null},{"AlphabeticCode": "NZD", "Currency": "New Zealand Dollar", "Entity": "COOK ISLANDS (THE)", "MinorUnit": "2", "NumericCode": 554.0, "WithdrawalDate": null},{"AlphabeticCode": "CRC", "Currency": "Costa Rican Colon", "Entity": "COSTA RICA", "MinorUnit": "2", "NumericCode": 188.0, "WithdrawalDate": null},{"AlphabeticCode": "XOF", "Currency": "CFA Franc BCEAO", "Entity": "C\u00d4TE D'IVOIRE", "MinorUnit": "0", "NumericCode": 952.0, "WithdrawalDate": null},{"AlphabeticCode": "HRK", "Currency": "Kuna", "Entity": "CROATIA", "MinorUnit": "2", "NumericCode": 191.0, "WithdrawalDate": null},{"AlphabeticCode": "CUP", "Currency": "Cuban Peso", "Entity": "CUBA", "MinorUnit": "2", "NumericCode": 192.0, "WithdrawalDate": null},{"AlphabeticCode": "CUC", "Currency": "Peso Convertible", "Entity": "CUBA", "MinorUnit": "2", "NumericCode": 931.0, "WithdrawalDate": null},{"AlphabeticCode": "ANG", "Currency": "Netherlands Antillean Guilder", "Entity": "CURA\u00c7AO", "MinorUnit": "2", "NumericCode": 532.0, "WithdrawalDate": null},{"AlphabeticCode": "EUR", "Currency": "Euro", "Entity": "CYPRUS", "MinorUnit": "2", "NumericCode": 978.0, "WithdrawalDate": null},{"AlphabeticCode": "CZK", "Currency": "Czech Koruna", "Entity": "CZECHIA", "MinorUnit": "2", "NumericCode": 203.0, "WithdrawalDate": null},{"AlphabeticCode": "DKK", "Currency": "Danish Krone", "Entity": "DENMARK", "MinorUnit": "2", "NumericCode": 208.0, "WithdrawalDate": null},{"AlphabeticCode": "DJF", "Currency": "Djibouti Franc", "Entity": "DJIBOUTI", "MinorUnit": "0", "NumericCode": 262.0, "WithdrawalDate": null},{"AlphabeticCode": "XCD", "Currency": "East Caribbean Dollar", "Entity": "DOMINICA", "MinorUnit": "2", "NumericCode": 951.0, "WithdrawalDate": null},{"AlphabeticCode": "DOP", "Currency": "Dominican Peso", "Entity": "DOMINICAN REPUBLIC (THE)", "MinorUnit": "2", "NumericCode": 214.0, "WithdrawalDate": null},{"AlphabeticCode": "USD", "Currency": "US Dollar", "Entity": "ECUADOR", "MinorUnit": "2", "NumericCode": 840.0, "WithdrawalDate": null},{"AlphabeticCode": "EGP", "Currency": "Egyptian Pound", "Entity": "EGYPT", "MinorUnit": "2", "NumericCode": 818.0, "WithdrawalDate": null},{"AlphabeticCode": "SVC", "Currency": "El Salvador Colon", "Entity": "EL SALVADOR", "MinorUnit": "2", "NumericCode": 222.0, "WithdrawalDate": null},{"AlphabeticCode": "USD", "Currency": "US Dollar", "Entity": "EL SALVADOR", "MinorUnit": "2", "NumericCode": 840.0, "WithdrawalDate": null},{"AlphabeticCode": "XAF", "Currency": "CFA Franc BEAC", "Entity": "EQUATORIAL GUINEA", "MinorUnit": "0", "NumericCode": 950.0, "WithdrawalDate": null},{"AlphabeticCode": "ERN", "Currency": "Nakfa", "Entity": "ERITREA", "MinorUnit": "2", "NumericCode": 232.0, "WithdrawalDate": null},{"AlphabeticCode": "EUR", "Currency": "Euro", "Entity": "ESTONIA", "MinorUnit": "2", "NumericCode": 978.0, "WithdrawalDate": null},{"AlphabeticCode": "SZL", "Currency": "Lilangeni", "Entity": "ESWATINI", "MinorUnit": "2", "NumericCode": 748.0, "WithdrawalDate": null},{"AlphabeticCode": "ETB", "Currency": "Ethiopian Birr", "Entity": "ETHIOPIA", "MinorUnit": "2", "NumericCode": 230.0, "WithdrawalDate": null},{"AlphabeticCode": "EUR", "Currency": "Euro", "Entity": "EUROPEAN UNION", "MinorUnit": "2", "NumericCode": 978.0, "WithdrawalDate": null},{"AlphabeticCode": "FKP", "Currency": "Falkland Islands Pound", "Entity": "FALKLAND ISLANDS (THE) [MALVINAS]", "MinorUnit": "2", "NumericCode": 238.0, "WithdrawalDate": null},{"AlphabeticCode": "DKK", "Currency": "Danish Krone", "Entity": "FAROE ISLANDS (THE)", "MinorUnit": "2", "NumericCode": 208.0, "WithdrawalDate": null},{"AlphabeticCode": "FJD", "Currency": "Fiji Dollar", "Entity": "FIJI", "MinorUnit": "2", "NumericCode": 242.0, "WithdrawalDate": null},{"AlphabeticCode": "EUR", "Currency": "Euro", "Entity": "FINLAND", "MinorUnit": "2", "NumericCode": 978.0, "WithdrawalDate": null},{"AlphabeticCode": "EUR", "Currency": "Euro", "Entity": "FRANCE", "MinorUnit": "2", "NumericCode": 978.0, "WithdrawalDate": null},{"AlphabeticCode": "EUR", "Currency": "Euro", "Entity": "FRENCH GUIANA", "MinorUnit": "2", "NumericCode": 978.0, "WithdrawalDate": null},{"AlphabeticCode": "XPF", "Currency": "CFP Franc", "Entity": "FRENCH POLYNESIA", "MinorUnit": "0", "NumericCode": 953.0, "WithdrawalDate": null},{"AlphabeticCode": "EUR", "Currency": "Euro", "Entity": "FRENCH SOUTHERN TERRITORIES (THE)", "MinorUnit": "2", "NumericCode": 978.0, "WithdrawalDate": null},{"AlphabeticCode": "XAF", "Currency": "CFA Franc BEAC", "Entity": "GABON", "MinorUnit": "0", "NumericCode": 950.0, "WithdrawalDate": null},{"AlphabeticCode": "GMD", "Currency": "Dalasi", "Entity": "GAMBIA (THE)", "MinorUnit": "2", "NumericCode": 270.0, "WithdrawalDate": null},{"AlphabeticCode": "GEL", "Currency": "Lari", "Entity": "GEORGIA", "MinorUnit": "2", "NumericCode": 981.0, "WithdrawalDate": null},{"AlphabeticCode": "EUR", "Currency": "Euro", "Entity": "GERMANY", "MinorUnit": "2", "NumericCode": 978.0, "WithdrawalDate": null},{"AlphabeticCode": "GHS", "Currency": "Ghana Cedi", "Entity": "GHANA", "MinorUnit": "2", "NumericCode": 936.0, "WithdrawalDate": null},{"AlphabeticCode": "GIP", "Currency": "Gibraltar Pound", "Entity": "GIBRALTAR", "MinorUnit": "2", "NumericCode": 292.0, "WithdrawalDate": null},{"AlphabeticCode": "EUR", "Currency": "Euro", "Entity": "GREECE", "MinorUnit": "2", "NumericCode": 978.0, "WithdrawalDate": null},{"AlphabeticCode": "DKK", "Currency": "Danish Krone", "Entity": "GREENLAND", "MinorUnit": "2", "NumericCode": 208.0, "WithdrawalDate": null},{"AlphabeticCode": "XCD", "Currency": "East Caribbean Dollar", "Entity": "GRENADA", "MinorUnit": "2", "NumericCode": 951.0, "WithdrawalDate": null},{"AlphabeticCode": "EUR", "Currency": "Euro", "Entity": "GUADELOUPE", "MinorUnit": "2", "NumericCode": 978.0, "WithdrawalDate": null},{"AlphabeticCode": "USD", "Currency": "US Dollar", "Entity": "GUAM", "MinorUnit": "2", "NumericCode": 840.0, "WithdrawalDate": null},{"AlphabeticCode": "GTQ", "Currency": "Quetzal", "Entity": "GUATEMALA", "MinorUnit": "2", "NumericCode": 320.0, "WithdrawalDate": null},{"AlphabeticCode": "GBP", "Currency": "Pound Sterling", "Entity": "GUERNSEY", "MinorUnit": "2", "NumericCode": 826.0, "WithdrawalDate": null},{"AlphabeticCode": "GNF", "Currency": "Guinean Franc", "Entity": "GUINEA", "MinorUnit": "0", "NumericCode": 324.0, "WithdrawalDate": null},{"AlphabeticCode": "XOF", "Currency": "CFA Franc BCEAO", "Entity": "GUINEA-BISSAU", "MinorUnit": "0", "NumericCode": 952.0, "WithdrawalDate": null},{"AlphabeticCode": "GYD", "Currency": "Guyana Dollar", "Entity": "GUYANA", "MinorUnit": "2", "NumericCode": 328.0, "WithdrawalDate": null},{"AlphabeticCode": "HTG", "Currency": "Gourde", "Entity": "HAITI", "MinorUnit": "2", "NumericCode": 332.0, "WithdrawalDate": null},{"AlphabeticCode": "USD", "Currency": "US Dollar", "Entity": "HAITI", "MinorUnit": "2", "NumericCode": 840.0, "WithdrawalDate": null},{"AlphabeticCode": "AUD", "Currency": "Australian Dollar", "Entity": "HEARD ISLAND AND McDONALD ISLANDS", "MinorUnit": "2", "NumericCode": 36.0, "WithdrawalDate": null},{"AlphabeticCode": "EUR", "Currency": "Euro", "Entity": "HOLY SEE (THE)", "MinorUnit": "2", "NumericCode": 978.0, "WithdrawalDate": null},{"AlphabeticCode": "HNL", "Currency": "Lempira", "Entity": "HONDURAS", "MinorUnit": "2", "NumericCode": 340.0, "WithdrawalDate": null},{"AlphabeticCode": "HKD", "Currency": "Hong Kong Dollar", "Entity": "HONG KONG", "MinorUnit": "2", "NumericCode": 344.0, "WithdrawalDate": null},{"AlphabeticCode": "HUF", "Currency": "Forint", "Entity": "HUNGARY", "MinorUnit": "2", "NumericCode": 348.0, "WithdrawalDate": null},{"AlphabeticCode": "ISK", "Currency": "Iceland Krona", "Entity": "ICELAND", "MinorUnit": "0", "NumericCode": 352.0, "WithdrawalDate": null},{"AlphabeticCode": "INR", "Currency": "Indian Rupee", "Entity": "INDIA", "MinorUnit": "2", "NumericCode": 356.0, "WithdrawalDate": null},{"AlphabeticCode": "IDR", "Currency": "Rupiah", "Entity": "INDONESIA", "MinorUnit": "2", "NumericCode": 360.0, "WithdrawalDate": null},{"AlphabeticCode": "XDR", "Currency": "SDR (Special Drawing Right)", "Entity": "INTERNATIONAL MONETARY FUND (IMF)", "MinorUnit": "-", "NumericCode": 960.0, "WithdrawalDate": null},{"AlphabeticCode": "IRR", "Currency": "Iranian Rial", "Entity": "IRAN (ISLAMIC REPUBLIC OF)", "MinorUnit": "2", "NumericCode": 364.0, "WithdrawalDate": null},{"AlphabeticCode": "IQD", "Currency": "Iraqi Dinar", "Entity": "IRAQ", "MinorUnit": "3", "NumericCode": 368.0, "WithdrawalDate": null},{"AlphabeticCode": "EUR", "Currency": "Euro", "Entity": "IRELAND", "MinorUnit": "2", "NumericCode": 978.0, "WithdrawalDate": null},{"AlphabeticCode": "GBP", "Currency": "Pound Sterling", "Entity": "ISLE OF MAN", "MinorUnit": "2", "NumericCode": 826.0, "WithdrawalDate": null},{"AlphabeticCode": "ILS", "Currency": "New Israeli Sheqel", "Entity": "ISRAEL", "MinorUnit": "2", "NumericCode": 376.0, "WithdrawalDate": null},{"AlphabeticCode": "EUR", "Currency": "Euro", "Entity": "ITALY", "MinorUnit": "2", "NumericCode": 978.0, "WithdrawalDate": null},{"AlphabeticCode": "JMD", "Currency": "Jamaican Dollar", "Entity": "JAMAICA", "MinorUnit": "2", "NumericCode": 388.0, "WithdrawalDate": null},{"AlphabeticCode": "JPY", "Currency": "Yen", "Entity": "JAPAN", "MinorUnit": "0", "NumericCode": 392.0, "WithdrawalDate": null},{"AlphabeticCode": "GBP", "Currency": "Pound Sterling", "Entity": "JERSEY", "MinorUnit": "2", "NumericCode": 826.0, "WithdrawalDate": null},{"AlphabeticCode": "JOD", "Currency": "Jordanian Dinar", "Entity": "JORDAN", "MinorUnit": "3", "NumericCode": 400.0, "WithdrawalDate": null},{"AlphabeticCode": "KZT", "Currency": "Tenge", "Entity": "KAZAKHSTAN", "MinorUnit": "2", "NumericCode": 398.0, "WithdrawalDate": null},{"AlphabeticCode": "KES", "Currency": "Kenyan Shilling", "Entity": "KENYA", "MinorUnit": "2", "NumericCode": 404.0, "WithdrawalDate": null},{"AlphabeticCode": "AUD", "Currency": "Australian Dollar", "Entity": "KIRIBATI", "MinorUnit": "2", "NumericCode": 36.0, "WithdrawalDate": null},{"AlphabeticCode": "KPW", "Currency": "North Korean Won", "Entity": "KOREA (THE DEMOCRATIC PEOPLE'S REPUBLIC OF)", "MinorUnit": "2", "NumericCode": 408.0, "WithdrawalDate": null},{"AlphabeticCode": "KRW", "Currency": "Won", "Entity": "KOREA (THE REPUBLIC OF)", "MinorUnit": "0", "NumericCode": 410.0, "WithdrawalDate": null},{"AlphabeticCode": "KWD", "Currency": "Kuwaiti Dinar", "Entity": "KUWAIT", "MinorUnit": "3", "NumericCode": 414.0, "WithdrawalDate": null},{"AlphabeticCode": "KGS", "Currency": "Som", "Entity": "KYRGYZSTAN", "MinorUnit": "2", "NumericCode": 417.0, "WithdrawalDate": null},{"AlphabeticCode": "LAK", "Currency": "Lao Kip", "Entity": "LAO PEOPLE'S DEMOCRATIC REPUBLIC (THE)", "MinorUnit": "2", "NumericCode": 418.0, "WithdrawalDate": null},{"AlphabeticCode": "EUR", "Currency": "Euro", "Entity": "LATVIA", "MinorUnit": "2", "NumericCode": 978.0, "WithdrawalDate": null},{"AlphabeticCode": "LBP", "Currency": "Lebanese Pound", "Entity": "LEBANON", "MinorUnit": "2", "NumericCode": 422.0, "WithdrawalDate": null},{"AlphabeticCode": "LSL", "Currency": "Loti", "Entity": "LESOTHO", "MinorUnit": "2", "NumericCode": 426.0, "WithdrawalDate": null},{"AlphabeticCode": "ZAR", "Currency": "Rand", "Entity": "LESOTHO", "MinorUnit": "2", "NumericCode": 710.0, "WithdrawalDate": null},{"AlphabeticCode": "LRD", "Currency": "Liberian Dollar", "Entity": "LIBERIA", "MinorUnit": "2", "NumericCode": 430.0, "WithdrawalDate": null},{"AlphabeticCode": "LYD", "Currency": "Libyan Dinar", "Entity": "LIBYA", "MinorUnit": "3", "NumericCode": 434.0, "WithdrawalDate": null},{"AlphabeticCode": "CHF", "Currency": "Swiss Franc", "Entity": "LIECHTENSTEIN", "MinorUnit": "2", "NumericCode": 756.0, "WithdrawalDate": null},{"AlphabeticCode": "EUR", "Currency": "Euro", "Entity": "LITHUANIA", "MinorUnit": "2", "NumericCode": 978.0, "WithdrawalDate": null},{"AlphabeticCode": "EUR", "Currency": "Euro", "Entity": "LUXEMBOURG", "MinorUnit": "2", "NumericCode": 978.0, "WithdrawalDate": null},{"AlphabeticCode": "MOP", "Currency": "Pataca", "Entity": "MACAO", "MinorUnit": "2", "NumericCode": 446.0, "WithdrawalDate": null},{"AlphabeticCode": "MKD", "Currency": "Denar", "Entity": "NORTH MACEDONIA", "MinorUnit": "2", "NumericCode": 807.0, "WithdrawalDate": null},{"AlphabeticCode": "MGA", "Currency": "Malagasy Ariary", "Entity": "MADAGASCAR", "MinorUnit": "2", "NumericCode": 969.0, "WithdrawalDate": null},{"AlphabeticCode": "MWK", "Currency": "Malawi Kwacha", "Entity": "MALAWI", "MinorUnit": "2", "NumericCode": 454.0, "WithdrawalDate": null},{"AlphabeticCode": "MYR", "Currency": "Malaysian Ringgit", "Entity": "MALAYSIA", "MinorUnit": "2", "NumericCode": 458.0, "WithdrawalDate": null},{"AlphabeticCode": "MVR", "Currency": "Rufiyaa", "Entity": "MALDIVES", "MinorUnit": "2", "NumericCode": 462.0, "WithdrawalDate": null},{"AlphabeticCode": "XOF", "Currency": "CFA Franc BCEAO", "Entity": "MALI", "MinorUnit": "0", "NumericCode": 952.0, "WithdrawalDate": null},{"AlphabeticCode": "EUR", "Currency": "Euro", "Entity": "MALTA", "MinorUnit": "2", "NumericCode": 978.0, "WithdrawalDate": null},{"AlphabeticCode": "USD", "Currency": "US Dollar", "Entity": "MARSHALL ISLANDS (THE)", "MinorUnit": "2", "NumericCode": 840.0, "WithdrawalDate": null},{"AlphabeticCode": "EUR", "Currency": "Euro", "Entity": "MARTINIQUE", "MinorUnit": "2", "NumericCode": 978.0, "WithdrawalDate": null},{"AlphabeticCode": "MRU", "Currency": "Ouguiya", "Entity": "MAURITANIA", "MinorUnit": "2", "NumericCode": 929.0, "WithdrawalDate": null},{"AlphabeticCode": "MUR", "Currency": "Mauritius Rupee", "Entity": "MAURITIUS", "MinorUnit": "2", "NumericCode": 480.0, "WithdrawalDate": null},{"AlphabeticCode": "EUR", "Currency": "Euro", "Entity": "MAYOTTE", "MinorUnit": "2", "NumericCode": 978.0, "WithdrawalDate": null},{"AlphabeticCode": "XUA", "Currency": "ADB Unit of Account", "Entity": "MEMBER COUNTRIES OF THE AFRICAN DEVELOPMENT BANK GROUP", "MinorUnit": "-", "NumericCode": 965.0, "WithdrawalDate": null},{"AlphabeticCode": "MXN", "Currency": "Mexican Peso", "Entity": "MEXICO", "MinorUnit": "2", "NumericCode": 484.0, "WithdrawalDate": null},{"AlphabeticCode": "MXV", "Currency": "Mexican Unidad de Inversion (UDI)", "Entity": "MEXICO", "MinorUnit": "2", "NumericCode": 979.0, "WithdrawalDate": null},{"AlphabeticCode": "USD", "Currency": "US Dollar", "Entity": "MICRONESIA (FEDERATED STATES OF)", "MinorUnit": "2", "NumericCode": 840.0, "WithdrawalDate": null},{"AlphabeticCode": "MDL", "Currency": "Moldovan Leu", "Entity": "MOLDOVA (THE REPUBLIC OF)", "MinorUnit": "2", "NumericCode": 498.0, "WithdrawalDate": null},{"AlphabeticCode": "EUR", "Currency": "Euro", "Entity": "MONACO", "MinorUnit": "2", "NumericCode": 978.0, "WithdrawalDate": null},{"AlphabeticCode": "MNT", "Currency": "Tugrik", "Entity": "MONGOLIA", "MinorUnit": "2", "NumericCode": 496.0, "WithdrawalDate": null},{"AlphabeticCode": "EUR", "Currency": "Euro", "Entity": "MONTENEGRO", "MinorUnit": "2", "NumericCode": 978.0, "WithdrawalDate": null},{"AlphabeticCode": "XCD", "Currency": "East Caribbean Dollar", "Entity": "MONTSERRAT", "MinorUnit": "2", "NumericCode": 951.0, "WithdrawalDate": null},{"AlphabeticCode": "MAD", "Currency": "Moroccan Dirham", "Entity": "MOROCCO", "MinorUnit": "2", "NumericCode": 504.0, "WithdrawalDate": null},{"AlphabeticCode": "MZN", "Currency": "Mozambique Metical", "Entity": "MOZAMBIQUE", "MinorUnit": "2", "NumericCode": 943.0, "WithdrawalDate": null},{"AlphabeticCode": "MMK", "Currency": "Kyat", "Entity": "MYANMAR", "MinorUnit": "2", "NumericCode": 104.0, "WithdrawalDate": null},{"AlphabeticCode": "NAD", "Currency": "Namibia Dollar", "Entity": "NAMIBIA", "MinorUnit": "2", "NumericCode": 516.0, "WithdrawalDate": null},{"AlphabeticCode": "ZAR", "Currency": "Rand", "Entity": "NAMIBIA", "MinorUnit": "2", "NumericCode": 710.0, "WithdrawalDate": null},{"AlphabeticCode": "AUD", "Currency": "Australian Dollar", "Entity": "NAURU", "MinorUnit": "2", "NumericCode": 36.0, "WithdrawalDate": null},{"AlphabeticCode": "NPR", "Currency": "Nepalese Rupee", "Entity": "NEPAL", "MinorUnit": "2", "NumericCode": 524.0, "WithdrawalDate": null},{"AlphabeticCode": "EUR", "Currency": "Euro", "Entity": "NETHERLANDS (THE)", "MinorUnit": "2", "NumericCode": 978.0, "WithdrawalDate": null},{"AlphabeticCode": "XPF", "Currency": "CFP Franc", "Entity": "NEW CALEDONIA", "MinorUnit": "0", "NumericCode": 953.0, "WithdrawalDate": null},{"AlphabeticCode": "NZD", "Currency": "New Zealand Dollar", "Entity": "NEW ZEALAND", "MinorUnit": "2", "NumericCode": 554.0, "WithdrawalDate": null},{"AlphabeticCode": "NIO", "Currency": "Cordoba Oro", "Entity": "NICARAGUA", "MinorUnit": "2", "NumericCode": 558.0, "WithdrawalDate": null},{"AlphabeticCode": "XOF", "Currency": "CFA Franc BCEAO", "Entity": "NIGER (THE)", "MinorUnit": "0", "NumericCode": 952.0, "WithdrawalDate": null},{"AlphabeticCode": "NGN", "Currency": "Naira", "Entity": "NIGERIA", "MinorUnit": "2", "NumericCode": 566.0, "WithdrawalDate": null},{"AlphabeticCode": "NZD", "Currency": "New Zealand Dollar", "Entity": "NIUE", "MinorUnit": "2", "NumericCode": 554.0, "WithdrawalDate": null},{"AlphabeticCode": "AUD", "Currency": "Australian Dollar", "Entity": "NORFOLK ISLAND", "MinorUnit": "2", "NumericCode": 36.0, "WithdrawalDate": null},{"AlphabeticCode": "USD", "Currency": "US Dollar", "Entity": "NORTHERN MARIANA ISLANDS (THE)", "MinorUnit": "2", "NumericCode": 840.0, "WithdrawalDate": null},{"AlphabeticCode": "NOK", "Currency": "Norwegian Krone", "Entity": "NORWAY", "MinorUnit": "2", "NumericCode": 578.0, "WithdrawalDate": null},{"AlphabeticCode": "OMR", "Currency": "Rial Omani", "Entity": "OMAN", "MinorUnit": "3", "NumericCode": 512.0, "WithdrawalDate": null},{"AlphabeticCode": "PKR", "Currency": "Pakistan Rupee", "Entity": "PAKISTAN", "MinorUnit": "2", "NumericCode": 586.0, "WithdrawalDate": null},{"AlphabeticCode": "USD", "Currency": "US Dollar", "Entity": "PALAU", "MinorUnit": "2", "NumericCode": 840.0, "WithdrawalDate": null},{"AlphabeticCode": null, "Currency": "No universal currency", "Entity": "PALESTINE, STATE OF", "MinorUnit": null, "NumericCode": null, "WithdrawalDate": null},{"AlphabeticCode": "PAB", "Currency": "Balboa", "Entity": "PANAMA", "MinorUnit": "2", "NumericCode": 590.0, "WithdrawalDate": null},{"AlphabeticCode": "USD", "Currency": "US Dollar", "Entity": "PANAMA", "MinorUnit": "2", "NumericCode": 840.0, "WithdrawalDate": null},{"AlphabeticCode": "PGK", "Currency": "Kina", "Entity": "PAPUA NEW GUINEA", "MinorUnit": "2", "NumericCode": 598.0, "WithdrawalDate": null},{"AlphabeticCode": "PYG", "Currency": "Guarani", "Entity": "PARAGUAY", "MinorUnit": "0", "NumericCode": 600.0, "WithdrawalDate": null},{"AlphabeticCode": "PEN", "Currency": "Sol", "Entity": "PERU", "MinorUnit": "2", "NumericCode": 604.0, "WithdrawalDate": null},{"AlphabeticCode": "PHP", "Currency": "Philippine Peso", "Entity": "PHILIPPINES (THE)", "MinorUnit": "2", "NumericCode": 608.0, "WithdrawalDate": null},{"AlphabeticCode": "NZD", "Currency": "New Zealand Dollar", "Entity": "PITCAIRN", "MinorUnit": "2", "NumericCode": 554.0, "WithdrawalDate": null},{"AlphabeticCode": "PLN", "Currency": "Zloty", "Entity": "POLAND", "MinorUnit": "2", "NumericCode": 985.0, "WithdrawalDate": null},{"AlphabeticCode": "EUR", "Currency": "Euro", "Entity": "PORTUGAL", "MinorUnit": "2", "NumericCode": 978.0, "WithdrawalDate": null},{"AlphabeticCode": "USD", "Currency": "US Dollar", "Entity": "PUERTO RICO", "MinorUnit": "2", "NumericCode": 840.0, "WithdrawalDate": null},{"AlphabeticCode": "QAR", "Currency": "Qatari Rial", "Entity": "QATAR", "MinorUnit": "2", "NumericCode": 634.0, "WithdrawalDate": null},{"AlphabeticCode": "EUR", "Currency": "Euro", "Entity": "R\u00c9UNION", "MinorUnit": "2", "NumericCode": 978.0, "WithdrawalDate": null},{"AlphabeticCode": "RON", "Currency": "Romanian Leu", "Entity": "ROMANIA", "MinorUnit": "2", "NumericCode": 946.0, "WithdrawalDate": null},{"AlphabeticCode": "RUB", "Currency": "Russian Ruble", "Entity": "RUSSIAN FEDERATION (THE)", "MinorUnit": "2", "NumericCode": 643.0, "WithdrawalDate": null},{"AlphabeticCode": "RWF", "Currency": "Rwanda Franc", "Entity": "RWANDA", "MinorUnit": "0", "NumericCode": 646.0, "WithdrawalDate": null},{"AlphabeticCode": "EUR", "Currency": "Euro", "Entity": "SAINT BARTH\u00c9LEMY", "MinorUnit": "2", "NumericCode": 978.0, "WithdrawalDate": null},{"AlphabeticCode": "SHP", "Currency": "Saint Helena Pound", "Entity": "SAINT HELENA, ASCENSION AND TRISTAN DA CUNHA", "MinorUnit": "2", "NumericCode": 654.0, "WithdrawalDate": null},{"AlphabeticCode": "XCD", "Currency": "East Caribbean Dollar", "Entity": "SAINT KITTS AND NEVIS", "MinorUnit": "2", "NumericCode": 951.0, "WithdrawalDate": null},{"AlphabeticCode": "XCD", "Currency": "East Caribbean Dollar", "Entity": "SAINT LUCIA", "MinorUnit": "2", "NumericCode": 951.0, "WithdrawalDate": null},{"AlphabeticCode": "EUR", "Currency": "Euro", "Entity": "SAINT MARTIN (FRENCH PART)", "MinorUnit": "2", "NumericCode": 978.0, "WithdrawalDate": null},{"AlphabeticCode": "EUR", "Currency": "Euro", "Entity": "SAINT PIERRE AND MIQUELON", "MinorUnit": "2", "NumericCode": 978.0, "WithdrawalDate": null},{"AlphabeticCode": "XCD", "Currency": "East Caribbean Dollar", "Entity": "SAINT VINCENT AND THE GRENADINES", "MinorUnit": "2", "NumericCode": 951.0, "WithdrawalDate": null},{"AlphabeticCode": "WST", "Currency": "Tala", "Entity": "SAMOA", "MinorUnit": "2", "NumericCode": 882.0, "WithdrawalDate": null},{"AlphabeticCode": "EUR", "Currency": "Euro", "Entity": "SAN MARINO", "MinorUnit": "2", "NumericCode": 978.0, "WithdrawalDate": null},{"AlphabeticCode": "STN", "Currency": "Dobra", "Entity": "SAO TOME AND PRINCIPE", "MinorUnit": "2", "NumericCode": 930.0, "WithdrawalDate": null},{"AlphabeticCode": "SAR", "Currency": "Saudi Riyal", "Entity": "SAUDI ARABIA", "MinorUnit": "2", "NumericCode": 682.0, "WithdrawalDate": null},{"AlphabeticCode": "XOF", "Currency": "CFA Franc BCEAO", "Entity": "SENEGAL", "MinorUnit": "0", "NumericCode": 952.0, "WithdrawalDate": null},{"AlphabeticCode": "RSD", "Currency": "Serbian Dinar", "Entity": "SERBIA", "MinorUnit": "2", "NumericCode": 941.0, "WithdrawalDate": null},{"AlphabeticCode": "SCR", "Currency": "Seychelles Rupee", "Entity": "SEYCHELLES", "MinorUnit": "2", "NumericCode": 690.0, "WithdrawalDate": null},{"AlphabeticCode": "SLL", "Currency": "Leone", "Entity": "SIERRA LEONE", "MinorUnit": "2", "NumericCode": 694.0, "WithdrawalDate": null},{"AlphabeticCode": "SGD", "Currency": "Singapore Dollar", "Entity": "SINGAPORE", "MinorUnit": "2", "NumericCode": 702.0, "WithdrawalDate": null},{"AlphabeticCode": "ANG", "Currency": "Netherlands Antillean Guilder", "Entity": "SINT MAARTEN (DUTCH PART)", "MinorUnit": "2", "NumericCode": 532.0, "WithdrawalDate": null},{"AlphabeticCode": "XSU", "Currency": "Sucre", "Entity": "SISTEMA UNITARIO DE COMPENSACION REGIONAL DE PAGOS \"SUCRE\"", "MinorUnit": "-", "NumericCode": 994.0, "WithdrawalDate": null},{"AlphabeticCode": "EUR", "Currency": "Euro", "Entity": "SLOVAKIA", "MinorUnit": "2", "NumericCode": 978.0, "WithdrawalDate": null},{"AlphabeticCode": "EUR", "Currency": "Euro", "Entity": "SLOVENIA", "MinorUnit": "2", "NumericCode": 978.0, "WithdrawalDate": null},{"AlphabeticCode": "SBD", "Currency": "Solomon Islands Dollar", "Entity": "SOLOMON ISLANDS", "MinorUnit": "2", "NumericCode": 90.0, "WithdrawalDate": null},{"AlphabeticCode": "SOS", "Currency": "Somali Shilling", "Entity": "SOMALIA", "MinorUnit": "2", "NumericCode": 706.0, "WithdrawalDate": null},{"AlphabeticCode": "ZAR", "Currency": "Rand", "Entity": "SOUTH AFRICA", "MinorUnit": "2", "NumericCode": 710.0, "WithdrawalDate": null},{"AlphabeticCode": null, "Currency": "No universal currency", "Entity": "SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS", "MinorUnit": null, "NumericCode": null, "WithdrawalDate": null},{"AlphabeticCode": "SSP", "Currency": "South Sudanese Pound", "Entity": "SOUTH SUDAN", "MinorUnit": "2", "NumericCode": 728.0, "WithdrawalDate": null},{"AlphabeticCode": "EUR", "Currency": "Euro", "Entity": "SPAIN", "MinorUnit": "2", "NumericCode": 978.0, "WithdrawalDate": null},{"AlphabeticCode": "LKR", "Currency": "Sri Lanka Rupee", "Entity": "SRI LANKA", "MinorUnit": "2", "NumericCode": 144.0, "WithdrawalDate": null},{"AlphabeticCode": "SDG", "Currency": "Sudanese Pound", "Entity": "SUDAN (THE)", "MinorUnit": "2", "NumericCode": 938.0, "WithdrawalDate": null},{"AlphabeticCode": "SRD", "Currency": "Surinam Dollar", "Entity": "SURINAME", "MinorUnit": "2", "NumericCode": 968.0, "WithdrawalDate": null},{"AlphabeticCode": "NOK", "Currency": "Norwegian Krone", "Entity": "SVALBARD AND JAN MAYEN", "MinorUnit": "2", "NumericCode": 578.0, "WithdrawalDate": null},{"AlphabeticCode": "SEK", "Currency": "Swedish Krona", "Entity": "SWEDEN", "MinorUnit": "2", "NumericCode": 752.0, "WithdrawalDate": null},{"AlphabeticCode": "CHF", "Currency": "Swiss Franc", "Entity": "SWITZERLAND", "MinorUnit": "2", "NumericCode": 756.0, "WithdrawalDate": null},{"AlphabeticCode": "CHE", "Currency": "WIR Euro", "Entity": "SWITZERLAND", "MinorUnit": "2", "NumericCode": 947.0, "WithdrawalDate": null},{"AlphabeticCode": "CHW", "Currency": "WIR Franc", "Entity": "SWITZERLAND", "MinorUnit": "2", "NumericCode": 948.0, "WithdrawalDate": null},{"AlphabeticCode": "SYP", "Currency": "Syrian Pound", "Entity": "SYRIAN ARAB REPUBLIC", "MinorUnit": "2", "NumericCode": 760.0, "WithdrawalDate": null},{"AlphabeticCode": "TWD", "Currency": "New Taiwan Dollar", "Entity": "TAIWAN (PROVINCE OF CHINA)", "MinorUnit": "2", "NumericCode": 901.0, "WithdrawalDate": null},{"AlphabeticCode": "TJS", "Currency": "Somoni", "Entity": "TAJIKISTAN", "MinorUnit": "2", "NumericCode": 972.0, "WithdrawalDate": null},{"AlphabeticCode": "TZS", "Currency": "Tanzanian Shilling", "Entity": "TANZANIA, UNITED REPUBLIC OF", "MinorUnit": "2", "NumericCode": 834.0, "WithdrawalDate": null},{"AlphabeticCode": "THB", "Currency": "Baht", "Entity": "THAILAND", "MinorUnit": "2", "NumericCode": 764.0, "WithdrawalDate": null},{"AlphabeticCode": "USD", "Currency": "US Dollar", "Entity": "TIMOR-LESTE", "MinorUnit": "2", "NumericCode": 840.0, "WithdrawalDate": null},{"AlphabeticCode": "XOF", "Currency": "CFA Franc BCEAO", "Entity": "TOGO", "MinorUnit": "0", "NumericCode": 952.0, "WithdrawalDate": null},{"AlphabeticCode": "NZD", "Currency": "New Zealand Dollar", "Entity": "TOKELAU", "MinorUnit": "2", "NumericCode": 554.0, "WithdrawalDate": null},{"AlphabeticCode": "TOP", "Currency": "Pa'anga", "Entity": "TONGA", "MinorUnit": "2", "NumericCode": 776.0, "WithdrawalDate": null},{"AlphabeticCode": "TTD", "Currency": "Trinidad and Tobago Dollar", "Entity": "TRINIDAD AND TOBAGO", "MinorUnit": "2", "NumericCode": 780.0, "WithdrawalDate": null},{"AlphabeticCode": "TND", "Currency": "Tunisian Dinar", "Entity": "TUNISIA", "MinorUnit": "3", "NumericCode": 788.0, "WithdrawalDate": null},{"AlphabeticCode": "TRY", "Currency": "Turkish Lira", "Entity": "TURKEY", "MinorUnit": "2", "NumericCode": 949.0, "WithdrawalDate": null},{"AlphabeticCode": "TMT", "Currency": "Turkmenistan New Manat", "Entity": "TURKMENISTAN", "MinorUnit": "2", "NumericCode": 934.0, "WithdrawalDate": null},{"AlphabeticCode": "USD", "Currency": "US Dollar", "Entity": "TURKS AND CAICOS ISLANDS (THE)", "MinorUnit": "2", "NumericCode": 840.0, "WithdrawalDate": null},{"AlphabeticCode": "AUD", "Currency": "Australian Dollar", "Entity": "TUVALU", "MinorUnit": "2", "NumericCode": 36.0, "WithdrawalDate": null},{"AlphabeticCode": "UGX", "Currency": "Uganda Shilling", "Entity": "UGANDA", "MinorUnit": "0", "NumericCode": 800.0, "WithdrawalDate": null},{"AlphabeticCode": "UAH", "Currency": "Hryvnia", "Entity": "UKRAINE", "MinorUnit": "2", "NumericCode": 980.0, "WithdrawalDate": null},{"AlphabeticCode": "AED", "Currency": "UAE Dirham", "Entity": "UNITED ARAB EMIRATES (THE)", "MinorUnit": "2", "NumericCode": 784.0, "WithdrawalDate": null},{"AlphabeticCode": "GBP", "Currency": "Pound Sterling", "Entity": "UNITED KINGDOM OF GREAT BRITAIN AND NORTHERN IRELAND (THE)", "MinorUnit": "2", "NumericCode": 826.0, "WithdrawalDate": null},{"AlphabeticCode": "USD", "Currency": "US Dollar", "Entity": "UNITED STATES MINOR OUTLYING ISLANDS (THE)", "MinorUnit": "2", "NumericCode": 840.0, "WithdrawalDate": null},{"AlphabeticCode": "USD", "Currency": "US Dollar", "Entity": "UNITED STATES OF AMERICA (THE)", "MinorUnit": "2", "NumericCode": 840.0, "WithdrawalDate": null},{"AlphabeticCode": "USN", "Currency": "US Dollar (Next day)", "Entity": "UNITED STATES OF AMERICA (THE)", "MinorUnit": "2", "NumericCode": 997.0, "WithdrawalDate": null},{"AlphabeticCode": "UYU", "Currency": "Peso Uruguayo", "Entity": "URUGUAY", "MinorUnit": "2", "NumericCode": 858.0, "WithdrawalDate": null},{"AlphabeticCode": "UYI", "Currency": "Uruguay Peso en Unidades Indexadas (UI)", "Entity": "URUGUAY", "MinorUnit": "0", "NumericCode": 940.0, "WithdrawalDate": null},{"AlphabeticCode": "UYW", "Currency": "Unidad Previsional", "Entity": "URUGUAY", "MinorUnit": "4", "NumericCode": 927.0, "WithdrawalDate": null},{"AlphabeticCode": "UZS", "Currency": "Uzbekistan Sum", "Entity": "UZBEKISTAN", "MinorUnit": "2", "NumericCode": 860.0, "WithdrawalDate": null},{"AlphabeticCode": "VUV", "Currency": "Vatu", "Entity": "VANUATU", "MinorUnit": "0", "NumericCode": 548.0, "WithdrawalDate": null},{"AlphabeticCode": "VES", "Currency": "Bol\u00edvar Soberano", "Entity": "VENEZUELA (BOLIVARIAN REPUBLIC OF)", "MinorUnit": "2", "NumericCode": 928.0, "WithdrawalDate": null},{"AlphabeticCode": "VND", "Currency": "Dong", "Entity": "VIET NAM", "MinorUnit": "0", "NumericCode": 704.0, "WithdrawalDate": null},{"AlphabeticCode": "USD", "Currency": "US Dollar", "Entity": "VIRGIN ISLANDS (BRITISH)", "MinorUnit": "2", "NumericCode": 840.0, "WithdrawalDate": null},{"AlphabeticCode": "USD", "Currency": "US Dollar", "Entity": "VIRGIN ISLANDS (U.S.)", "MinorUnit": "2", "NumericCode": 840.0, "WithdrawalDate": null},{"AlphabeticCode": "XPF", "Currency": "CFP Franc", "Entity": "WALLIS AND FUTUNA", "MinorUnit": "0", "NumericCode": 953.0, "WithdrawalDate": null},{"AlphabeticCode": "MAD", "Currency": "Moroccan Dirham", "Entity": "WESTERN SAHARA", "MinorUnit": "2", "NumericCode": 504.0, "WithdrawalDate": null},{"AlphabeticCode": "YER", "Currency": "Yemeni Rial", "Entity": "YEMEN", "MinorUnit": "2", "NumericCode": 886.0, "WithdrawalDate": null},{"AlphabeticCode": "ZMW", "Currency": "Zambian Kwacha", "Entity": "ZAMBIA", "MinorUnit": "2", "NumericCode": 967.0, "WithdrawalDate": null},{"AlphabeticCode": "ZWL", "Currency": "Zimbabwe Dollar", "Entity": "ZIMBABWE", "MinorUnit": "2", "NumericCode": 932.0, "WithdrawalDate": null},{"AlphabeticCode": "XBA", "Currency": "Bond Markets Unit European Composite Unit (EURCO)", "Entity": "ZZ01_Bond Markets Unit European_EURCO", "MinorUnit": "-", "NumericCode": 955.0, "WithdrawalDate": null},{"AlphabeticCode": "XBB", "Currency": "Bond Markets Unit European Monetary Unit (E.M.U.-6)", "Entity": "ZZ02_Bond Markets Unit European_EMU-6", "MinorUnit": "-", "NumericCode": 956.0, "WithdrawalDate": null},{"AlphabeticCode": "XBC", "Currency": "Bond Markets Unit European Unit of Account 9 (E.U.A.-9)", "Entity": "ZZ03_Bond Markets Unit European_EUA-9", "MinorUnit": "-", "NumericCode": 957.0, "WithdrawalDate": null},{"AlphabeticCode": "XBD", "Currency": "Bond Markets Unit European Unit of Account 17 (E.U.A.-17)", "Entity": "ZZ04_Bond Markets Unit European_EUA-17", "MinorUnit": "-", "NumericCode": 958.0, "WithdrawalDate": null},{"AlphabeticCode": "XTS", "Currency": "Codes specifically reserved for testing purposes", "Entity": "ZZ06_Testing_Code", "MinorUnit": "-", "NumericCode": 963.0, "WithdrawalDate": null},{"AlphabeticCode": "XXX", "Currency": "The codes assigned for transactions where no currency is involved", "Entity": "ZZ07_No_Currency", "MinorUnit": "-", "NumericCode": 999.0, "WithdrawalDate": null},{"AlphabeticCode": "XAU", "Currency": "Gold", "Entity": "ZZ08_Gold", "MinorUnit": "-", "NumericCode": 959.0, "WithdrawalDate": null},{"AlphabeticCode": "XPD", "Currency": "Palladium", "Entity": "ZZ09_Palladium", "MinorUnit": "-", "NumericCode": 964.0, "WithdrawalDate": null},{"AlphabeticCode": "XPT", "Currency": "Platinum", "Entity": "ZZ10_Platinum", "MinorUnit": "-", "NumericCode": 962.0, "WithdrawalDate": null},{"AlphabeticCode": "XAG", "Currency": "Silver", "Entity": "ZZ11_Silver", "MinorUnit": "-", "NumericCode": 961.0, "WithdrawalDate": null},{"AlphabeticCode": "AFA", "Currency": "Afghani", "Entity": "AFGHANISTAN", "MinorUnit": null, "NumericCode": 4.0, "WithdrawalDate": "2003-01"},{"AlphabeticCode": "FIM", "Currency": "Markka", "Entity": "\u00c5LAND ISLANDS", "MinorUnit": null, "NumericCode": 246.0, "WithdrawalDate": "2002-03"},{"AlphabeticCode": "ALK", "Currency": "Old Lek", "Entity": "ALBANIA", "MinorUnit": null, "NumericCode": 8.0, "WithdrawalDate": "1989-12"},{"AlphabeticCode": "ADP", "Currency": "Andorran Peseta", "Entity": "ANDORRA", "MinorUnit": null, "NumericCode": 20.0, "WithdrawalDate": "2003-07"},{"AlphabeticCode": "ESP", "Currency": "Spanish Peseta", "Entity": "ANDORRA", "MinorUnit": null, "NumericCode": 724.0, "WithdrawalDate": "2002-03"},{"AlphabeticCode": "FRF", "Currency": "French Franc", "Entity": "ANDORRA", "MinorUnit": null, "NumericCode": 250.0, "WithdrawalDate": "2002-03"},{"AlphabeticCode": "AOK", "Currency": "Kwanza", "Entity": "ANGOLA", "MinorUnit": null, "NumericCode": 24.0, "WithdrawalDate": "1991-03"},{"AlphabeticCode": "AON", "Currency": "New Kwanza", "Entity": "ANGOLA", "MinorUnit": null, "NumericCode": 24.0, "WithdrawalDate": "2000-02"},{"AlphabeticCode": "AOR", "Currency": "Kwanza Reajustado", "Entity": "ANGOLA", "MinorUnit": null, "NumericCode": 982.0, "WithdrawalDate": "2000-02"},{"AlphabeticCode": "ARA", "Currency": "Austral", "Entity": "ARGENTINA", "MinorUnit": null, "NumericCode": 32.0, "WithdrawalDate": "1992-01"},{"AlphabeticCode": "ARP", "Currency": "Peso Argentino", "Entity": "ARGENTINA", "MinorUnit": null, "NumericCode": 32.0, "WithdrawalDate": "1985-07"},{"AlphabeticCode": "ARY", "Currency": "Peso", "Entity": "ARGENTINA", "MinorUnit": null, "NumericCode": 32.0, "WithdrawalDate": "1989 to 1990"},{"AlphabeticCode": "RUR", "Currency": "Russian Ruble", "Entity": "ARMENIA", "MinorUnit": null, "NumericCode": 810.0, "WithdrawalDate": "1994-08"},{"AlphabeticCode": "ATS", "Currency": "Schilling", "Entity": "AUSTRIA", "MinorUnit": null, "NumericCode": 40.0, "WithdrawalDate": "2002-03"},{"AlphabeticCode": "AYM", "Currency": "Azerbaijan Manat", "Entity": "AZERBAIJAN", "MinorUnit": null, "NumericCode": 945.0, "WithdrawalDate": "2005-10"},{"AlphabeticCode": "AZM", "Currency": "Azerbaijanian Manat", "Entity": "AZERBAIJAN", "MinorUnit": null, "NumericCode": 31.0, "WithdrawalDate": "2005-12"},{"AlphabeticCode": "RUR", "Currency": "Russian Ruble", "Entity": "AZERBAIJAN", "MinorUnit": null, "NumericCode": 810.0, "WithdrawalDate": "1994-08"},{"AlphabeticCode": "BYB", "Currency": "Belarusian Ruble", "Entity": "BELARUS", "MinorUnit": null, "NumericCode": 112.0, "WithdrawalDate": "2001-01"},{"AlphabeticCode": "BYR", "Currency": "Belarusian Ruble", "Entity": "BELARUS", "MinorUnit": null, "NumericCode": 974.0, "WithdrawalDate": "2017-01"},{"AlphabeticCode": "RUR", "Currency": "Russian Ruble", "Entity": "BELARUS", "MinorUnit": null, "NumericCode": 810.0, "WithdrawalDate": "1994-06"},{"AlphabeticCode": "BEC", "Currency": "Convertible Franc", "Entity": "BELGIUM", "MinorUnit": null, "NumericCode": 993.0, "WithdrawalDate": "1990-03"},{"AlphabeticCode": "BEF", "Currency": "Belgian Franc", "Entity": "BELGIUM", "MinorUnit": null, "NumericCode": 56.0, "WithdrawalDate": "2002-03"},{"AlphabeticCode": "BEL", "Currency": "Financial Franc", "Entity": "BELGIUM", "MinorUnit": null, "NumericCode": 992.0, "WithdrawalDate": "1990-03"},{"AlphabeticCode": "BOP", "Currency": "Peso boliviano", "Entity": "BOLIVIA", "MinorUnit": null, "NumericCode": 68.0, "WithdrawalDate": "1987-02"},{"AlphabeticCode": "BAD", "Currency": "Dinar", "Entity": "BOSNIA AND HERZEGOVINA", "MinorUnit": null, "NumericCode": 70.0, "WithdrawalDate": "1998-07"},{"AlphabeticCode": "BRB", "Currency": "Cruzeiro", "Entity": "BRAZIL", "MinorUnit": null, "NumericCode": 76.0, "WithdrawalDate": "1986-03"},{"AlphabeticCode": "BRC", "Currency": "Cruzado", "Entity": "BRAZIL", "MinorUnit": null, "NumericCode": 76.0, "WithdrawalDate": "1989-02"},{"AlphabeticCode": "BRE", "Currency": "Cruzeiro", "Entity": "BRAZIL", "MinorUnit": null, "NumericCode": 76.0, "WithdrawalDate": "1993-03"},{"AlphabeticCode": "BRN", "Currency": "New Cruzado", "Entity": "BRAZIL", "MinorUnit": null, "NumericCode": 76.0, "WithdrawalDate": "1990-03"},{"AlphabeticCode": "BRR", "Currency": "Cruzeiro Real", "Entity": "BRAZIL", "MinorUnit": null, "NumericCode": 987.0, "WithdrawalDate": "1994-07"},{"AlphabeticCode": "BGJ", "Currency": "Lev A/52", "Entity": "BULGARIA", "MinorUnit": null, "NumericCode": 100.0, "WithdrawalDate": "1989 to 1990"},{"AlphabeticCode": "BGK", "Currency": "Lev A/62", "Entity": "BULGARIA", "MinorUnit": null, "NumericCode": 100.0, "WithdrawalDate": "1989 to 1990"},{"AlphabeticCode": "BGL", "Currency": "Lev", "Entity": "BULGARIA", "MinorUnit": null, "NumericCode": 100.0, "WithdrawalDate": "2003-11"},{"AlphabeticCode": "BUK", "Currency": "Kyat", "Entity": "BURMA", "MinorUnit": null, "NumericCode": 104.0, "WithdrawalDate": "1990-02"},{"AlphabeticCode": "HRD", "Currency": "Croatian Dinar", "Entity": "CROATIA", "MinorUnit": null, "NumericCode": 191.0, "WithdrawalDate": "1995-01"},{"AlphabeticCode": "HRK", "Currency": "Croatian Kuna", "Entity": "CROATIA", "MinorUnit": null, "NumericCode": 191.0, "WithdrawalDate": "2015-06"},{"AlphabeticCode": "CYP", "Currency": "Cyprus Pound", "Entity": "CYPRUS", "MinorUnit": null, "NumericCode": 196.0, "WithdrawalDate": "2008-01"},{"AlphabeticCode": "CSJ", "Currency": "Krona A/53", "Entity": "CZECHOSLOVAKIA", "MinorUnit": null, "NumericCode": 203.0, "WithdrawalDate": "1989 to 1990"},{"AlphabeticCode": "CSK", "Currency": "Koruna", "Entity": "CZECHOSLOVAKIA", "MinorUnit": null, "NumericCode": 200.0, "WithdrawalDate": "1993-03"},{"AlphabeticCode": "ECS", "Currency": "Sucre", "Entity": "ECUADOR", "MinorUnit": null, "NumericCode": 218.0, "WithdrawalDate": "2000-09"},{"AlphabeticCode": "ECV", "Currency": "Unidad de Valor Constante (UVC)", "Entity": "ECUADOR", "MinorUnit": null, "NumericCode": 983.0, "WithdrawalDate": "2000-09"},{"AlphabeticCode": "GQE", "Currency": "Ekwele", "Entity": "EQUATORIAL GUINEA", "MinorUnit": null, "NumericCode": 226.0, "WithdrawalDate": "1986-06"},{"AlphabeticCode": "EEK", "Currency": "Kroon", "Entity": "ESTONIA", "MinorUnit": null, "NumericCode": 233.0, "WithdrawalDate": "2011-01"},{"AlphabeticCode": "XEU", "Currency": "European Currency Unit (E.C.U)", "Entity": "EUROPEAN MONETARY CO-OPERATION FUND (EMCF)", "MinorUnit": null, "NumericCode": 954.0, "WithdrawalDate": "1999-01"},{"AlphabeticCode": "FIM", "Currency": "Markka", "Entity": "FINLAND", "MinorUnit": null, "NumericCode": 246.0, "WithdrawalDate": "2002-03"},{"AlphabeticCode": "FRF", "Currency": "French Franc", "Entity": "FRANCE", "MinorUnit": null, "NumericCode": 250.0, "WithdrawalDate": "2002-03"},{"AlphabeticCode": "FRF", "Currency": "French Franc", "Entity": "FRENCH GUIANA", "MinorUnit": null, "NumericCode": 250.0, "WithdrawalDate": "2002-03"},{"AlphabeticCode": "FRF", "Currency": "French Franc", "Entity": "FRENCH SOUTHERN TERRITORIES", "MinorUnit": null, "NumericCode": 250.0, "WithdrawalDate": "2002-03"},{"AlphabeticCode": "GEK", "Currency": "Georgian Coupon", "Entity": "GEORGIA", "MinorUnit": null, "NumericCode": 268.0, "WithdrawalDate": "1995-10"},{"AlphabeticCode": "RUR", "Currency": "Russian Ruble", "Entity": "GEORGIA", "MinorUnit": null, "NumericCode": 810.0, "WithdrawalDate": "1994-04"},{"AlphabeticCode": "DDM", "Currency": "Mark der DDR", "Entity": "GERMAN DEMOCRATIC REPUBLIC", "MinorUnit": null, "NumericCode": 278.0, "WithdrawalDate": "1990-07 to 1990-09"},{"AlphabeticCode": "DEM", "Currency": "Deutsche Mark", "Entity": "GERMANY", "MinorUnit": null, "NumericCode": 276.0, "WithdrawalDate": "2002-03"},{"AlphabeticCode": "GHC", "Currency": "Cedi", "Entity": "GHANA", "MinorUnit": null, "NumericCode": 288.0, "WithdrawalDate": "2008-01"},{"AlphabeticCode": "GHP", "Currency": "Ghana Cedi", "Entity": "GHANA", "MinorUnit": null, "NumericCode": 939.0, "WithdrawalDate": "2007-06"},{"AlphabeticCode": "GRD", "Currency": "Drachma", "Entity": "GREECE", "MinorUnit": null, "NumericCode": 300.0, "WithdrawalDate": "2002-03"},{"AlphabeticCode": "FRF", "Currency": "French Franc", "Entity": "GUADELOUPE", "MinorUnit": null, "NumericCode": 250.0, "WithdrawalDate": "2002-03"},{"AlphabeticCode": "GNE", "Currency": "Syli", "Entity": "GUINEA", "MinorUnit": null, "NumericCode": 324.0, "WithdrawalDate": "1989-12"},{"AlphabeticCode": "GNS", "Currency": "Syli", "Entity": "GUINEA", "MinorUnit": null, "NumericCode": 324.0, "WithdrawalDate": "1986-02"},{"AlphabeticCode": "GWE", "Currency": "Guinea Escudo", "Entity": "GUINEA-BISSAU", "MinorUnit": null, "NumericCode": 624.0, "WithdrawalDate": "1978 to 1981"},{"AlphabeticCode": "GWP", "Currency": "Guinea-Bissau Peso", "Entity": "GUINEA-BISSAU", "MinorUnit": null, "NumericCode": 624.0, "WithdrawalDate": "1997-05"},{"AlphabeticCode": "ITL", "Currency": "Italian Lira", "Entity": "HOLY SEE (VATICAN CITY STATE)", "MinorUnit": null, "NumericCode": 380.0, "WithdrawalDate": "2002-03"},{"AlphabeticCode": "ISJ", "Currency": "Old Krona", "Entity": "ICELAND", "MinorUnit": null, "NumericCode": 352.0, "WithdrawalDate": "1989 to 1990"},{"AlphabeticCode": "IEP", "Currency": "Irish Pound", "Entity": "IRELAND", "MinorUnit": null, "NumericCode": 372.0, "WithdrawalDate": "2002-03"},{"AlphabeticCode": "ILP", "Currency": "Pound", "Entity": "ISRAEL", "MinorUnit": null, "NumericCode": 376.0, "WithdrawalDate": "1978 to 1981"},{"AlphabeticCode": "ILR", "Currency": "Old Shekel", "Entity": "ISRAEL", "MinorUnit": null, "NumericCode": 376.0, "WithdrawalDate": "1989 to 1990"},{"AlphabeticCode": "ITL", "Currency": "Italian Lira", "Entity": "ITALY", "MinorUnit": null, "NumericCode": 380.0, "WithdrawalDate": "2002-03"},{"AlphabeticCode": "RUR", "Currency": "Russian Ruble", "Entity": "KAZAKHSTAN", "MinorUnit": null, "NumericCode": 810.0, "WithdrawalDate": "1994-05"},{"AlphabeticCode": "RUR", "Currency": "Russian Ruble", "Entity": "KYRGYZSTAN", "MinorUnit": null, "NumericCode": 810.0, "WithdrawalDate": "1993-01"},{"AlphabeticCode": "LAJ", "Currency": "Pathet Lao Kip", "Entity": "LAO", "MinorUnit": null, "NumericCode": 418.0, "WithdrawalDate": "1979-12"},{"AlphabeticCode": "LVL", "Currency": "Latvian Lats", "Entity": "LATVIA", "MinorUnit": null, "NumericCode": 428.0, "WithdrawalDate": "2014-01"},{"AlphabeticCode": "LVR", "Currency": "Latvian Ruble", "Entity": "LATVIA", "MinorUnit": null, "NumericCode": 428.0, "WithdrawalDate": "1994-12"},{"AlphabeticCode": "LSM", "Currency": "Loti", "Entity": "LESOTHO", "MinorUnit": null, "NumericCode": 426.0, "WithdrawalDate": "1985-05"},{"AlphabeticCode": "ZAL", "Currency": "Financial Rand", "Entity": "LESOTHO", "MinorUnit": null, "NumericCode": 991.0, "WithdrawalDate": "1995-03"},{"AlphabeticCode": "LTL", "Currency": "Lithuanian Litas", "Entity": "LITHUANIA", "MinorUnit": null, "NumericCode": 440.0, "WithdrawalDate": "2014-12"},{"AlphabeticCode": "LTT", "Currency": "Talonas", "Entity": "LITHUANIA", "MinorUnit": null, "NumericCode": 440.0, "WithdrawalDate": "1993-07"},{"AlphabeticCode": "LUC", "Currency": "Luxembourg Convertible Franc", "Entity": "LUXEMBOURG", "MinorUnit": null, "NumericCode": 989.0, "WithdrawalDate": "1990-03"},{"AlphabeticCode": "LUF", "Currency": "Luxembourg Franc", "Entity": "LUXEMBOURG", "MinorUnit": null, "NumericCode": 442.0, "WithdrawalDate": "2002-03"},{"AlphabeticCode": "LUL", "Currency": "Luxembourg Financial Franc", "Entity": "LUXEMBOURG", "MinorUnit": null, "NumericCode": 988.0, "WithdrawalDate": "1990-03"},{"AlphabeticCode": "MGF", "Currency": "Malagasy Franc", "Entity": "MADAGASCAR", "MinorUnit": null, "NumericCode": 450.0, "WithdrawalDate": "2004-12"},{"AlphabeticCode": "MWK", "Currency": "Kwacha", "Entity": "MALAWI", "MinorUnit": null, "NumericCode": 454.0, "WithdrawalDate": "2016-02"},{"AlphabeticCode": "MVQ", "Currency": "Maldive Rupee", "Entity": "MALDIVES", "MinorUnit": null, "NumericCode": 462.0, "WithdrawalDate": "1989-12"},{"AlphabeticCode": "MLF", "Currency": "Mali Franc", "Entity": "MALI", "MinorUnit": null, "NumericCode": 466.0, "WithdrawalDate": "1984-11"},{"AlphabeticCode": "MTL", "Currency": "Maltese Lira", "Entity": "MALTA", "MinorUnit": null, "NumericCode": 470.0, "WithdrawalDate": "2008-01"},{"AlphabeticCode": "MTP", "Currency": "Maltese Pound", "Entity": "MALTA", "MinorUnit": null, "NumericCode": 470.0, "WithdrawalDate": "1983-06"},{"AlphabeticCode": "FRF", "Currency": "French Franc", "Entity": "MARTINIQUE", "MinorUnit": null, "NumericCode": 250.0, "WithdrawalDate": "2002-03"},{"AlphabeticCode": "MRO", "Currency": "Ouguiya", "Entity": "MAURITANIA", "MinorUnit": null, "NumericCode": 478.0, "WithdrawalDate": "2017-12"},{"AlphabeticCode": "FRF", "Currency": "French Franc", "Entity": "MAYOTTE", "MinorUnit": null, "NumericCode": 250.0, "WithdrawalDate": "2002-03"},{"AlphabeticCode": "MXP", "Currency": "Mexican Peso", "Entity": "MEXICO", "MinorUnit": null, "NumericCode": 484.0, "WithdrawalDate": "1993-01"},{"AlphabeticCode": "RUR", "Currency": "Russian Ruble", "Entity": "MOLDOVA, REPUBLIC OF", "MinorUnit": null, "NumericCode": 810.0, "WithdrawalDate": "1993-12"},{"AlphabeticCode": "FRF", "Currency": "French Franc", "Entity": "MONACO", "MinorUnit": null, "NumericCode": 250.0, "WithdrawalDate": "2002-03"},{"AlphabeticCode": "MZE", "Currency": "Mozambique Escudo", "Entity": "MOZAMBIQUE", "MinorUnit": null, "NumericCode": 508.0, "WithdrawalDate": "1978 to 1981"},{"AlphabeticCode": "MZM", "Currency": "Mozambique Metical", "Entity": "MOZAMBIQUE", "MinorUnit": null, "NumericCode": 508.0, "WithdrawalDate": "2006-06"},{"AlphabeticCode": "NLG", "Currency": "Netherlands Guilder", "Entity": "NETHERLANDS", "MinorUnit": null, "NumericCode": 528.0, "WithdrawalDate": "2002-03"},{"AlphabeticCode": "ANG", "Currency": "Netherlands Antillean Guilder", "Entity": "NETHERLANDS ANTILLES", "MinorUnit": null, "NumericCode": 532.0, "WithdrawalDate": "2010-10"},{"AlphabeticCode": "NIC", "Currency": "Cordoba", "Entity": "NICARAGUA", "MinorUnit": null, "NumericCode": 558.0, "WithdrawalDate": "1990-10"},{"AlphabeticCode": "PEH", "Currency": "Sol", "Entity": "PERU", "MinorUnit": null, "NumericCode": 604.0, "WithdrawalDate": "1989 to 1990"},{"AlphabeticCode": "PEI", "Currency": "Inti", "Entity": "PERU", "MinorUnit": null, "NumericCode": 604.0, "WithdrawalDate": "1991-07"},{"AlphabeticCode": "PEN", "Currency": "Nuevo Sol", "Entity": "PERU", "MinorUnit": null, "NumericCode": 604.0, "WithdrawalDate": "2015-12"},{"AlphabeticCode": "PES", "Currency": "Sol", "Entity": "PERU", "MinorUnit": null, "NumericCode": 604.0, "WithdrawalDate": "1986-02"},{"AlphabeticCode": "PLZ", "Currency": "Zloty", "Entity": "POLAND", "MinorUnit": null, "NumericCode": 616.0, "WithdrawalDate": "1997-01"},{"AlphabeticCode": "PTE", "Currency": "Portuguese Escudo", "Entity": "PORTUGAL", "MinorUnit": null, "NumericCode": 620.0, "WithdrawalDate": "2002-03"},{"AlphabeticCode": "FRF", "Currency": "French Franc", "Entity": "R\u00c9UNION", "MinorUnit": null, "NumericCode": 250.0, "WithdrawalDate": "2002-03"},{"AlphabeticCode": "ROK", "Currency": "Leu A/52", "Entity": "ROMANIA", "MinorUnit": null, "NumericCode": 642.0, "WithdrawalDate": "1989 to 1990"},{"AlphabeticCode": "ROL", "Currency": "Old Leu", "Entity": "ROMANIA", "MinorUnit": null, "NumericCode": 642.0, "WithdrawalDate": "2005-06"},{"AlphabeticCode": "RON", "Currency": "New Romanian Leu", "Entity": "ROMANIA", "MinorUnit": null, "NumericCode": 946.0, "WithdrawalDate": "2015-06"},{"AlphabeticCode": "RUR", "Currency": "Russian Ruble", "Entity": "RUSSIAN FEDERATION", "MinorUnit": null, "NumericCode": 810.0, "WithdrawalDate": "2004-01"},{"AlphabeticCode": "FRF", "Currency": "French Franc", "Entity": "SAINT MARTIN", "MinorUnit": null, "NumericCode": 250.0, "WithdrawalDate": "1999-01"},{"AlphabeticCode": "FRF", "Currency": "French Franc", "Entity": "SAINT PIERRE AND MIQUELON", "MinorUnit": null, "NumericCode": 250.0, "WithdrawalDate": "2002-03"},{"AlphabeticCode": "FRF", "Currency": "French Franc", "Entity": "SAINT-BARTH\u00c9LEMY", "MinorUnit": null, "NumericCode": 250.0, "WithdrawalDate": "1999-01"},{"AlphabeticCode": "ITL", "Currency": "Italian Lira", "Entity": "SAN MARINO", "MinorUnit": null, "NumericCode": 380.0, "WithdrawalDate": "2002-03"},{"AlphabeticCode": "STD", "Currency": "Dobra", "Entity": "SAO TOME AND PRINCIPE", "MinorUnit": null, "NumericCode": 678.0, "WithdrawalDate": "2017-12"},{"AlphabeticCode": "CSD", "Currency": "Serbian Dinar", "Entity": "SERBIA AND MONTENEGRO", "MinorUnit": null, "NumericCode": 891.0, "WithdrawalDate": "2006-10"},{"AlphabeticCode": "EUR", "Currency": "Euro", "Entity": "SERBIA AND MONTENEGRO", "MinorUnit": null, "NumericCode": 978.0, "WithdrawalDate": "2006-10"},{"AlphabeticCode": "SKK", "Currency": "Slovak Koruna", "Entity": "SLOVAKIA", "MinorUnit": null, "NumericCode": 703.0, "WithdrawalDate": "2009-01"},{"AlphabeticCode": "SIT", "Currency": "Tolar", "Entity": "SLOVENIA", "MinorUnit": null, "NumericCode": 705.0, "WithdrawalDate": "2007-01"},{"AlphabeticCode": "ZAL", "Currency": "Financial Rand", "Entity": "SOUTH AFRICA", "MinorUnit": null, "NumericCode": 991.0, "WithdrawalDate": "1995-03"},{"AlphabeticCode": "SDG", "Currency": "Sudanese Pound", "Entity": "SOUTH SUDAN", "MinorUnit": null, "NumericCode": 938.0, "WithdrawalDate": "2012-09"},{"AlphabeticCode": "RHD", "Currency": "Rhodesian Dollar", "Entity": "SOUTHERN RHODESIA", "MinorUnit": null, "NumericCode": 716.0, "WithdrawalDate": "1978 to 1981"},{"AlphabeticCode": "ESA", "Currency": "Spanish Peseta", "Entity": "SPAIN", "MinorUnit": null, "NumericCode": 996.0, "WithdrawalDate": "1978 to 1981"},{"AlphabeticCode": "ESB", "Currency": "\"A\" Account (convertible Peseta Account)", "Entity": "SPAIN", "MinorUnit": null, "NumericCode": 995.0, "WithdrawalDate": "1994-12"},{"AlphabeticCode": "ESP", "Currency": "Spanish Peseta", "Entity": "SPAIN", "MinorUnit": null, "NumericCode": 724.0, "WithdrawalDate": "2002-03"},{"AlphabeticCode": "SDD", "Currency": "Sudanese Dinar", "Entity": "SUDAN", "MinorUnit": null, "NumericCode": 736.0, "WithdrawalDate": "2007-07"},{"AlphabeticCode": "SDP", "Currency": "Sudanese Pound", "Entity": "SUDAN", "MinorUnit": null, "NumericCode": 736.0, "WithdrawalDate": "1998-06"},{"AlphabeticCode": "SRG", "Currency": "Surinam Guilder", "Entity": "SURINAME", "MinorUnit": null, "NumericCode": 740.0, "WithdrawalDate": "2003-12"},{"AlphabeticCode": "SZL", "Currency": "Lilangeni", "Entity": "SWAZILAND", "MinorUnit": null, "NumericCode": 748.0, "WithdrawalDate": "2018-08"},{"AlphabeticCode": "CHC", "Currency": "WIR Franc (for electronic)", "Entity": "SWITZERLAND", "MinorUnit": null, "NumericCode": 948.0, "WithdrawalDate": "2004-11"},{"AlphabeticCode": "RUR", "Currency": "Russian Ruble", "Entity": "TAJIKISTAN", "MinorUnit": null, "NumericCode": 810.0, "WithdrawalDate": "1995-05"},{"AlphabeticCode": "TJR", "Currency": "Tajik Ruble", "Entity": "TAJIKISTAN", "MinorUnit": null, "NumericCode": 762.0, "WithdrawalDate": "2001-04"},{"AlphabeticCode": "IDR", "Currency": "Rupiah", "Entity": "TIMOR-LESTE", "MinorUnit": null, "NumericCode": 360.0, "WithdrawalDate": "2002-07"},{"AlphabeticCode": "TPE", "Currency": "Timor Escudo", "Entity": "TIMOR-LESTE", "MinorUnit": null, "NumericCode": 626.0, "WithdrawalDate": "2002-11"},{"AlphabeticCode": "TRL", "Currency": "Old Turkish Lira", "Entity": "TURKEY", "MinorUnit": null, "NumericCode": 792.0, "WithdrawalDate": "2005-12"},{"AlphabeticCode": "TRY", "Currency": "New Turkish Lira", "Entity": "TURKEY", "MinorUnit": null, "NumericCode": 949.0, "WithdrawalDate": "2009-01"},{"AlphabeticCode": "RUR", "Currency": "Russian Ruble", "Entity": "TURKMENISTAN", "MinorUnit": null, "NumericCode": 810.0, "WithdrawalDate": "1993-10"},{"AlphabeticCode": "TMM", "Currency": "Turkmenistan Manat", "Entity": "TURKMENISTAN", "MinorUnit": null, "NumericCode": 795.0, "WithdrawalDate": "2009-01"},{"AlphabeticCode": "UGS", "Currency": "Uganda Shilling", "Entity": "UGANDA", "MinorUnit": null, "NumericCode": 800.0, "WithdrawalDate": "1987-05"},{"AlphabeticCode": "UGW", "Currency": "Old Shilling", "Entity": "UGANDA", "MinorUnit": null, "NumericCode": 800.0, "WithdrawalDate": "1989 to 1990"},{"AlphabeticCode": "UAK", "Currency": "Karbovanet", "Entity": "UKRAINE", "MinorUnit": null, "NumericCode": 804.0, "WithdrawalDate": "1996-09"},{"AlphabeticCode": "SUR", "Currency": "Rouble", "Entity": "UNION OF SOVIET SOCIALIST REPUBLICS", "MinorUnit": null, "NumericCode": 810.0, "WithdrawalDate": "1990-12"},{"AlphabeticCode": "USS", "Currency": "US Dollar (Same day)", "Entity": "UNITED STATES", "MinorUnit": null, "NumericCode": 998.0, "WithdrawalDate": "2014-03"},{"AlphabeticCode": "UYN", "Currency": "Old Uruguay Peso", "Entity": "URUGUAY", "MinorUnit": null, "NumericCode": 858.0, "WithdrawalDate": "1989-12"},{"AlphabeticCode": "UYP", "Currency": "Uruguayan Peso", "Entity": "URUGUAY", "MinorUnit": null, "NumericCode": 858.0, "WithdrawalDate": "1993-03"},{"AlphabeticCode": "RUR", "Currency": "Russian Ruble", "Entity": "UZBEKISTAN", "MinorUnit": null, "NumericCode": 810.0, "WithdrawalDate": "1994-07"},{"AlphabeticCode": "VEB", "Currency": "Bolivar", "Entity": "VENEZUELA", "MinorUnit": null, "NumericCode": 862.0, "WithdrawalDate": "2008-01"},{"AlphabeticCode": "VEF", "Currency": "Bolivar Fuerte", "Entity": "VENEZUELA", "MinorUnit": null, "NumericCode": 937.0, "WithdrawalDate": "2011-12"},{"AlphabeticCode": "VEF", "Currency": "Bolivar", "Entity": "VENEZUELA (BOLIVARIAN REPUBLIC OF)", "MinorUnit": null, "NumericCode": 937.0, "WithdrawalDate": "2016-02"},{"AlphabeticCode": "VEF", "Currency": "Bol\u00edvar", "Entity": "VENEZUELA (BOLIVARIAN REPUBLIC OF)", "MinorUnit": null, "NumericCode": 937.0, "WithdrawalDate": "2018-08"},{"AlphabeticCode": "VNC", "Currency": "Old Dong", "Entity": "VIETNAM", "MinorUnit": null, "NumericCode": 704.0, "WithdrawalDate": "1989-1990"},{"AlphabeticCode": "YDD", "Currency": "Yemeni Dinar", "Entity": "YEMEN, DEMOCRATIC", "MinorUnit": null, "NumericCode": 720.0, "WithdrawalDate": "1991-09"},{"AlphabeticCode": "YUD", "Currency": "New Yugoslavian Dinar", "Entity": "YUGOSLAVIA", "MinorUnit": null, "NumericCode": 890.0, "WithdrawalDate": "1990-01"},{"AlphabeticCode": "YUM", "Currency": "New Dinar", "Entity": "YUGOSLAVIA", "MinorUnit": null, "NumericCode": 891.0, "WithdrawalDate": "2003-07"},{"AlphabeticCode": "YUN", "Currency": "Yugoslavian Dinar", "Entity": "YUGOSLAVIA", "MinorUnit": null, "NumericCode": 890.0, "WithdrawalDate": "1995-11"},{"AlphabeticCode": "ZRN", "Currency": "New Zaire", "Entity": "ZAIRE", "MinorUnit": null, "NumericCode": 180.0, "WithdrawalDate": "1999-06"},{"AlphabeticCode": "ZRZ", "Currency": "Zaire", "Entity": "ZAIRE", "MinorUnit": null, "NumericCode": 180.0, "WithdrawalDate": "1994-02"},{"AlphabeticCode": "ZMK", "Currency": "Zambian Kwacha", "Entity": "ZAMBIA", "MinorUnit": null, "NumericCode": 894.0, "WithdrawalDate": "2012-12"},{"AlphabeticCode": "ZWC", "Currency": "Rhodesian Dollar", "Entity": "ZIMBABWE", "MinorUnit": null, "NumericCode": 716.0, "WithdrawalDate": "1989-12"},{"AlphabeticCode": "ZWD", "Currency": "Zimbabwe Dollar (old)", "Entity": "ZIMBABWE", "MinorUnit": null, "NumericCode": 716.0, "WithdrawalDate": "2006-08"},{"AlphabeticCode": "ZWD", "Currency": "Zimbabwe Dollar", "Entity": "ZIMBABWE", "MinorUnit": null, "NumericCode": 716.0, "WithdrawalDate": "2008-08"},{"AlphabeticCode": "ZWN", "Currency": "Zimbabwe Dollar (new)", "Entity": "ZIMBABWE", "MinorUnit": null, "NumericCode": 942.0, "WithdrawalDate": "2006-09"},{"AlphabeticCode": "ZWR", "Currency": "Zimbabwe Dollar", "Entity": "ZIMBABWE", "MinorUnit": null, "NumericCode": 935.0, "WithdrawalDate": "2009-06"},{"AlphabeticCode": "XFO", "Currency": "Gold-Franc", "Entity": "ZZ01_Gold-Franc", "MinorUnit": null, "NumericCode": null, "WithdrawalDate": "2006-10"},{"AlphabeticCode": "XRE", "Currency": "RINET Funds Code", "Entity": "ZZ02_RINET Funds Code", "MinorUnit": null, "NumericCode": null, "WithdrawalDate": "1999-11"},{"AlphabeticCode": "XFU", "Currency": "UIC-Franc", "Entity": "ZZ05_UIC-Franc", "MinorUnit": null, "NumericCode": null, "WithdrawalDate": "2013-11"}]
</script>

<script type="module" defer>
import { Autocomplete } from "{{ asset('vendor/autocomplete/autocomplete.js') }}";

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

    const getCustomers = async () => {
        try
        {
            const f = await fetch(`{{ route('invoices.customers') }}`);
            const customers = await f.json();
            const cs = customers.map(x => ({'label': x.customer_name, 'value': x.id}));

            return cs;
        }
        catch(err)
        {
            console.log(err);
        }
    }

    const setListCustomers = async () => {
        let customers = await getCustomers();

        autocomplete.setData(customers);
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

    async function getTaxesData()
    {
        try {
            const f = await fetch("{{ route('invoices.taxes') }}");
            const j = await f.json();

            const map = j.map(x => ({'label': x.tax_name, 'value': x.id}));
            
            return map;

        } catch (error) {
            console.log(error);
        }
    }


    async function taxAutocomplete()
    {
        const names = taxContainer.getElementsByClassName('tax-name');
        const map = await getTaxesData();

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
        row.classList.add('row', 'mt-3', 'align-items-center');
        // col-left 
        const colLeft = document.createElement('div');
        colLeft.classList.add('col-12', 'col-md-8', 'pe-1');
        // col-middle
        const colMiddle = document.createElement('div');
        colMiddle.classList.add('col-12', 'col-md-2','px-1');
        // col-right
        const colRight = document.createElement('div');
        colRight.classList.add('col-12', 'col-md-2', 'ps-1');
        // input-group-left
        const inputGroupLeft = document.createElement('div');
        inputGroupLeft.classList.add('input-group', 'input-group-static');
        // input-group-middlw (sengaja beda biar classListNya beda)
        const inputGroupMiddle = document.createElement('div');
        inputGroupMiddle.classList.add('input-group', 'input-group-static');
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
        // inputText.onfocus = async e => await inputOnFocus(e);
        // inputText.onblur = async e => await inputOnFocusOut(e);
        // inputText.onkeyup = async e => await inputOnKeyup(e);
        inputGroupLeft.appendChild(labelLeft);
        inputGroupLeft.appendChild(inputText);
        inputGroupLeft.appendChild(inputTextValue);
        colLeft.appendChild(inputGroupLeft);
        row.appendChild(colLeft);
        // MIDDLE
        //labelMiddle.innerText = '';
        labelMiddle.innerHTML = "{{ __('invoice.form.fields.total') }} <span class=\"text-danger\">*</span>";
        inputNumber.name= "invoice_items["+ (+lastIndex + 1) +"][total]";
        // inputNumber.onfocus = async e => await inputOnFocus(e);
        // inputNumber.onblur = async e => await inputOnFocusOut(e);
        // inputNumber.onkeyup = async e => await inputOnKeyup(e);
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
        row.classList.add('row', 'mt-3', 'align-items-center');
        // col-left 
        const colLeft = document.createElement('div');
        colLeft.classList.add('col-12', 'col-md-9', 'pe-1');
        // col-right
        const colRight = document.createElement('div');
        colRight.classList.add('col-12', 'col-md-2', 'ps-1');
        // input-group-left
        const inputGroupLeft = document.createElement('div');
        inputGroupLeft.classList.add('input-group', 'input-group-static');
        // input-group-middlw (sengaja beda biar classListNya beda)
        // input text value
        const inputTextValue = document.createElement('input');
        inputTextValue.type = 'number';
        inputTextValue.classList.add('d-none', 'tax-name-value');
        // pisahin ajah
        const inputGroupMiddle = document.createElement('div');
        inputGroupMiddle.classList.add('input-group', 'input-group-static');
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
        labelLeft.innerHTML = "{{ __('invoice.form.fields.tax') }} <span class=\"text-danger\">*</span>";
        inputText.name = "invoice_tax["+ (+lastTaxIndex + 1) +"][name]";
        inputTextValue.name =  "invoice_tax["+ (+lastTaxIndex + 1) +"][value]";
        //inputText.onfocus = async e => await inputOnFocus(e);
        //inputText.onblur = async e => await inputOnFocusOut(e);
        //inputText.onkeyup = async e => await inputOnKeyup(e);
        inputGroupLeft.appendChild(labelLeft);
        inputGroupLeft.appendChild(inputText);
        inputGroupLeft.appendChild(inputTextValue);
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
    @php($notes = old('invoice_notes') ?? $invoice['notes'])
    @if (!empty($notes))
        editor.root.innerHTML = `{!! $notes !!}`;
        document.querySelector('textarea[name="invoice_notes"]').innerHTML = editor.root.innerHTML;
    @endif

    editor.on('text-change', (delta, oldDelta, source) => {
        console.log(delta);
    })
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

    // Table Addtional Fields
    const tblAdd = document.getElementById('table-additional');
    const tblAddTBody = tblAdd.tBodies[0];
    const arrLength = tblAddTBody.rows.length;
    const btnAdditionalField = document.getElementById('btn-additional');

    const setAdditionalFieldsRow = row => {
        console.log(row);

        // Name
        const cellName = row.insertCell(0);
        cellName.innerHTML = `<input type="text" name="additional_input[${arrLength}][name]" class="form-control form-control-sm border">`;
        // Value
        const cellValue = row.insertCell(1);
        cellValue.innerHTML = `<input type="number" name="additional_input[${arrLength}][value]" class="form-control form-control-sm border">`;
        // Units
        const cellUnits = row.insertCell(2);
        cellUnits.innerHTML = `<select name="additional_input[${arrLength}][unit]" class="form-select form-select-sm">` +
                                `<option value="fixed">Rp.</value>` +  
                                `<option value="percent">%</value>` +  
                             `</select>`;
        // Operation
        const cellOpt = row.insertCell(3);
        cellOpt.innerHTML = `<select name="additional_input[${arrLength}][operation]" class="form-select form-select-sm">` + 
                                `<option value="+">+</option>` + 
                                `<option value="-">-</option>` + 
                                `<option value="x">x</option>` + 
                                `<option value="/">/</option>` + 
                            `<select>`;
        // Last Index
        const cellRemove = row.insertCell(4);
        cellRemove.innerHTML = '<button type="button" onclick="deleteAddtionalFieldRow(event)" class="btn btn-danger btn-circle p-0">' +
                                    '<i class="fas fa-trash font-reset"></i>' +
                               '</button>';
    }
    // End Table addiotnal Fields

    // CURRENCY SELECT
    const currency = document.querySelector('select[name="invoice_currency"]');
    const currencyData = document.getElementById('currency-codes').innerText;

    const setCurrencySelection = async () => {
        Array.from(JSON.parse(currencyData), item => {
            const option = document.createElement('option');
            option.value = item.AlphabeticCode;
            option.text = item.AlphabeticCode + ' - ' + item.Entity;

            currency.add(option);
        }); 
        
    }
    // EN CURRENCY SELECT

    (async () => {
        //await getCustomers();
        await firstProductAutoComplete();
        await taxAutocomplete();
        await setListCustomers();
        //await setCurrencySelection();

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

       btnAdditionalField.addEventListener('click', e => {
           
            const row = tblAddTBody.insertRow();
            console.log(e);
            setAdditionalFieldsRow(row);
       });

    //    customerList.addEventListener('change', e => {
    //         if(e.target.value)
    //             e.target.parentNode.closest('.input-group').classList.add('is-filled');
    //         else
    //             e.target.parentNode.closest('.input-group').classList.remove('is-filled');;
    //    });

       form.addEventListener('submit', e => {
            document.querySelector('textarea[name="invoice_notes"]').innerHTML = editor.root.innerHTML;
            loading();
       });

    })();
</script>
@endsection