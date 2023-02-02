@extends('layouts.app')

@section('css')

<style>
    .table-print {
        width: 100%;
        border-collapse: collapse; 
        font-weight: 400;
        font-size: 14px;
    }

    .table-print thead {
        background-color: var(--bs-gray); 
        color: var(--bs-light);
        border: 1px solid lightgray;
    }

    .table-print th {
        padding-top: .25rem;
        padding-bottom: .25rem;

    }

    .table-print td {
        height: 28px;
        vertical-align: center;
    }

    .table-print-footer {
        border: 1px solid lightgray;
    }

    .table-print tr:last-child {
        border: 1px solid lightgray;
    }

    .table-print td,
    .table-print th,
    .table-print-footer td
     {
        padding-left: .6rem;
    }

    .table-print tr:not(#subtotal-row):not(.taxes):not(.discount):not(.additional-field):not(.summary) td:nth-child(4),
    .table-print tr:not(#subtotal-row):not(.taxes):not(.discount):not(.additional-field):not(.summary) th:nth-child(4),
    .table-print-footer .summary td:nth-child(1),
    .table-print-footer .taxes td:nth-child(1),
    .table-print-footer .discount td:nth-child(1),
    .table-print-footer .additional-field td:nth-child(1) 
    {
        width: 244px;
    }

    .table-print tr:not(#subtotal-row):not(.taxes):not(.discount):not(.additional-field):not(.summary) td:nth-child(5),
    .table-print tr:not(#subtotal-row):not(.taxes):not(.discount):not(.additional-field):not(.summary) th:nth-child(5),
     #subtotal-row td:nth-child(2),
    .table-print-footer .summary td:nth-child(2),
    .table-print-footer .taxes td:nth-child(2),
    .table-print-footer .discount td:nth-child(2),
    .table-print-footer .additional-field td:nth-child(2)
    {
        width: 174px;
    }

    .table-print tr,
    .table-print td,
    .table-print th,
    .table-print-footer td
     {
        border-left: 1px solid lightgray;
        border-right: 1px solid lightgray;
    }

    #subtotal-row td,
    .table-print .summary td {
        border: 1px solid lightgray;
    }

    .table-header {
        font-size: 14px;
    }

    #description div {
       min-height: 78px;
    }

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
<div class="row h-100">
    <div class="col-12">

        <div class="card fadeIn3 fadeInBottom h-100">
            <div class="card-header border-bottom">
                <div class="btn-group btn-group-sm mb-0">
                    @if($invoice['invoice_status'] !== 1)
                    <a id="send-mail" class="btn btn-primary" href="{{ route('invoices.mail', ['id' => $invoice['id']]) }}">
                        <i class="fas fa-envelope font-reset"></i>
                        {{ __('Kirim') }}
                    </a>
                    @endif
                    <a class="btn btn-primary" href="{{ route('invoices.index') }}">
                        <i class="fas fa-hand-point-left font-reset"></i>
                        {{ __('Kembali') }}
                    </a>
                </div>
            </div>
            <div class="card-body">
                <header class="d-flex flex-nowrap w-100 align-items-center border-bottom pb-1">
                    <img src="{{ asset('img/New-HIT-Resize12.png') }}" style="height: 74px">
                    <h3 class="mx-auto">INVOICE</h3>
                    <span class="d-flex flex-column flex-nowrap">
                        <span class="text-decoration-underline fs-6"><strong>HITCorporation</strong></span>
                        <small>Gandaria 8 Office Tower, 7th floor. Unit I-J</small>
                        <small>Telp. 021-99835304</small>
                    </span>
                </header>
                <div id="invoice-body">
                    <div class="row">
                        <dl class="col-5 d-flex">
                            <dt>Bill To :</dt>
                            <dd class="ms-3">
                                <h6 class="mb-0 text-bold text-decoration-underline">{{ $invoice['customers']['customer_name'] }}</h6>
                                <small>{{ $invoice['customers']['customer_address'] }}</small>
                            </dd>
                        </dl>
                        <div class="col-4 ms-auto">
                            <table class="w-100 table-header">
                                <tbody>
                                    <tr>
                                        <td class="fw-bold">No. Invoice</td>
                                        <td>: {{ $invoice['invoice_no'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Tanggal Invoice</td>
                                        <td>: {{ $invoice['create_date'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">No. PO</td>
                                        <td>: {{ $invoice['po_no'] }}</td>
                                    </tr>
                                <tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8 me-0 pe-0">
                            <table class="table-print">
                                <thead>
                                    <tr>
                                        <th style="width: 40px">No.</th>
                                        <th>Deskripsi</th>
                                        <th>Harga/Unit</th>
                                    </tr>
                                   
                                </thead>
                                <tbody>
                                    @for ($i=0;$i<11;$i++)
                                        @if(!empty($invoice['products'][$i]))
                                        @php($product = $invoice['products'][$i])
                                        <tr>
                                            <td style="width: 40px">{{ !empty($product['product_name']) ?  $i + 1  : ''}}</td>
                                            <td>{{ $product['product_name'] ?? '' }}</td>
                                            <td>{{ number_format($product['product_price'], 0, NULL, '.') ?? ''}}</td>
                                        </tr>
                                        @else
                                        <tr>
                                            <td style="width: 40px"></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        @endif
                                    @endfor
                                   
                                </tbody>
                            </table>
                        </div>
                        <div class="col-4 ms-0 ps-0">
                            <table class="table-print">
                                <thead>
                                    <tr>
                                        <th>Qty</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i=0;$i<10;$i++)
                                    @if(!empty($invoice['products'][$i]))
                                    @php($product = $invoice['products'][$i])
                                    <tr>
                                        <td class="w-50">{{ $product['pivot']['quantity'] ?? '' }}</td>
                                        <td class="w-50">{{ number_format($product['pivot']['total_price'], 0, NULL, '.') ?? ''}}</td>
                                    </tr>
                                    @else
                                    <tr>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    @endif
                                @endfor
                                <tr id="subtotal-row">
                                    <td class="text-bold w-50">Sub Total</td>
                                    <td class="text-bold w-50">{{  number_format($invoice['invoice_summary']['total_summary'], 0, NULL, '.') }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                   
                    <div class="row">
                        <div class="col-8">
                            @if(!empty($invoice['notes']))
                            <div id="description" class="mt-2">
                                <h6 class="mb-0">Deskripsi</h6>
                                <div class="border rounded w-100">
                                    {!! $invoice['notes'] !!}
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="col ms-0 ps-0">
                            <table class="table-print-footer w-100">
                                @foreach ($invoice['taxes'] as $tax)
                                <tr class="taxes">
                                    <td class="text-bold w-50">{{ $tax['tax_name'] }}&nbsp;{{ $tax['tax_amount'] }}%</td>
                                    <td class="text-bold w-50">{{  number_format(($invoice['invoice_summary']['total_summary'] * $tax['tax_amount']) / 100, 0, NULL, '.') }}</td>
                                </tr>
                                @endforeach
                                @if (!empty($invoice['discount_amount']) )
                                <tr class="discount">
                                    <td class="text-bold w-50">Discount {{ $invoice['discount_unit'] == 'percent' ? $invoice['discount_amount'].'%' : NULL }}</td>
                                    <td class="text-bold w-50">{{  number_format($invoice['discount_sum'], 0, NULL, '.') }}</td>
                                </tr>
                                @endif
                                @if(!empty($invoice['additional_field']))
                                    @foreach($invoice['additional_field'] as $af)
                                    <tr class="additional-field">
                                        <td class="text-bold w-50">{{ $af['field_name'] }} {{ $af['unit'] == 'percent' ? $af['field_value'].'%' : NULL }}</td>
                                        <td class="text-bold w-50">{{  number_format($af['field_sum'], 0, NULL, '.') }}</td>
                                    </tr>
                                    @endforeach
                                @endif
                                <tr class="summary">
                                    <td class="text-bold w-50">{{ __('Total') }}</td>
                                    <td class="text-bold w-50">{{  number_format($invoice['last_result'], 0, NULL, '.') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
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

document.getElementById('send-mail').addEventListener('click', e => {
    loading();
});
</script>


@endsection

