<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Status;
use App\Models\Projects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        // dd(Role::whereRaw('name = ?',[Auth::user()->user_type])->get());
        return view('Admin.Pages.index',compact('status'));
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
