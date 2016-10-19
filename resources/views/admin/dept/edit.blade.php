@extends('layouts.admin')
@section('content')
        <!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="{{url('dmin/info')}}">首页</a> &raquo; 部门修改
</div>
<!--面包屑导航 结束-->

<!--结果集标题与导航组件 开始-->
<div class="result_wrap">
    <div class="result_title">
        <h3>编辑分类</h3>
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
            <a href="{{url('Admin/Dept/create')}}"><i class="fa fa-plus"></i>添加部门</a>
            <a href="{{url('Admin/Dept')}}"><i class="fa fa-recycle"></i>部门列表</a>
        </div>
    </div>
</div>
<!--结果集标题与导航组件 结束-->

<div class="result_wrap">
    <form action="{{url('Admin/Dept/'.$field->dept_id)}}" method="post">
        <input type="hidden" name="_method" value="put">
        {{csrf_field()}}
        <table class="add_tab">
            <tbody>
            <tr>
                <th width="120"><i class="require">*</i>上级部门：</th>
                <td>
                    <select name="dept_pid">
                        <option value="0">==顶级部门==</option>
                        @foreach($data as $d)
                        <option value="{{$d->dept_id}}"
                                @if($d->dept_id==$field->dept_pid) selected @endif
                        >{{$d->dept_name}}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>部门名称：</th>
                <td>
                    <input type="text" name="dept_name" value="{{$field->dept_name}}">
                    <span><i class="fa fa-exclamation-circle yellow"></i>部门名称必须填写</span>
                </td>
            </tr>
            <tr>
                <th>描述：</th>
                <td>
                    <textarea name="dept_read">{{$field->dept_read}}</textarea>
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>排序：</th>
                <td>
                    <input type="text" class="sm" name="dept_sort"  value="{{$field->dept_sort}}">
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
