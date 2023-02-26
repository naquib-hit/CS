<?php

namespace App\Http\Controllers;

use App\Models\{NoteMail, Project};
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\{ RedirectResponse, JsonResponse };
use App\Http\Requests\StoreNoteMailRequest;
use App\Http\Requests\UpdateNoteMailRequest;

class NoteMailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        //
        return view('noteMails.index');
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreNoteMailRequest $request)
    {
        //
        // try
        // {
        //     $valid = $request->validated();

        //     $item = !empty($valid['id']) ? NoteMail::find($valid['id']) : new NoteMail;
        //     $item->name = $valid['note-name'];
        //     $item->content = $valid['note-content'];
        //     $item->project_id = $valid['note-project'];
        //     $item->save();

        //     return redirect()->route('noteMails.index')->with('success', __('validation.success.create'));
        // }
        // catch(\Throwable $e)
        // {
        //     Log::error($e->__toString());
        //     return redirect()->back()->with('error', __('validation.failed.create'));
        // }
        $valid = $request->validated();
        dd(session());
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

    /**
     * Get All Projects Data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function projects(): JsonResponse
    {
        return response()->json(Project::cursor(), 200, ['Content-Type' => 'application/json']);
    }
}
