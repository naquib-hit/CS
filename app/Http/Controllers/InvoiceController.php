<?php

namespace App\Http\Controllers;

use Response;
use Illuminate\Support\Facades\{Log, Auth};
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Models\{Invoice, Customer, Product, Tax};

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('invoices.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('invoices.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreInvoiceRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInvoiceRequest $request)
    {
        //
        $items = []; $taxes = [];
        try {
            $valid = $request->validated();

            $invoice = new Invoice;
            $invoice->invoice_no = $valid['invoice_no'];
            $invoice->customer_id  = $valid['invoice_customer'];
            $invoice->create_date = (new \DateTime($valid['invoice_date']))->format('Y-m-d');
            $invoice->due_date = (new \DateTime($valid['invoice_due']))->format('Y-m-d');
            $invoice->notes = $valid['invoice_notes'];
            $invoice->user_id = (int) Auth::id();
            $invoice->save();

            // attach products for pivot table
            foreach ($valid['invoice_items'] as $item)
                $items[$item['value']] = [
                    'quantity'      => $item['total'],
                    'total_price'   => (Product::find($item['value']))->product_price * $item['total']
                ];
            $invoice->products()->attach($items);

            // attach tax for pivot table
            $taxes = collect($valid['invoice_tax'])->pluck('value');
            $invoice->taxes()->attach($taxes);

            return redirect()->route('invoices.index')->with('success', __('validation.success.create'));
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return redirect()->back()->with('error', __('validation.failed.create'));
        } finally {
            $items = NULL;
            $taxes = NULL;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateInvoiceRequest  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        //
    }

    /**
     * get all customers data for selection
     *
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function getCustomers()
    {
        return response()->json(Customer::cursor(), 200, ['Content-Type' => 'application/json']);
    }

    /**
     * get all products data for selection
     *
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function getProducts()
    {
        return response()->json(Product::cursor(), 200, ['Content-Type' => 'application/json']);
    }

    /**
     * get all taxes data for selection
     *
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function getTaxes()
    {
        return response()->json(Tax::cursor(), 200, ['Content-Type' => 'application/json']);
    }
}