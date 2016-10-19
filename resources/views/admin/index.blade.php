@extends('layouts.admin')
@section('content')
		<!--头部 开始-->
<div class="top_box">
	<div class="top_left">
		<div class="logo">后台管理模板</div>
		<ul>
			<li><a href="{{url('Admin/index')}}" class="active">首页</a></li>
			<li><a href="{{url('Admin/info')}}" target="main">管理页</a></li>
		</ul>
	</div>
	<div class="top_right">
		<ul>
			<li>管理员：{{session('name')}}</li>
			<li><a href="{{url('Admin/pass')}}" target="main">修改密码</a></li>
			<li><a href="{{url('Admin/loginout')}}">退出</a></li>
		</ul>
	</div>
</div>
<!--头部 结束-->

<!--左侧导航 开始-->
<div class="menu_box">
	<ul>
		<li>
			<h3><i class="fa fa-fw fa-clipboard"></i>内容管理</h3>
			<ul class="sub_menu">
				<li><a href="{{url('Admin/Dept')}}" target="main"><i class="fa fa-fw fa-list-ul"></i>部门管理</a></li>
				<li><a href="{{url('Admin/user')}}" target="main"><i class="fa fa-fw fa-list-ul"></i>职员管理</a></li>
				<li><a href="{{url('Admin/article')}}" target="main"><i class="fa fa-fw fa-list-ul"></i>公告管理</a></li>
			</ul>
		</li>
		<li>
			<h3><i class="fa fa-fw fa-cog"></i>邮件管理</h3>
			<ul class="sub_menu" style="display: block;">
				<li><a href="{{url('Admin/email/write')}}" target="main"><i class="fa fa-fw fa-cubes"></i>写邮件</a></li>
				<li><a href="{{url('Admin/email/read')}}" target="main"><i class="fa fa-fw fa-navicon"></i>收件箱</a></li>
				<li><a href="{{url('Admin/email/sent')}}" target="main"><i class="fa fa-fw fa-cogs"></i>已发送邮件</a></li>
			</ul>
		</li>
	</ul>
</div>
<!--左侧导航 结束-->

<!--主体部分 开始-->
<div class="main_box">
	<iframe src="{{url('Admin/info')}}" frameborder="0" width="100%" height="100%" name="main"></iframe>
</div>
<!--主体部分 结束-->

<!--底部 开始-->
<div class="bottom_box">
	CopyRight © 2015. Powered By <a href="http://www.houdunwang.com">http://www.houdunwang.com</a>.
</div>
<!--底部 结束-->

@endsection


