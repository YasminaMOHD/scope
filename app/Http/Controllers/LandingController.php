<?php

namespace App\Http\Controllers;

use App\Models\Landing;
use App\Models\Projects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LandingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view-project', Projects::class);
        $projects = Projects::all();
        $landing = Landing::with('project')->get();
        return view('Admin.Pages.landing', compact('projects','landing'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'project' => 'required|string|max:255',
            'page' => 'required|string',
        ])->validate();

        if($validate){
             $land = Landing::create([
                'url' => $request->page,
                'project_id' => $request->project,

             ]);
                if($land){
                    return redirect()->route('admin.landing.index')->with('success', 'Add Project URL Page Successfully');
                }else{
                    return redirect()->route('admin.landing.index')->with('error', 'Something went wrong');
                }
        }else{
                   return redirect()->route('admin.landing.index')->withError($validate);
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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'project' => 'required|string|max:255',
            'page' => 'required|string',
        ])->validate();

        if($validate){
             $land = Landing::where('id',$id)->update([
                'url' => $request->page,
                'project_id' => $request->project,

             ]);
                if($land){
                    return redirect()->route('admin.landing.index')->with('success', 'Project URL Page Updated Successfully');
                }else{
                    return redirect()->route('admin.landing.index')->with('error', 'Something went wrong');
                }
        }else{
                   return redirect()->route('admin.landing.index')->withError($validate);
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
        $land = Landing::findOrFail($id);
        $del = $land->delete();
        if($del){
            return redirect()->route('admin.landing.index')->with('success', 'Project URL Page Deleted Successfully');
        }else{
            return redirect()->route('admin.landing.index')->with('error', 'Something went wrong');
        }
    }
}
