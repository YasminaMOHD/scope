<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Roles_Users;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{

    public function __construct(){
        $this->middleware(['can:view-role,App\Models\Role::class']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::get();
        return view('admin.Pages.role', compact('roles'));
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
        $validate = Validator::make($request->all(),[
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ])->validate();
        if($validate){
            $role = Role::create([
                'name' => $request->name,
                'permissions' => $request->permission,
            ]);

            return redirect()->route('superAdmin.role.index')->with('success', 'Role created successfully');
        }else{
            return redirect()->route('superAdmin.role.index')->withErrors($validate);
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
            'name' => [
                'required',
                'unique:roles,name,'.$id,
                Rule::unique('roles')->ignore($id),
            ],
            'permission' => 'required',
        ])->validate();
        if($validate){
            $role = Role::where('id',$id)->update([
                'name' => $request['name'],
                'permissions' => $request['permission'],
            ]);
            if($role){
                return redirect()->route('superAdmin.role.index')->with('success', 'Role updated successfully');
            }
        }else{
            return redirect()->route('superAdmin.role.index')->withErrors($validate);
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
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect()->route('superAdmin.role.index')->with('success', 'Role deleted successfully');
    }
}
