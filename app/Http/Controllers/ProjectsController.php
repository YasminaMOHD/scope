<?php

namespace App\Http\Controllers;

use App\Models\Agents;
use App\Models\Projects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreProjectsRequest;
use App\Http\Requests\UpdateProjectsRequest;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view-project', Projects::class);
        $projects = Projects::with('agent')->get();
        $agents = Agents::get();
        return view('Admin.Pages.projects',compact('projects','agents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProjectsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create-project', Projects::class);
        $validate = Validator::make($request->all(),[
            'projectname' => 'required|string|max:255',
            'projectred'=>'required|string|max:255',
        ])->validate();
        if($validate){
            $project = Projects::create([
                'name' => $request->projectname,
                'developerName' => $request->projectred,
            ]);
            if($project){
                return redirect()->route('admin.project.index')->with('success','Project created successfully');
            }
        }else{
            return redirect()->route('admin.project.index')->withErrors($validate);;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Projects  $projects
     * @return \Illuminate\Http\Response
     */
    public function show(Projects $projects)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Projects  $projects
     * @return \Illuminate\Http\Response
     */
    public function edit(Projects $projects)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProjectsRequest  $request
     * @param  \App\Models\Projects  $projects
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $projects)
    {
        $this->authorize('update-project', Projects::class);
        $validate = Validator::make($request->all(),[
            'projectname' => 'required|string|max:255',
            'projectred'=>'required|string|max:255',
        ])->validate();
        if($validate){
            $project = Projects::where('id',$projects)->update([
                'name' => $request->projectname,
                'developerName' => $request->projectred,
                'agent_id' => $request->projectseller,
            ]);
            if($project){
                return redirect()->route('admin.project.index')->with('success','Project updated successfully');
            }
        }else{
            return redirect()->route('admin.project.index')->withErrors($validate);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Projects  $projects
     * @return \Illuminate\Http\Response
     */
    public function destroy($projects)
    {
        $this->authorize('force-delete-project', Projects::class);
        $project = Projects::findOrFail($projects);
        $project->delete();
        return redirect()->route('admin.project.index')->with('success','Project deleted successfully');
    }
}
