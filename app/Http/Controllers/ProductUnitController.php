<?php

namespace App\Http\Controllers;

use App\Models\ProductUnit;
use App\Http\Requests\StoreProductUnitRequest;
use App\Http\Requests\UpdateProductUnitRequest;

class ProductUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        //
        $_headers = [
            'Content-Type'  => 'application/json'
        ];
        return response()->json(ProductUnit::cursor(), 200, $_headers); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('products.unit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductUnitRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductUnitRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductUnit  $productUnit
     * @return \Illuminate\Http\Response
     */
    public function show(ProductUnit $productUnit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductUnit  $productUnit
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductUnit $productUnit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductUnitRequest  $request
     * @param  \App\Models\ProductUnit  $productUnit
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductUnitRequest $request, ProductUnit $productUnit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductUnit  $productUnit
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductUnit $productUnit)
    {
        //
    }
}
