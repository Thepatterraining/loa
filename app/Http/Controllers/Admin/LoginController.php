<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    //登陆方法
    public function login(Request $request)
    {
        if ($input = Input::all()) {
            $code = new \Code;
            $_code = $code->get();
            if (strtoupper($input['code']) != $_code) {
                return back()->with('msg','验证码错误');
            }
//            $pa = bcrypt($input['user_pass']);
//            $da = password_verify($input['user_pass'],$pa);
            if (Auth::attempt(['user_name'=>$input['user_name'],'password'=>$input['user_pass']],true)) {
                $user = User::where('user_name',$input['user_name'])->get();
                session(['name'=>$input['user_name'],'mail'=>$user[0]->user_mail]);
                return redirect()->intended('Admin/index');
            } else {
                return back()->with('msg','用户名或密码错误');
            }
        } else {
            return view('admin.login');
        }
    }

    //验证码
    public function code()
    {
        $code = new \Code;
        $code->make();
    }

    //处理登陆
    public function loginout()
    {
        Auth::logout();
        session()->flush();
        return redirect('login');
    }
}
