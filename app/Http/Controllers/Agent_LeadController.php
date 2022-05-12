<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Agents;
use App\Models\Agents_lead;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class Agent_LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view-agent', Agents::class);
        $agent_lead = Agents_lead::with('agent')->get();
        $leads = Lead::all();
        $agents = Agents::all();
        return view('Admin.Pages.AgentLead',compact('agent_lead','leads','agents'));
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
            'agent_id' => 'unique:agents_lead',
        ])->validate();

        if($validate){
               $store = Agents_lead::create([
                   'agent_id' => $request->agent_id,
                   'leads' => $request->lead
               ]);
               if($store){
                return redirect()->route('admin.agent_lead.index')->with('success','Successfully Assign Leads To agent');
               }else{
                return redirect()->route('admin.agent_lead.index')->with('error','Something wrong');
               }
            }else{
                return redirect()->route('admin.agent_lead.index')->withError($validate);
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
            'agent_id' =>  Rule::unique('agents_lead')->ignore($id),
        ])->validate();
        if($validate){
               $store = Agents_lead::where('id',$id)->update([
                   'agent_id' => $request->agent_id,
                   'leads' => $request->lead
               ]);
               if($store){
                return redirect()->route('admin.agent_lead.index')->with('success','Successfully update Assign Leads To agent');
               }else{
                return redirect()->route('admin.agent_lead.index')->with('error','Something wrong');
               }
            }else{
                return redirect()->route('admin.agent_lead.index')->withError($validate);
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
        $lead = Agents_lead::findOrFail($id);
        $del = $lead->delete();
        if($del){
            return redirect()->route('admin.agent_lead.index')->with('success', 'Lead Deleted Successfully');
        }else{
            return redirect()->route('admin.agent_lead.index')->with('error', 'Something went wrong');
        }
    }
}
