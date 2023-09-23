<?php

namespace App\Exports;

use App\Models\Enquiry;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class EnggAchievementExport implements FromView
{

    function __construct($EnggAchievementReportData)
    {
        $this->EnggAchievementReportData = $EnggAchievementReportData;
    }
    public function view(): View
    {
        return view('backend/reports/engg_achievement_report_excel', [
            'EnggAchievementReportData' => $this->EnggAchievementReportData
        ]);
    }
}
