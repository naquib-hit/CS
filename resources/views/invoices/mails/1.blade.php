<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="{{ public_path('vendor/bootstrap-4/css/bootstrap.min.css') }}" media="all">  
        <style>
            .table-print,
            .table-print-footer {
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

            .table-print td,
            .table-print th,
            .table-print-footer th,
            .table-print-footer td {
                padding-left: .6rem;
            }

            .table-print tr:last-child {
                border: 1px solid lightgray;
            }
        
            /*
            .table-print tr td:nth-child(4),
            .table-print tr th:nth-child(4),
             #subtotal-row td:nth-child(2),
            .table-print-footer .summary td:nth-child(1),
            .table-print-footer .taxes td:nth-child(1),
            .table-print-footer .discount td:nth-child(1),
            .table-print-footer .additional-field td:nth-child(1) {
                width: 244px;
            }
        
            .table-print tr td:nth-child(5),
            .table-print tr th:nth-child(5),
             #subtotal-row td:nth-child(2),
            .table-print-footer .summary td:nth-child(2),
            .table-print-footer .taxes td:nth-child(2),
            .table-print-footer .discount td:nth-child(2),
            .table-print-footer .additional-field td:nth-child(2)
            {
                width: 174px;
            }
            */
        
            .table-print tr,
            .table-print td,
            .table-print th,
            .table-print-footer th,
            .table-print-footer td
             {
                border-left: 1px solid lightgray;
                border-right: 1px solid lightgray;
            }
        
            #subtotal-row td,
            .table-print-footer .summary td {
                border: 1px solid lightgray !important;
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

            @media print {
                .w-100 {
                    width: 100%;
                }
            }
        </style>
    </head>
    <body class="vh-100 vw-100 container-fluid py-2">
        <table id="header" class="w-100">
            <tr class="pb-1 w-100">
                <td>
                    <img src="{{ public_path('img/New-HIT-Resize12.png') }}" style="height: 74px">
                </td>
                <td>
                    <h3 class="d-block mx-auto">INVOICE</h3>
                </td>
                
                <td>
                    <span class="text-decoration-underline fs-6 d-print-block"><strong>HITCorporation</strong></span><br/>
                    <small>Gandaria 8 Office Tower, 7th floor. Unit I-J</small><br/>
                    <small>Telp. 021-99835304</small><br/>
                </td>
            </tr>
        </table>
        <hr class="border-bottom"/>
               
        <table id="invoice-body" class="w-100">
            <tr class="w-100">
                <td class="col-5">
                    <table>
                        <tr>
                            <td>Bill To :</td>
                            <td class="ml-3">
                                <h6 class="mb-0 text-bold text-decoration-underline">{{ $invoice['customers']['customer_name'] }}</h6>
                                <small>{{ $invoice['customers']['customer_address'] }}</small>
                            </td>
                        </tr>
                        
                    </table>
                </td>
                <td class="col-4 ml-auto">
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
                </td>
            </tr>
            <div class="row">
                <div class="col-8 mr-0 pr-0">
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
                <div class="col-4 ml-0 pl-0">
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
                                <td>{{ $product['pivot']['quantity'] ?? '' }}</td>
                                <td>{{ number_format($product['pivot']['total_price'], 0, NULL, '.') ?? ''}}</td>
                            </tr>
                            @else
                            <tr>
                                <td></td>
                                <td></td>
                            </tr>
                            @endif
                        @endfor
                        <tr id="subtotal-row">
                            <td class="text-bold">Sub Total</td>
                            <td class="text-bold">{{  number_format($invoice['invoice_summary']['total_summary'], 0, NULL, '.') }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="d-print-flex">
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
                <div class="col-4 ml-auto">
                    <table class="table-print-footer ml-auto">
                        @foreach ($invoice['taxes'] as $tax)
                        <tr class="taxes">
                            <td class="text-bold">{{ $tax['tax_name'] }}&nbsp;{{ $tax['tax_amount'] }}%</td>
                            <td class="text-bold">{{  number_format(($invoice['invoice_summary']['total_summary'] * $tax['tax_amount']) / 100, 0, NULL, '.') }}</td>
                        </tr>
                        @endforeach
                        @if (!empty($invoice['discount_amount']) )
                        <tr class="discount">
                            <td class="text-bold">Discount {{ $invoice['discount_unit'] == 'percent' ? $invoice['discount_amount'].'%' : NULL }}</td>
                            <td class="text-bold">{{  number_format($invoice['discount_sum'], 0, NULL, '.') }}</td>
                        </tr>
                        @endif
                        @if(!empty($invoice['additional_field']))
                            @foreach($invoice['additional_field'] as $af)
                            <tr class="additional-field">
                                <td class="text-bold">{{ $af['field_name'] }} {{ $af['unit'] == 'percent' ? $af['field_value'].'%' : NULL }}</td>
                                <td class="text-bold">{{  number_format($af['field_sum'], 0, NULL, '.') }}</td>
                            </tr>
                            @endforeach
                        @endif
                        <tr class="summary">
                            <td class="text-bold">{{ __('Total') }}</td>
                            <td class="text-bold">{{  number_format($invoice['last_result'], 0, NULL, '.') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </table>
    </body>
</html>