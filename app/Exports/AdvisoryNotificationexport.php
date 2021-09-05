<?php

namespace App\Exports;

use App\Models\AdvisoryNotification;
use Maatwebsite\Excel\Concerns\FromCollection;

class AdvisoryNotificationexport implements FromCollection
{
    public function collection()
    {
        return AdvisoryNotification::all();
    }
}