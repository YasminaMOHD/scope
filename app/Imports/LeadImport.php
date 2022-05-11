<?php

namespace App\Imports;

use App\Models\Lead;
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
        $status = Status::where('name','Undefined')->first();
        $c_id = Campagines::where('name',$row['campaign_name'])->where('source',$row['platform'])->first();
       $contact = Lead::firstOrCreate(
            [
                'name' => $row['full_name'],
            // 'email' => $row['email'],
            'phone' => $row['phone_number'],
            // 'address' => $row['address'],
            'status_id' => $status->id,
            'campagine_id' => $c_id->id,
            ]

        );

        if (! $contact->wasRecentlyCreated) {
            $contact->update([
                'name' => $row['full_name'],
            // 'email' => $row['email'],
            'phone' => $row['phone_number'],
            // 'address' => $row['address'],
            'status_id' => $status->id,
            'campagine_id' => $c_id->id,
            ]);
        }
    }

}
