<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     *   created by : Maaz Ansari
     *   Created On : 18-aug-2022
     *   Uses :  To show sub product listing page
     */

    public function index()
    {
        $data['product_add'] = checkPermission('product_add');
        $data['product_edit'] = checkPermission('product_edit');
        $data['product_view'] = checkPermission('product_view');
        $data['product_status'] = checkPermission('product_status');
        return view('backend/product/index', ["data" => $data]);
    }

    /**
     *   created by : Maaz Ansari
     *   Created On : 18-aug-2022
     *   Uses :  display dynamic data in datatable for product page
     *   @param Request request
     *   @return Response
     */
    public function fetch(Request $request)
    {
        if ($request->ajax()) {
            try {
                $query = Product::orderBy('updated_at', 'desc');
                return DataTables::of($query)
                    ->filter(function ($query) use ($request) {
                        if (isset($request['search']['search_name']) && !is_null($request['search']['search_name'])) {
                            $query->where('product_name', 'like', "%" . $request['search']['search_name'] . "%");
                        }
                        $query->get();
                    })
                    ->editColumn('product_name', function ($event) {
                        return $event->product_name;
                    })->editColumn('email_id', function ($event) {
                        return $event->email_id;
                    })
                    ->editColumn('action', function ($event) {
                        $product_view = checkPermission('product_view');
                        $product_edit = checkPermission('product_edit');
                        $actions = '<span style="white-space:nowrap;">';

                        if ($product_view) {
                            $actions .= '<a href="product_view/' . $event->id . '" class="btn btn-primary btn-sm modal_src_data" data-size="large" title="View"><i class="fa fa-eye"></i></a>';
                        }
                        if ($product_edit) {
                            $actions .= ' <a href="product_edit/' . $event->id . '" class="btn btn-success btn-sm src_data" title="Update"><i class="fa fa-edit"></i></a>';
                        }
                        $actions .= '</span>';
                        return $actions;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['product_name', 'email_id','action'])->setRowId('id')->make(true);
            } catch (\Exception $e) {
                \Log::error("Something Went Wrong. Error: " . $e->getMessage());
                return response([
                    'draw'            => 0,
                    'recordsTotal'    => 0,
                    'recordsFiltered' => 0,
                    'data'            => [],
                    'error'           => 'Something went wrong',
                ]);
            }
        }
    }

    /**
     *    created by : Arjun
     *    Created On : 25 Apr 2023
     *   Uses :   To edit  product 
     *   @param $id
     *   @return Response
     */
    public function editProduct($id)
    {
        $data['data'] = Product::find($id);
        return view('backend/product/product_edit', $data);
    }
    /**
     *    created by : Arjun
     *    Created On : 25 Apr 2023
     *   Uses :   To save product data
     *   @param Request request
     *   @return Response
     */
    public function saveProduct(Request $request)
    {
        $msg_data = array();
        $msg = "";

        $validationErrors = $this->validateProductRequest($request);

        if (count($validationErrors)) {
            errorMessage(implode("\n", $validationErrors->all()), $msg_data);
        }
        $emails = explode(',', $request->email_list);
        $email_arr = array_unique(array_filter($emails));
        $email_list = implode(',', $email_arr);

        if ($_GET['id']) {
            $product = Product::find($_GET['id']);
        } else {
            $product = new Product;
        }
        $product ->email_id = $email_list;
        $product->save();
        successMessage("Data Saved Successfully", $msg_data);
    }

    /**
     *   Created by : Arjun
     *   Created On : 25 Apr 2023
     *   Uses :  to load product view
     *   @param int $id
     *   @return Response
     */
    public function view($id)
    {
        $data['data'] = Product::find($id);
        return view('backend/product/product_view', $data);
    }

    /**
     *   Created by : Maaz Ansari
     *   Created On : 18-aug-2022
     *   Uses :  To publish or unpublish product records
     *   @param Request request
     *   @return Response
     */
    public function updateStatus(Request $request)
    {
        $msg_data = array();
        $recordData = Product::find($request->id);
        $recordData->status = $request->status;
        $recordData->save();
        if ($request->status == 1) {
            successMessage('Published', $msg_data);
        } else {
            successMessage('Unpublished', $msg_data);
        }
    }

    /**
     *   Created by : Maaz Ansari
     *   Created On : 18-aug-2022
     *   Uses :  product Edit Form Validation part will be handle by below function
     *   @param Request request
     *   @return Response
     */
    private function validateRequest(Request $request)
    {
        return \Validator::make($request->all(), [
            'product_name' => 'required|string',
            'sku_code' => 'required|string',
            'current_stock' => 'required|integer',
            'product_name' => 'required|string',
            'brand' => 'required',
            'sale_price' => 'required|integer',
            'purchase_price' => 'required|integer',
            'shipping_cost' => 'required|integer',
            'product_sub_category' => 'required|integer',
            'product_category' => 'required|integer',
            'map_variations' => 'required_if:has_variations,on',

            'options' => 'required',
            //'product_image' =>'required',
            //'product_form' => 'required|integer',
            //'packaging_treatment' => 'required|integer',

        ], [
            'map_variations.required_if' => 'The products to bundle field is required',

        ])->errors();
    }

    /**
     *   Created by : Maaz Ansari
     *   Created On : 18-aug-2022
     *   Uses :  product Add Form Validation part will be handle by below function
     *   @param Request request
     *   @return Response
     */
    private function validateNewRequest(Request $request)
    {
        return \Validator::make($request->all(), [
            'product_name' => 'required|string',
            'sku_code' => 'required|string',
            'current_stock' => 'required|integer',
            'product_name' => 'required|string',
            'brand' => 'required',
            'sale_price' => 'required|integer',
            'purchase_price' => 'required|integer',
            'shipping_cost' => 'required|integer',
            'product_image' => 'required',
            'options' => 'required',
            'map_variations' => 'required_if:has_variations,on',
            // 'product_description' => 'required|string',
            'product_sub_category' => 'required|integer',
            'product_category' => 'required|integer',

        ], ['map_variations.required_if' => 'The products to bundle field is required',])->errors();
    }


    /**
     *   Created by :Swayama
     *   Created On : 22-aug-2022
     *   Uses :  Edit stock Form Validation part will be handle by below function
     *   @param Request request
     *   @return Response
     */
    private function validateProductRequest(Request $request)
    {
        return \Validator::make($request->all(), [
            'email_list' => [
                'required',
                function ($attribute, $value, $fail) {
                    $emails = array_unique(array_filter(explode(',', $value)));

                    foreach ($emails as $email) {
                        if (!filter_var(trim($email), FILTER_VALIDATE_EMAIL)) {
                            $fail("The email '$email' is invalid.");
                        }
                    }
                },
            ],
        ])->errors();
    }
    /**
     *   Created by :Swayama
     *   Created On : 22-aug-2022
     *   Uses :  Delete Images of product in edit page
     *   @param Request request
     *   @return Response
     */
    public function deleteImage(Request $request)
    {
        $msg_data = array();
        deleteImage($_GET['id'], $request->ib, $_GET['extension']);
        $productObj = Product::find($_GET['id']);
        $actual_img_count = $productObj->num_of_imgs;
        $productObj->num_of_imgs =  $actual_img_count - 1;
        $productObj->save();
        successMessage('image deleted successfully', $msg_data);
    }
}
