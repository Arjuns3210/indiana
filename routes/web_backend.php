<?php

use App\Http\Controllers\Backend\AbpController;
use App\Http\Controllers\Backend\MipoController;
use App\Http\Controllers\Backend\RegionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// controllers

Route::get('/', 'LoginController@index')->name('login');
Route::post('login', 'LoginController@login');
Route::get('/forgot-password', 'LoginController@forgotPassword')->name('password.request');
Route::post('/forgot-password', 'LoginController@forgotPasswordStore')->name('password.email');
Route::get('/reset-password/{token}/{email}', 'LoginController@passwordReset')->name('password.reset')->middleware('signed');
Route::post('/reset-password', 'LoginController@passwordUpdate')->name('password.update');

Route::get('/force_password_change', 'AdminController@forcePassword');
Route::post('/force_reset_password', 'AdminController@ForceResetPassword');
Route::group(['middleware' => ['customAuth']], function () {
	Route::get('dashboard', 'DashboardController@index')->name('dashboard');
	Route::get('dashboard/test', 'DashboardController@index_phpinfo');

	//profile
	Route::get('/profile', 'AdminController@profile');
	Route::post('/updateProfile', 'AdminController@updateProfile');

	//change password
	Route::get('/updatePassword', 'AdminController@updatePassword');
	Route::post('/resetPassword', 'AdminController@resetPassword');

	//General Settings
	Route::get('/generalSetting', 'AdminController@fetchSetting');
	Route::post('/updateSettingInfo', 'AdminController@updateSetting');
	Route::post('/publishEmailNotification', 'AdminController@updateEmailNotification');
	Route::post('/publishSMSNotification', 'AdminController@updateSMSNotification');


	//ContactUs
	// Route::get('/contactus', 'ContactusController@index');
	// Route::post('/contactus_data', 'ContactusController@fetch')->name('contactus_data');

	//Reviews
	Route::get('/review', 'ReviewController@index');
	Route::post('/review_data', 'ReviewController@fetch')->name('review_data');
	Route::get('reviewApproval/{id}', 'ReviewController@approval');
	Route::post('/updateReviewApproval', 'ReviewController@updateApprovalStatus');
	Route::post('/publishReview', 'ReviewController@updateStatus');
	Route::get('/review_view/{id}', 'ReviewController@view');

	//Roles
	Route::get('/roles', 'AdminController@roles');
	Route::post('/role_data', 'AdminController@roleData')->name('role_data');
	Route::get('/role_permission/{id}', 'AdminController@assignRolePermission');
	Route::post('/publishPermission', 'AdminController@publishPermission');

	//staff
	Route::get('/staff', 'StaffController@index');
	Route::post('/staff_data', 'StaffController@staffData')->name('staff_data');
	Route::get('/staff_add', 'StaffController@addStaff');
	Route::post('/saveStaff', 'StaffController@saveStaff');
	Route::get('/staff_edit/{id}', 'StaffController@editStaff');
	Route::post('/publishStaff', 'StaffController@publishStaff');
	Route::get('/staff_view/{id}', 'StaffController@view');

	//Product
	Route::get('/product', 'ProductController@index');
	Route::post('/product_data', 'ProductController@fetch');
	Route::get('/product_edit/{id}', 'ProductController@editProduct');
	Route::get('/product_view/{id}', 'ProductController@view');
	Route::post('/saveProduct', 'ProductController@saveProduct');


	//state
	Route::get('/state', 'StateController@index');
	Route::post('/state_data', 'StateController@fetch')->name('state_data');
	Route::get('/state_add', 'StateController@add');
	Route::post('/saveState', 'StateController@saveFormData');
	Route::get('/state_edit/{id}', 'StateController@edit');
	Route::post('/publishState', 'StateController@updateStatus');
	Route::get('/state_view/{id}', 'StateController@view');

	//Enquiry
	Route::get('/enquiry_list', 'EnquiryController@index');
	Route::post('/enquiry_data', 'EnquiryController@fetch')->name('enquiry_data');
	Route::get('/enquiry_view/{id}', 'EnquiryController@view');
	Route::get('/enquiry_remark/{id}', 'EnquiryController@engineerRemark');
	Route::get('/enquiry_delete/{id}', 'EnquiryController@adminDelete');
	Route::post('/enquiryRemark', 'EnquiryController@enquiryRemark');

	Route::get('/email_enquiry_view/{id}', 'EnquiryController@viewEmail');

	Route::get('/enquiry_form/{id}', 'EnquiryController@enquiryForm');
	Route::post('/enquiry_form/autoData', 'EnquiryController@autoData')->name('enquiry_form.autoData');
	Route::get('/enquiry_revision/{id}', 'EnquiryController@enquiryRevision');
	Route::post('/saveEnquiryDetails', 'EnquiryController@saveEnquiryDetails');
	Route::get('/enquiry_view/{id}', 'EnquiryController@view');

	Route::get('/transfer_engineer/{id}', 'EnquiryController@transferEngineer');
	Route::post('/saveTransferEngineer', 'EnquiryController@saveTransferEngineer');

	//engineer status dashboard  for sales
	Route::post('/engineer_status_dashboard_chart', 'EnquiryController@engineerStatusDashboard');

	//category status dashboard  for sales
	Route::post('/category_status_dashboard_chart', 'EnquiryController@categoryStatusDashboard');

	//category status dashboard  for Admin
	Route::post('/admin_category_status_dashboard_chart', 'EnquiryController@adminCategoryStatusDashboard');

	//engineer status dashboard  for Admin
	Route::post('/admin_engineer_status_dashboard_chart', 'EnquiryController@adminEngineerStatusDashboard');

	//typist status dashboard  for Admin
	Route::post('/admin_typist_status_dashboard_chart', 'EnquiryController@adminTypistStatusDashboard');

	//region dashboard  for Admin
	Route::post('/admin_region_dashboard_chart', 'EnquiryController@adminRegionDashboard');

	Route::get('/transfer_typist/{id}', 'EnquiryController@transferTypist');
	Route::post('/saveTransferTypist', 'EnquiryController@saveTransferTypist');
	Route::get('/import_enquiry', 'EnquiryController@importEnquiry')->name('import.form');
	Route::post('/importExcelFile', 'EnquiryController@importExcelFile');

	//reports

	// mis report
	Route::get('/mis_report', 'EnquiryController@misReportForm')->name('mis_report');
	Route::post('/generateMISReport', 'EnquiryController@generateMISReport');

	// ABP Weekly report
	Route::get('/abp_weekly_report', 'AbpController@abpWeeklyReport')->name('abp_weekly_report');
	Route::post('/generateAbpWeeklyReport', 'AbpController@generateAbpWeeklyReport');

	// ABP overall summary report
	Route::get('/abp_overall_summary_report', 'AbpController@abpOverallSummaryReport')->name('abp_overall_summary_report');
	Route::post('/generateAbpOverallSummaryReport', 'AbpController@generateAbpOverallSummaryReport');

	//data report
	Route::get('/data_report', 'EnquiryController@dataReportForm')->name('data_report');
	Route::post('/generateDataReport', 'EnquiryController@generateDataReport');

	// engineer achievement report
	Route::get('/engineer_achievement_report', 'EnquiryController@engineerAchievementReportForm')->name('engineer_achievement_report');
	Route::post('/generateEnggAchievementReport', 'EnquiryController@generateEnggAchievementReport');

	// typist_achievement_report
	Route::get('/typist_achievement_report', 'EnquiryController@typistAchievementReportForm')->name('typist_achievement_report');
	Route::post('/generateTypistAchievementReport', 'EnquiryController@generateTypistAchievementReport');


	//message sms
	Route::get('/sms', 'MessageSmsController@index');
	Route::post('/sms_data', 'MessageSmsController@fetch')->name('sms_data');
	Route::post('/saveSms', 'MessageSmsController@saveFormData');
	Route::get('/sms_edit/{id}', 'MessageSmsController@edit');
	Route::post('/publishSmsStatus', 'MessageSmsController@updateStatus');
	Route::get('/sms_view/{id}', 'MessageSmsController@view');

	//message notification
	Route::get('/notification', 'MessageNotificationController@index');
	Route::post('/notification_data', 'MessageNotificationController@fetch')->name('notification_data');
	Route::get('/notification_add', 'MessageNotificationController@add');
	Route::get('/notification_edit/{id}', 'MessageNotificationController@edit');
	Route::post('/saveNotification', 'MessageNotificationController@saveFormData');
	Route::post('/publishNotificationStatus', 'MessageNotificationController@updateStatus');
	Route::get('/notification_view/{id}', 'MessageNotificationController@view');
	Route::get('/notification_send/{id}', 'MessageNotificationController@send');
	Route::post('/getUser', 'MessageNotificationController@getUser');
	Route::post('notify', 'MessageNotificationController@notify');
	//message email
	Route::get('/email', 'MessageEmailController@index');
	Route::post('/email_data', 'MessageEmailController@fetch')->name('email_data');
	Route::get('/email_edit/{id}', 'MessageEmailController@edit');
	Route::post('/saveEmail', 'MessageEmailController@saveFormData');
	Route::post('/publishEmailStatus', 'MessageEmailController@updateStatus');
	Route::get('/email_view/{id}', 'MessageEmailController@view');
	// daily remarks
	Route::get('/remarks', 'DailyRemarkController@index');
	Route::post('/remark_data', 'DailyRemarkController@remarkData')->name('remark_data');
	Route::get('/remark_add', 'DailyRemarkController@addRemark');
	Route::post('/saveRemark', 'DailyRemarkController@saveRemark');
	Route::get('/remark_view/{id}', 'DailyRemarkController@view');
	Route::get('/remark_edit/{id}', 'DailyRemarkController@editRemark');
	Route::get('/remark_delete/{id}', 'DailyRemarkController@deleteremark');

	// Mipo
    Route::get('mipo',[MipoController::class,'index'])->name('mipo.index');
    Route::post('mipo_data' ,[MipoController::class,'fetch'])->name('mipo_data');
    Route::get('mipo-form',[MipoController::class,'viewForm'])->name('mipo.view-form');
    Route::post('get-enquiry-data',[MipoController::class,'getEnquiryData'])->name('mipo-form.get-enquiry-data');
    Route::post('get-mipo-data',[MipoController::class,'getMipoData'])->name('mipo-form.get-mipo-data');
    Route::post('save-mipo-details', [MipoController::class, 'saveMipoDetails'])->name('mipo.store-mipo-details');
    Route::post('store-case-incharge-mipo-details', [MipoController::class, 'saveCashinchargeMipoDetails'])->name('mipo.store-case-incharge-mipo-details');
    Route::get('mipo_edit/{id}', [MipoController::class,'editMipo'])->name('mipo.edit');
    Route::get('mipo_delete/{id}', [MipoController::class,'deleteMipo'])->name('mipo.destroy');
    Route::get('/mipo_view/{mipo}', [MipoController::class,'viewMipo']);
    Route::post('save-mipo-allocation', [MipoController::class,'saveMipoAllocation'])->name('mipo.store-mipo-allowcation');
    Route::post('save-mipo-estimator-form', [MipoController::class,'saveMipoEstimatorForm'])->name('mipo.save-mipo-estimator-form');
    Route::post('save-commercial-mipo-form', [MipoController::class,'saveCommercialMipoForm'])->name('mipo.save-commercial-mipo-form');
    Route::post('save-purchase-team-mipo-form', [MipoController::class,'savePurchaseTeamMipoForm'])->name('mipo.save-purchase-team-mipo-form');
    Route::post('delete-mipo-document', [MipoController::class,'deleteMipoDocument'])->name('delete-mipo-document');
    Route::post('/save_mipo_enquiry', 'MipoController@saveMipoEnquiry')->name('save_mipo_enquiry');
    Route::get('/add_mipo_enquiry_form', 'MipoController@addMipoEnquiry')->name('add_mipo_enquiry_form');
    Route::post('/mipo/get-clientname', [MipoController::class,'getClientname'])->name('mipo.get-client_name');

    // Save MIPO Design engineer form
    Route::post('save_designer_mipo_form', [MipoController::class,'saveDesignerMipoForm'])->name('mipo.save_designer_mipo_form');
    Route::get('/email_mipo_view/{id}', [MipoController::class,'viewEmail']);
    Route::get('mipo_reassign/{id}', [MipoController::class, 'mipoReassign']);
    Route::post('save_mipo_reassign_details', [MipoController::class, 'saveMipoReassignDetails']);

    // Mipo verification routes
    Route::get('edit_mipo_verification/{id}', [MipoController::class,'editMipoVerification'])->name('mipo.edit_mipo_verification');
    Route::post('save_mipo_verification', [MipoController::class, 'saveMipoVerification'])->name('mipo.save_mipo_verification');

    // Estimator Head verification routes
    Route::post('save_estimator_head_verification', [MipoController::class, 'saveEstimatorHeadVerification'])->name('mipo.save_estimator_head_verification');

    // Mipo Upload order sheet and approval
    Route::post('save_mipo_order_approval_form', [MipoController::class,'saveMipoOrderApprovalForm'])->name('mipo.save_mipo_order_approval_form');

    // Managementverification routes
    Route::post('save_management_verification', [MipoController::class, 'saveManagementVerification'])->name('mipo.save_management_verification');
    
    // Mipo Report routes 
    Route::get('mipo_report', [MipoController::class, 'mipoReportView'])->name('mipo_report');
    Route::post('generate_mipo_report', [MipoController::class, 'generateMipoReport']);

    // Abp routes
    Route::get('/abp_list', [AbpController::class,'index']);
    Route::post('/abp_data', [AbpController::class, 'fetch']);
    Route::get('/abp_form', [AbpController::class, 'abpForm']);
    Route::post('/save_abp_details', [AbpController::class, 'saveAbpDetails']);
    Route::get('/abp_edit/{abp}', [AbpController::class, 'editAbp']);
    Route::get('/abp_delete/{id}', [AbpController::class, 'deleteAbp']);
    Route::get('/prepare_payment_term', [AbpController::class, 'preparePaymentTerm']);
    Route::get('/abp_view/{abp}', [AbpController::class, 'viewAbp']);

    Route::get('/abp_report', [AbpController::class, 'abpReportView']);
    Route::post('/generate_abp_report', [AbpController::class, 'generateAbpReport']);

    Route::get('abp_tracker_report', [AbpController::class, 'abpTrackerReportView']);
    Route::post('export_abp_tracker_report', [AbpController::class, 'exportAbpTrackerReport']);
    //Save approval form route after ceo approval
    Route::post('/save_after_approval_abp_details', [AbpController::class,'saveAfterApprovalAbpDetails']);

    //For admin reviewal remark process
    Route::get('/abp_review/{abp}', [AbpController::class,'reviewAbp']);
    Route::post('/save_abp_review_remark', [AbpController::class,'saveReviewRemarkProcess']);
    
    // Region List
    Route::get('/region_list', [RegionController::class,'index']);
    Route::post('/region_data', [RegionController::class,'fetch']);
    Route::get('/region_view/{id}', [RegionController::class,'viewRegion']);
    Route::get('/abp_approve_edit/{id}', [RegionController::class,'editAbpApprove']);
    Route::post('/save_abp_ceo_approval_form', [RegionController::class,'saveAbpCeoApproval']);
});

// routes
Route::get('/logout', function () {
	session()->forget('data');
	return redirect('/webadmin');
});
