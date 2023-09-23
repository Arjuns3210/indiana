<?php

namespace App\Exports;

use App\Models\Abp;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AbpVarianceReportExport implements FromView
{
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        $data = $this->data;

        return view('backend.reports.abp_variance_report_view')->with($data);
    }
}
