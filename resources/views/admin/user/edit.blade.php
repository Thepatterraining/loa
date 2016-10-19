@extends('layouts.admin')
@section('content')
        <!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="{{url('Admin/info')}}">首页</a> &raquo; 修改职员
</div>
<!--面包屑导航 结束-->

<!--结果集标题与导航组件 开始-->
<div class="result_wrap">
    <div class="result_title">
        <h3>添加分类</h3>
        @if(count($errors)>0)
            <div class="mark">
                @if(is_object($errors))
                    @foreach($errors->all() as $error)
                        <p>{{$error}}</p>
                    @endforeach
                @else
                    <p>{{$errors}}</p>
                @endif
            </div>
        @endif
    </div>
    <div class="result_content">
        <div class="short_wrap">
            <a href="{{url('Admin/user')}}"><i class="fa fa-recycle"></i>职员列表</a>
        </div>
    </div>
</div>
<!--结果集标题与导航组件 结束-->

<div class="result_wrap">
    <form action="{{url('Admin/user/' . $field->id)}}" method="post">
        {{method_field('PUT')}}
        {{csrf_field()}}
        <table class="add_tab">
            <tbody>
            <tr>
                <th width="120"><i class="require">*</i>所属部门：</th>
                <td>
                    <select name="dept_id">
                        @foreach($data as $d)
                        <option value="{{$d->dept_id}}" @if($d->dept_id == $field->dept_id) selected @endif>{{$d->dept_name}}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <th>职员昵称：</th>
                <td>
                    <input type="text" name="user_name" value="{{$field->user_name}}">
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>职员姓名：</th>
                <td>
                    <input type="text" name="user_truename" value="{{$field->user_truename}}">
                    <span><i class="fa fa-exclamation-circle yellow"></i>职员姓名必须填写</span>
                </td>
            </tr>
            <tr>
                <th></th>
                <td>
                    <input type="submit" value="提交">
                    <input type="button" class="back" onclick="history.go(-1)" value="返回">
                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div>

@endsection
