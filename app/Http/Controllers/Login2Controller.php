<?php

namespace App\Http\Controllers;
use DB;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use App\Role;

class Login2Controller extends Controller
{

    /* @GET
     */
    public function loginForm()
    {
        $title = " Manage Users";
        return view('login',compact('title'));
    }

    /* @POST
     */
    public function login(Request $request){
//	    dd('here');
        if ((\Auth::attempt([
                'email' => $request->email,
                'password' => $request->password])
            ) || (\Auth::attempt([
                'username' => $request->email,
                'password' => $request->password])
            )){

            $role = DB::connection('DB_CFG')
                ->table('user_groups')
                ->join('users', 'users.role_id', '=', 'user_groups.id')
                ->select('user_groups.*')
                ->where('users.username', $request->email)
                ->orWhere('users.email', $request->email)
                ->first();

            setcookie('username', $request->email, time() + (86400 * 30), "/");
            setcookie('role', $role->name, time() + (86400 * 30), "/");
            setcookie('menu', $role->role, time() + (86400 * 30), "/");
            return redirect('/');

        }
        return redirect('/login')->with('error', "Login Error : Username or Password not match");
    }
    /* GET
    */
    public function logout(Request $request)
    {
        if(\Auth::check())
        {
            \Auth::logout();
            $request->session()->invalidate();
            setcookie('username', $request->email, time()  - 3600);
            setcookie('role', $role->name, time()  - 3600);
            setcookie('menu', $role->role, time()  - 3600);
        }
        return  redirect('/login');
    }
}
