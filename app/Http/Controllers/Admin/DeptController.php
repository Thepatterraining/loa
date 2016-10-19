<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Dept;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class DeptController extends CommonController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = (new Dept)->tree();
        //展示部门列表，传递data参数
        return view('admin.dept.index',compact(['data']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Dept::all(); //获取所有部门
        //展示部门列表，传递data参数
        return view('admin.dept.add',compact(['data']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        //获取除了_token以外的值
        $input = Input::except('_token');
        $rules = [
            'dept_name'=>'required', //验证规则
        ];
        $message = [
            //验证不成功的返回提示
            'dept_name.required'=>'部门名称不能为空！',
        ];
        $validator = Validator::make($input,$rules,$message);
        if ($validator->passes()) {
            //执行添加
            $rst = Dept::create($input);
            if ($rst) { //添加成功
                //跳转到部门列表
                return redirect('Admin/Dept');
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
        $field = Dept::find($id);
        $data = Dept::where('dept_pid',0)->get();
        return view('admin.dept.edit',compact(['data','field']));
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
        $rst = Dept::where('dept_id',$id)->update($input);
        if ($rst) {
            return redirect('Admin/Dept');
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
    public function destroy($dept_id)
    {
        $rst = Dept::where('dept_id',$dept_id)->delete();
        $rs = Dept::where('dept_pid',$dept_id)->update('dept_pid',0);
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

    //排序方法
    public function changeOrder()
    {
        $input = Input::all();
        $cate = Dept::find($input['dept_id']);
        $cate->dept_sort = $input['dept_sort'];
        $re = $cate->update();
        if($re){
            $data = [
                'status' => 0,
                'msg' => '部门排序更新成功！',
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '部门排序更新失败，请稍后重试！',
            ];
        }
        return $data;
    }
}
