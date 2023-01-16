<?php

namespace App\Http\Controllers;

use App\Http\Requests\{StoreInvoiceRequest, UpdateInvoiceRequest};
use Illuminate\Support\Facades\{Log, Auth};
use App\Models\{Invoice, Customer, Product, Tax};
use Illuminate\Http\{RedirectResponse, Request, Response, JsonResponse};
use Illuminate\View\View;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        //
        return view('invoices.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        //
        return view('invoices.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreInvoiceRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreInvoiceRequest $request): RedirectResponse
    {
        //
        try {
            $valid = $request->validated();
            $invoice = Invoice::createInvoice($valid);

            return redirect()->route('invoices.index')->with('success', __('validation.success.create'));
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', __('validation.failed.create'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\View\View
     */
    public function show(Invoice $invoice): View
    {
        //
        return view('invoices.show')->with('invoice', $invoice);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice): Response
    {
        //
        return new Response('Mau Tau Aja', 200, ['Content-Type' => 'text/plain']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateInvoiceRequest  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice): Response
    {
        //
        return new Response('Mau Tau Aja', 200, ['Content-Type' => 'text/plain']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Invoice $invoice): RedirectResponse
    {
        //
        try {
            $invoice->delete();
            return redirect()->route('invoices.index')->with('success', __('validation.success.delete'));
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', __('validation.failed.delete'));
        }
    }

    /**
     * *******************************************************************
     *              CUSTOM FUNCTIONS
     * *******************************************************************
     */

    /**
     * Summary of get
     * @param Request $req
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function get(Request $req): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $invoices = Invoice::with(['customers', 'products', 'taxes', 'invoiceSummary'])
            ->orderBy('created_at', 'desc')->orderBy('id', 'desc');

        return $invoices->paginate(8);
    }

    /**
     * get all customers data for selection
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCustomers(): JsonResponse
    {
        return response()->json(Customer::cursor(), 200, ['Content-Type' => 'application/json']);
    }

    /**
     * get all products data for selection
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProducts(): JsonResponse
    {
        return response()->json(Product::cursor(), 200, ['Content-Type' => 'application/json']);
    }

    /**
     * get all taxes data for selection
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTaxes(): JsonResponse
    {
        return response()->json(Tax::cursor(), 200, ['Content-Type' => 'application/json']);
    }
}