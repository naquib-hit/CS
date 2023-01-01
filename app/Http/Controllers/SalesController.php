<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreSalesRequest;
use App\Http\Requests\UpdateSalesRequest;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('sales.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('sales.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSalesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSalesRequest $request)
    {
        //
        $valid = $request->validated();
        try {
            
            Sales::create($request->validated());
            return redirect()->route('sales.index')->with('success', __('validation.success.create'));
        }
        catch(\Exception $e)
        {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', __('validation.failed.create'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function show(Sales $sales)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $sales = Sales::find($id);
        return view('sales.edit', ['sale' => $sales]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSalesRequest  $request
     * @param  \App\Models\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSalesRequest $request, $id)
    {
        //
        try
        {
            $sales = Sales::find($id);
            $sales->update($request->validated());
            return redirect()->route('sales.index')->with('success', __('validation.success.update'));
        }
        catch(\Throwable $e)
        {
            Log::error(''.$e);
            return redirect()->back()->with('error', __('validation.failed.update'));
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sales $sales)
    {
        //
    }

    /**
     * GET All Data.
     *
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function get(Request $request)
    {
        //
        $sales = Sales::query()->orderBy('created_at', 'desc')->orderBy('id', 'desc');

        if(!empty($request->input('s_sales_code')))
            $sales = $sales->whereRaw('LOWER(sales_code) LIKE ?', ['%'.strtolower($request->input('s_sales_code')).'%']);

        $page = $sales->paginate(6)->withQueryString();

        return $page;
    }
}
