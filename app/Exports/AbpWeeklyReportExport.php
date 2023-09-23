<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AbpWeeklyReportExport implements FromView
{
    public $abp_weekly_data;
    
    public function __construct($abp_weekly_data)
    {
        $this->abp_weekly_data = $abp_weekly_data;
    }

    public function view(): View
    {
        return view('backend/reports/abp_weekly_report_excel', [
            'abp_weekly_data' => $this->abp_weekly_data,
        ]);
    }
}
