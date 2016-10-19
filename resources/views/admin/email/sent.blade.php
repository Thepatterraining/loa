@extends('layouts.admin')
@section('content')
        <!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="{{url('Admin/info')}}">首页</a> &raquo; 发件箱
</div>
<!--面包屑导航 结束-->

<!--搜索结果页面 列表 开始-->
<form action="#" method="post">
    <div class="result_wrap">
        <!--快捷导航 开始-->
        <div class="result_title">
            <h3>文章列表</h3>
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('Admin/email/write')}}"><i class="fa fa-plus"></i>写邮件</a>
                <a href="{{url('Admin/email/read')}}"><i class="fa fa-recycle"></i>收件箱</a>
            </div>
        </div>
        <!--快捷导航 结束-->
    </div>

    <div class="result_wrap">
        <div class="result_content">
            <table class="list_tab">
                <tr>
                    <th class="tc">ID</th>
                    <th>标题</th>
                    <th>内容</th>
                    <th>收件人</th>
                    <th>发送时间</th>
                    <th>操作</th>
                </tr>
                @foreach($data as $v)
                <tr>
                    <td class="tc">{{$v->mail_id}}</td>
                    <td>
                        <a href="#">{{$v->mail_title}}</a>
                    </td>
                    <td>{!! mb_substr($v->mail_content,0,30) !!}</td>
                    <td>{{$v->mail_toaddr}}</td>
                    <td>{{date('Y-m-d',$v->mail_date)}}</td>
                    <td>
                        <a href="{{url('Admin/email/show/'.$v->mail_id)}}">查看</a>
                        <a href="{{url('Admin/email/edit/'.$v->mail_id)}}">修改</a>
                        <a href="javascript:;" onclick="delArt({{$v->mail_id}})">删除</a>
                    </td>
                </tr>
                @endforeach
            </table>
            <div class="page_list">
                {{$data->links()}}
            </div>
        </div>
    </div>
</form>
<!--搜索结果页面 列表 结束-->

<style>
    .result_content ul li span {
        font-size: 15px;
        padding: 6px 12px;
    }
</style>

<script>
    //删除分类
    function delArt(mail_id) {
        layer.confirm('您确定要删除这篇文章吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            $.post("{{url('Admin/email/')}}/"+mail_id,{'_method':'delete','_token':"{{csrf_token()}}"},function (data) {
                if(data.status==0){
                    location.href = location.href;
                    layer.msg(data.msg, {icon: 6});
                }else{
                    layer.msg(data.msg, {icon: 5});
                }
            });
//            layer.msg('的确很重要', {icon: 1});
        }, function(){

        });
    }
</script>

@endsection
