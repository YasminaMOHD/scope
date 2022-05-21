<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Agents;
use App\Models\Roles_Users;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Notifications\AgentUser;
use App\Notifications\CreateAgent;
use App\Notifications\DeleteAgent;
use App\Notifications\UpdateAgent;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Hash;
use App\Notifications\UpdateAgentUser;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UpdateAgentsRequest;

class AgentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view-agent', Agents::class);
        $agents = Agents::with('user')->orderBy('id','desc')->get();
        return view('Admin.Pages.agents',compact(['agents']));
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
     * @param  \App\Http\Requests\StoreAgentsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create-agent', Agents::class);
        $validate = Validator::make($request->all(),[
            'username' => 'required|string|max:255',
            'fullname'=>'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'phone' => 'required',
        ])->validate();
        if($validate){
             $user = User::create([
                'name' => $request['username'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
            ]);
             $agent = Agents::create([
                'fullName' => $request->fullname,
                'phone' => $request->phone,
                'companyName' => 'ScopeRealestate',
                'user_id' => $user->id,
           ]);
           Roles_Users::create([
            'user_id' => $user->id,
            'role_id' => Role::where('name','user')->first()->id,
        ]);
        $users = User::whereIn('user_type',['super-admin','admin'])->get();
                     foreach ($users as $user1) {
                      $user1->notify(new CreateAgent($agent));
                  }
              $user->notify(new AgentUser($agent));
            return redirect()->route('admin.agent.index')->with('success','Agent created successfully');
        }else{
            return redirect()->route('admin.agent.index')->withErrors($validate);;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Agents  $agents
     * @return \Illuminate\Http\Response
     */
    public function show(Agents $agents)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Agents  $agents
     * @return \Illuminate\Http\Response
     */
    public function edit(Agents $agents)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAgentsRequest  $request
     * @param  \App\Models\Agents  $agents
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $agents)
    {
        $this->authorize('update-agent', Agents::class);
        $validate = Validator::make($request->all(),[
            'username' => 'required|string|max:255',
            'fullname'=>'required|string|max:255',
            'email' => [
                'required',
                Rule::unique('users')->ignore($request['update']),
            ],
            'password' => ['required', 'string', 'min:8'],
            'phone' => 'required',
        ])->validate();

        if($validate){
            $user = User::where('id',$request['update'])->update([
                'name' => $request['username'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
            ]);
             $agent = Agents::where('id',$agents)->update([
                'fullName' => $request->fullname,
                'phone' => $request->phone,
                'companyName' => 'ScopeRealestate',
           ]);
           $users = User::whereIn('user_type',['super-admin','admin'])->get();
                     foreach ($users as $user1) {
                      $user1->notify(new UpdateAgent(Agents::where('id',$agents)->first()));
                  }
                  $user = User::where('id',$request['update'])->first();
                  $user->notify(new UpdateAgentUser(Agents::where('id',$agents)->first()));
            return redirect()->route('admin.agent.index')->with('success','Agent updated successfully');
        }else{
            return redirect()->route('admin.agent.index')->withErrors($validate);;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Agents  $agents
     * @return \Illuminate\Http\Response
     */
    public function destroy($agents)
    {
        $this->authorize('delete-agent', Agents::class);
        $agent = Agents::findOrFail($agents);
        $user = User::findOrFail($agent->user_id);
        $role = Roles_Users::where('user_id',$user->id)->first();
        $del = $agent->delete();
        $del_role = $role->delete();
        $del_user = $user->forceDelete();
        if($del && $del_role && $del_user){
            $users = User::whereIn('user_type',['super-admin','admin'])->get();
                     foreach ($users as $user) {
                      $user->notify(new DeleteAgent($agent));
                  }
            return redirect()->route('admin.agent.index')->with('success','Agent deleted successfully');
    }else{
           return redirect()->route('admin.agent.index')->with('error','Error in deleting process ');
    }
}
}
