<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\{Log, Auth};
use App\Models\{Invoice, Customer, Product, Tax};
use App\Http\Requests\{StoreInvoiceRequest, UpdateInvoiceRequest};
use Illuminate\Http\{RedirectResponse, Request, Response, JsonResponse};
use Knp\Snappy\Pdf;

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
        try 
        {
            $valid = $request->validated();
            $invoice = Invoice::createInvoice($valid);

            $render = view('invoices.mails.1')->with('invoice', $invoice->getInvoiceByID($invoice->id))->render();
            $pdf = new Pdf(base_path(env('WKHTML_PDF_BINARY')));
            $pdfOption = [
                'page-size' => 'Letter',
                'margin-left' => '6mm'
            ];
            $pdf->generateFromHtml($render, public_path('files/invoices/'.$invoice->id.'.pdf'), $pdfOption, TRUE);

            return redirect()->route('invoices.show', ['invoice' => $invoice])->with('success', __('validation.success.create'));
        } 
        catch (\Throwable $e) 
        {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', __('validation.failed.create'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  mixed $id
     * @return \Illuminate\View\View
     */
    public function show(Invoice $invoice)
    {
        //
        return view('invoices.show')->with('invoice', $invoice->getInvoiceByID($invoice->id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\View\View
     */
    public function edit(Invoice $invoice): View
    {
        //
        $inv = $invoice->getInvoiceByID($invoice->id);
        return view('invoices.edit')->with('invoice', $inv);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateInvoiceRequest  $request
     * @param  int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateInvoiceRequest $request, int $id): RedirectResponse
    {
        //
        try
        {
            $valid = $request->validated();
            $invoice = Invoice::updateInvoice($valid, $id);

            $render = view('invoices.mails.1')->with('invoice', $invoice->getInvoiceByID($invoice->id))->render();
            $pdf = new Pdf(base_path(env('WKHTML_PDF_BINARY')));
            $pdfOption = [
                'page-size' => 'Letter',
                'margin-left' => '6mm'
            ];
            $pdf->generateFromHtml($render, public_path('files/invoices/'.$invoice->id.'.pdf'), $pdfOption, TRUE);

            return redirect()->route('invoices.show', ['invoice' => $invoice])->with('success', __('validation.success.create'));
        }
        catch(\Throwable $e)
        {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', __('validation.failed.create'));
        }
        
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
    public function get(Request $req)
    {
        $invoices = Invoice::with(['customers', 'products', 'taxes', 'invoiceSummary'])
                    ->orderBy('created_at', 'desc')->orderBy('id', 'desc')
                    ->paginate(8);

        return $invoices;
    }

    /**
     * Function for send mail
     *
     * @param integer $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function mail(int $id): RedirectResponse
    {
        try 
        {
            $invoice = Invoice::getInvoiceByID($id);
            Mail::to($invoice['customers']['customer_email'])->send(new \App\Mail\InvoiceMail($invoice));

            if(count(Mail::failures()) > 0) 
            {
                Invoice::find($id)->update([
                    'invoice_status' => 2
                ]);
                return redirect()->back()->with('error', __('Email Gagal Terkirim'));
            }

            Invoice::find($id)->update([
                'invoice_status' => 1
            ]);

            return redirect()->route('invoices.index')->with('success', __('Email berhasil dikirim'));
        }
        catch(\Throwable $e)
        {
            Log::error($e->getMessage());
            
            Invoice::find($id)->update([
                'invoice_status' => 2
            ]);
            return redirect()->back()->with('error', __('Email Gagal Terkirim'));
        }
        
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