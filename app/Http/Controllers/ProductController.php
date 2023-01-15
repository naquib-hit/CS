<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\{JsonResponse, RedirectResponse };
use Illuminate\Support\Facades\Log;
use App\Models\{Product, ProductUnit};
use App\Http\Requests\{StoreProductRequest, UpdateProductRequest};
use Illuminate\Pagination\LengthAwarePaginator;

class ProductController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        //
        return view('products.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        //
        $units = ProductUnit::cursor();
        return view('products.create')->with('units', $units);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreProductRequest $request): RedirectResponse
    {
        //
        try 
        {
            $valid = $request->validated();

            $prod = Product::create([
                'product_name'  => $valid['product_name'],
                'product_price' => $valid['product_price']
            ]);

            if (!$prod)
                return redirect()->back()->with('error', __('validation.failed.create'));

            return redirect()->route('products.index')->with('success', __('validation.success.create'));
        } 
        catch (\Exception $e) 
        {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', __('validation.failed.create'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product): View
    {
        //
        return view('products.edit', compact('product', 'product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        try {
            $valid = $request->validated();
            $rs = $product->update($valid);

            if (!$rs)
                return redirect()->back()->with('error', __('validation.failed.update'));

            return redirect()->route('products.index')->with('success', __('validation.success.create'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', __('validation.failed.update'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Product $product):RedirectResponse
    {
        //
        $product->delete();
        return redirect()->route('products.index')->with('success', __('validation.success.delete'));
    }

    /**
     * get data and return to json format
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator | \Illuminate\Http\JsonResponse
     */
    public function get(): ?LengthAwarePaginator
    {
        try 
        {
            $data = Product::orderBy('created_at', 'desc')->orderBy('id', 'desc');
            return $data->paginate(6)->withQueryString();
        } 
        catch (\Exception $e) 
        {
            Log::error($e->getMessage());
            return null;
        }
    }
}
