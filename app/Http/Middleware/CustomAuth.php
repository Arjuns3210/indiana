<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use DB;
use Session;

class CustomAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(session()->has('data'))
        {
            $id = session('data')['role_id'];
            $data['data'] = session('data');
            $roleData = Role::find($id);
            if($roleData) {
                $role_permissions = implode(',',json_decode($roleData['permission'],true));
            }
            if(empty($role_permissions)) {
                $role_permissions = 0;
            }
            $permissions = DB::select("SELECT codename FROM permissions where status = 'Yes' and id in (".$role_permissions.")");

            if(session('data')['force_pwd_change_flag'] == 1){
                return redirect('webadmin/force_password_change');
            }
            Session::flash('permissions', $permissions);
            return $next($request);
        } else {
            return redirect('webadmin/');
        }
    }
}
