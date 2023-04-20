<?php

namespace App\Exports;

use App\Models\Campaign;
use Maatwebsite\Excel\Concerns\FromCollection;

class CampaignsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Campaign::all();
    }
}
