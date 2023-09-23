<?php

namespace App\Exports;

use App\Models\Mipo;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class MipoReportExport implements FromCollection, WithHeadings, WithCustomStartCell, WithEvents, WithColumnFormatting 
{
    public $request;

    public function __construct($request)
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
                $sheet = $event->sheet;
                $start_date = Carbon::parse(now())->format('Y-m-d');
                $end_date = Carbon::parse(now())->format('Y-m-d');
                if (isset($this->request->daterange) && !empty($this->request->daterange)) {
                    $string = explode('-', $this->request->daterange);
                    $start_date = Carbon::createFromFormat('d/m/Y', trim($string[0]))->format('d/m/Y');
                    $end_date = Carbon::createFromFormat('d/m/Y', trim($string[1]))->format('d/m/Y');
                }

                $sheet->mergeCells('A1:BD1');
                $sheet->setCellValue('A1', "Mipo Report (" . $start_date . " - " . $end_date . ")");


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

                $headerColumn = 'A2:BD2'; // Columns
                $columns = range('A', 'ZZ');

                for ($i = 'A'; $i < 'ZZ'; $i++) {
                    $event->sheet->getDelegate()->getColumnDimension($i)->setWidth(20);

                    if ($i == 'BD') {
                        break;
                    }
                }
                $event->sheet->getDelegate()->getStyle($headerColumn)->getFill()->applyFromArray($columnColorArray);
                $event->sheet->getDelegate()->getStyle($headerColumn)->getBorders()->applyFromArray($columnBorderArray);
                $event->sheet->getDelegate()->getStyle($headerColumn)->getFont()->applyFromArray($columnFontArray);
                $event->sheet->getDelegate()->getColumnDimension('BD')->setWidth(20);
                $event->sheet->getDelegate()->getStyle('BD1:BD'.$event->sheet->getDelegate()->getHighestRow())->getAlignment()->setWrapText(true);
            },
        ];
    }

    public function headings(): array
    {
        return [
            'SR.NO',
            'Po No.',
            'Mapped Enquiry Number',
            'Revision No.',
            'Po Received Date',
            'Ho Received Date',
            'Po Type',
            'Client',
            'Project',
            'Region',
            'Product',
            'Category',
            'Reference',
            'Mipo User',
            'Mipo Allocation Date',
            'Team Assigning Date',
            'Case Incharge',
            'CI Status Date',
            'CI Approval Status',
            'CI Remark',
            'Estimator',
            'EST Status Date',
            'EST Approval Status',
            'EST Remark',
            'Design Engineer',
            'Designer Document Upload Date',
            'Designer Approval Status',
            'Designer Remark',
            'Commercial',
            'Commercial Status Date',
            'Commercial Approval Status',
            'Commercial Remark',
            'Purchase Team',
            'Purchase Team Status Date',
            'Purchase Team Approval Status',
            'Purchase Team Remark',
            'Mipo Final Verification Status',
            'Mipo Remarks',
            'Head Estimator',
            'Head EST Allocation Date',
            'Head EST Status Date',
            'Head EST Approval status',
            'Head EST Remark',
            'Order Approval Sheet Upload Date',
            'Order Sheet Status Date',
            'Order Sheet Approval Status',
            'Order Sheet Remarks',
            'Management',
            'Management Status Date',
            'Management Approval Status',
            'Management Remarks',
            'Is Frp',
            'Is Gr',
            'Mipo Status',
            'Created On',
            'Mipo History',
        ];
    }

    public function collection()
    {
        $input = $this->request->all();
        $msg_data = array();
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
        $roleId = session('data')['role_id'];

        switch ($roleId) {
            case 8:
                $fieldName = 'mipo_user_id';
                break;
            case 3:
                $fieldName = 'case_incharge_id';
                break;
            case 5:
                $fieldName = 'engineer_id';
                break;
            case 9:
                $fieldName = 'drawing_id';
                break;
            case 10:
                $fieldName = 'commercial_id';
                break;
            case 11:
                $fieldName = 'purchase_id';
                break;
            default:
                $fieldName = '';
                break;
        }
        $report_details = Mipo::with([
            'User', 'enquiry.region', 'region',
            'category', 'product', 'caseIncharge',
            'estimateEngineer', 'commercial',
            'purchaseTeam', 'designEngineer',
            'headEngineer', 'managementUser',
            'mipoCaseHistories.adminUser', 'mipoStatus',
        ])
            ->when($fieldName && in_array($roleId, [1, 7]), function ($query) use ($fieldName) {
                $userId = session('data')['id'];

                return $query->where($fieldName, $userId);
            })
            ->whereBetween('po_recv_date', [$start_date, $end_date])
            ->when(isset($input['region_id']) && ! empty($input['region_id']), function ($query) use ($input) {
                return $query->where('region_id', $input['region_id']);
            })
            ->when(isset($input['product_id']) && ! empty($input['product_id']), function ($query) use ($input) {
                return $query->where('product_id', $input['product_id']);
            })
            ->when(isset($input['mipo_status']) && ! empty($input['mipo_status']), function ($query) use ($input) {
                return $query->whereIn('mipo_status', $input['mipo_status']);
            })
            ->get();

        $po_data = [];

        if ($report_details->count()) {
            $i = 1;
            foreach ($report_details as $mipo) {
                $empty_values = '';
                $mipoHistories = '';
                foreach ($mipo->mipoCaseHistories as $mipoCaseHistory) {
                    $mipoHistories .= $mipoCaseHistory->adminUser->admin_name.' '.
                        $mipoCaseHistory->action.'  '.$mipoCaseHistory->remarks.' on  '.
                        Carbon::parse($mipoCaseHistory->created_at)->format('d-m-Y H:i:s');
                    //add user remark
                    if ($mipoCaseHistory->user_remarks) {
                        $mipoHistories .= ' [ User Remark : '.$mipoCaseHistory->user_remarks.' ]';
                    }
                    if ($mipo->mipoCaseHistories->last() != $mipoCaseHistory) {
                        $mipoHistories .= '  ||||||   ';
                    }
                }

                $po_data[] = [
                    'sr_no'                              => $i,
                    'po_no'                              => $mipo->po_no,
                    'enquiry'                            => $mipo->enquiry->enq_no.' / '.$mipo->enquiry->region->region_code." / ".$mipo->enquiry->revision_no,
                    'revision_no'                        => $mipo->revision_no ?? '',
                    'po_recv_date'                       => $mipo->po_recv_date ? date('d-M-Y',
                        strtotime($mipo->po_recv_date)) : $empty_values,
                    'ho_recv_date'                       => $mipo->ho_recv_date ? date('d-M-Y',
                        strtotime($mipo->ho_recv_date)) : $empty_values,
                    'po_type'                            => strtoupper($mipo->po_type),
                    'client'                             => $mipo->client_name,
                    'project'                            => $mipo->project_name,
                    'Region'                             => $mipo->region->region_code ?? $empty_values,
                    'product'                            => $mipo->product->product_name ?? $empty_values,
                    'category'                           => $mipo->category->category_name ?? $empty_values,
                    'Reference'                          => $mipo->reference ?? $empty_values,
                    'mipo_user'                          => $mipo->user->nick_name ?? $empty_values,
                    'mipo_user_allocation_dt'            => $mipo->mipo_user_allocation_dt ? date('d-M-Y',
                        strtotime($mipo->mipo_user_allocation_dt)) : $empty_values,
                    'allocation_completion_date'         => $mipo->allocation_completion_dt ? date('d-M-Y',
                        strtotime($mipo->allocation_completion_dt)) : $empty_values,
                    'case_incharge'                      => $mipo->caseIncharge->nick_name ?? '',
                    'ci_upload_document_dt'              => $mipo->ci_document_upload_dt ? date('d-M-Y',
                        strtotime($mipo->ci_document_upload_dt)) : $empty_values,
                    'ci_approval_status'                 => $mipo->ci_approval_status,
                    'ci_remark'                          => $mipo->ci_remarks ?? $empty_values,
                    'estimator_engineer'                 => $mipo->estimateEngineer->nick_name ?? $empty_values,
                    'e_engineer_upload_document_date'    => $mipo->engg_document_upload_dt ? date('d-M-Y',
                        strtotime($mipo->engg_document_upload_dt)) : $empty_values,
                    'e_engineer_approval_status'         => $mipo->engg_approval_status,
                    'e_engineer_remark'                  => $mipo->engg_remarks,
                    'design_engineer'                    => $mipo->designEngineer->nick_name ?? '',
                    'd_engineer_upload_document_date'    => $mipo->drawing_document_upload_dt ? date('d-M-Y',
                        strtotime($mipo->drawing_document_upload_dt)) : $empty_values,
                    'd_engineer_approval_status'         => $mipo->drawing_approval_status,
                    'd_Engineer_Remark'                  => $mipo->drawing_remarks ?? '',
                    'commercial'                         => $mipo->commercial->nick_name ?? '',
                    'commercial_upload_document_date'    => $mipo->commercial_document_upload_dt ? date('d-M-Y',
                        strtotime($mipo->commercial_document_upload_dt)) : $empty_values,
                    'commercial_Approval_Status'         => $mipo->commercial_approval_status,
                    'commercial_Remark'                  => $mipo->commercial_remarks,
                    'purchase_Team'                      => $mipo->purchaseTeam->nick_name ?? $empty_values,
                    'purchase_team_upload_document_date' => $mipo->purchase_document_upload_dt ? date('d-M-Y',
                        strtotime($mipo->purchase_document_upload_dt)) : $empty_values,
                    'purchase_Team_Approval_Status'      => $mipo->purchase_approval_status ?? $empty_values,
                    'purchase_Team_Remark'               => $mipo->purchase_remarks ?? $empty_values,
                    'mipo_verification_status'           => $mipo->mipo_verification_status ?? $empty_values,
                    'mipo_remarks'                       => $mipo->mipo_remarks ?? $empty_values,
                    'head_engineer'                      => $mipo->headEngineer->nick_name ?? $empty_values,
                    'head_eng_allocation_dt'             => $mipo->head_engg_allocation_dt ? date('d-M-Y',
                        strtotime($mipo->head_engg_allocation_dt)) : $empty_values,
                    'head_Eng_status'                    => $mipo->head_engg_status_dt ? date('d-M-Y',
                        strtotime($mipo->head_engg_status_dt)) : $empty_values,
                    'head_engg_approval_status'          => $mipo->head_engg_approval_status ?? $empty_values,
                    'head_engg_remarks'                  => $mipo->head_engg_remarks ?? $empty_values,
                    'Order Approval Sheet Upload Date'   => $mipo->order_approval_sheet_upload_dt ? date('d-M-Y',
                        strtotime($mipo->order_approval_sheet_upload_dt)) : $empty_values,
                    'Order Sheet Status Date'            => $mipo->order_sheet_status_dt ? date('d-M-Y',
                        strtotime($mipo->order_sheet_status_dt)) : $empty_values,
                    'Order Sheet Approval Status'        => $mipo->order_sheet_approval_status ?? '',
                    'Order Sheet Remarks'                => $mipo->order_sheet_remarks ?? '',
                    'Management'                         => $mipo->managementUser->nick_name ?? '',
                    'Management Status Date'             => $mipo->management_status_dt ? date('d-M-Y',
                        strtotime($mipo->management_status_dt)) : $empty_values,
                    'Management Approval Status'         => $mipo->management_approval_status ?? '',
                    'Management Remarks'                 => $mipo->management_remarks ?? '',
                    'Is Frp'                             => $mipo->is_frp ? 'Yes' : 'No',
                    'Is Gr'                              => $mipo->is_gr ? 'Yes' : 'No',
                    'mipo_status'                        => $mipo->mipoStatus->mipo_status ?? '',
                    'created_on'                         => $mipo->created_at ? date('d-M-Y',
                        strtotime($mipo->created_at)) : $empty_values,
                    'mipo_history'                       => $mipoHistories,
                ];
                $i++;
            }
        }
        
        return collect($po_data);
    }

    public function columnFormats(): array
    {
        return [
        ];
    }
    
}
