<?php

namespace App\Http\Controllers;

use App\Models\NoteMail;
use App\Http\Requests\StoreNoteMailRequest;
use App\Http\Requests\UpdateNoteMailRequest;

class NoteMailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreNoteMailRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNoteMailRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NoteMail  $noteMail
     * @return \Illuminate\Http\Response
     */
    public function show(NoteMail $noteMail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NoteMail  $noteMail
     * @return \Illuminate\Http\Response
     */
    public function edit(NoteMail $noteMail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateNoteMailRequest  $request
     * @param  \App\Models\NoteMail  $noteMail
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNoteMailRequest $request, NoteMail $noteMail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NoteMail  $noteMail
     * @return \Illuminate\Http\Response
     */
    public function destroy(NoteMail $noteMail)
    {
        //
    }
}
