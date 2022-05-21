<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Requests\StoreStatusRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UpdateStatusRequest;

class StatusController extends Controller
{
    public function __construct(){
        $this->middleware(['can:viwe-status,App\Models\Status::class']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statuses = Status::all();
        return view('Admin.Pages.status', compact('statuses'));
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
     * @param  \App\Http\Requests\StoreStatusRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|unique:statuses|max:255',
            'icon' => 'required',
            'color' => 'required',
        ]);
        if($validate){
            $status = Status::create([
                'name' => $request->name,
                'color' => $request->color,
                'icon' => $request->icon,
            ]);
            if($status){
                return redirect()->route('superAdmin.status.index')->with('success', 'Status created successfully');
            }
        }else{
            return redirect()->route('superAdmin.status.index')->withErrors($validate);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function show(Status $status)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function edit(Status $status)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStatusRequest  $request
     * @param  \App\Models\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $status)
    {
        $validate = Validator::make($request->all(), [
            'name' => ['required','unique:statuses','max:255',Rule::unique('statuses')->ignore($status)],
            'icon' => 'required',
            'color' => 'required',
        ]);
        if($validate){
            if((Status::where('id',$status)->first()->name) == 'Undefined'){
                return redirect()->route('superAdmin.status.index')->with('error', 'Status name can not be Undefined');
            }else{
            $status = Status::where('id',$status)->update([
                'name' => $request->name,
                'color' => $request->color,
                'icon' => $request->icon,
            ]);
            if($status){
            return redirect()->route('superAdmin.status.index')->with('success', 'Status updated successfully');
            }
        }
        }else{
            return redirect()->route('superAdmin.status.index')->withErrors($validate);
        }
        }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function destroy(Status $status)
    {
        $status = Status::findOrFail($status->id);
        if($status->name == 'Undefined'){
            return redirect()->route('superAdmin.status.index')->with('error', 'Status Undefind can not be deleted');
        }else{
        $del = $status->delete();
        if($del){
            return redirect()->route('superAdmin.status.index')->with('success', 'Status deleted successfully');
        }
    }

    }
}
