<?php

namespace App\Imports;

use App\Models\Agents;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;use App\Contact;

class AgentImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if($row['agent_name'] != null || $row['agent_name'] != ''){
        $contact = Agents::firstOrCreate(
            [
                'fullName' => $row['agent_name'],
            ]

        );

        if (! $contact->wasRecentlyCreated) {
            $contact->update([
                'fullName' => $row['agent_name'],
            ]);
        }
    }
}
}
