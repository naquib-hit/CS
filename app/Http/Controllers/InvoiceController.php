<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Models\{Invoice, Customer, Product};

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
     * @param  \App\Http\Requests\StoreInvoiceRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreInvoiceRequest $request): \Illuminate\Http\JsonResponse
    {
        //
        try {
            $valid = $request->validated();

            return response()->json(
                ['success' => true, 'message' => __('validation.success.create'), 'token' => csrf_token()],
                200,
                ['Content-Type' => 'application/json']
            );
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            return response()->json(
                ['success' => false, 'message' => __('validation.failed.create'), 'token' => csrf_token()],
                422,
                ['Content-Type' => 'application/json']
            );
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
     * @return Illuminate\Http\JsonResponse
     */
    public function getCustomers(): JsonResponse
    {
        return response()->json(Customer::cursor(), 200, ['Content-Type' => 'application/json']);
    }

    /**
     * get all products data for selection
     *
     * @return Illuminate\Http\JsonResponse
     */
    public function getProducts(): JsonResponse
    {
        return response()->json(Product::cursor(), 200, ['Content-Type' => 'application/json']);
    }
}