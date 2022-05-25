<?php

namespace App\Imports;

use App\Models\Lead;
use Maatwebsite\Excel\Row;
use App\Models\Description;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;use App\Contact;

class DescImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if($row['desc'] != null || $row['desc'] != ''){
        $lead=Lead::where('name',$row['full_name'])->where('phone',$row['phone_number'])->
         where('email',$row['email'])->first();
        $contact = Description::firstOrCreate(
            [
                'user_id' => Auth::user()->id,
                'lead_id' => $lead->id,
                'text' => $row['desc']
            ]

        );

        if (! $contact->wasRecentlyCreated) {
            $contact->update([
                'user_id' => Auth::user()->id,
                'lead_id' => $lead->id,
                'text' => $row['desc']
            ]);
        }
    }
}
}
