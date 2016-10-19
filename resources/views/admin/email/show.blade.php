@extends('layouts.admin')
@section('content')
        <!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="{{url('Admin/info')}}">首页</a> &raquo; 写邮件
</div>
<!--面包屑导航 结束-->

<!--结果集标题与导航组件 开始-->
<div class="result_wrap">
    <div class="result_title">
        <h3>添加公告</h3>
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
            <a href="{{url('Admin/email/sent')}}"><i class="fa fa-recycle"></i>发件箱</a>
            <a href="{{url('Admin/email/read')}}"><i class="fa fa-recycle"></i>收件箱</a>
        </div>
    </div>
</div>
<!--结果集标题与导航组件 结束-->

<div class="result_wrap">
    <form action="{{url('Admin/email/write')}}" method="post">
        {{csrf_field()}}
        <table class="add_tab">
            <tbody>
            <tr>
                <th><i class="require">*</i> 标题：</th>
                <td>
                    <input type="text" class="lg" name="mail_title" value="{{$data->mail_title}}">
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i> 发件人：</th>
                <td>
                    <input type="text" class="lg" name="mail_formname" value="{{$data->mail_formname}}">
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i> 收件人：</th>
                <td>
                    <input type="text" class="lg" name="mail_toaddr" value="{{$data->mail_toaddr}}">
                </td>
            </tr>
            @if($data->mail_filename != "")
            <tr>
                <th>附件：</th>
                <td>
                    <input type="text" size="50" name="mail_filename" value="{{$data->mail_filename}}">
                    <a href='javascript:;' data="{$data->mail_id}" class="download">【下载】</a>
                </td>
            </tr>
            @endif
            <tr>
                <th>内容：</th>
                <td>
                    <script type="text/javascript" charset="utf-8" src="{{asset('resources/org/ueditor/ueditor.config.js')}}"></script>
                    <script type="text/javascript" charset="utf-8" src="{{asset('resources/org/ueditor/ueditor.all.min.js')}}"> </script>
                    <script type="text/javascript" charset="utf-8" src="{{asset('resources/org/ueditor/lang/zh-cn/zh-cn.js')}}"></script>
                    <script id="editor" name="mail_content" type="text/plain" style="width:860px;height:500px;">
                        {!! $data->mail_content !!}
                    </script>
                    <script type="text/javascript">
                        var ue = UE.getEditor('editor');
                    </script>
                    <style>
                        .edui-default{line-height: 28px;}
                        div.edui-combox-body,div.edui-button-body,div.edui-splitbutton-body
                        {overflow: hidden; height:20px;}
                        div.edui-box{overflow: hidden; height:22px;}
                    </style>
                </td>
            </tr>

            <tr>
                <th></th>
                <td>
                    <input type="button" class="back" onclick="history.go(-1)" value="返回">
                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div>
<script language="javascript">
$(function(){
//给下载按钮添加点击事件
$('.download').on('click',function(){
//事件处理程序
var id = $(this).attr('data');//获取下载附件id
    alert(id)
window.location.href = 'loa.com/Admin/email/download/' + id;//跳转方法
})
</script>
@endsection
