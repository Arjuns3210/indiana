<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use App\Models\Admin;
use App\Models\Role;
use App\Models\user;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use App\Models\EmailNotification;
use Illuminate\Validation\Rules;

class LoginController extends Controller
{
    /**
     * Created By :Ankita Singh
     * Created On : 19 aug 2022
     * Uses : This will load login view.
     */
    public function index()
    {
        // return \App::getLocale();
        return view('backend/auth/login');
    }

    /**
     * Created By :Ankita Singh
     * Created On : 19 aug 2022
     * Uses : This will login admin user.
     * @param Request $request
     * @return Response
     */
    public function login(Request $request)
    {
        \Log::info("Logging in, starting at: " . Carbon::now()->format('H:i:s:u'));
        // print_r($request->all());exit;
        try {
            $validationErrors = $this->validateLogin($request);
            if (count($validationErrors)) {
                \Log::error("Auth Exception: " . implode(", ", $validationErrors->all()));
                return redirect()->back()->withErrors(array("msg" => implode("\n", $validationErrors->all())));
            }
            $email = trim(strtolower($request->email));

            $response = Admin::with('role')->where([['email', $email], ['password', md5($email . $request->password)]])->get();
            if (!count($response)) {
                \Log::error("User not found with this email id and password.");
                return redirect()->back()->withErrors(array("msg" => "Invalid login credentials"));
            } else {
                if ($response[0]['status'] == 1) {
                    \Log::info("Login Successful!");
                    $data = array(
                        "id" => $response[0]['id'],
                        "name" => $response[0]['admin_name'],
                        "nick_name" => $response[0]['nick_name'],
                        "email" => $email,
                        "role_id" => $response[0]['role_id'],
                        "force_pwd_change_flag" => $response[0]['force_pwd_change_flag'],
                        "pwd_expiry_date" => $response[0]['pwd_expiry_date'],
                        "permissions" => $response[0]['role']['permission']
                    );
                    $request->session()->put('data', $data);
                    return redirect('webadmin/dashboard');
                } else {
                    \Log::error("Account Suspended.");
                    return redirect()->back()->withErrors(array("msg" => "Your account is deactivated."));
                }
            }
        } catch (\Exception $e) {
            \Log::error("Login failed: " . $e->getMessage());
            return redirect()->back()->withErrors(array("msg" => "Something went wrong"));
        }
    }
    /**
     * Validates input login
     *
     * @param Request $request
     * @return Response
     */
    public function validateLogin(Request $request)
    {
        return \Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ])->errors();
    }

    /**
     * Display the password reset link request view.
     *
     * @return \Illuminate\View\View
     */
    public function forgotPassword(Request $request)
    {
        return view('backend/auth/forgot-password');
    }


    /**
     * created by : Maaz 
     * created at : 5/08/2022
     * uses : To generate password reset email link 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function forgotPasswordStore(Request $request)
    {
        $table = 'admins';
        $password_reset_table = 'password_resets';

        $request->validate([
            'email' => 'required|email|exists:' . $table . ',email',
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.

        $email = trim(strtolower($request->email));
        $token = Str::random(60);
        
        DB::table($password_reset_table)->updateOrInsert(
            [
                'email' => $email,
                'token' => $token,
                'created_at' => Carbon::now(),
            ],
            [
                'email'   => $email,
            ]
        );
        $action_link =  URL::temporarySignedRoute(
            'password.reset',
            now()->addHours(48),
            ['token' => $token,
            'email' => $email]
        );

        $adminData = Admin::where('email', $email)->first();
        $emailData = EmailNotification::where([['mail_key', 'FORGOT_PASSWORD'], ['user_type', 'all'], ['status', 1]])->first();

        $subjects = $emailData['subject'] ?? '';
        $admin_name = $adminData['admin_name'];
        $url = $action_link;
        $from_name = $emailData['from_name'] ?? '';

        $emailData['content'] = str_replace('$$admin_name$$', $admin_name, $emailData['content'] ?? '');
        $emailData['content'] = str_replace('$$url$$', $url, $emailData['content']);
        $emailData['content'] = str_replace('$$from_name$$', $from_name, $emailData['content']);
        $content =  htmlspecialchars_decode(stripslashes($emailData['content'])); 
        
        if(config('global.TRIGGER_CUSTOM_EMAIL'))
        Mail::send('backend/auth/email-forgot', ['body' => $content], function ($message) use ($email) {
            $message->from('noreply@indianagroup.com', 'Indiana Team');
            $message->to($email, 'Indiana Team')->subject('Forgot Password - Indiana Team');
        });
        return back()->with('status', __('passwords.sent'));
    }

    /**
     * created by : Maaz Ansari
     * created at ; 5/08/2022
     * uses : Return to password reset page or 404 not found page
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function passwordReset(Request $request)
    {
        $token = $request->token;
        $password_reset_table = 'password_resets';
        $check_token = DB::table($password_reset_table)->where(['token' => $token])->first();
        if (!$check_token) {
            return view('backend/auth/page-not-found');
        }
        return view('backend/auth/reset-password', ['request' => $request]);
    }


    /**
     * Handle an incoming new password request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function passwordUpdate(Request $request)
    {
        $msg_data = array();
        $is_user = $request->c;
        $password_reset_table = 'password_resets';
        if ($is_user) {
            $password_reset_table = 'user_password_resets';
        }
        $request->validate([
            'token' => ['required'],
            'email' => 'required|email|exists:' . $password_reset_table . ',email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $email = trim(strtolower($request->email));
        $token = $request->token;
        $check_token = DB::table($password_reset_table)->where(['email' => $email, 'token' => $token])->first();
        if (!$check_token) {
            return  back()->withInput($request->only('email'))
                ->withErrors(['email' => __('passwords.token')]);
        }
        if ($is_user) {
            User::where('email', $email)->update([
                'password' => md5($email . $request->password),
            ]);
            DB::table($password_reset_table)->where(['email' => $email])->delete();
            return redirect()->route('')->with('status', __('passwords.reset'));
            return redirect()->route('password.request')->with('status', __('passwords.reset'));
            // return back()->with('status', __('passwords.reset'));
        } else {
            Admin::where('email', $email)->update([
                'password' => md5($email . $request->password),
            ]);
            DB::table($password_reset_table)->where(['email' => $email])->delete();
            return redirect()->route('login')->with('status', __('passwords.reset'));
        }
    }
}
