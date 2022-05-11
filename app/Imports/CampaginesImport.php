<?php

namespace App\Imports;

use App\Models\Campagines;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;use App\Contact;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;

class CampaginesImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $contact = Campagines::firstOrCreate(
            [
                'name' => $row['campaign_name'],
                'source' => $row['platform'],
            ]

        );

        if (! $contact->wasRecentlyCreated) {
            $contact->update([
                'name' => $row['campaign_name'],
                'source' => $row['platform'],
            ]);
        }
    }
}
