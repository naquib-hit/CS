<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('customers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCustomerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomerRequest $request)
    {
        //
        try
        {
            $valid = $request->validated();

            Customer::create([
                'customer_name'     => $valid['customer_name'],
                'customer_email'    => $valid['customer_email'],
                'customer_phone'    => $valid['customer_phone'],
                'customer_address'  => $request->input('customer_address') ?? NULL
            ]);

            return redirect()->route('customers.index')->with('success', __('validation.success.create'));
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
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
        return view('customers.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCustomerRequest  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
        try
        {
            $customer->delete();
            return redirect()->route('customers.index')->with('success', __('validation.success.delete'));
        }
        catch(\Exception $e)
        {
            Log::error($e->getMessage());
            return redirect()->route('customers.index')->with('error', __('validation.failed.delete'));
        }
    }

    /**
     * Return records for json consumption.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
        // Paging parameters
        $itemsPerPage = 6;
        $pages = floor(Customer::count() / $itemsPerPage);
        $customers = Customer::orderBy('id', 'desc')->orderBy('created_at', 'desc');

        $customers = $customers->cursorPaginate($itemsPerPage);
        $customers->appends(['total_pages' => $pages]);

        return $customers;
    }
}
