<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use App\Models\Campagines;
use App\Http\Requests\StoreCampaginesRequest;
use App\Http\Requests\UpdateCampaginesRequest;

class CampaginesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Projects::with('campagine')->get();
        return view('Admin.Pages.campaigens',compact('projects'));
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
     * @param  \App\Http\Requests\StoreCampaginesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCampaginesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Campagines  $campagines
     * @return \Illuminate\Http\Response
     */
    public function show(Campagines $campagines)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Campagines  $campagines
     * @return \Illuminate\Http\Response
     */
    public function edit(Campagines $campagines)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCampaginesRequest  $request
     * @param  \App\Models\Campagines  $campagines
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCampaginesRequest $request, Campagines $campagines)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Campagines  $campagines
     * @return \Illuminate\Http\Response
     */
    public function destroy(Campagines $campagines)
    {
        //
    }
}
