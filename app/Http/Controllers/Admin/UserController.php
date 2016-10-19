<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Dept;
use App\Http\Model\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class UserController extends CommonController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('user')
                ->leftjoin('dept','user.dept_id','=','dept.dept_id')
                ->get();
        //展示部门列表，传递data参数
        return view('admin.user.index',compact(['data']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Dept::all(); //获取所有职员
        //展示部门列表，传递data参数
        return view('admin.user.add',compact(['data']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //获取除了_token以外的值
        $input = Input::except('_token');
        $rules = [
            'user_truename'=>'required', //验证规则
            'password'=>'required', //验证规则
        ];
        $message = [
            //验证不成功的返回提示
            'user_truename.required'=>'职员姓名不能为空！',
            'password.required'=>'职员密码不能为空！',
        ];
        $validator = Validator::make($input,$rules,$message);
        if ($validator->passes()) {
            //执行添加
            $input['password'] = bcrypt($input['password']);
            $rst = User::create($input);
            if ($rst) { //添加成功
                //跳转到部门列表
                return redirect('Admin/user');
            } else { //添加失败
                //返回添加页面
                return back()->with('errors','添加失败');
            }
        } else {
            return back()->withErrors($validator);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $field = User::find($id);
        $data = Dept::all();
        return view('admin.user.edit',compact(['data','field']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $input = Input::except('_method','_token');
        $rst = User::where('id',$id)->update($input);
        if ($rst) {
            return redirect('Admin/user');
        } else {
            return back()->with('errors','修改失败，请重试');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id)
    {
        $rst = User::where('id',$user_id)->delete();
        if ($rst) {
            $data = [
                'status' => 0,
                'msg' => '删除成功',
            ];
        } else {
            $data = [
                'status' => 1,
                'msg' => '删除失败，请重试',
            ];
        }
        return $data;
    }
}
