<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        //
        try
        {
            $valid = $request->validated();

            User::create([
                'username'  => $valid['username'],
                'email'     => $valid['email'],
                'fullname'  => $valid['fullname'],
                'password'  => Hash::make($valid['password']),
            ]);

            return redirect()->route('users.index')->with('success', __('validation.success.create'));
        }
        catch(\Throwable $e)
        {
            Log::error($e->__toString());
            return redirect()->back()->with('error', __('validation.failed.create'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $user = User::find($id);
        return view('users.edit')->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, int $id)
    {
        //
        //
        try
        {
            $valid = $request->validated();
            $user = User::updateUser($valid, $id);

            return redirect()->route('users.index')->with('success', __('validation.success.create'));
        }
        catch(\Throwable $e)
        {
            Log::error($e->__toString());
            return redirect()->back()->with('error', __('validation.failed.update'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        try
        {
            User::find($id)->delete();
            return redirect()->route('users.index')->with('success', __('validation.success.delete'));
        }
        catch(\Throwable $e)
        {
            Log::error($e->__toString());
            return redirect()->back()->with('error', __('validation.failed.delete'));
        }
    }


    public function get()
    {
        $users = User::query()->orderBy('id', 'desc');
        
        return $users->paginate(8);
    }
}
