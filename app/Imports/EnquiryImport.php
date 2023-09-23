<?php

namespace App\Imports;

use App\Models\Admin;
use App\Models\AllocationStatus;
use App\Models\Category;
use App\Models\EngineerStatus;
use App\Models\Enquiry;
use App\Models\Industry;
use App\Models\Product;
use App\Models\Region;
use App\Models\TypistStatus;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use \PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithUpsertColumns;
use Maatwebsite\Excel\Concerns\WithUpserts;

class EnquiryImport implements ToCollection, WithHeadingRow, WithValidation, SkipsEmptyRows, WithMultipleSheets
{




    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection  $rows)
    {


        foreach ($rows as $row) {
            $engg_transfer_date = NULL;
            $typist_transfer_date = NULL;
            $estimated_date = NULL;
            $typist_completed_date = NULL;

            $enq_recv_date = Date::excelToDateTimeObject($row['actual_enquiry_received_date'])->format('Y-m-d');
            $enq_register_date = Date::excelToDateTimeObject($row['enquiry_date'])->format('Y-m-d');
            $enq_due_date = Date::excelToDateTimeObject($row['enquiry_due_date'])->format('Y-m-d');
            $enq_reminder_date = Date::excelToDateTimeObject($row['estimator_due_date'])->format('Y-m-d');
            $category_mapped_date = Date::excelToDateTimeObject($row['category_date'])->format('Y-m-d');
            $allocation_date = Date::excelToDateTimeObject($row['allocation_date'])->format('Y-m-d');

            if (!empty($row['engineer_transfer_date'])) {
                $engg_transfer_date = Date::excelToDateTimeObject($row['engineer_transfer_date'])->format('Y-m-d');
            }

            if (!empty($row['typist_transfer_date'])) {
                $typist_transfer_date = Date::excelToDateTimeObject($row['typist_transfer_date'])->format('Y-m-d');
            }

            if (!empty($row['estimated_date'])) {
                $estimated_date = Date::excelToDateTimeObject($row['estimated_date'])->format('Y-m-d');
            }

            if (!empty($row['typist_date'])) {
                $typist_completed_date = Date::excelToDateTimeObject($row['typist_date'])->format('Y-m-d');
            }

            $product_id = 0;
            $region_id = 0;
            $case_incharge_id = 0;
            $sales_id = 0;
            $category_id = 0;
            $industry_id = 0;
            $allocation_status = NULL;
            $engineer_id = 0;
            $old_engineer_id = 0;
            $typist_id = 0;
            $old_typist_id = 0;
            $allocator_id = 0;
            $engineer_status = NULL;
            $typist_status = NULL;


            if (in_array($this->getTrimValue($row['product']), $this->products)) {
                $product_id = array_search($this->getTrimValue($row['product']), $this->products);
            }

            if (in_array($this->getTrimValue($row['region']), $this->regions)) {
                $region_id = array_search($this->getTrimValue($row['region']), $this->regions);
            }

            if (in_array($this->getTrimValue($row['case_incharge']), $this->caseIncharge)) {
                $case_incharge_id = array_search($this->getTrimValue($row['case_incharge']), $this->caseIncharge);
            }

            if (in_array($this->getTrimValue($row['sales']), $this->sales)) {
                $sales_id = array_search($this->getTrimValue($row['sales']), $this->sales);
            }

            if (in_array($this->getTrimValue($row['category']), $this->categories)) {
                $category_id = array_search($this->getTrimValue($row['category']), $this->categories);
            }

            if (in_array($this->getTrimValue($row['industry']), $this->industries)) {
                $industry_id = array_search($this->getTrimValue($row['industry']), $this->industries);
            }

            if (in_array($this->getTrimValue($row['allocation_status']), $this->allocationStatus)) {
                $allocation_status = array_search($this->getTrimValue($row['allocation_status']), $this->allocationStatus);
            }

            if (in_array($this->getTrimValue($row['engineer']), $this->engineers)) {
                $engineer_id = array_search($this->getTrimValue($row['engineer']), $this->engineers);
            }

            if (in_array($this->getTrimValue($row['transfer_from_engg']), $this->engineers)) {
                $old_engineer_id = array_search($this->getTrimValue($row['transfer_from_engg']), $this->engineers);
            }

            if (in_array($this->getTrimValue($row['typist']), $this->typist)) {
                $typist_id = array_search($this->getTrimValue($row['typist']), $this->typist);
            }

            if (in_array($this->getTrimValue($row['transfer_from_typist']), $this->typist)) {
                $old_typist_id = array_search($this->getTrimValue($row['transfer_from_typist']), $this->typist);
            }

            if (in_array($this->getTrimValue($row['allocator']), $this->allocator)) {
                $allocator_id = array_search($this->getTrimValue($row['allocator']), $this->allocator);
            }

            if (in_array($this->getTrimValue($row['engineer_status']), $this->engineerStatus)) {
                $engineer_status = array_search($this->getTrimValue($row['engineer_status']), $this->engineerStatus);
            }

            if (in_array($this->getTrimValue($row['typist_status']), $this->typistStatus)) {
                $typist_status = array_search($this->getTrimValue($row['typist_status']), $this->typistStatus);
            }

            $sheetValues = [
                'enq_no'     => $row['enquiry_no'],
                'revision_no'     => $row['revision_no'] ?? 0,
                "enq_recv_date" =>  $enq_recv_date,
                "enq_register_date" =>  $enq_register_date,
                "enq_due_date" =>  $enq_due_date,
                "enq_reminder_date" =>  $enq_reminder_date,
                "client_name" =>  $row['client'],
                "project_name" =>  $row['project'],
                "product_id" =>  $product_id,
                "region_id" =>  $region_id,
                "case_incharge_id" =>  $case_incharge_id,
                "sales_remark" =>  $row['sales_remark'],
                "sales_id" =>  $sales_id,
                "category_id" =>  $category_id,
                "industry_id" =>  $industry_id,
                "category_mapped_date" =>  $category_mapped_date,
                "actual_client" =>  $row['end_user'],
                "case_incharge_remark" =>  $row['ci_remark'],
                "allocation_status" => $allocation_status,
                "allocation_date" => $allocation_date,
                "engineer_id" => $engineer_id,
                "old_engineer_id" => $old_engineer_id,
                "engg_transfer_date" => $engg_transfer_date,
                "typist_id" => $typist_id,
                "old_typist_id" => $old_typist_id,
                "typist_transfer_date" => $typist_transfer_date,
                "allocation_remark" =>  $row['allocation_remark'],
                "allocator_id" => $allocator_id,
                "engineer_status" => $engineer_status,
                "engineer_remark" =>  $row['engineer_remark'],
                "estimated_date" =>  $estimated_date,
                "typist_status" =>  $typist_status,
                "amount" =>  $row['amount'] ?? 0.00,
                "typist_remark" =>  $row['typist_remark'],
                "typist_completed_date" =>  $typist_completed_date,
            ];

            $financial_year = get_finacial_year_range();
            $start_date = Carbon::createFromFormat('d/m/Y', trim($financial_year['start_date']))->format('Y-m-d');
            $end_date = Carbon::createFromFormat('d/m/Y', trim($financial_year['end_date']))->format('Y-m-d');
            $enquiryExist = Enquiry::where([
                ['enq_no', $row['enquiry_no']],
                ['revision_no', $row['revision_no']],
                ['region_id', $region_id],
                ['enq_register_date', '>=', $start_date],
                ['enq_register_date', '<=', $end_date]
            ])->take(1)->get()->toArray();

            if (count($enquiryExist) == 0) {
                Enquiry::Create($sheetValues);
            } else {
                Enquiry::where("id", $enquiryExist[0]['id'])->update($sheetValues);
            }
        }
    }

    public $products;
    public $regions;
    public $caseIncharge;
    public $sales;
    public $categories;
    public $industries;
    public $allocationStatus;
    public $engineers;
    public $typist;
    public $allocator;
    public $engineerStatus;
    public $limitEngineerStatus;
    public $typistStatus;
    function __construct()
    {
        $this->products = Product::where([['status', 1]])->pluck('product_name', 'id')->toArray();
        $this->regions = Region::where([['status', 1]])->pluck('region_name', 'id')->toArray();
        $this->caseIncharge = Admin::where([['role_id', 3], ['status', 1]])->pluck('nick_name', 'id')->toArray();
        $this->sales = Admin::where([['role_id', 2], ['status', 1]])->pluck('nick_name', 'id')->toArray();
        $this->categories = Category::where([['status', 1]])->pluck('category_name', 'id')->toArray();
        $this->industries = Industry::where([['status', 1]])->pluck('industry_name', 'id')->toArray();
        $this->industries = array_map('strtoupper', $this->industries);
        $this->allocationStatus = AllocationStatus::where([['status', 1]])->pluck('allocation_status_name', 'id')->toArray();
        $this->engineers = Admin::where([['role_id', 5], ['status', 1]])->pluck('nick_name', 'id')->toArray();
        $this->typist = Admin::where([['role_id', 6], ['status', 1]])->pluck('nick_name', 'id')->toArray();
        $this->allocator = Admin::where([['role_id', 4], ['status', 1]])->pluck('nick_name', 'id')->toArray();
        $this->engineerStatus = EngineerStatus::where([['status', 1]])->pluck('engineer_status_name', 'id')->toArray();
        $this->limitEngineerStatus = EngineerStatus::where([['status', 1]])->whereIn('id', [1, 2])->pluck('engineer_status_name', 'id')->toArray();
        $this->typistStatus = TypistStatus::where([['status', 1]])->pluck('typist_status_name', 'id')->toArray();
        // print_r($this->industries);
        // die;
    }

    // public function model(array $row)
    // {


    //     $engg_transfer_date = NULL;
    //     $typist_transfer_date = NULL;
    //     $estimated_date = NULL;
    //     $typist_completed_date = NULL;

    //     $enq_recv_date = Date::excelToDateTimeObject($row['actual_enquiry_received_date'])->format('Y-m-d');
    //     $enq_register_date = Date::excelToDateTimeObject($row['enquiry_date'])->format('Y-m-d');
    //     $enq_due_date = Date::excelToDateTimeObject($row['enquiry_due_date'])->format('Y-m-d');
    //     $enq_reminder_date = Date::excelToDateTimeObject($row['estimator_due_date'])->format('Y-m-d');
    //     $category_mapped_date = Date::excelToDateTimeObject($row['category_date'])->format('Y-m-d');
    //     $allocation_date = Date::excelToDateTimeObject($row['allocation_date'])->format('Y-m-d');

    //     if (!empty($row['engineer_transfer_date'])) {
    //         $engg_transfer_date = Date::excelToDateTimeObject($row['engineer_transfer_date'])->format('Y-m-d');
    //     }

    //     if (!empty($row['typist_transfer_date'])) {
    //         $typist_transfer_date = Date::excelToDateTimeObject($row['typist_transfer_date'])->format('Y-m-d');
    //     }

    //     if (!empty($row['estimated_date'])) {
    //         $estimated_date = Date::excelToDateTimeObject($row['estimated_date'])->format('Y-m-d');
    //     }

    //     if (!empty($row['typist_date'])) {
    //         $typist_completed_date = Date::excelToDateTimeObject($row['typist_date'])->format('Y-m-d');
    //     }

    //     $product_id = 0;
    //     $region_id = 0;
    //     $case_incharge_id = 0;
    //     $sales_id = 0;
    //     $category_id = 0;
    //     $industry_id = 0;
    //     $allocation_status = NULL;
    //     $engineer_id = 0;
    //     $old_engineer_id = 0;
    //     $typist_id = 0;
    //     $old_typist_id = 0;
    //     $allocator_id = 0;
    //     $engineer_status = NULL;
    //     $typist_status = NULL;


    //     if (in_array($this->getTrimValue($row['product']), $this->products)) {
    //         $product_id = array_search($this->getTrimValue($row['product']), $this->products);
    //     }

    //     if (in_array($this->getTrimValue($row['region']), $this->regions)) {
    //         $region_id = array_search($this->getTrimValue($row['region']), $this->regions);
    //     }

    //     if (in_array($this->getTrimValue($row['case_incharge']), $this->caseIncharge)) {
    //         $case_incharge_id = array_search($this->getTrimValue($row['case_incharge']), $this->caseIncharge);
    //     }

    //     if (in_array($this->getTrimValue($row['sales']), $this->sales)) {
    //         $sales_id = array_search($this->getTrimValue($row['sales']), $this->sales);
    //     }

    //     if (in_array($this->getTrimValue($row['category']), $this->categories)) {
    //         $category_id = array_search($this->getTrimValue($row['category']), $this->categories);
    //     }

    //     if (in_array($this->getTrimValue($row['industry']), $this->industries)) {
    //         $industry_id = array_search($this->getTrimValue($row['industry']), $this->industries);
    //     }

    //     if (in_array($this->getTrimValue($row['allocation_status']), $this->allocationStatus)) {
    //         $allocation_status = array_search($this->getTrimValue($row['allocation_status']), $this->allocationStatus);
    //     }

    //     if (in_array($this->getTrimValue($row['engineer']), $this->engineers)) {
    //         $engineer_id = array_search($this->getTrimValue($row['engineer']), $this->engineers);
    //     }

    //     if (in_array($this->getTrimValue($row['transfer_from_engg']), $this->engineers)) {
    //         $old_engineer_id = array_search($this->getTrimValue($row['transfer_from_engg']), $this->engineers);
    //     }

    //     if (in_array($this->getTrimValue($row['typist']), $this->typist)) {
    //         $typist_id = array_search($this->getTrimValue($row['typist']), $this->typist);
    //     }

    //     if (in_array($this->getTrimValue($row['transfer_from_typist']), $this->typist)) {
    //         $old_typist_id = array_search($this->getTrimValue($row['transfer_from_typist']), $this->typist);
    //     }

    //     if (in_array($this->getTrimValue($row['allocator']), $this->allocator)) {
    //         $allocator_id = array_search($this->getTrimValue($row['allocator']), $this->allocator);
    //     }

    //     if (in_array($this->getTrimValue($row['engineer_status']), $this->engineerStatus)) {
    //         $engineer_status = array_search($this->getTrimValue($row['engineer_status']), $this->engineerStatus);
    //     }

    //     if (in_array($this->getTrimValue($row['typist_status']), $this->typistStatus)) {
    //         $typist_status = array_search($this->getTrimValue($row['typist_status']), $this->typistStatus);
    //     }



    //     return new Enquiry([
    //         'enq_no'     => $row['enquiry_no'],
    //         'revision_no'     => $row['revision_no'],
    //         "enq_recv_date" =>  $enq_recv_date,
    //         "enq_register_date" =>  $enq_register_date,
    //         "enq_due_date" =>  $enq_due_date,
    //         "enq_reminder_date" =>  $enq_reminder_date,
    //         "client_name" =>  $row['client'],
    //         "project_name" =>  $row['project'],
    //         "product_id" =>  $product_id,
    //         "region_id" =>  $region_id,
    //         "case_incharge_id" =>  $case_incharge_id,
    //         "sales_remark" =>  $row['sales_remark'],
    //         "sales_id" =>  $sales_id,
    //         "category_id" =>  $category_id,
    //         "industry_id" =>  $industry_id,
    //         "category_mapped_date" =>  $category_mapped_date,
    //         "actual_client" =>  $row['end_user'],
    //         "case_incharge_remark" =>  $row['ci_remark'],
    //         "allocation_status" => $allocation_status,
    //         "allocation_date" => $allocation_date,
    //         "engineer_id" => $engineer_id,
    //         "old_engineer_id" => $old_engineer_id,
    //         "engg_transfer_date" => $engg_transfer_date,
    //         "typist_id" => $typist_id,
    //         "old_typist_id" => $old_typist_id,
    //         "typist_transfer_date" => $typist_transfer_date,
    //         "allocation_remark" =>  $row['allocation_remark'],
    //         "allocator_id" => $allocator_id,
    //         "engineer_status" => $engineer_status,
    //         "engineer_remark" =>  $row['engineer_remark'],
    //         "estimated_date" =>  $estimated_date,
    //         "typist_status" =>  $typist_status,
    //         "amount" =>  $row['amount'] ?? 0.00,
    //         "typist_remark" =>  $row['typist_remark'],
    //         "typist_completed_date" =>  $typist_completed_date,
    //     ]);
    // }


    /**
     * Tweak the data slightly before sending it to the validator
     * @param $data
     * @param $index
     * @return mixed
     */
    // public function prepareForValidation($data, $index)
    // {
    //     //Fix that Excel's numeric date (counting in days since 1900-01-01)
    //     $data['enq_recv_date'] = Date::excelToDateTimeObject($data['enq_recv_date'])->format('Y-m-d');
    //     //...
    // }

    /**
     * List the validation rules
     * @return array
     */
    public function rules(): array
    {

        // $products = Product::pluck('id')->toArray();
        // $regions = Region::pluck('id')->toArray();
        // $caseIncharge = Admin::where([['role_id', 3]])->pluck('id')->toArray();

        return [
            'enquiry_no' => 'required',
            'revision_no' => 'nullable|integer',
            'actual_enquiry_received_date' => 'required|integer',
            'enquiry_date' => 'required|integer',
            'enquiry_due_date' => 'required|integer',
            'estimator_due_date' => 'required|integer',
            'client' => 'required',
            'project' => 'required',
            'product' => ['required', function ($attribute, $value, $onFailure) {
                if (!in_array($this->getTrimValue($value), $this->products)) {
                    $onFailure('Product does not exist');
                }
            },],
            'region' => ['required', function ($attribute, $value, $onFailure) {
                if (!in_array($this->getTrimValue($value), $this->regions)) {
                    $onFailure('Region does not exist');
                }
            },],
            'case_incharge' => ['required', function ($attribute, $value, $onFailure) {
                if (!in_array($this->getTrimValue($value), $this->caseIncharge)) {
                    $onFailure('Case Incharge does not exist');
                }
            },],
            'category' => ['nullable', function ($attribute, $value, $onFailure) {
                if (!in_array($this->getTrimValue($value), $this->categories)) {
                    $onFailure('Category does not exist');
                }
            },],
            'industry' => ['nullable', function ($attribute, $value, $onFailure) {
                if (!in_array($this->getTrimValue($value), $this->industries)) {
                    $onFailure('Industry does not exist');
                }
            },],
            'category_date' => 'nullable|integer',
            'typist_transfer_date' => 'nullable|integer',
            'allocation_status' => ['nullable', function ($attribute, $value, $onFailure) {
                if (!in_array($this->getTrimValue($value), $this->allocationStatus)) {
                    $onFailure('Allocation Status does not exist');
                }
            },],
            'allocation_date' => 'nullable|integer',
            'engineer' => ['nullable', function ($attribute, $value, $onFailure) {
                if (!in_array($this->getTrimValue($value), $this->engineers)) {
                    $onFailure('Engineer does not exist');
                }
            },],
            'transfer_from_engg' => ['nullable', function ($attribute, $value, $onFailure) {
                if (!in_array($this->getTrimValue($value), $this->engineers)) {
                    $onFailure('In Transfer From Engineer does not exist');
                }
            },],
            'engineer_transfer_date' => 'nullable|integer',
            'typist' => ['nullable', function ($attribute, $value, $onFailure) {
                if (!in_array($this->getTrimValue($value), $this->typist)) {
                    $onFailure('Typist does not exist');
                }
            },],
            'transfer_from_typist' => ['nullable', function ($attribute, $value, $onFailure) {
                if (!in_array($this->getTrimValue($value), $this->typist)) {
                    $onFailure('In Transfer from Typist does not exist');
                }
            },],
            'typist_transfer_date' => 'nullable|integer',
            'engineer_status' => ['nullable', function ($attribute, $value, $onFailure) {
                if (!in_array($this->getTrimValue($value), $this->engineerStatus)) {
                    $onFailure('Engineer Status does not exist');
                }
            },],
            'typist_status' => ['nullable', function ($attribute, $value, $onFailure) {
                if (!in_array($this->getTrimValue($value), $this->typistStatus)) {
                    $onFailure('Typist Status does not exist');
                }
            },],
            'estimated_date' => 'nullable|integer',
            'typist_date' => 'nullable|integer',
            'amount' => 'nullable|numeric|gte:0',


        ];
    }

    public function customValidationMessages()
    {
        return [
            'enquiry_no.required' => 'Enquiry No is empty, kindly check the row',
            'revision_no.integer' => 'Revision No must be an integer',
            'actual_enquiry_received_date.required' => 'Enquiry Receive date is Required',
            'actual_enquiry_received_date.integer' => 'Enquiry Receive date format is wrong, format should (MM/DD/YYYY)',
            'enquiry_date.required' => 'Enquiry Register date is Required',
            'enquiry_date.integer' => 'Enquiry Register date format is wrong, format should (MM/DD/YYYY)',
            'enquiry_due_date.required' => 'Enquiry Reminder date is Required',
            'enquiry_due_date.integer' => 'Enquiry Reminder date format is wrong, format should (MM/DD/YYYY)',
            'client.required' => 'Client name is Required',
            'project.required' => 'Project name is Required',
            'product.required' => 'Product is Required',
            'region.required' => 'Region is Required',
            'case_incharge.required' => 'Case incharge is Required',
            'category.required' => 'Category is Required',
            'category_date.required' => 'Category date is Required',
            'category_date.integer' => 'Category date format is wrong, format should (MM/DD/YYYY)',
            'allocation_date.required_if' => 'Allocation date is Required',
            'allocation_date.integer' => 'Allocation date format is wrong, format should (MM/DD/YYYY)',
            'engineer.required_if' => 'Engineer is Required',
            'engineer_transfer_date.integer' => 'Engineer transfer date format is wrong, format should (MM/DD/YYYY)',
            'typist.required_if' => 'Typist is Required',
            'typist_transfer_date.integer' => 'Typist transfer date format is wrong, format should (MM/DD/YYYY)',
            'engineer_status.required_if' => 'Engineer status is Required',
            'typist_status.required_if' => 'Typist status is Required',
            'estimated_date.integer' => 'Estimated date date format is wrong, format should (MM/DD/YYYY)',
            'typist_date.integer' => 'Typist date format is wrong, format should (MM/DD/YYYY)',

        ];
    }

    public function withValidator($validator)
    {

        $validator->after(function ($validator) {
            foreach ($validator->getData() as $key => $data) {
                $todays_date =  Carbon::parse(now())->format('Y-m-d');
                $todays_date_minus_one =  Carbon::parse(now())->subDays(1)->format('Y-m-d');
                $enquiry_date = Date::excelToDateTimeObject($data['enquiry_date'])->format('Y-m-d');
                $enquiry_due_date = Date::excelToDateTimeObject($data['enquiry_due_date'])->format('Y-m-d');
                $estimator_due_date = Date::excelToDateTimeObject($data['estimator_due_date'])->format('Y-m-d');

                if (in_array($this->getTrimValue($data['engineer_status']), $this->limitEngineerStatus) && empty($data['typist_status'])) {
                    $validator->errors()->add($key, 'Typist Status is required when Engineer Status is EST OR REV-EST');
                }

                if (($enquiry_date < $todays_date_minus_one) && empty($data['category'])) {
                    // $validator->errors()->add($key, 'Category is required when Enquiry date is less then todays date');
                }

                if (($enquiry_due_date > $todays_date)) {

                    // if (empty($data['category'])) {
                    //     $validator->errors()->add($key, 'Category is required when Enquiry Due date is less then or equal to todays date');
                    // }

                    // if (empty($data['category_date'])) {
                    //     $validator->errors()->add($key, 'Category date is required when Enquiry Due date is less then or equal to todays date');
                    // }

                    // if (empty($data['engineer'])) {
                    //     $validator->errors()->add($key, 'Engineer is required when Enquiry due date is less then or equal to todays date');
                    // }

                    // if (empty($data['typist'])) {
                    //     $validator->errors()->add($key, 'Typist is required when Enquiry due date is less then or equal to todays date');
                    // }

                    // if (empty($data['allocation_status'])) {
                    //     $validator->errors()->add($key, 'Allocation status is required when Enquiry due date is less then or equal to todays date');
                    // }

                    // if (empty($data['allocation_date'])) {
                    //     $validator->errors()->add($key, 'Allocation Date is required when Enquiry due date is less then or equal to todays date');
                    // }
                }

                if (($estimator_due_date > $todays_date)) {

                    // if (empty($data['category'])) {
                    //     $validator->errors()->add($key, 'Category is required when Estimator Due date is less then or equal to todays date');
                    // }

                    // if (empty($data['category_date'])) {
                    //     $validator->errors()->add($key, 'Category date is required when Estimator Due date is less then or equal to todays date');
                    // }
                }
            }
        });
    }

    public function isEmptyWhen(array $row): bool
    {
        return $row['enquiry_no'] === 'John Doe';
    }

    private function getMasterId($models, $value)
    {
        $formatedValue = strtoupper(trim($value));
        switch ($models) {
            case 'Product':
                $model = new Product();
                $whereCondition = [['product_name', $formatedValue]];
                break;
            case 'Region':
                $model = new Region();
                $whereCondition = [['region_name', $formatedValue]];
                break;
            case 'Admin':
                $model = new Admin();
                $whereCondition = [['role_id', 3], ['nick_name', $formatedValue]];
                break;
            case 'Category':
                $model = new Category();
                $whereCondition = [['category_name', $formatedValue]];
                break;

            default:
                # code...
                break;
        }
        $masterID = $model->where($whereCondition)->pluck('id')->first();
        return $masterID;
    }

    public function sheets(): array
    {
        return [
            $this
        ];
    }
    private function getTrimValue($value)
    {
        $formatedValue = strtoupper(trim($value));
        return $formatedValue;
    }
}
