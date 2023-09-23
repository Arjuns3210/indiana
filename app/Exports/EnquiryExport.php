<?php

namespace App\Exports;

use App\Models\Enquiry;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Sheet;
use Maatwebsite\Excel\Concerns\FromCollection;
use DateTime;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class EnquiryExport implements FromCollection, WithHeadings, WithCustomStartCell, WithEvents, WithColumnFormatting
{

    function __construct($request)
    {
        $this->request = $request;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function startCell(): string
    {
        return 'A2';
    }
    public function registerEvents(): array
    {

        return [
            AfterSheet::class => function (AfterSheet $event) {
                /** @var Sheet $sheet */
                $sheet = $event->sheet;
                $start_date = Carbon::parse(now())->format('Y-m-d');
                $end_date = Carbon::parse(now())->format('Y-m-d');
                if (isset($this->request->daterange) && !empty($this->request->daterange)) {
                    $string = explode('-', $this->request->daterange);
                    $start_date = Carbon::createFromFormat('d/m/Y', trim($string[0]))->format('d/m/Y');
                    $end_date = Carbon::createFromFormat('d/m/Y', trim($string[1]))->format('d/m/Y');
                }

                $sheet->mergeCells('A1:AR1');
                $sheet->setCellValue('A1', "Enquiry Report (" . $start_date . " - " . $end_date . ")");


                $styleArray = [
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ];



                $headerFontArray = [
                    'name' => 'Calibri',
                    'bold' => TRUE,
                    'italic' => FALSE,
                    'underline' => \PhpOffice\PhpSpreadsheet\Style\Font::UNDERLINE_NONE,
                    'strikethrough' => FALSE,
                    'size' => 16,
                    'color' => [
                        'rgb' => 'FF000000'
                    ]
                ];
                $heading = 'A1:AK1'; // Main Heading
                $event->sheet->getDelegate()->getStyle($heading)->applyFromArray($styleArray);
                $event->sheet->getDelegate()->getStyle($heading)->getFont()->applyFromArray($headerFontArray);


                //column style
                $columnFontArray = [
                    'name' => 'Calibri',
                    'bold' => TRUE,
                    'italic' => FALSE,
                    'underline' => \PhpOffice\PhpSpreadsheet\Style\Font::UNDERLINE_NONE,
                    'strikethrough' => FALSE,
                    'size' => 11,
                    'color' => [
                        'rgb' => 'FF000000'
                    ]
                ];

                $columnBorderArray =   [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => [
                            'rgb' => 'FF000000'
                        ]
                    ]
                ];

                $columnColorArray = [
                    'fillType' => Fill::FILL_GRADIENT_LINEAR,
                    'rotation' => 0.0,
                    'startColor' => [
                        'rgb' => 'FFFFFF00'
                    ],
                    'endColor' => [
                        'argb' => 'FFFFFF00'
                    ]
                ];

                $headerColumn = 'A2:AR2'; // Columns
                $columns = range('A', 'ZZ');

                for ($i = 'A'; $i < 'ZZ'; $i++) {
                    $event->sheet->getDelegate()->getColumnDimension($i)->setWidth(20);
                    if ($i == 'AR') {
                        break;
                    }
                }


                // foreach ($columns as $elements) {
                // }

                $event->sheet->getDelegate()->getStyle($headerColumn)->getFill()->applyFromArray($columnColorArray);
                $event->sheet->getDelegate()->getStyle($headerColumn)->getBorders()->applyFromArray($columnBorderArray);
                $event->sheet->getDelegate()->getStyle($headerColumn)->getFont()->applyFromArray($columnFontArray);


                //below line is added by Arjun to wrap estimator remarks
                $event->sheet->getDelegate()->getStyle('AK1:AK'.$event->sheet->getDelegate()->getHighestRow())->getAlignment()->setWrapText(true);

                // $event->sheet->getDelegate()->getStyle('D')
                //     ->getAlignment()
                //     ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            },
        ];
    }
    public function headings(): array
    {
        return [
            'SR.NO',
            'Enq No.',
            'REV',
            'Actul Enq. Rec.',
            'ENQ Date',
            'ENQ Due Date',
            'Estimator Due Date',
            'CLIENT',
            'PROJECTS/TENDER DETAILS',
            'PRODUCT ',
            'REGION',
            'CI',
            'Sales',
            'Sales Remark',
            'CATEGORY',
            'CAT Date',
            'CAT Time',
            'Industry',
            'End User',
            'CI REMARK',
            'Allocation Status',
            'Allocation Date',
            'Allocation Time',
            'ENGG',
            'Transfer From Engg',
            'Engineer Transfer Date',
            'Engineer Transfer time',
            'TYPIST',
            'Transfer From Typist',
            'Typist Transfer Date',
            'Typist Transfer Time',
            'Allocation Remark',
            'Allocator',
            'Engg Status',
            'EST - Date',
            'EST - Time',
            'Engg Remark',
            'Typist Status',
            'TYP Completed ON',
            'TYP Completed Time',
            'Amount',
            'Typist Remark',
            'Days Old',
            'Created On',
        ];
    }

    public function collection()
    {
        // return Enquiry::all();

        $role_id = session('data')['role_id'];
        $user_id = session('data')['id'];
        $msg_data = array();
        $msg = "";
        $start_date = Carbon::parse(now())->format('Y-m-d');
        $end_date = Carbon::parse(now())->format('Y-m-d');
        if (isset($this->request->daterange) && !empty($this->request->daterange)) {
            $string = explode('-', $this->request->daterange);
            $start_date = Carbon::createFromFormat('d/m/Y', trim($string[0]))->format('Y-m-d');
            $end_date = Carbon::createFromFormat('d/m/Y', trim($string[1]))->format('Y-m-d');
        }

        $datediff = strtotime($end_date) - strtotime($start_date);
        $days = round($datediff / (60 * 60 * 24));
        $report_max_days = config('global.MAX_DAYS.MAX_ENQ_REP_DAYS');

        if ($days > $report_max_days) {
            errorMessage(__('report.days_count_exceed'), $msg_data);
        }

        $main_table = 'enquiries';
        $report_details = DB::table('enquiries')->select(
            'enquiries.*',
            'products.product_name',
            'regions.region_name',
            'categories.category_name',
            'engineer_statuses.engineer_status_name',
            'typist_statuses.typist_status_name',
            'allocation_statuses.allocation_status_name',
            'industries.industry_name',
            'sales.nick_name as sales',
            'ci.nick_name as case_incharge',
            'allocator.nick_name as allocator',
            'eng.nick_name as engineer',
            'old_eng.nick_name as old_engineer',
            'typ.nick_name as typist',
            'old_typ.nick_name as old_typist',
        )
            ->where('enquiries.status', 1)
            ->where('enquiries.deleted_at', NULL)
            ->leftjoin('products', 'products.id', '=', 'enquiries.product_id')
            ->leftjoin('regions', 'regions.id', '=', 'enquiries.region_id')
            ->leftjoin('categories', 'categories.id', '=', 'enquiries.category_id')
            ->leftjoin('engineer_statuses', 'engineer_statuses.id', '=', 'enquiries.engineer_status')
            ->leftjoin('typist_statuses', 'typist_statuses.id', '=', 'enquiries.typist_status')
            ->leftjoin('allocation_statuses', 'allocation_statuses.id', '=', 'enquiries.allocation_status')
            ->leftjoin('industries', 'industries.id', '=', 'enquiries.industry_id')
            ->leftjoin('admins as sales', 'sales.id', '=', 'enquiries.sales_id')
            ->leftjoin('admins as ci', 'ci.id', '=', 'enquiries.case_incharge_id')
            ->leftjoin('admins as allocator', 'allocator.id', '=', 'enquiries.allocator_id')
            ->leftjoin('admins as eng', 'eng.id', '=', 'enquiries.engineer_id')
            ->leftjoin('admins as old_eng', 'old_eng.id', '=', 'enquiries.old_engineer_id')
            ->leftjoin('admins as typ', 'typ.id', '=', 'enquiries.typist_id')
            ->leftjoin('admins as old_typ', 'old_typ.id', '=', 'enquiries.old_typist_id')
            ->whereDate($main_table . '' . '.enq_register_date', '>=', $start_date)
            ->whereDate($main_table . '' . '.enq_register_date', '<=', $end_date);


        if (isset($this->request->typist_date) && $this->request->typist_date != '') {
            $typist_date = Carbon::createFromFormat('d/m/Y', $this->request->typist_date)->format('Y-m-d');
            $report_details = $report_details->whereDate($main_table . '' . '.typist_completed_date', $typist_date);
        }

        if (isset($this->request->user_specific) && $this->request->user_specific == true) {
            $table_name = $main_table;
            $table_name .= ($role_id == 6) ? '.typist_id' : (($role_id == 5) ? '.engineer_id' : '');

            if (!empty($table_name)) {
                $report_details = $report_details->where($table_name, $user_id);

                //aded by arjun : start
                if($role_id == 6){
                     $report_details->whereIn('engineer_status', [1, 2]);
                }
                //aded by arjun : end
            }

        }

        if (isset($this->request->search_region) && $this->request->search_region != '') {
            $region = $this->request->search_region;
            $report_details = $report_details->where($main_table . '' . '.region_id', $region);
        }

        if (isset($this->request->amount) && $this->request->amount != '') {
            $numberAmount = number_format((float)$this->request->amount, 2, '.', '');
            $report_details = $report_details->where($main_table . '.amount','>=', $numberAmount);
        }
        
      

        if (isset($this->request->typist_status) && $this->request->typist_status != '') {
            $typistStatusArray = $this->request->typist_status;
            if (in_array('blank', $this->request->typist_status)) {
                $report_details = $report_details->where($main_table . '' . '.typist_id', '!=', 0);
                $key = array_search('blank', $typistStatusArray);
                $typistStatusArray[$key] = -1;
            }
            $implodeTypistStatusArray = implode(",", $typistStatusArray);
            $report_details = $report_details->whereRaw("COALESCE(typist_status,-1) IN (" . $implodeTypistStatusArray . ")");
        }

        if (isset($this->request->engineer_status) && $this->request->engineer_status != '') {
            $enggStatusArray = $this->request->engineer_status;
            if (in_array('blank', $this->request->engineer_status)) {
                $report_details = $report_details->where($main_table . '' . '.engineer_id', '!=', 0);
                $key = array_search('blank', $enggStatusArray);
                $enggStatusArray[$key] = -1;
            }
            $implodeEnggStatusArray = implode(",", $enggStatusArray);
            $report_details = $report_details->whereRaw("COALESCE(engineer_status,-1) IN (" . $implodeEnggStatusArray . ")");
        }
        $report_details = $report_details->get();
          //print_r($report_details);die;
        $enq_data = [];

        if (!empty($report_details)) {
            $report_details = $report_details->toArray();
            $i = 1;
            foreach ($report_details as $enq) {

                $today = now();
                $enq_register_date = $enq->enq_register_date;
                $datetime1 = new DateTime($today);
                $datetime2 = new DateTime($enq_register_date);
                $interval = $datetime1->diff($datetime2);
                $days = $interval->format('%a');
                $old_days = $days;
                $empty_values = '';
                $empty_revision_values = 0;
                $engineerRemark=$enq->engineer_remark;

                if(!empty($engineerRemark))
                {
                    $engineerRemark=str_replace('<br/>','\n',strip_tags($engineerRemark));
                }

                $enq_data[] = [
                    'sr_no' => $i,
                    'enq_no' => $enq->enq_no,
                    'revision_no' => $enq->revision_no ? $enq->revision_no : $empty_revision_values,
                    'enq_recv_date' => $enq->enq_recv_date ? date('d-M-Y', strtotime($enq->enq_recv_date)) : $empty_values,
                    'enq_register_date' => $enq->enq_register_date ? date('d-M-Y', strtotime($enq->enq_register_date)) : $empty_values,
                    'enq_due_date' => $enq->enq_due_date ? date('d-M-Y', strtotime($enq->enq_due_date)) : $empty_values,
                    'enq_reminder_date' => $enq->enq_reminder_date ? date('d-M-Y', strtotime($enq->enq_reminder_date)) : $empty_values,
                    'client_name' => $enq->client_name ?? $empty_values,
                    'project_name' => $enq->project_name ?? $empty_values,
                    'product_name' => $enq->product_name ?? $empty_values,
                    'region_name' => $enq->region_name ?? $empty_values,
                    'case_incharge' => $enq->case_incharge ?? $empty_values,
                    'sales' => $enq->sales ?? $empty_values,
                    'sales_remark' => $enq->sales_remark ?? $empty_values,
                    'category_name' => $enq->category_name ?? $empty_values,
                    'category_mapped_date' => $enq->category_mapped_date ? date('d-M-Y', strtotime($enq->category_mapped_date)) : $empty_values,
                    'category_mapped_time' => $enq->category_mapped_time ? $enq->category_mapped_time : $empty_values,
                    'industry' => $enq->industry_name ?? $empty_values,
                    'end_user' => $enq->actual_client ?? $empty_values,
                    'case_incharge_remark' => $enq->case_incharge_remark ?? $empty_values,
                    'allocation_status' => $enq->allocation_status_name ?? $empty_values,
                    'allocation_date' => $enq->allocation_date ? date('d-M-Y', strtotime($enq->allocation_date)) : $empty_values,
                    'allocation_time' => $enq->allocation_time ? $enq->allocation_time : $empty_values,
                    'engineer' => $enq->engineer ?? $empty_values,
                    'old_engineer' => $enq->old_engineer ?? $empty_values,
                    'engg_transfer_date' => $enq->engg_transfer_date ? date('d-M-Y', strtotime($enq->engg_transfer_date)) : $empty_values,
                    'engg_transfer_time' => $enq->engg_transfer_time ? $enq->engg_transfer_time : $empty_values,
                    'typist' => $enq->typist ?? $empty_values,
                    'old_typist' => $enq->old_typist ?? $empty_values,
                    'typist_transfer_date' => $enq->typist_transfer_date ? date('d-M-Y', strtotime($enq->typist_transfer_date)) : $empty_values,
                    'typist_transfer_time' => $enq->typist_transfer_time ? $enq->typist_transfer_time : $empty_values,
                    'allocation_remark' => $enq->allocation_remark ?? $empty_values,
                    'allocator' => $enq->allocator ?? $empty_values,
                    'engineer_status_name' => $enq->engineer_status_name ?? $empty_values,
                    'estimated_date' => $enq->estimated_date ? date('d-M-Y', strtotime($enq->estimated_date)) : $empty_values,
                    'estimated_time' => $enq->estimated_time ? $enq->estimated_time: $empty_values,
                    'engineer_remark' => $engineerRemark ?? $empty_values,
                    'typist_status_name' => $enq->typist_status_name ?? $empty_values,
                    'typist_completed_date' => $enq->typist_completed_date ? date('d-M-Y', strtotime($enq->typist_completed_date)) : $empty_values,
                    'typist_completed_time' => $enq->typist_completed_time ? $enq->typist_completed_time: $empty_values,
                    'amount' => $enq->amount ?? $empty_values,
                    'typist_remark' => $enq->typist_remark ?? $empty_values,
                    'days_old' => $old_days,
                    'created_at' => $enq->created_at ? date('d-M-Y H:i:s', strtotime($enq->created_at)) : $empty_values,
                ];
                $i++;
            }
        }

        $collection = collect($enq_data);
        return $collection;
    }


    public function columnFormats(): array
    {

        return [
            'D' => config('global.FORMAT_DATE_NEW'),
            'E' => config('global.FORMAT_DATE_NEW'),
            'F' => config('global.FORMAT_DATE_NEW'),
            'G' => config('global.FORMAT_DATE_NEW'),
            'P' => config('global.FORMAT_DATE_NEW'),
            'U' => config('global.FORMAT_DATE_NEW'),
            'X' => config('global.FORMAT_DATE_NEW'),
            'AA' => config('global.FORMAT_DATE_NEW'),
            'AE' => config('global.FORMAT_DATE_NEW'),
            'AH' => config('global.FORMAT_DATE_NEW'),
        ];
    }
}
