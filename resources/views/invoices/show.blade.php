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

    .table-print td,
    .table-print th {
        padding-left: .6rem;
    }

    .table-print tr:not(#subtotal-row):not(.taxes):not(.discount):not(.additional-field):not(.summary) td:nth-child(4),
    .table-print tr:not(#subtotal-row):not(.taxes):not(.discount):not(.additional-field):not(.summary) th:nth-child(4) {
        width: 160px;
    }

    .table-print tr,
    .table-print td,
    .table-print th
     {
        border-left: 1px solid lightgray;
        border-right: 1px solid lightgray;
    }

    #subtotal-row td {
        border: 1px solid lightgray;
    }
</style>
@endsection

@section('content')
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
                    <table class="table-print">
                        <thead>
                            <tr>
                                <th style="width: 40px">No.</th>
                                <th>Deskripsi</th>
                                <th>Harga/Unit</th>
                                <th>Qty</th>
                                <th>Total</th>
                            </tr>
                           
                        </thead>
                        <tbody>
                            @for ($i=0;$i<10;$i++)
                                @if(!empty($invoice['products'][$i]))
                                @php($product = $invoice['products'][$i])
                                <tr>
                                    <td style="width: 40px">{{ !empty($product['product_name']) ?  $i + 1  : ''}}</td>
                                    <td>{{ $product['product_name'] ?? '' }}</td>
                                    <td>{{ number_format($product['product_price'], 0, NULL, '.') ?? ''}}</td>
                                    <td>{{ $product['pivot']['quantity'] ?? '' }}</td>
                                    <td>{{ number_format($product['pivot']['total_price'], 0, NULL, '.') ?? ''}}</td>
                                </tr>
                                @else
                                <tr>
                                    <td style="width: 40px"></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                @endif
                            @endfor
                            <tr id="subtotal-row">
                                <td colspan="3"></td>
                                <td class="text-bold">Sub Total</td>
                                <td class="text-bold">{{  number_format($invoice['invoice_summary']['total_summary'], 0, NULL, '.') }}</td>
                            </tr>
                            @foreach ($invoice['taxes'] as $tax)
                            <tr class="taxes">
                                <td colspan="3"></td>
                                <td class="text-bold">{{ $tax['tax_name'] }}&nbsp;{{ $tax['tax_amount'] }}%</td>
                                <td class="text-bold">{{  number_format(($invoice['invoice_summary']['total_summary'] * $tax['tax_amount']) / 100, 0, NULL, '.') }}</td>
                            </tr>
                            @endforeach
                            @if (!empty($invoice['discount_amount']) )
                            <tr class="discount">
                                <td colspan="3"></td>
                                <td class="text-bold">Discount {{ $invoice['discount_unit'] == 'percent' ? $invoice['discount_amount'].'%' : NULL }}</td>
                                <td class="text-bold">{{  number_format($invoice['discount_sum'], 0, NULL, '.') }}</td>
                            </tr>
                            @endif
                            @if(!empty($invoice['additional_field']))
								@foreach($invoice['additional_field'] as $af)
								<tr class="additional-field">
									<td colspan="3"></td>
									<td class="text-bold">{{ $af['field_name'] }} {{ $af['unit'] == 'percent' ? $af['field_value'].'%' : NULL }}</td>
									<td class="text-bold">{{  number_format($af['field_sum'], 0, NULL, '.') }}</td>
								</tr>
								@endforeach
                            @endif
                            <tr class="summary">
                                <td colspan="3"></td>
                                <td class="text-bold">{{ __('Total') }}</td>
                                <td class="text-bold">{{  number_format($invoice['last_result'], 0, NULL, '.') }}</td>
                            </tr>
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

