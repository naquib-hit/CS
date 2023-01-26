@extends('layouts.app')

@section('css')

<style>
    .table-print {
        width: 100%;
        border-collapse: collapse; 
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

    .table-print td,
    .table-print th {
        padding-left: .6rem;
    }

    .table-print tr,
    .table-print td,
    .table-print th
     {
        border-left: 1px solid lightgray;
        border-right: 1px solid lightgray;
    }
</style>
@endsection

@section('content')
@php
    echo '<pre>';
    print_r($invoice);
    echo '</pre>';
    $total = 0;
@endphp
<div class="row h-100">
    <div class="col-12">

        <div class="card fadeIn3 fadeInBottom h-100">

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
                    </div>
                    @php
                        $i = 0;
                    @endphp
                    <table class="table-print">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Deskripsi</th>
                                <th>Harga/Unit</th>
                                <th>Qty</th>
                                <th>Total</th>
                            </tr>
                           
                        </thead>
                        <tbody>
                            @foreach ($invoice['products'] as $product)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $product['product_name'] }}</td>
                                    <td>{{ number_format($product['product_price'], 0, NULL, '.') }}</td>
                                    <td>{{ $product['pivot']['quantity'] }}</td>
                                    <td>{{ number_format($product['pivot']['total_price'], 0, NULL, '.') }}</td>
                                </tr>
                              
                                @php($i++)
                            @endforeach
                            <tr>
                                <td colspan="3"></td>
                                <td class="text-bold">Sub Total</td>
                                <td class="text-bold">{{  number_format($invoice['invoice_summary']['total_summary'], 0, NULL, '.') }}</td>
                            </tr>
                            @if (!empty($invoice['discount_amount']) )
                                <td colspan="3"></td>
                                <td class="text-bold">Discount {{ $invoice['discount_unit'] == 'percent' ? $invoice['discount_amount'].'%' : NULL }}</td>
                                <td class="text-bold">{{  number_format($invoice['discount_amount'], 0, NULL, '.') }}</td>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('js')

@endsection

