<?php

namespace App\Imports;

use App\Models\Projects;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;use App\Contact;

class ProjectImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if($row['project_name'] != null || $row['project_name'] != ''){
        $contact = Projects::firstOrCreate(
            [
                'name' => $row['project_name'],
                'developerName' => $row['project_name'],
            ]

        );

        if (! $contact->wasRecentlyCreated) {
            $contact->update([
                'name' => $row['project_name'],
                'developerName' => $row['project_name'],
            ]);
        }
    }
}
}
