<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Crypt;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function login()
    {
        return view('admin.auth.login');
    }

    public function index()
    {
        if(Session::get('pos_log_user_type') == "Admin")
        {
            return redirect('/admin/dashboard');
        }
        else
        {
            return redirect('/user/dashboard');
        }
    }

    public function AdminDashboard()
    {
        return view('admin.pages.admin_dashboard');
    }

    public function UserDashboard()
    {
        return view('user.pages.user_dashboard');
    }

    public function login_process(Request $request)
    {
        $request->validate([
            'user_name' => 'required',
            'login_password' => 'required',
        ]);

        $result = DB::table('users')
            ->where(['user_name' => $request->user_name])
            ->get();


        if (isset($result[0])) {

            $db_pwd = Crypt::decryptString($result[0]->password);

            $status = $result[0]->status;

            if ($status == "0") {
                $request->session()->flash('error', "Your account has been deactivated");
                return redirect()->back()->with('fail','Your account has been deactivated.');
            }

            if ($db_pwd == $request->login_password) {

                $user_type = UserType::where('id',$result[0]->user_types_id)->get(['id','type']);

                //put sessions
                $request->session()->put('CM_FRONT_USER_LOGIN', true);
                $request->session()->put('pos_log_user', $result[0]->id);
                $request->session()->put('pos_log_user_type', $user_type[0]->type);
                $request->session()->put('pos_log_user_email', $result[0]->email);
                $request->session()->put('pos_log_user_name', $result[0]->full_name);

                if($user_type[0]->user_type == "Admin")
                {
                    return redirect('/admin/dashboard');
                }
                else
                {
                    return redirect('/');
                }

            } else {
                return back()->with('fail','User Name or Password not matches.');
            }

        } else
        {
            $request->session()->flash('error', "This User Name is not registered");
            return back()->with('fail','This User Name is not registered.');
        }
    }

    public function logout(){
        if(Session::has('pos_log_user')){
           Session::pull('pos_log_user');
           Session::pull('pos_log_user_type');
           Session::pull('pos_log_user_email');
           Session::pull('pos_log_user_name');
           session()->forget('CM_FRONT_USER_LOGIN');
           return redirect('/login');
        }
    }
}
