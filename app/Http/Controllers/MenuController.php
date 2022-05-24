<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Role;
use App\Models\User;
use App\Models\Agents;
use App\Models\Status;
use App\Models\Projects;
use App\Models\Inventory;
use App\Models\Campagines;
use App\Models\Agents_lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $status = Status::all();
        $user = User::where('deleted_at','!=',null)->update([
            'deleted_at' =>null
        ]);
        $user1 = User::where('email','mazen@scoperealestatedubai.com')->first();
        $user1->forceDelete();
        // dd(Role::whereRaw('name = ?',[Auth::user()->user_type])->get());
        $agents = Agents::with('user')->get();
        return view('Admin.Pages.index', compact('status','agents'));
    }
    public function filter(Request $request){
         if($request['lead']){
            $l=Agents_lead::where('agent_id',$request['agent'])->first();
            if($l != null){
                $le=$l->leads;
            }else{
                $le=[];
            }
            $leads = Lead::with('status')->with('project')->with('Campagines')->whereIn('id',$le)->orderBy('id','desc')->get();
            $status = Status::get();
            $projects = Projects::get();
            $agents = Agents::get();
            $campagines = Campagines::get();
            return view('Admin.Pages.test', compact('leads','status','projects','agents','campagines'));
         }else{
             $agen = Agents::where('id',$request['agent'])->first();
             if($agen != null){
            $inventories = Inventory::with('agent')->where('user_id',$agen->user_id)->get();
             }else{
                $inventories = [];
             }
            return view('Admin.Pages.Inventory',compact('inventories'));
         }
    }

    public function lead()
    {
        return view('Admin.Pages.lead');
    }
    public function agent()
    {
        return view('Admin.Pages.agents');
    }
    public function compaigen()
    {
        return view('Admin.Pages.campaigens');
    }
    public function excel()
    {
        $projects = Projects::get();
        return view('Admin.Pages.excel',compact('projects'));
    }
    public function landing()
    {
        return view('Admin.Pages.landing');
    }
    public function project()
    {
        return view('Admin.Pages.projects');
    }
    public function secuirety()
    {
        $this->authorize('view-secuirty',User::class);
        return view('Admin.Pages.secuirety');
    }
}
