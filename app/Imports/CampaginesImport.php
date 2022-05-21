<?php

namespace App\Imports;

use App\Models\Projects;
use App\Models\Campagines;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;use App\Contact;

class CampaginesImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if($row['campaign_name'] != null || $row['campaign_name'] != ''){
         $project= Projects::where('name',$row['project_name'])->first();
        $contact = Campagines::firstOrCreate(
            [
                'name' => $row['campaign_name'],
                'source' => $row['platform'],
                'project_id' => $project->id,
            ]

        );

        if (! $contact->wasRecentlyCreated) {
            $contact->update([
                'name' => $row['campaign_name'],
                'source' => $row['platform'],
                'project_id' => $project->id,
            ]);
        }
    }
}
}
