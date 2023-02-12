<?php

namespace App\Http\Controllers;

use Illuminate\Http\{Request, JsonResponse};
use Illuminate\Support\Facades\Log;
use App\Models\{ Project, Customer, User };
use App\Http\Requests\ { StoreProjectRequest, UpdateProjectRequest };

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\View\View
     */
    public function index() : \Illuminate\View\View
    {
        //
        return view('projects.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create(): \Illuminate\View\View
    {
        //
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProjectRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreProjectRequest $request): \Illuminate\Http\RedirectResponse
    {
        //
        try
        {
            $valid = $request->validated();
            Project::create([
                'project_name'  => $valid['project_name'],
                'customer_id'   => $valid['project_customer'],
                'created_by'    => User::find(auth()->id())->fullname
            ]);
            
            return redirect()->route('projects.index')->with('success', __('validation.success.create'));
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
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\View\View
     */
    public function edit(Project $project): \Illuminate\View\View
    {
        //
        return view('projects.edit')->with('project', $project);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProjectRequest  $request
     * @param  \App\Models\Project  $project
     * @return  \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateProjectRequest $request, Project $project):  \Illuminate\Http\RedirectResponse
    {
         try
         {
             $valid = $request->validated();
             $project->update([
                 'project_name'  => $valid['project_name'],
                 'customer_id'   => $valid['project_customer'],
                 'created_by'    => User::find(auth()->id())->fullname
             ]);
             
             return redirect()->route('projects.index')->with('success', __('validation.success.create'));
         }
         catch(\Throwable $e)
         {
             Log::error($e->__toString());
             return redirect()->back()->with('error', __('validation.failed.create'));
         }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Project $project): \Illuminate\Http\RedirectResponse
    {
        //
        try
        {
            $project->delete();
            return redirect()->route('projects.index')->with('success', __('validation.success.create'));
        }
        catch(\Throwable $e)
        {
            Log::error($e->__toString());
            return redirect()->back()->with('error', __('validation.failed.create'));
        }
    }

    /**
     * Get All List Data And Paging
     * 
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function get(Request $request): \Illuminate\Pagination\LengthAwarePaginator
    {
        $project = Project::with('customers')->orderBy('id', 'desc')->orderBy('created_at', 'desc');

        if(!empty($request->input('s_project_name')))
            $project->whereRaw('LOWER(project_name) LIKE ?', ['%'.strtolower($request->input('s_project_name')).'%']);
        if(!empty($request->input('s_project_customer')))
            $project->whereHas('customers', function($q) use ($request) { 
                return $q->whereRaw('LOWER(customer_name) LIKE ?', ['%'.strtolower($request->input('s_project_customer')).'$']); 
            });

        return $project->paginate(6);
    }

    /**
     * Mass Delete
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function truncate(Request $request): \Illuminate\Http\RedirectResponse 
    {
        try 
        {
            $project = Project::with('customers');

            if($request->input('rows') == 'all')
            {
                if(!empty($request->input('s_project_name')))
                    $project->whereRaw('LOWER(project_name) LIKE ?', ['%'.strtolower($request->input('s_project_name')).'%']);
                if(!empty($request->input('s_project_customer')))
                    $project->whereHas('customers', function($q) use ($request) { 
                        return $q->whereRaw('LOWER(customers.customer_name) LIKE ?', ['%'.strtolower($request->input('s_project_customer')).'$']); 
                    });
            }
            else
            {
                $ids = explode(',', $request->input('rows'));
                $project->whereIn('id', $ids);
            }

            $project->delete();

            return redirect()->route('projects.index')->with('success', __('validation.success.delete'));    
        }
        catch(\Throwable $e)
        {
            Log::error($e->__toString());
            return redirect()->back()->with('error', __('validation.failed.delete'));
        }
    }


    /**
     * get all customers data for selection
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCustomers(): JsonResponse
    {
        return response()->json(Customer::cursor(), 200, ['Content-Type' => 'application/json']);
    }
}
