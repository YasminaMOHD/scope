<?php

namespace App\Http\Controllers;

use Excel;
use Carbon\Carbon;
use App\Models\Lead;
use App\Models\User;
use App\Models\Agents;
use App\Models\Status;
use App\Models\Projects;
use App\Jobs\SendRmainder;
use App\Models\Campagines;
use App\Imports\DescImport;
use App\Imports\LeadImport;
use App\Models\Agents_lead;
use App\Models\Description;
use App\Imports\AgentImport;
use Illuminate\Http\Request;
use App\Imports\ProjectImport;
use Illuminate\Validation\Rule;
use App\Imports\AgentLeadImport;
use App\Imports\CampaginesImport;
use App\Notifications\AssignLead;
use App\Notifications\CreateLead;
use App\Notifications\DeleteLead;
use App\Notifications\UpdateLead;
use App\Notifications\CreateExcel;
use Illuminate\Support\Facades\DB;
use App\Notifications\ChangeStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Notifications\AgentLeadAssign;
use App\Http\Requests\StoreLeadRequest;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\UpdateLeadRequest;
use App\Notifications\CreateDiscription;
use App\Notifications\DeleteDescription;
use App\Notifications\UpdateDiscription;
use Illuminate\Support\Facades\Validator;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view-lead', Lead::class);
        if(Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'super-admin'){
            $leads = Lead::with('status')->with('project')->with('Campagines')->orderBy('id','desc')->get();
        }else{
        $l=Agents_lead::where('agent_id',Agents::where('user_id',Auth::user()->id)->first()->id)->first();
        if($l != null){
            $le=$l->leads;
        }else{
            $le=[];
        }
        $leads = Lead::with('status')->with('project')->with('Campagines')->whereIn('id',$le)->orderBy('id','desc')->get();
        }
        $status = Status::get();
        $projects = Projects::get();
        $agents = Agents::get();
        $campagines = Campagines::get();
        return view('Admin.Pages.test', compact('leads','status','projects','agents','campagines'));
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
     * @param  \App\Http\Requests\StoreLeadRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create-lead', Lead::class);
        $validate = Validator::make($request->all(), [
            'leadname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'leadphone' => 'required|string|max:255',
            'leadaddress' => 'required|string|max:255',
        ])->validate();

        if($validate){
            $status = Status::where('name','Undefined')->first();
           $lead = Lead::create([
               'name' => $request->leadname,
                'email' => $request->email,
                'phone' => $request->leadphone,
                'address' => $request->leadaddress,
                'status_id' => $status->id,
           ]);

           if($request->leadproject != null){
               $p = Projects::where('id',$request->leadproject)->first();
               if($p != null){
                   $lead->update([
                       'project_id'=>$request->leadproject
                   ]);
               }else{
                   $newP=Projects::create([
                       'name'=>$request->leadproject,
                       'developerName'=>$request->leadproject
                   ]);
                   $lead->update([
                       'project_id'=>$newP->id
                   ]);
               }
           }
           if($request->leadcampagin != null && $request->leadsource != null){
              $c= Campagines::where('name',$request->leadcampagin)->where('source',$request->leadsource)->first();
              if($c == null){
                $newC=  Campagines::create([
                      'name'=>$request->leadcampagin,
                      'source'=>$request->leadsource
                  ]);
                  $addC = $lead->update([
                      'campagine_id'=>$newC->id
                  ]);
              }else{
                return redirect()->route('lead.index')->with('error', 'The Campagineb already present');
              }
            }else{
                $addC = $lead->update([
                    'campagine_id'=>$request->leadcampagin
                ]);
            }

           if($lead){
               $users = User::whereIn('user_type',['super-admin','admin'])->get();
               foreach ($users as $user) {
                $user->notify(new CreateLead($lead));
            }
               return redirect()->route('lead.index')->with('success', 'Lead Created Successfully');
           }
        }else{
              return response()->json(['error' => 'Something went wrong']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function show(Lead $lead)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function edit(Lead $lead)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLeadRequest  $request
     * @param  \App\Models\Lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $lead)
    {
        $this->authorize('update-lead', Lead::class);
        $validate = Validator::make($request->all(), [
            'leadname' => 'required|string|max:255',
            'email' => [
                'required',
            ],
            'leadtel' => 'required|string|max:255',
            'leadaddress' => 'required|string|max:255',
        ])->validate();

        if($validate){
             $lead1 = Lead::where('id',$lead)->update([
                'name' => $request->leadname,
                'email' => $request->email,
                'phone' => $request->leadtel,
                'address' => $request->leadaddress,
                'project_id' => $request->leadproject,
             ]);
                if($lead1){
                    $users = User::whereIn('user_type',['super-admin','admin'])->get();
                    foreach ($users as $user) {
                     $user->notify(new UpdateLead(Lead::where('id',$lead)->first()));
                 }
                    return redirect()->route('lead.index')->with('success', 'Lead Updated Successfully');
                }else{
                    return redirect()->route('lead.index')->with('error', 'Something went wrong');
                }
        }else{
                   return redirect()->route('lead.index')->withError($validate);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function destroy($lead)
    {
        $this->authorize('delete-lead', Lead::class);
        $lead = Lead::findOrFail($lead);
        $l=$lead;
        $del = $lead->delete();
        if($del){
            $users = User::whereIn('user_type',['super-admin','admin'])->get();
            foreach ($users as $user) {
             $user->notify(new DeleteLead($l));
         }
            return redirect()->route('lead.index')->with('success', 'Lead Deleted Successfully');
        }else{
            return redirect()->route('lead.index')->with('error', 'Something went wrong');
        }
    }

    public function search(Request $req ,$Status=null,$lead=null)
    {
        if($Status == 'status'){
            if(Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'super-admin'){
                $leads = Lead::with('status')->with('project')->with('Campagines')->where('status_id',$lead)->orderBy('id','desc')->get();
            }else{
             $l=Agents_lead::where('agent_id',Agents::where('user_id',Auth::user()->id)->first()->id)->first();
             if($l != null){
                $le=$l->leads;
            }else{
                $le=[];
            }
            $leads = Lead::with('status')->with('project')->with('Campagines')->whereIn('id',$le)->where('status_id',$lead)->orderBy('id','desc')->get();
            }
        }else if($Status == 'project'){
            $leads = Lead::with('status')->with('project')->where('project_id',$lead)->get();
        }else{
            if($req->from != null && $req->to !=null){
                $leads = Lead::with('status')->with('project')->with('Campagines')->whereBetween('created_at',[date('Y-m-d H:m:s', strtotime($req->from)), date('Y-m-d H:m:s', strtotime($req->to))])->get();
            }else  if($req->to == null && $req->from !=null){
                    $leads =  Lead::with('status')->with('project')->with('Campagines')->whereBetween('created_at',[date('Y-m-d H:m:s', strtotime($req->from)), Carbon::now()->format('Y-m-d H:m:s')])->get();
        }
    }
        $status = Status::get();
        $projects = Projects::get();
        $agents = Agents::get();
        $campagines = Campagines::get();
        return  view('Admin.Pages.test', compact('leads','status','projects','agents','campagines'));
    }

    public function trash(){
        $this->authorize('restore-lead', Lead::class);
        $leads = Lead::with('status')->with('project')->with('Campagines')->onlyTrashed()->get();
        $status = Status::get();
        $projects = Projects::get();
        return  view('Admin.Pages.trash', compact('leads','status','projects'));
    }
    public function restore($id){
        $lead = Lead::withTrashed()->find($id)->restore();;
        if($lead){
            return redirect()->route('lead.trash')->with('success', 'Lead Restored Successfully');
    }else{
        return redirect()->route('lead.trash')->with('error', 'Something went wrong');
    }
}
    public function leadDesc(Request $req,$id){
        if($req->newDescription != null){
            $desc = Description::create([
                'lead_id' => $id,
                'text' => $req->newDescription,
                'user_id' => Auth::user()->id,
            ]);
            $lead = Lead::where('id',$id)->update([
                'status_id' => $req->lead_status,
            ]);
            if($desc && $lead){

                    $users = User::whereIn('user_type',['super-admin','admin'])->get();
                    $l = Lead::where('id',$id)->first();
                    foreach ($users as $user) {
                     $user->notify(new CreateDiscription($l,$desc));
                 }
            return redirect()->route('lead.index')->with('success', 'Lead Description Added Successfully');
            }else{
            return redirect()->route('lead.index')->with('error', 'Something went wrong');
            }
            }else{
            $lead = Lead::where('id',$id)->update([
                'status_id' => $req->lead_status,
            ]);
            if($lead){
                $users = User::whereIn('user_type',['super-admin','admin'])->get();
                    $l = Lead::with('status')->where('id',$id)->first();
                    foreach ($users as $user) {
                     $user->notify(new ChangeStatus($l));
                 }
            return redirect()->route('lead.index')->with('success', 'Lead Status Updated Successfully');
            }else{
            return redirect()->route('lead.index')->with('error', 'Something went wrong');
            }
            }
            }
        public function import(Request $request){
            $this->authorize('create-lead', Lead::class);
            if($request->hasFile('uploadfile')){
               $campagine = Excel::import(new CampaginesImport, $request->file('uploadfile'));
               $project = Excel::import(new ProjectImport, $request->file('uploadfile'));
               $leads = Excel::import(new LeadImport, $request->file('uploadfile'));
               $agent = Excel::import(new AgentLeadImport, $request->file('uploadfile'));
               $desc = Excel::import(new DescImport, $request->file('uploadfile'));
               Lead::where('project_id',null)->update([
                   'project_id' => $request->project,
               ]);
               Campagines::where('project_id',null)->update([
                   'project_id' => $request->project,
               ]);
            if($leads){
                $users = User::whereIn('user_type',['super-admin','admin'])->get();
                foreach ($users as $user) {
                       $user->notify(new CreateExcel());
                }
                   return redirect()->route('lead.index')->with('success', 'Leads Imported Successfully');
             }else{
                      return redirect()->route('lead.index')->with('error', 'Something went wrong');
                    }
            }else{
                    return redirect()->route('admin.excel')->with('error', 'Please Select File');
                }
           }
            // $agent->user->notify(new AgentLeadAssign($lead));

        public function assign(Request $reques,$lead){
           if($reques->agent_id != null){
            $agent=Agents_lead::where('agent_id',$reques->agent_id)->first();
            if($agent != null){
                $alraedy = DB::table('Agents_lead')->where('agent_id',$reques->agent_id)->whereJsonContains('leads',$lead)->first();
                if($alraedy != null){
                    return redirect()->route('lead.index')->with('error', 'Agent Already Assigned');
                }else{
                $check=DB::table('Agents_lead')->whereJsonContains('leads',$lead)->first();
                if($check != null){
                $a=json_decode($check->leads);
                if (($key = array_search($lead, $a)) !== false) {
                    unset($a[$key]); // remove item at index 0
                    $a2 = array_values($a); // 'reindex' array
                    Agents_lead::where('agent_id',$check->agent_id)->update([
                        'leads'=>$a2
                    ]);
                }
                }
                $a1=$agent->leads;
                array_push($a1,$lead);
                $a3 = array_values($a1); // 'reindex' array
                $add=Agents_lead::where('agent_id',$reques->agent_id)->update([
                    'leads'=>$a3,
                ]);
                if($add){
                    $agent = Agents::with('user')->where('id',$reques->agent_id)->first();
                    $lead=Lead::where('id',$lead)->first();
                    $users = User::whereIn('user_type',['super-admin','admin'])->get();
                    foreach ($users as $user) {
                      $user->notify(new AssignLead($lead,$agent));
                    }
                    $userAssign = User::where('id',$agent->user_id)->first();
                    $userAssign->notify(new AgentLeadAssign($lead));
                    return redirect()->route('lead.index')->with('success', 'Leads Assign Successfully');
                }else{
                    return redirect()->route('lead.index')->with('error', 'Something went wrong');
                  }
                }
            }else{
                $check=DB::table('Agents_lead')->whereJsonContains('leads',$lead)->first();
                if($check != null){
                $a=json_decode($check->leads);
                if (($key = array_search($lead, $a)) !== false) {
                    unset($a[$key]); // remove item at index 0
                    $a2 = array_values($a); // 'reindex' array
                    Agents_lead::where('agent_id',$check->agent_id)->update([
                        'leads'=>$a2
                    ]);
                }
                }
                $add=Agents_lead::create([
                    'agent_id'=>$reques->agent_id,
                    'leads'=>[$lead],
                ]);
                if($add){
                    $users = User::whereIn('user_type',['super-admin','admin'])->get();
                    foreach ($users as $user) {
                      $user->notify(new AssignLead($lead,$agent));
                    }
                    $userAssign = User::where('id',$agent->user_id)->first();
                    $userAssign->notify(new AgentLeadAssign($lead));
                    return redirect()->route('lead.index')->with('success', 'Leads Assign Successfully');
                }else{
                    return redirect()->route('lead.index')->with('error', 'Something went wrong');
                  }
            }
        }else{
            return redirect()->route('lead.index')->with('error', 'Not Select Lead');
        }
    }
    public function leadDescUpdate(Request $request){
        $desc1 = Description::where('id',$request['id'])->first()->lead_id;

        $desc = Description::where('id',$request['id'])->update([
            'text'=>$request['desc']
        ]);
        if($desc){
            $users = User::whereIn('user_type',['super-admin','admin'])->get();
            foreach ($users as $user) {
             $user->notify(new UpdateDiscription(Lead::where('id',$desc1)->first()));
            }
            $desc = Description::with('user')->where('lead_id',$desc1)->get();
            return  $desc;
        }
    }
    public function leadDescdel(Request $request){
        $desc = Description::where('id',$request['id'])->first()->lead_id;
        $lead = Description::findOrFail($request['id']);
        $desc1=$lead;
        $del = $lead->forceDelete();
        if($del){
            $desc = Description::with('user')->where('lead_id',$desc)->get();
            return  $desc;
        }
    }
    public function reminder(Request $request){
        $desc = Description::where('id',$request['id'])->update([
            'reminder_at'=> $request['desc']
        ]);
        if($desc){
            $desc = Description::with('user')->where('id',$request['id'])->get();
            return  $desc;
        }
    }

public function sendReminder(){

    // foreach ($desc as $key) {
    //     if($key->reminder_at < Carbon::now()){
    //         $users = User::whereIn('user_type',['super-admin','admin'])->get();
    //         foreach ($users as $user) {
    //          $user->notify(new Reminder(Lead::where('id',$key->lead_id)->first()));
    //         }
    //     }
    // }

}
}
