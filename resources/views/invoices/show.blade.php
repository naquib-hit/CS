@extends('layouts.app')

@section('css')

@endsection

@section('content')
<div class="row h-100">
    <div class="col-12">

        <div class="card fadeIn3 fadeInBottom h-100">
            {{-- <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg py-2 pe-1 d-flex flex-nowrap align-itesm-center">
                  <h4 class="text-white font-weight-bolder ms-3 my-0">{{ __('invoice.form.fields.notes') }}</h4>
            </div> --}}
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
                    @php($i = 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <th>No.</th>
                                <th>Deskripsi</th>
                                <th>Harga/Unit</th>
                                <th>Qty</th>
                                <th>Total</th>
                            </thead>
                            <tbody>
                              <@foreach ($invoice['products'] as $product)
                                  <td>{{ $i + 1 }}</td>
                                  <td>{{ $product['product_name'] }}</td>
                                  <td>{{ $product['product_price'] }}</td>
                                  <td>{{ $product['pivot']['quantity'] }}</td>
                                  <td>{{ $product['pivot']['total_price'] }}</td>
                                  @php($i++)
                              @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('js')

@endsection

