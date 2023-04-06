<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Imports\CustomerImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request as Request;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Support\Facades\{ Log as Log, View };

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): ViewContract
    {
        //
        try
        {

            return view('customers.index');
        }
        catch(\Exception $e)
        {
            Log::error($e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create():  ViewContract
    {
        //
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCustomerRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreCustomerRequest $request): RedirectResponse
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
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Customer $customer): ViewContract
    {
        //
        return view('customers.edit', compact('customer', 'customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCustomerRequest  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateCustomerRequest $request, Customer $customer): RedirectResponse
    {
        //
        try
        {
            $valid = $request->validated();
            $customer->update($valid);

            return redirect()->route('customers.index')->with('success', __('validation.success.update'));
        }
        catch(\Exception $e)
        {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(__('validation.failed.update'))->withInput();
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Customer $customer): RedirectResponse
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
    public function get(Request $req): LengthAwarePaginator
    {
        // Paging parameters
        $customers = Customer::query()->orderBy('id', 'desc')->orderBy('created_at', 'desc');

        if(!empty($req->input('s_customer_name')))
            $customers = $customers->whereRaw('LOWER(customer_name) LIKE ?', ['%'.strtolower($req->input('s_customer_name')).'%']);
        if(!empty($req->input('s_customer_email')))
            $customers = $customers->whereRaw('LOWER(customer_email) LIKE ?', ['%'.strtolower($req->input('s_customer_email')).'%']);
        if(!empty($req->input('s_customer_phone')))
            $customers = $customers->whereRaw('LOWER(customer_phone) LIKE ?', ['%'.strtolower($req->input('s_customer_phone')).'%']);

        $customers = $customers->paginate(6)->withQueryString();

        //$customers->appends(['total_pages' => $pages]);
        
        return $customers;
    }

      /**
     * Mass Delete Alias.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clean(Request $req): RedirectResponse
    {
        //
        try
        {
            $customers = Customer::query();

            if($req->input('rows') === 'all') 
            {
                if(!empty($req->input('customer_name')))
                    $customers = $customers->whereRaw('LOWER(customer_name) LIKE ?', ['%'.strtolower($req->input('customer_name')).'%']);
                if(!empty($req->input('customer_email')))
                    $customers = $customers->whereRaw('LOWER(customer_email) LIKE ?', ['%'.strtolower($req->input('customer_email')).'%']);
                if(!empty($req->input('customer_phone')))
                    $customers = $customers->whereRaw('LOWER(customer_phone) LIKE ?', ['%'.strtolower($req->input('customer_phone')).'%']);
            }
            else 
            {
                $ids = explode(',', $req->input('rows'));
                $customers = $customers->whereIn('id', $ids);
            }    

            $customers->delete();

            return redirect()->back()->with('success' , __('validation.success.delete'));
        }
        catch(\Exception $e)
        {
            Log::error($e->getMessage());
            return redirect()->back()->with('error' , __('validation.failed.delete'));       
        }
    }

    /**
     * Undocumented function
     *
     * @param Request $req
     * @return  \Illuminate\Http\RedirectResponse
     */
    public function import(Request $req): RedirectResponse {
        $file = $req->file('file-import');

       try
       {
            Excel::import(new CustomerImport, $file);
            return redirect()->back()->with('success' , __('File Berhasil Di Unggah'));
       } 
       catch(\Throwable $e)
       {
            Log::error($e->__toString());
            return redirect()->back()->with('error' , __('File Gagal Di Unggah'));      
       }
    }
}
