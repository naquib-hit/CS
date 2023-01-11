<?php

namespace App\Http\Controllers;

use App\Models\Tax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreTaxRequest;
use App\Http\Requests\UpdateTaxRequest;

class TaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('taxes.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('taxes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTaxRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaxRequest $request)
    {
        //
        try {
            $valid = $request->validated();
            Tax::create($valid);

            return redirect()->route('taxes.index')->with('success', __('validation.success.create'));
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', __('validation.failed.create'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function show(Tax $tax)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function edit(Tax $tax)
    {
        //
        return view('taxes.edit', compact('tax'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTaxRequest  $request
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTaxRequest $request, Tax $tax)
    {
        //
        try {
            $valid = $request->validated();
            $tax->update($valid);

            return redirect()->route('taxes.index')->with('success', __('validation.success.create'));
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            return response()->back()->with('error', __('validation.failed.create'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tax $tax)
    {
        //
    }

    /**
     * GET PAGINATED data for datatable
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function get(Request $req)
    {
        try {
            $taxes = Tax::query()->orderBy('created_at', 'desc')->orderBy('id', 'desc');

            if (!empty($req->input('s_tax_name')))
                $taxes = $taxes->whereRaw('LOWER(tax_name) LIKE ?', ['%' . strtolower($req->input('s_tax_name')) . '%']);
            $page = $taxes->paginate(6);

            return $page;
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
        }
    }

    /**
     * Truncate data by filter or selected record
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function truncate(Request $req): \Illuminate\Http\RedirectResponse
    {
        try {
            $taxes = Tax::query();

            if ($req->input('rows') === 'all') {

                if (!empty($req->input('tax_name')))
                    $taxes = $taxes->whereRaw('LOWER(tax_name) LIKE ?', ['%' . strtolower($req->input('tax_name')) . '%']);
            } else {
                $ids = explode(',', $req->input('rows'));
                $taxes = $taxes->whereIn('id', $ids);
            }

            $taxes->delete();

            return redirect()->back()->with('success', __('validation.success.delete'));
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return redirect()->back()->with('success', __('validation.failed.delete'));
        }
    }
}