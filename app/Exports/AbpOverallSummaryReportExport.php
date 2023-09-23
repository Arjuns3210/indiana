<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AbpOverallSummaryReportExport implements FromView
{
    public $overall_summary_data;
    
    public function __construct($overall_summary_data)
    {
        $this->overall_summary_data = $overall_summary_data;
    }

    public function view(): View
    {
        return view('backend/reports/abp_overall_summary_report_excel', [
            'overall_summary_data' => $this->overall_summary_data,
        ]);
    }

}
