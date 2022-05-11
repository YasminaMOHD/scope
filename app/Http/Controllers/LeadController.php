<?php

namespace App\Http\Controllers;

use Excel;
use Carbon\Carbon;
use App\Models\Lead;
use App\Models\Status;
use App\Models\Projects;
use App\Models\Campagines;
use App\Imports\LeadImport;
use App\Models\Description;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Imports\CampaginesImport;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreLeadRequest;
use App\Http\Requests\UpdateLeadRequest;
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
        $leads = Lead::with('status')->with('project')->with('Campagines')->orderBy('id','desc')->get();
        $status = Status::get();
        $projects = Projects::get();
        return view('Admin.Pages.test', compact('leads','status','projects'));
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
                'project_id' => $request->leadproject,
                'status_id' => $status->id,
           ]);
           if($lead){
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
             $lead = Lead::where('id',$lead)->update([
                'name' => $request->leadname,
                'email' => $request->email,
                'phone' => $request->leadtel,
                'address' => $request->leadaddress,
                'project_id' => $request->leadproject,
             ]);
                if($lead){
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
        $this->authorize('force-delete-lead', Lead::class);
        $lead = Lead::findOrFail($lead);
        $del = $lead->delete();
        if($del){
            return redirect()->route('lead.index')->with('success', 'Lead Deleted Successfully');
        }else{
            return redirect()->route('lead.index')->with('error', 'Something went wrong');
        }
    }

    public function search(Request $req ,$Status=null,$lead=null)
    {
        if($Status == 'status'){
            $leads = Lead::with('status')->with('project')->with('desc')->orderBy('id','desc')->where('status_id',$lead)->get();
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
        return  view('Admin.Pages.test', compact('leads','status','projects'));
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
            return redirect()->route('lead.index')->with('success', 'Lead Description Added Successfully');
            }else{
            return redirect()->route('lead.index')->with('error', 'Something went wrong');
            }
            }else{
            $lead = Lead::where('id',$id)->update([
                'status_id' => $req->lead_status,
            ]);
            if($lead){
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
               $leads = Excel::import(new LeadImport, $request->file('uploadfile'));
               Lead::where('project_id',null)->update([
                   'project_id' => $request->project,
               ]);
               Campagines::where('project_id',null)->update([
                   'project_id' => $request->project,
               ]);
               if($leads){
                   return redirect()->route('lead.index')->with('success', 'Leads Imported Successfully');
                 }else{
                      return redirect()->route('lead.index')->with('error', 'Something went wrong');
                    }
                }else{
                    return redirect()->route('admin.excel')->with('error', 'Please Select File');
                }
           }
}
