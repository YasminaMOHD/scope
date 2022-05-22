<?php

namespace App\Imports;

use App\Models\Lead;
use App\Models\Agents;
use Maatwebsite\Excel\Row;
use App\Models\Agents_lead;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;use App\Contact;

class AgentLeadImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if($row['agent_name'] != null || $row['agent_name'] != ''){
        $agent_id = Agents::where('fullName',$row['agent_name'])->first();
        if($agent_id != null){
        $agent=Agents_lead::where('agent_id',$agent_id->id)->first();
        $lead = Lead::where('name',$row['full_name'])->where('phone',$row['phone_number'])->
        where('email',$row['email'])->first();
        if($agent != null && $lead != null){
            $check=Agents_lead::whereJsonContains('leads',$lead->id)->first();
            if($check != null){
            $a=$check->leads;
            if (($key = array_search($lead->id, $a)) !== false) {
                unset($a[$key]); // remove item at index 0
                $a2 = array_values($a); // 'reindex' array
                Agents_lead::where('agent_id',$check->agent_id)->update([
                    'leads'=>$a2
                ]);
            }
            }
            $a1=$agent->leads;
            array_push($a1,$lead->id);
            $a3 = array_values($a1); // 'reindex' array
            $add=Agents_lead::where('agent_id',$agent_id->id)->update([
                'leads'=>$a3,
            ]);

        }else{
            $check=Agents_lead::whereJsonContains('leads',$lead->id)->first();
            if($check != null){
            $a=$check->leads;
            if (($key = array_search($lead->id, $a)) !== false) {
                unset($a[$key]); // remove item at index 0
                $a2 = array_values($a); // 'reindex' array
                Agents_lead::where('agent_id',$check->agent_id)->update([
                    'leads'=>$a2
                ]);
            }
            }
            $add=Agents_lead::create([
                'agent_id'=>$agent_id->id,
                'leads'=>[$lead->id],
            ]);
    }

     }
        }
    }
}
