<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Mipo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\EngineerStatus;
use App\Models\Enquiry;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
	public function index_phpinfo()
	{
		$laravel = app();
		echo 'Curl: ', function_exists('curl_version') ? 'Enabled' . "\xA" : 'Disabled' . "\xA";
		echo ' || Laravel Version is : ' . $laravel::VERSION;
		phpinfo();
		exit;
	}

	public function index()
	{
		$data = array();
		$role_id = session('data')['role_id'];
		$user_id = session('data')['id'];
		$dashboard_view = 'index';

		//for admin
		if ($role_id == 1) {
			// $dashboard_view = 'sales_export_dashboard';
			return $this->adminDashboard($user_id);
		}
		//for case incharge
		elseif ($role_id == 2) {
			// $dashboard_view = 'sales_export_dashboard';
			return $this->saleExportDashboard($user_id);
		}
		//for case incharge
		elseif ($role_id == 3) {
			return $this->caseInchargeDashboard($user_id);
		}
		//for allocator
		elseif ($role_id == 4) {
			// $dashboard_view = 'allocation_dashboard';
			return $this->allocatorDashboard($user_id);
		}
		// for engineer
		elseif ($role_id == 5) {
			return $this->engineerDashboard($user_id);
		}
		//for typist
		elseif ($role_id == 6) {
			return $this->typistDashboard($user_id);
		}
		
		// role id 7 is skipped and for role id 7 is redirect to general dashboard.
        
		//for mipo 
        elseif ($role_id == 8) {
            return $this->mipoDashboard($user_id);
        }

        //for Design Engineer 
        elseif ($role_id == 9) {
            return $this->designEngineerDashboard($user_id);
        }

        //for Commercial 
        elseif ($role_id == 10) {
            return $this->commercialDashboard($user_id);
        }

        //for Purchase Team 
        elseif ($role_id == 11) {
            return $this->purchaseTeamDashboard($user_id);
        }

        else { // for others
			return $this->generalDashboard($user_id);
		}

		return view('backend/dashboard/' . $dashboard_view,  $data);
	}

	private function saleExportDashboard($user_id)
	{
		$todays_date = Carbon::parse(now())->format('Y-m-d');
		$dashboard_view = 'sales_export_dashboard';
		$data['sales_id'] = $user_id;
		// print_r($data['allocator_id']);exit;
		$data['total_enquiries'] = Enquiry::where([['sales_id', $user_id], ['status', 1]])->count();
		$data['enquiry_added_today'] = Enquiry::where([['enq_register_date', $todays_date], ['sales_id', $user_id], ['status', 1]])->count();
		return view('backend/dashboard/' . $dashboard_view,  $data);
	}

	private function caseInchargeDashboard($user_id)
	{
		$todays_date = Carbon::parse(now())->format('Y-m-d');
		$dashboard_view = 'case_incharge_dashboard';
		$data['total_mapped_enquiries'] = Enquiry::where([['case_incharge_id', $user_id], ['status', 1]])->count();
		$data['enquiries_mapped_today'] = Enquiry::where([['enq_register_date', $todays_date], ['case_incharge_id', $user_id], ['status', 1]])->count();
        $data['enquiries_due_today'] = Enquiry::where([
            ['enq_due_date', $todays_date], ['case_incharge_id', $user_id], ['status', 1],
        ])->count();
        $data['enquiries_without_category'] = Enquiry::where([
            ['category_id', 0], ['case_incharge_id', $user_id], ['status', 1],
        ])->count();
        $data['enquiries_need_action'] = Enquiry::with('admin', 'region')->where([
            ['category_id', 0], ['case_incharge_id', $user_id], ['status', 1],
        ])->orderBy('id', 'desc')->take(20)->get();
        $data['total_mapped_po'] = Mipo::where([['case_incharge_id', $user_id], ['status', 1]])->count();
        $data['po_mapped_today'] = Mipo::where([
            ['case_incharge_id', $user_id], ['status', 1], ['po_recv_date', today()],
        ])->count();
        $data['po_need_action'] = Mipo::with('region')
            ->where([
                ['case_incharge_id', $user_id], ['status', 1], ['ci_approval_status', 'pending'],
                ['ci_document_upload_dt', null],
            ])
            ->whereBetween('created_at', [now()->subDays(3), now()])
            ->orderByDesc('created_at')
            ->get();

        $data['totalMipoProcess'] = Mipo::where([
            ['status', 1],
            ['case_incharge_id', $user_id],
        ])
            ->whereRaw('(ci_approval_status = "pending" 
        OR engg_approval_status = "pending" 
        OR commercial_approval_status = "pending" 
        OR head_engg_approval_status = "pending"
        OR order_sheet_approval_status = "pending"
        OR management_approval_status = "pending"'
                .('is_frp == 1' ? ' OR purchase_approval_status = "pending"' : '')
                .')')
            ->count();
        $data['totalMipoComplete'] = Mipo::where([
            ['status', 1], ['case_incharge_id', $user_id], ['mipo_status', getMipoStatusId('POC')],
        ])
            ->count();

        return view('backend/dashboard/'.$dashboard_view, $data);
    }

	private function engineerDashboard($user_id)
	{
		$todays_date = Carbon::parse(now())->format('Y-m-d');
		$yesterdays_date = Carbon::parse(now()->subDays(1))->format('Y-m-d');
		$tommorows_date = Carbon::parse((now()->addDays(1)))->format('Y-m-d');
		$dashboard_view = 'engineer_dashboard';
		$data['total_mapped_enquiries'] = Enquiry::where([['engineer_id', $user_id], ['status', 1]])->count();
		$data['enquiries_mapped_today'] = Enquiry::where([['allocation_date', $todays_date], ['engineer_id', $user_id], ['status', 1]])->count();
		$data['enquiries_acted_today'] = Enquiry::where([['estimated_date', $todays_date], ['engineer_id', $user_id], ['status', 1]])->count();
		$data['enquiries_due_today'] = Enquiry::where([['enq_reminder_date', $todays_date], ['engineer_id', $user_id], ['status', 1]])->count();
		$q1 = Enquiry::where([['engineer_id', $user_id], ['enquiries.status', 1]])->groupBy('engineer_status')
			->selectRaw('count(enquiries.id) as count, engineer_status_name')
			->leftjoin('engineer_statuses', 'engineer_statuses.id', '=', 'enquiries.engineer_status')
			->pluck('count', 'engineer_status_name');

		$q2 = EngineerStatus::where([['status', 1]])->selectRaw('0, engineer_status_name')
			->pluck('0', 'engineer_status_name');
		$data['enquiries_status_count'] = $q1->union($q2);

		$data['enquiries_need_action'] = Enquiry::select(
			'enquiries.id',
			'enquiries.enq_no',
			'regions.region_name',
			'enquiries.enq_reminder_date',
			'enquiries.enq_register_date',
			'enquiries.client_name',
			'engineer_statuses.engineer_status_name',

		)
			->where([['enquiries.engineer_id', $user_id], ['enquiries.status', 1]])
			->Where(function ($query) {
				$query->whereIn('engineer_status', [3, 4, 5, 12, 14])
					->orWhereNull('engineer_status');
			})
			->leftjoin('engineer_statuses', 'engineer_statuses.id', '=', 'enquiries.engineer_status')
			->leftjoin('regions', 'regions.id', '=', 'enquiries.region_id')
			->orderBy('enq_reminder_date', 'asc')->take(20)->get();
			
    /* updated vikas showing hold status on dashboard 2-02-2023 : start   */ 
		$data['enquiries_on_hold'] = Enquiry::select(
			'enquiries.id',
			'enquiries.enq_no',
			'regions.region_name',
			'enquiries.enq_reminder_date',
			'enquiries.enq_register_date',
			'enquiries.client_name',
			'engineer_statuses.engineer_status_name',

		)
			->where([['enquiries.engineer_id', $user_id], ['enquiries.status', 1]])
			->Where(function ($query) {
				$query->whereIn('engineer_status', [15]);
						
				})
				->leftjoin('engineer_statuses', 'engineer_statuses.id', '=', 'enquiries.engineer_status')
				->leftjoin('regions', 'regions.id', '=', 'enquiries.region_id')
				->orderBy('enq_reminder_date', 'asc')->take(20)->get();
    /* updated vikas showing hold status on dashboard 2-02-2023 : end   */
        
        // PO needs action table
        $data['total_mapped_po'] = Mipo::where([['engineer_id', $user_id], ['status', 1]])->count();
        $data['po_mapped_today'] = Mipo::where([['engineer_id', $user_id], ['status', 1],['po_recv_date',today()]])->count();
        $data['po_need_action'] = Mipo::with( 'region')
            ->where([['engineer_id',$user_id],['status',1],['engg_approval_status','pending'],['engg_document_upload_dt',null]])
            ->whereBetween('created_at', [now()->subDays(3), now()])
            ->orderByDesc('created_at')
            ->get();
        $data['totalMipoProcess'] = Mipo::where([
            ['status', 1],
            ['engineer_id', $user_id],
        ])
            ->whereRaw('(ci_approval_status = "pending" 
        OR engg_approval_status = "pending" 
        OR commercial_approval_status = "pending" 
        OR head_engg_approval_status = "pending"
        OR order_sheet_approval_status = "pending"
        OR management_approval_status = "pending"'
                .('is_frp == 1' ? ' OR purchase_approval_status = "pending"' : '')
                .')')
            ->count();
        $data['totalMipoComplete'] = Mipo::where([
            ['status', 1], ['engineer_id', $user_id], ['mipo_status', getMipoStatusId('POC')],
        ])
            ->count();

        return view('backend/dashboard/'.$dashboard_view, $data);
    }


	private function typistDashboard($user_id)
	{
		$todays_date = Carbon::parse(now())->format('Y-m-d');
		$dashboard_view = 'typist_dashboard';
		$data['enquiries_mapped_today'] = Enquiry::where([['estimated_date', $todays_date], ['typist_id', $user_id], ['typist_status', NULL], ['status', 1]])->whereIn('engineer_status', [1, 2])->count();
		$data['enquiries_completed_today'] = Enquiry::where([['typist_completed_date', $todays_date], ['typist_id', $user_id], ['typist_status', '!=', NULL], ['status', 1]])->whereIn('engineer_status', [1, 2])->count();
		$data['enquiries_due_today'] = Enquiry::where([['enq_due_date', $todays_date], ['typist_id', $user_id], ['typist_status', NULL], ['status', 1]])->whereIn('engineer_status', [1, 2])->count();
		$data['enquiries_need_action'] = Enquiry::with('admin', 'region')->where([['typist_status', NULL], ['typist_id', $user_id], ['status', 1]])->whereIn('engineer_status', [1, 2])->orderBy('enq_due_date', 'asc')->take(20)->get();
		return view('backend/dashboard/' . $dashboard_view,  $data);
	}


	private function allocatorDashboard($user_id)
	{
		$todays_date = Carbon::parse(now())->format('Y-m-d');
		$yesterdays_date = Carbon::parse(now()->subDays(1))->format('Y-m-d');
		$tommorows_date = Carbon::parse((now()->addDays(1)))->format('Y-m-d');
		$dashboard_view = 'allocation_dashboard';
		$data['total_allocated_enquiries'] = Enquiry::where([['allocator_id', $user_id], ['status', 1], ['allocation_date', '!=', null]])->count();
		$data['enquiries_allocated_today'] = Enquiry::where([['allocation_date', $todays_date], ['allocator_id', $user_id], ['status', 1]])->count();
		$data['enquiries_pending_allocation'] = Enquiry::where([['allocation_date', null], ['category_id', '!=', 0], ['allocation_status', null], ['status', 1]])
			// ->whereNotIn('allocation_status', [1])

			->count();
		$data['enquiries_need_action'] = Enquiry::with('admin', 'region', 'category')->where([['allocation_date', null], ['category_id', '!=', 0], ['allocation_status', null], ['status', 1]])
			// ->whereNotIn('allocation_status', [1])
			->orderBy('enq_register_date', 'asc')->take(20)->get();
		return view('backend/dashboard/' . $dashboard_view,  $data);
	}
	// 	SELECT * FROM (select count(enquiries.id) as count, engineer_status_name from `engineer_statuses` RIGHT join `enquiries` on `engineer_statuses`.`id` = `enquiries`.`engineer_status`
	// group by  `engineer_status`
	// UNION
	// SELECT 0,engineer_status_name FROM engineer_statuses) AS ENQ
	// group by  `engineer_status_name`;


	private function adminDashboard($user_id)
    {

        $todays_date = Carbon::parse(now())->format('Y-m-d');
        $dashboard_view = 'admin_dashboard';
        $data['sales_id'] = $user_id;
        // print_r($data['allocator_id']);exit;
        $data['total_enquiries'] = Enquiry::where([['enquiries.status', 1]])->count();
        $data['enquiry_added_today'] = Enquiry::where([
            ['enq_register_date', $todays_date], ['enquiries.status', 1],
        ])->count();
        $data['total_staff'] = Admin::all()->count();
        $data['total_active_staff'] = Admin::where([['status', 1]])->count();
        $data['overallMipoCount'] = Mipo::where('status', 1)->count();
        $data['addedTodayMipo'] = Mipo::where([['status', 1], ['created_at', Carbon::today()->startOfDay()]])->count();
        $data['totalMipoRejection'] = Mipo::where('status', 1)
            ->whereRaw('(ci_approval_status = "rejected" 
                OR engg_approval_status = "rejected" 
                OR commercial_approval_status = "rejected" 
                OR purchase_approval_status = "rejected" 
                OR head_engg_approval_status = "rejected"
                OR order_sheet_approval_status = "rejected"
                OR management_approval_status = "rejected"
                )')
            ->count();
        $data['totalMipoComplete'] = Mipo::where([['status', 1], ['mipo_status', getMipoStatusId('POC')]])
            ->count();

        return view('backend/dashboard/'.$dashboard_view, $data);
    }
	private function generalDashboard($user_id)
	{

		$todays_date = Carbon::parse(now())->format('Y-m-d');
		$dashboard_view = 'index';
		$data['sales_id'] = $user_id;
		// print_r($data['allocator_id']);exit;
		$data['total_enquiries'] = Enquiry::where([['enquiries.status', 1]])->count();
		$data['enquiry_added_today'] = Enquiry::where([['enq_register_date', $todays_date], ['enquiries.status', 1]])->count();
		return view('backend/dashboard/' . $dashboard_view,  $data);
	}

    /**
     * @param $user_id
     * Mipo User  dashboard
     *
     * @return Application|Factory|View
     */
    private function mipoDashboard($user_id)
    {
        $dashboard_view = 'mipo_dashboard';
        $startDate = Carbon::now()->subDays(3);
        $endDate = Carbon::now();
        $data['assingMipoUserRecords'] = Mipo::with(['region','category'])
            ->where([['mipo_user_id', $user_id], ['status', 1]])
            ->whereBetween('po_recv_date', [$startDate, $endDate])
            ->orderBy('po_recv_date', 'desc')   
            ->take(20)
            ->get();

        $data['rejectedMipoRecords'] = Mipo::with(['region','category'])
            ->where([['mipo_user_id', $user_id], ['status', 1]])
            ->whereBetween('po_recv_date', [$startDate, $endDate])
            ->where(function ($query) {
                $query->orWhere('ci_approval_status', 'rejected')
                    ->orWhere('engg_approval_status', 'rejected')
                    ->orWhere('commercial_approval_status', 'rejected')
                    ->orWhere('purchase_approval_status', 'rejected')
                    ->orWhere('head_engg_approval_status', 'rejected');
            })
            ->orderBy('po_recv_date', 'desc')
            ->get();

        $getMipouserData = Mipo::where('mipo_user_id', $user_id);
        $data['totalMipoCount'] = $getMipouserData->count();
        $data['todayMipoCount'] = $getMipouserData->where('po_recv_date',
            Carbon::now()->format('Y-m-d'))->count();

        return view('backend/dashboard/'.$dashboard_view, $data);
    }

    private function designEngineerDashboard($user_id)
    {
        $dashboard_view = 'design_engineer_dashboard';

        $data['total_mapped_po'] = Mipo::where([['drawing_id', $user_id], ['status', 1]])->count();
        $data['po_mapped_today'] = Mipo::where([['drawing_id', $user_id], ['status', 1],['po_recv_date',today()]])->count();
        $data['po_need_action'] = Mipo::with( 'region')
            ->where([['drawing_id',$user_id],['status',1],['drawing_approval_status','pending'],['drawing_document_upload_dt',null]])
            ->whereBetween('created_at', [now()->subDays(3), now()])
            ->orderByDesc('created_at')
            ->get();
        $data['totalMipoProcess'] = Mipo::where([
            ['status', 1],
            ['drawing_id', $user_id],
        ])
            ->whereRaw('(ci_approval_status = "pending" 
        OR engg_approval_status = "pending" 
        OR commercial_approval_status = "pending" 
        OR head_engg_approval_status = "pending"
        OR order_sheet_approval_status = "pending"
        OR management_approval_status = "pending"'
                .('is_frp == 1' ? ' OR purchase_approval_status = "pending"' : '')
                .')')
            ->count();
        $data['totalMipoComplete'] = Mipo::where([
            ['status', 1], ['drawing_id', $user_id], ['mipo_status', getMipoStatusId('POC')],
        ])
            ->count();

        return view('backend/dashboard/'.$dashboard_view, $data);
    }

    private function commercialDashboard($user_id)
    {
        $dashboard_view = 'commercial_dashboard';
        $data['total_mapped_po'] = Mipo::where([['commercial_id', $user_id], ['status', 1]])->count();
        $data['po_mapped_today'] = Mipo::where([
            ['commercial_id', $user_id], ['status', 1], ['po_recv_date', today()],
        ])->count();
        $data['po_need_action'] = Mipo::with('region')
            ->where([
                ['commercial_id', $user_id], ['status', 1], ['commercial_approval_status', 'pending'],
                ['commercial_document_upload_dt', null],
            ])
            ->whereBetween('created_at', [now()->subDays(3), now()])
            ->orderByDesc('created_at')
            ->get();

        $data['totalMipoProcess'] = Mipo::where([
            ['status', 1],
            ['commercial_id', $user_id],
        ])
            ->whereRaw('(ci_approval_status = "pending" 
        OR engg_approval_status = "pending" 
        OR commercial_approval_status = "pending" 
        OR head_engg_approval_status = "pending"
        OR order_sheet_approval_status = "pending"
        OR management_approval_status = "pending"'
                .('is_frp == 1' ? ' OR purchase_approval_status = "pending"' : '')
                .')')
            ->count();
        $data['totalMipoComplete'] = Mipo::where([
            ['status', 1], ['commercial_id', $user_id], ['mipo_status', getMipoStatusId('POC')],
        ])
            ->count();

        return view('backend/dashboard/'.$dashboard_view, $data);
    }

    private function purchaseTeamDashboard($user_id)
    {
        $dashboard_view = 'purchase_team_dashboard';
        $data['total_mapped_po'] = Mipo::where([['purchase_id', $user_id], ['status', 1]])->count();
        $data['po_mapped_today'] = Mipo::where([
            ['purchase_id', $user_id], ['status', 1], ['po_recv_date', today()],
        ])->count();
        $data['po_need_action'] = Mipo::with('region')
            ->where([
                ['purchase_id', $user_id], ['status', 1], ['purchase_approval_status', 'pending'],
                ['purchase_document_upload_dt', null],
            ])
            ->whereBetween('created_at', [now()->subDays(3), now()])
            ->orderByDesc('created_at')
            ->get();


        $data['totalMipoProcess'] = Mipo::where([
            ['status', 1],
            ['purchase_id', $user_id],
        ])
            ->whereRaw('(ci_approval_status = "pending" 
        OR engg_approval_status = "pending" 
        OR commercial_approval_status = "pending" 
        OR head_engg_approval_status = "pending"
        OR order_sheet_approval_status = "pending"
        OR management_approval_status = "pending"'
                .('is_frp == 1' ? ' OR purchase_approval_status = "pending"' : '')
                .')')
            ->count();
        $data['totalMipoComplete'] = Mipo::where([
            ['status', 1], ['purchase_id', $user_id], ['mipo_status', getMipoStatusId('POC')],
        ])
            ->count();

        return view('backend/dashboard/'.$dashboard_view, $data);
    }
}
