<?php

use App\Models\Abp;
use App\Models\Admin;
use App\Models\EmailNotification;
use App\Models\Enquiry;
use App\Models\Mipo;
use App\Models\MipoCaseHistory;
use App\Models\MipoStatus;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Tymon\JWTAuth\Facades\JWTAuth;

if (!function_exists('errorMessage')) {
    function errorMessage($msg = '', $data = array(), $expireSessionCode = "")
    {
        $return_array = array();
        $return_array['success'] = '0';
        if ($expireSessionCode != "") {
            $return_array['success'] = $expireSessionCode;
        }
        $return_array['message'] = $msg;
        if (isset($data) && count($data) > 0)
            $return_array['data'] = $data;
        if (isset($other_data) && !empty($other_data)) {
            foreach ($other_data as $key => $val)
                $return_array[$key] = $val;
        }
        echo json_encode($return_array);
        exit();
    }
}

if (!function_exists('successMessage')) {
    function successMessage($msg = '', $data = array())
    {
        $return_array = array();
        $return_array['success'] = '1';
        $return_array['message'] = $msg;
        if (isset($data) && count($data) > 0)
            $return_array['data'] = $data;
        if (isset($other_data) && !empty($other_data)) {
            foreach ($other_data as $key => $val)
                $return_array[$key] = $val;
        }
        echo json_encode($return_array);
        exit();
    }
}

if (!function_exists('generateRandomOTP')) {
    function generateRandomOTP()
    {
        // return (rand(1000,9999));
        return (1234);
    }
}

if (!function_exists('readHeaderToken')) {
    function readHeaderToken()
    {
        $msg_data = array();
        $tokenData = Session::get('tokenData');
        $userDeviceData = Session::get('userDeviceData');
        $token = JWTAuth::setToken($tokenData)->getPayload();
        $userChk = UserDevice::where([['user_id', $token['sub']], ['device_id', $userDeviceData]])->get();
        if (count($userChk) == 0 || $userChk[0]->remember_token == '') {
            errorMessage(__('auth.please_login_and_try_again'), $msg_data, 4);
        }
        return $token;
    }
}

if (!function_exists('checkPermission')) {
    function checkPermission($name)
    {
        if (session('data')['role_id'] == 1) {
            return true;
        }
        $permissions = Session::get('permissions');
        $permission_array = array();
        for ($i = 0; $i < count($permissions); $i++) {
            $permission_array[$i] = $permissions[$i]->codename;
        }
        if (in_array($name, $permission_array)) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('generateSeoURL')) {
    function generateSeoURL($string, $wordLimit = 0)
    {
        $separator = '-';
        if ($wordLimit != 0) {
            $wordArr = explode(' ', $string);
            $string = implode(' ', array_slice($wordArr, 0, $wordLimit));
        }
        $quoteSeparator = preg_quote($separator, '#');
        $trans = array(
            '&.+?;'                    => '',
            '[^\w\d _-]'            => '',
            '\s+'                    => $separator,
            '(' . $quoteSeparator . ')+' => $separator
        );
        $string = strip_tags($string);
        foreach ($trans as $key => $val) {
            $UTF8_ENABLED = config('global.UTF8_ENABLED');
            $string = preg_replace('#' . $key . '#i' . ($UTF8_ENABLED ? 'u' : ''), $val, $string);
        }
        $string = strtolower($string);
        return trim(trim($string, $separator));
    }
}

if (!function_exists('approvalStatusArray')) {
    function approvalStatusArray($displayValue = "", $allKeys = false)
    {
        $returnArray = array(
            'pending' => 'Pending',
            'accepted' => 'Accepted',
            'rejected' => 'Rejected'
        );
        if (!empty($displayValue)) {
            $returnArray = $returnArray[$displayValue];
        }
        if (empty($displayValue) && $allKeys) {
            $returnArray = array_keys($returnArray);
        }
        return $returnArray;
    }
}

/**
 *   created by : Sagar Thokal
 *   Created On : 09-aug-2022
 *   Uses : To display globally status 0|1 as Active|In-Active in view pages
 *   @param $key
 *   @return Response
 */
if (!function_exists('displayStatus')) {
    function displayStatus($displayValue = "")
    {
        $returnArray = array(
            '1' => 'Active',
            '0' => 'In-Active'
        );
        if (isset($displayValue)) {
            $returnArray = $returnArray[$displayValue];
        }

        return $returnArray;
    }
}

/**
 *   created by : Maaz Ansari
 *   Created On : 16-aug-2022
 *   Uses : To display globally dropdown status 0|1 as Yes|no in view pages and 
 *   @param $key
 *   @return Response
 */
if (!function_exists('dropdownStatus')) {
    function dropdownStatus($displayValue = "", $allKeys = false)
    {
        $returnArray = array(
            '1' => 'Yes',
            '0' => 'No'
        );
        if ($displayValue != '' || $displayValue != NULL) {
            $returnArray = $returnArray[$displayValue];
        }
        if (empty($displayValue) && $allKeys) {
            $returnArray = array_keys($returnArray);
        }
        return $returnArray;
    }
}

/**
 *   created by : Sagar Thokal
 *   Created On : 16-aug-2022
 *   Uses : To display globally Featured 0|1 as  Featured|Un-Featured in view pages
 *   @param $key
 *   @return Response
 */
if (!function_exists('displayFeatured')) {
    function displayFeatured($displayValue = "")
    {
        $returnArray = array(
            '1' => 'Featured',
            '0' => 'Un-Featured'
        );
        if (isset($displayValue)) {
            $returnArray = $returnArray[$displayValue];
        }

        return $returnArray;
    }
}

/**
 *   created by : Maaz Ansari
 *   Created On : 16-aug-2022
 *   Uses :  To fetch value in attribute value for type       
 */
if (!function_exists('attributeValueType')) {
    function attributeValueType($displayValue = "", $allKeys = false)
    {
        $returnArray = array(
            'brand' => 'Brand',
            'collection' => 'Collection',
            'category' => 'Category',
            'sub_category' => 'Sub Category'
        );
        if (!empty($displayValue)) {
            $returnArray = $returnArray[$displayValue];
        }
        if (empty($displayValue) && $allKeys) {
            $returnArray = array_keys($returnArray);
        }
        return $returnArray;
    }
}

/**
 *   created by : Maaz Ansari
 *   Created On : 09-aug-2022
 *   Uses :  To fetch value in order delivery status type       
 */
if (!function_exists('deliveryStatus')) {
    function deliveryStatus($displayValue = "", $allKeys = false)
    {
        $returnArray = array(
            'pending' => 'Pending',
            'processing' => 'Processing',
            'out_for_delivery' => 'Out For Delivery',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled',
            'returned' => 'Returned'
        );
        if (!empty($displayValue)) {
            $returnArray = $returnArray[$displayValue];
        }
        if (empty($displayValue) && $allKeys) {
            $returnArray = array_keys($returnArray);
        }
        return $returnArray;
    }
}

/**
 *   created by : Maaz Ansari
 *   Created On : 16-aug-2022
 *   Uses :  To fetch value in order payment status type       
 */
if (!function_exists('paymentStatus')) {
    function paymentStatus($displayValue = "", $allKeys = false)
    {
        $returnArray = array(
            'pending' => 'Pending',
            'paid' => 'Paid',
            'failed' => 'Failed',
            'refund_initiated' => 'Refund Initiated',
            'refund_completed' => 'Refund Completed'
        );
        if (!empty($displayValue)) {
            $returnArray = $returnArray[$displayValue];
        }
        if (empty($displayValue) && $allKeys) {
            $returnArray = array_keys($returnArray);
        }
        return $returnArray;
    }
}


/**
 *   created by : Maaz Ansari
 *   Created On : 16-aug-2022
 *   Uses :  To fetch value in user subscription payment type       
 */
if (!function_exists('paymentType')) {
    function paymentType($displayValue = "", $allKeys = false)
    {
        $returnArray = array(
            'cash' => 'Cash',
            'online_payment' => 'Online Payment'
        );
        if (!empty($displayValue)) {
            $returnArray = $returnArray[$displayValue];
        }
        if (empty($displayValue) && $allKeys) {
            $returnArray = array_keys($returnArray);
        }
        return $returnArray;
    }
}

/**
 *   Created by : Maaz Ansari
 *   Created On : 16-aug-2022
 *   Uses: This function will be used to full search data in api.
 */
if (!function_exists('fullSearchQuery')) {
    function fullSearchQuery($query, $word, $params)
    {
        $orwords = explode('|', $params);
        $query = $query->where(function ($query) use ($word, $orwords) {
            foreach ($orwords as $key) {
                $query->orWhere($key, 'like', '%' . $word . '%');
            }
        });
        return $query;
    }
}

/**
 *   created by : Maaz Ansari
 *   Created On : 16-aug-2022
 *   Uses :  To fetch value in user address       
 */
if (!function_exists('addressType')) {
    function addressType($displayValue = "", $allKeys = false)
    {
        $returnArray = array(
            'shipping' => 'Shipping',
            'billing' => 'Billing'
        );
        if (!empty($displayValue)) {
            $returnArray = $returnArray[$displayValue];
        }
        if (empty($displayValue) && $allKeys) {
            $returnArray = array_keys($returnArray);
        }
        return $returnArray;
    }
}

/**
 *   created by : Maaz Ansari
 *   Created On : 16-aug-2022
 *   Uses :  To fetch value in gst type dropdown in customer enquiry map to vendor       
 */
if (!function_exists('gstType')) {
    function gstType($displayValue = "", $allKeys = false)
    {
        $returnArray = array(
            'not_applicable' => 'Not Applicable',
            'cgst+sgst' => 'CGST+SGST',
            'igst' => 'IGST'
        );
        if (!empty($displayValue)) {
            $returnArray = $returnArray[$displayValue];
        }
        if (empty($displayValue) && $allKeys) {
            $returnArray = array_keys($returnArray);
        }
        return $returnArray;
    }
}

/**
 *   created by : Maaz Ansari
 *   Created On : 16-aug-2022
 *   Uses :  To fetch value in order Status in order table       
 */
if (!function_exists('orderStatus')) {
    function orderStatus($displayValue = "", $allKeys = false)
    {
        $returnArray = array(
            'initiated' => 'Initiated',
            'processing' => 'Processing',
            'cancelled' => 'Cancelled',
            'completed' => 'Completed',
            'returned' => 'Returned'

        );
        if (!empty($displayValue)) {
            $returnArray = $returnArray[$displayValue];
        }
        if (empty($displayValue) && $allKeys) {
            $returnArray = array_keys($returnArray);
        }
        return $returnArray;
    }
}

/**
 *   created by : Maaz Ansari
 *   Created On : 16-aug-2022
 *   Uses :  to get pin code details   
 */


if (!function_exists('getPincodeDetails')) {
    function getPincodeDetails($pincode)
    {
        $msg_data = array();

        $data = Http::get('https://api.postalpincode.in/pincode/' . $pincode)->json();
        if (empty($data[0]['PostOffice'])) {
            errorMessage(__('pin_code.not_found'), $msg_data);
        }

        $msg_data['city'] = $data[0]['PostOffice'][0]['District'];
        $msg_data['state'] = $data[0]['PostOffice'][0]['State'];
        $msg_data['pin_code'] = $data[0]['PostOffice'][0]['Pincode'];
        return $msg_data;
    }
}

if (!function_exists('getFormatid')) {
    function getFormatid($id)
    {
        // $formatId = str_pad($id, 4, 0, STR_PAD_LEFT);
        // return $formatId;
        return $id;
    }
}


if (!function_exists('convertNumberToWord')) {
    function convertNumberToWord($num = false)
    {
        $num = str_replace(array(',', ' '), '', trim($num));
        if (!$num) {
            return false;
        }
        $num = (int) $num;
        $words = array();
        $list1 = array(
            '', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
            'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
        );
        $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
        $list3 = array(
            '', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
            'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
            'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
        );
        $num_length = strlen($num);
        $levels = (int) (($num_length + 2) / 3);
        $max_length = $levels * 3;
        $num = substr('00' . $num, -$max_length);
        $num_levels = str_split($num, 3);
        for ($i = 0; $i < count($num_levels); $i++) {
            $levels--;
            $hundreds = (int) ($num_levels[$i] / 100);
            $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ' ' : '');
            $tens = (int) ($num_levels[$i] % 100);
            $singles = '';
            if ($tens < 20) {
                $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '');
            } else {
                $tens = (int)($tens / 10);
                $tens = ' ' . $list2[$tens] . ' ';
                $singles = (int) ($num_levels[$i] % 10);
                $singles = ' ' . $list1[$singles] . ' ';
            }
            $words[] = $hundreds . $tens . $singles . (($levels && (int) ($num_levels[$i])) ? ' ' . $list3[$levels] . ' ' : '');
        } //end for loop
        $commas = count($words);
        if ($commas > 1) {
            $commas = $commas - 1;
        }

        return ucwords(implode(' ', $words));
    }
}


/**
 *   created by : Maaz Ansari
 *   Created On : 16-aug-2022
 *   Uses : To display globally dropdown status 0|1 as Yes|no in view pages and 
 *   @param $key
 *   @return Response
 */
if (!function_exists('dropdownStatus')) {
    function dropdownStatus($displayValue = "", $allKeys = false)
    {
        $returnArray = array(
            '1' => 'Yes',
            '0' => 'No'
        );
        if ($displayValue != '' || $displayValue != NULL) {
            $returnArray = $returnArray[$displayValue];
        }
        if (empty($displayValue) && $allKeys) {
            $returnArray = array_keys($returnArray);
        }
        return $returnArray;
    }
}

if (!function_exists('get_finacial_year_range')) {
    function get_finacial_year_range($date = '')
    {
        if (empty($date)) {
            $date = now();
        }
        $year = date('Y', strtotime($date));
        $month = date('m', strtotime($date));
        if ($month < 4) {
            $year = $year - 1;
        }
        $start_date = date('d/m/Y', strtotime(($year) . '-04-01'));
        $end_date = date('d/m/Y', strtotime(($year + 1) . '-03-31'));
        $response = array('start_date' => $start_date, 'end_date' => $end_date);
        return $response;
    }
}

if (!function_exists('get_max_enq_no')) {
    function get_max_enq_no($region_id, $financial_year)
    {
        $start_date = Carbon::createFromFormat('d/m/Y', trim($financial_year['start_date']))->format('Y-m-d');
        $end_date = Carbon::createFromFormat('d/m/Y', trim($financial_year['end_date']))->format('Y-m-d');
        $maxEnqNo = Enquiry::select(DB::raw('max(enq_no*1.0) as enq_no'))
            ->where('region_id', $region_id)
            ->whereDate('enq_register_date', '>=', $start_date)
            ->whereDate('enq_register_date', '<=', $end_date)
            ->value('enq_no');
        return $maxEnqNo;
    }
}

// Added by Maaz Ansari
// get single enquiry for edit and view -- START
if (!function_exists('getEnquiryData')) {
    function getEnquiryData()
    {
        $EnquiryData = DB::table('enquiries')->select(
            'enquiries.*',
            'products.product_name',
            'regions.region_name',
            'categories.category_name',
            'engineer_statuses.engineer_status_name',
            'typist_statuses.typist_status_name',
            'allocation_statuses.allocation_status_name',
            'industries.industry_name',
            'ci.admin_name as case_incharge',
            'ci.nick_name as case_incharge_nick_name',
            'eng.admin_name as engineer',
            'eng.nick_name as engineer_nick_name',
            'old_eng.admin_name as old_engineer',
            'old_eng.nick_name as old_engineer_nick_name',
            'typ.admin_name as typist',
            'typ.nick_name as typist_nick_name',
            'old_typ.admin_name as old_typist',
            'old_typ.nick_name as old_typist_nick_name',
        )
            ->leftjoin('products', 'products.id', '=', 'enquiries.product_id')
            ->leftjoin('regions', 'regions.id', '=', 'enquiries.region_id')
            ->leftjoin('categories', 'categories.id', '=', 'enquiries.category_id')
            ->leftjoin('engineer_statuses', 'engineer_statuses.id', '=', 'enquiries.engineer_status')
            ->leftjoin('typist_statuses', 'typist_statuses.id', '=', 'enquiries.typist_status')
            ->leftjoin('allocation_statuses', 'allocation_statuses.id', '=', 'enquiries.allocation_status')
            ->leftjoin('industries', 'industries.id', '=', 'enquiries.industry_id')
            ->leftjoin('admins as ci', 'ci.id', '=', 'enquiries.case_incharge_id')
            ->leftjoin('admins as eng', 'eng.id', '=', 'enquiries.engineer_id')
            ->leftjoin('admins as old_eng', 'old_eng.id', '=', 'enquiries.old_engineer_id')
            ->leftjoin('admins as typ', 'typ.id', '=', 'enquiries.typist_id')
            ->leftjoin('admins as old_typ', 'old_typ.id', '=', 'enquiries.old_typist_id');
        return $EnquiryData;
    }
    // get single enquiry for edit and view -- END

}

// get mipo unique job number
if (! function_exists('uniqueMipoJobNumber')) {
    function uniqueMipoJobNumber()
    {
        $prefix = "PO";
        $initial = 1;

        $mipo = Mipo::withTrashed()->where('po_type', 'new')
            ->latest()->first();

        if (! empty($mipo && $mipo->po_no)) {
            $oldJobNumber = $mipo->po_no;
            $initial = (int) trim($oldJobNumber, $prefix);
            $initial++;
        }

        return $prefix.str_pad($initial, 5, '0', STR_PAD_LEFT);
    }
}

// assign task to mipo user
if (!function_exists('assignMipoUser')) {
    function assignMipoUser(){
        $mipoUserIds = Admin::where([
            ['status', '1'],
            ['role_id', 8],
            ['is_head', '!=', '1']
        ])->pluck('id')->toArray();

        $mipoUser = null;

        if(count($mipoUserIds)){

            $existingIds = Mipo::whereIn('mipo_user_id', $mipoUserIds)->pluck('mipo_user_id')->toArray();
            $notExistingIds = array_diff($mipoUserIds, $existingIds);
                            
            if(!empty($notExistingIds)){
                $mipoUser = array_values($notExistingIds)[0];
            }else {
                $mipoUser = Mipo::whereIn('mipo_user_id', $mipoUserIds)
                    ->select(DB::raw('mipo_user_id, COUNT(id) AS assigned_total'))
                    ->groupBy('mipo_user_id')
                    ->orderBy('assigned_total')
                    ->pluck('mipo_user_id')
                    ->first();
            }
        }

        return $mipoUser;
    }
}

// add mipo case history
if (!function_exists('addMipoCaseHistory')) {
    function addMipoCaseHistory($mipoId, $role, $action, $remark = null, $userRemark = null)
    {
        $user_id = session('data')['id'];

        $caseHistoryData = [
            'mipo_id'      => $mipoId,
            'admin_id'     => $user_id,
            'role'         => $role,
            'action'       => $action,
            'remarks'      => $remark,
            'user_remarks' => $userRemark,
            'action_dt'    => Carbon::now(),
        ];

        MipoCaseHistory::create($caseHistoryData);
        
        return true;
    }
}

// get All Enquiries
if (! function_exists('getEnquiriesListing')) {

    function getEnquiriesListing($client_name = '', $region_id = '')
    {
        $engineerStatusIds = DB::table('engineer_statuses')
            ->whereIn('engineer_status_name', ['RGT', 'DRP'])
            ->pluck('id')->toArray();

        $typistStatusIds = DB::table('typist_statuses')
            ->whereIn('typist_status_name', ['QTD', 'REV-QTD','MIPO-QTD'])
            ->pluck('id')->toArray();
        $categoryIds = DB::table('categories')
            ->whereIn('category_name', ['G', 'H', 'I'])
            ->pluck('id')->toArray();

        $query = DB::table('enquiries')
            ->join('regions', 'enquiries.region_id', '=', 'regions.id')
            ->select('enquiries.id', 'enquiries.enq_no', 'enquiries.revision_no', 'regions.region_code')
            //enquiry's Typist Status is QTD or REV-QTD 
            ->whereIn('enquiries.typist_status', $typistStatusIds)
            //enquiry's Engineer Status is not RGT or DRP
            ->whereNotIn('enquiries.engineer_status', $engineerStatusIds)
            // enquiry's category is G H I mapped so not show in listing
            ->whereNotIn('enquiries.category_id', $categoryIds)
            ->where('enquiries.has_revisions', '=', '0')
            ->where('enquiries.status', '=', '1')
            ->whereNull('enquiries.deleted_at');

        if (!empty($client_name)) {
            $query->where('client_name','LIKE','%'.$client_name.'%');
        }
        if (!empty($region_id)) {
            $query->where('region_id',$region_id);
        }
        return $query->orderBy('enquiries.id', 'DESC')->get();
    }
}

if (! function_exists('checkRejectMipoRoleName')) {
    function checkRejectMipoRoleName($mipo)
    {
        $roles = DB::table('roles')
            ->pluck('role_name', 'id');
        
        $roleName = [];
        if ($mipo->ci_approval_status == 'rejected') {
            $roleName[] = $roles[3]; //Cash incharge
        }
        if ($mipo->engg_approval_status == 'rejected') {
            $roleName[] = $roles[5]; //Estimator Engineer
        }
        if ($mipo->commercial_approval_status == 'rejected') {
            $roleName[] = $roles[10]; //Commercial;
        }
        if ($mipo->purchase_approval_status == 'rejected') {
            $roleName[] = $roles[11]; //Purchase Team;
        }
        if ($mipo->head_engg_approval_status == 'rejected') {
            $roleName[] = $roles[11]; //Head Engineer;
        }
        
        return implode(' , ',$roleName);
        
    }
}

if (! function_exists('getRejectedMipoLatestDate')) {
    function getRejectedMipoLatestDate($mipo)
    {
        $getLatestRejectedHistory = MipoCaseHistory::where([['mipo_id', $mipo->id], ['action', 'rejected']])
            ->latest()->first();
        if ($getLatestRejectedHistory) {

            return Carbon::parse($getLatestRejectedHistory->created_at)->format('d-m-Y');
        }

        return '';
    }
}

if (! function_exists('sendMipoMail')) {

    function sendMipoMail($mailType, $userType, $mipo, $roleId, $ccEmails = [])
    {
        $emailData = EmailNotification::where([
            ['mail_key', $mailType], ['user_type', $userType],
        ])->first();
        $subject = $emailData['subject'] ?? '';
        $from_name = $emailData['from_name'] ?? '';
        $url = URL::to('/webadmin/email_mipo_view/'.Crypt::encrypt($mipo->id));
        $mipoData = Mipo::select('po_no')->find($mipo->id);
        $po_no = '#'.$mipoData->po_no;
        $getRoleData = Admin::find($roleId ?? '');
        $email = strtolower($getRoleData['email']);
        $admin_name = $getRoleData['admin_name'];
        $emailData['content'] = str_replace('$$admin_name$$', $admin_name, $emailData['content'] ?? '');
        $emailData['content'] = str_replace('$$po_no$$', $po_no, $emailData['content']);
        $emailData['content'] = str_replace('$$url$$', $url, $emailData['content']);
        $emailData['content'] = str_replace('$$from_name$$', $from_name, $emailData['content']);
        if (in_array($mailType, ['PO_REJECTED','PO_APPROVED','PO_REVERIFY'])) {
            $roleName = Role::where('id', session('data')['role_id'])
                    ->first()->role_name ?? ' ';
            $nickName = session('data')['nick_name'] ?? '';
            $name = $nickName.'('.$roleName.')';
            $emailData['content'] = str_replace('$$role_name$$', $name, $emailData['content']);
        }

        if (config('global.TRIGGER_MIPO_EMAIL')) {
            Mail::send('backend/auth/email-forgot', ['body' => $emailData['content']],
                function ($message) use ($email, $subject, $ccEmails) {
                    $message->from('crm2@mypcot.com', 'Indiana Team');
                    $message->to($email, 'Indiana Team')->subject($subject);
                    foreach ($ccEmails as $ccEmail) {
                        if (! empty($ccEmail) && filter_var($ccEmail, FILTER_VALIDATE_EMAIL)) {
                            $message->cc($ccEmail);
                        }
                    }
                });
        }
    }
}

if (! function_exists('getUserData')) {

    function getUserData($userId)
    {

        if ($userId) {
            
            return Admin::where('id', $userId)->first();
        }

        return '';
    }
}

if (! function_exists('getRoleName')) {

    function getRoleName($roleId)
    {

        return Role::where('id', $roleId)->first()->role_name ?? '';
    }
}


if (! function_exists('updateMipoStatus')) {

    function updateMipoStatus($statusCode, $mipo)
    {
        if ($statusCode && $mipo) {
            $mipoStatusId = MipoStatus::where('mipo_status_code', $statusCode)->first()->id ?? '';
            if ($mipoStatusId) {
                $mipo->update([
                    'mipo_status' => $mipoStatusId,
                ]);
            }
        }
    }
}

if (! function_exists('checkIsAllRolesApprovedMipo')) {

    function checkIsAllRolesApprovedMipo($mipo)
    {
        $requiredApprovals = collect([
            'ci_approval_status',
            'engg_approval_status',
            'commercial_approval_status',
        ]);

        if ($mipo->is_frp) {
            $requiredApprovals->push('purchase_approval_status');
        }

        return $requiredApprovals->every(function ($approvalStatus) use ($mipo) {
            return $mipo->{$approvalStatus} == 'accepted';
        });

    }
}

if (! function_exists('checkTeamUserApproveOrRejected')) {

    function checkTeamUserApproveOrRejected($mipoId)
    {
        $role_id = session('data')['role_id'];
        $mipo = Mipo::find($mipoId);
        $status = "";

        switch ($role_id) {
            case 3:
                $status = $mipo->ci_approval_status;
                break;
            case 5:
                $status = $mipo->engg_approval_status;
                break;
            case 9:
                $status = $mipo->drawing_approval_status;
                if ($status != "accepted") {
                    return true;
                }
                break;
            case 10:
                $status = $mipo->commercial_approval_status;
                break;
            case 11:
                $status = $mipo->purchase_approval_status;
                break;
            default:
                return true;
        }

        return $status == "pending";
    }
}

if (! function_exists('getMipoStatusId')) {

    function getMipoStatusId($statusCode)
    {
        return MipoStatus::where('mipo_status_code', $statusCode)
                ->first()->id ?? '';
    }
}

if (! function_exists('checkRegionAbpDataExist')) {
    function checkRegionAbpDataExist($regionId)
    {
        $data = Abp::where('region_id',$regionId)->whereBetween('time_budget', [getFinancialYearStartDate(), getFinancialYearEndDate()])
            ->whereIn('product_id', config('global.ABP_VARIANCE_REPORT_PRODUCT'))
            ->get();
        
        if(count($data)){
            return true;
        }
        
        return false;
    }

}

if (! function_exists('checkAbpFinancialYearApproved')) {
    function checkAbpFinancialYearApproved($regionId)
    {
        $financialYearApproveEntryExists = Abp::where('region_id',$regionId)->whereBetween('time_budget', [getFinancialYearStartDate(), getFinancialYearEndDate()])
            ->whereIn('product_id', config('global.ABP_VARIANCE_REPORT_PRODUCT'))
            ->where('ceo_approval','1')
            ->exists();
        if($financialYearApproveEntryExists){
            return false;   
        }

        return true;
    }
}

if (! function_exists('checkCiRegionApproved')) {
    function checkCiRegionApproved($ciID)
    {
        $regionIds = Abp::where('ceo_approval','1')->whereBetween('time_budget', [getFinancialYearStartDate(), getFinancialYearEndDate()])->groupBy('region_id')->pluck('region_id');
        $regionApprovedEntryExists = Abp::where('case_incharge_id',$ciID)->whereIn('region_id',$regionIds)->whereBetween('time_budget', [getFinancialYearStartDate(), getFinancialYearEndDate()])->exists();
        
        if($regionApprovedEntryExists){
            return false;
        }
        
        return true;
    }
} 

if (! function_exists('getFinancialYearStartDate')) {
    function getFinancialYearStartDate(): string
    {
        $month = \Illuminate\Support\Carbon::now()->format('m');
        if ($month > 4) {
            $year = date('Y');
        } else {
            $year = date('Y', strtotime('-1 year'));
        }

        return Carbon::createFromDate($year, 4, 01)->format('Y-m-d');
    }
}

if (! function_exists('getFinancialYearEndDate')) {
    function getFinancialYearEndDate(): string
    {
        $month = \Illuminate\Support\Carbon::now()->format('m');

        if ($month > 4) {
            $year = date('Y', strtotime('+1 year'));
        } else {
            $year = date('Y');
        }

        return Carbon::createFromDate($year, 3, 31)->format('Y-m-d');
    }
}

if (! function_exists('checkProductIsExist')) {
    function checkProductIsExist($budgetData, $budgetType, $roleNickName)
    {
        $productNames = \App\Models\Product::whereIn('id',
            config('global.ABP_VARIANCE_REPORT_PRODUCT'))->pluck('product_code')->toArray();

        $budgetData = $budgetData->filter(function ($item) use ($productNames) {
            return in_array($item['product_name'], $productNames);
        })->values();

        $newCollection = collect([]);
        foreach ($productNames as $product) {
            $existingProduct = $budgetData->firstWhere('product_name', $product);

            if (! $existingProduct) {
                $emptyProductArray = [
                    "nick_name"             => $roleNickName,
                    "budget_type"           => $budgetType,
                    "sales_sum"             => 0,
                    "net_margin_sum"        => 0,
                    "calculated_margin_rs"  => 0,
                    "total_credit_days_sum" => 0,
                    "product_name"          => $product,
                ];
                $newCollection->push($emptyProductArray);
            } else {
                $existingProductArray = [
                    "nick_name"             => $existingProduct->nick_name,
                    "budget_type"           => $existingProduct->budget_type,
                    "sales_sum"             => $existingProduct->sales_sum,
                    "net_margin_sum"        => $existingProduct->net_margin_sum,
                    "calculated_margin_rs"  => $existingProduct->calculated_margin_rs,
                    "total_credit_days_sum" => $existingProduct->total_credit_days_sum,
                    "product_name"          => $existingProduct->product_name,
                ];
                $newCollection->push($existingProductArray);
            }
        }

        return $newCollection;
    }
}

if (! function_exists('calculateAbpTrackerData')) {
    function calculateAbpTrackerData($allBudgetData, $roleNickName = null)
    {
        $budgetData = $allBudgetData->flatten();

        $productNames = \App\Models\Product::whereIn('id',
            config('global.ABP_VARIANCE_REPORT_PRODUCT'))->pluck('product_code')->toArray();
        $productData = [];

        foreach ($productNames as $productName) {
            $productSumData = [
                "nick_name"             => $roleNickName,
                "budget_type"           => "",
                "sales_sum"             => $budgetData->where('product_name', $productName)->sum('sales_sum'),
                "net_margin_sum"        => $budgetData->where('product_name', $productName)->sum('net_margin_sum'),
                "calculated_margin_rs"  => $budgetData->where('product_name',
                    $productName)->sum('calculated_margin_rs'),
                "total_credit_days_sum" => $budgetData->where('product_name',
                    $productName)->sum('total_credit_days_sum'),
                "product_name"          => $productName,
            ];

            $productData[] = $productSumData;
        }

        return collect($productData);
    }
}
