<?php

namespace App\Imports;

use App\Models\Lead;
use App\Models\Agents;
use App\Models\Status;
use App\Models\Projects;
use App\Models\Campagines;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LeadImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        if($row['status'] != null || $row['status'] != ''){
            switch($row['status']){
                case 'junk' :
                    $row['status'] = 'Unsellable customer';
                    break;
                case 'JUNK' :
                    $row['status'] = 'Unsellable customer';
                    break;
                case 'potential' :
                    $row['status'] = 'Potential';
                    break;
                case 'POTENTIAL' :
                    $row['status'] = 'Potential';
                    break;
                case 'no answer' :
                    $row['status'] = 'No answer';
                    break;
                case 'NO ANSWER' :
                    $row['status'] = 'No answer';
                    break;
                case 'undefined' :
                    $row['status'] = 'Undefined';
                    break;
                case 'UNDEFINED' :
                    $row['status'] = 'Undefined';
                    break;
                case 'follow up' :
                    $row['status'] = 'Follow Up';
                    break;
                case 'FOLLOW UP' :
                    $row['status'] = 'Follow Up';
                    break;
                case 'Follow up' :
                    $row['status'] = 'Follow Up';
                    break;
                case 'meeting' :
                    $row['status'] = 'Meeting';
                    break;
                case 'MEETING' :
                    $row['status'] = 'Meeting';
                    break;
                case 'deal' :
                    $row['status'] = 'Deal';
                    break;
                case 'DEAL' :
                    $row['status'] = 'Deal';
                    break;
            }
            $status = Status::where('name',$row['status'])->first();
        }else{
            $status = Status::where('name','Undefined')->first();
        }
        $c_id = Campagines::where('name',$row['campaign_name'])->where('source',$row['platform'])->first();
        $proj_id = Projects::where('name',$row['project_name'])->first()->id;
        $contact = Lead::firstOrCreate(
            [
                'name' => $row['full_name'],
            'email' => $row['email'],
            'phone' => $row['phone_number'],
            'address' => $row['address'],
            'status_id' => $status->id,
            'campagine_id' => $c_id->id,
            'project_id'=>$proj_id,
            ]
        );

        if (! $contact->wasRecentlyCreated) {
            $contact->update([
                'name' => $row['full_name'],
            'email' => $row['email'],
            'phone' => $row['phone_number'],
            'address' => $row['address'],
            'status_id' => $status->id,
            'campagine_id' => $c_id->id,
            'project_id'=>$proj_id,
            ]);
        }
    }

}
