<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Article;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ArticleController extends CommonController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Article::orderBy('art_id','desc')->paginate(10);
        //展示部门列表，传递data参数
        return view('admin.article.index',compact(['data']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.article.add');
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
            'art_title'=>'required', //验证规则
            'art_content'=>'required', //验证规则
        ];
        $message = [
            //验证不成功的返回提示
            'art_title.required'=>'公告标题不能为空！',
            'art_content.required'=>'公告内容不能为空！',
        ];
        $validator = Validator::make($input,$rules,$message);
        if ($validator->passes()) {
            $input['art_auth'] = session('name');
            $input['art_time'] = time();
            //执行添加
            $rst = Article::create($input);
            if ($rst) { //添加成功
                //跳转到部门列表
                return redirect('Admin/article');
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
        $field = Article::find($id);
        return view('admin.article.show',compact(['field']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $field = Article::find($id);
        return view('admin.article.edit',compact(['field']));
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
        $rst = Article::where('art_id',$id)->update($input);
        if ($rst) {
            return redirect('Admin/article');
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
    public function destroy($id)
    {
        $rst = Article::where('art_id',$id)->delete();
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
