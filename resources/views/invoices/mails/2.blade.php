<!DOCTYPE html>
<html>
    <head>
        <base href="{{ public_path('/') }}">
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="css/app.css" media="all">  
        <style media="all">
            .table-print,
            .table-print-footer {
                width: 100%;
                border-collapse: separate; 
                font-weight: 400;
                font-size: 14px;
                border-spacing: 0;
                border: 1px solid lightgray;
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
                height: 18px;
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
        
            .table-print tr
             {
                border-left: 1px solid lightgray !important;
                border-right: 1px solid lightgray !important;
            }
        
            .subtotal-row td,
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

            .text-bold {
                    font-weight: bold;
                }

            table td[class*="col-"] {
                padding-left: 0px !important;
                padding-right: 0px !important;
            }

            .table-header td {
                vertical-align: top!important;
                padding: 0!important;
                margin: 0!important;
            }

            #header {
                margin-bottom: .354rem;
            }

                .table.table-borderless > tr > td,
                .table.table-borderless > tbody > tr > td {
                    border-style: hidden;
                }

                .table-print tbody > tr > td {
                    border-bottom-style: hidden;
                }

                .table-print tbody > tr.t-content:not(:last-child) > td {
                    border-bottom-style: hidden;
                }

                .table-print tbody > tr.t-content:last-child > td {
                    border-bottom: 1px solid lightgrey !important;
                }

                .table-print tbody > tr > td:not(:last-child) {
                    /* border-left: 1px solid lightgrey !important; */
                    border-right: 1px solid lightgrey !important;
                }

                .subtotal-row {
                    border: 3px solid lightgrey;
                }

                .table-print tr.summary td {
                    border: 3px solid lightgray;
                }

            @media print {
                .subtotal-row {
                    border: 1px solid lightgrey;
                }

                .w-100 {
                    width: 100%;
                }
                .text-bold {
                    font-weight: bold;
                }

                table td[class*="col-"] {
                    padding-left: 0px !important;
                    padding-right: 0px !important;
                }

                .w-33\.3 {
                    width: 33.33% !important;
                }

                .w-66\.6 {
                    width: 66.66666667% !important;
                }

                .w-16\.6 {
                    width: 16.66666667% !important;
                }

                .table.table-borderless > tr > td,
                .table.table-borderless > tbody > tr > td {
                    border-style: hidden;
                }

                .table-print thead {
                    background-color: gray; 
                    color: white;
                    
                }
            
                .table-print th {
                    padding-top: .4rem;
                    padding-bottom: .4rem;
                    border-bottom: 1px solid lightgray;
                    text-align: left;
                }
                
                .table-print td,
                .table-print th,
                .table-print-footer th,
                .table-print-footer td {
                    padding-left: .6rem;
                }

                .table-print th:not(:last-child) {
                    border-right: 1px solid lightgray;
                }

                .table-print tbody > tr.t-content:not(:last-child) > td {
                    border-bottom-style: hidden !important;
                }

                .table-print tbody > tr.t-content:last-child td {
                    border-bottom: 3px solid lightgray !important;
                }

                .table-print tr.subtotal-row td {
                    border-top: 1px solid lightgray !important;
                    border-bottom: 1px solid lightgray !important;
                }

                /* .table-print tr.subtotal-row td:not(:last-child) {
                    border-right: 1px solid lightgray;
                } */

                .table-print tr.summary td {
                    border-top: 1px solid lightgray !important;
                }

                .table-print tbody > tr > td:not(:last-child) {
                    border-right: 1px solid lightgray !important;
                }

                hr 
                {
                    border: 1px solid lightgray;
                }
            }
        </style>
    </head>
    <body class="vh-100 vw-100 container py-2">
        <table id="header" class="table table-borderless w-100">
            <tbody>
                <tr>
                    <td class="col-3">
                        <img src="img/New-HIT-Resize12.png" style="height: 74px">
                    </td>
                    <td class="col-5 text-center">
                        <h3>INVOICE</h3>
                    </td>
                    <td class="col-4">
                        <div class="w-auto ms-auto">
                            <span class="text-decoration-underline fs-6 d-print-block"><strong>HITCorporation</strong></span>
                            <small>Gandaria 8 Office Tower, 7th floor. Unit I-J</small><br/>
                            <small>Telp. 021-99835304</small><br/>
                        </div>
                    </td>
                </tr>
            </tbody>
            
        </table>
        <hr class="mt-0 border-bottom"/>

        <table id="invoice-body" class="table table-borderless w-100">
            <tbody>
            <tr>
                <td class="col-4 p-0 align-top pb-2">

                    <dl class="d-print-block">
                        <dt class="float-left"><strong>Bill To :</strong><dt>
                        <dd class="ms-2 clearfix">
                            <h6 class="mb-0 text-bold text-decoration-underline">{{ $invoice['projects']['customers']['customer_name'] }}</h6>
                            <small>{{ $invoice['projects']['customers']['customer_address'] }}</small>
                        </dd>
                    </dl>
                </td>
                <td class="col-4"></td>
                <td class="col-4 align-top">
                    <table class="w-100 table table-borderless table-header">
                        <tbody class="p-0">
                            <tr>
                                <td><strong>Tanggal Invoice</strong></td>
                                <td>: {{ $invoice['create_date'] }}</td>
                            </tr>
                           
                        <tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="3" class="col-12">
                    <table class="table table-borderless table-print">
                        <thead>
                            <tr>
                                <th class="text-left" style="width: 40px">No.</th>
                                <th class="text-left">Deskripsi</th>
                                <th class="text-left">Harga/Unit</th>
                                <th class="text-left">Qty</th>
                                <th class="text-left">Total</th>
                            </tr>
                            
                        </thead>
                        <tbody>
                            @for ($i=0;$i<9;$i++)
                                @if(!empty($invoice['products'][$i]))
                                @php($product = $invoice['products'][$i])
                                <tr class="t-content border-left border-right">
                                    <td style="width: 40px">{{ !empty($product['product_name']) ?  $i + 1  : ''}}</td>
                                    <td>{{ $product['product_name'] ?? '' }}</td>
                                    <td>{{ number_format($product['pivot']['gross_price'], 0, NULL, '.') ?? ''}}</td>
                                    <td>{{ $product['pivot']['quantity'] ?? '' }}</td>
                                    <td>{{ number_format($product['pivot']['total_gross'], 0, NULL, '.') ?? ''}}</td>
                                </tr>
                                @else
                                <tr class="t-content">
                                    <td style="width: 40px"></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                @endif
                            @endfor
                            <tr class="subtotal-row">
                                <td colspan="3"></td>
                                <td class="border text-bold">Sub Total</td>
                                <td class="border text-bold">{{  number_format($invoice['invoice_summary']['gross_summary'], 0, NULL, '.') }}</td>
                            </tr>
                            @foreach ($invoice['taxes'] as $tax)
                            <tr class="taxes">
                                <td colspan="3"></td>
                                <td class="text-bold">{{ $tax['tax_name'] }}&nbsp;{{ $tax['tax_amount'] }}%</td>
                                <td class="text-bold">{{  number_format(($invoice['invoice_summary']['gross_summary'] * $tax['tax_amount']) / 100, 0, NULL, '.') }}</td>
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
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    @if(!empty($invoice['notes']))
                    <div id="description" class="mt-2">
                        <h6 class="mb-0">Catatan</h6>
                        <div class="border rounded w-100">
                            {!! $invoice['notes'] !!}
                        </div>
                    </div>
                    @endif
                </td>
            </tr>
            </tbody>
        </table>
    </body>
</html>