<?php

namespace App\Exports;

use App\Models\Enquiry;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TypistAchievementExport implements FromView
{
    function __construct($TypistAchievementReportData)
    {
        $this->TypistAchievementReportData = $TypistAchievementReportData;
    }
    public function view(): View
    {
        return view('backend/reports/typist_achievement_report_excel', [
            'TypistAchievementReportData' => $this->TypistAchievementReportData
        ]);
    }
}
