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
    public function destroy($id)
    {
        //
        try
        {
            Sales::destroy($id);
            return redirect()->back()->with('success', __('validation.success.delete'));
        }
        catch(\Throwable $e)
        {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', __('validation.failed.delete'));
        }
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
        if(!empty($request->input('s_sales_name')))
            $sales = $sales->whereRaw('LOWER(sales_name) LIKE ?', ['%'.strtolower($request->input('s_sales_name')).'%']);
        if(!empty($request->input('s_sales_email')))
            $sales = $sales->whereRaw('LOWER(sales_email) LIKE ?', ['%'.strtolower($request->input('s_sales_email')).'%']);

        $page = $sales->paginate(6)->withQueryString();

        return $page;
    }

    /**
     * Truncate Data.
     *
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function clean(Request $request)
    {
        //
        try
        {
            $sales = Sales::query();

            if($request->input('rows') === 'all')
            {
                if(!empty($request->input('sales_code')))
                    $sales = $sales->whereRaw('LOWER(sales_code) LIKE ?', ['%'.strtolower($request->input('sales_code')).'%']);
                if(!empty($request->input('sales_name')))
                    $sales = $sales->whereRaw('LOWER(sales_name) LIKE ?', ['%'.strtolower($request->input('sales_name')).'%']);
                if(!empty($request->input('sales_email')))
                    $sales = $sales->whereRaw('LOWER(sales_email) LIKE ?', ['%'.strtolower($request->input('sales_email')).'%']);
            }
            else
            {
                $sales = $sales->whereIn('id', explode(',', $request->input('rows')));
            }

            $sales->delete();

            return redirect()->back()->with('success', __('validation.success.delete'));
        }
        catch(\Throwable $e)
        {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', __('validation.failed.delete'));
        }
        
    }
}
