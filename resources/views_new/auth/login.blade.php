<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<title>登录</title>
		<link rel="stylesheet" type="text/css" href="/index/common/css/com-css.css"/>
		<link rel="stylesheet" type="text/css" href="/login/login.css"/>
		
		<script src="/index/common/js/jQuery-1.8.3.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="/login/placeholder.js" type="text/javascript" charset="utf-8"></script>
		<script src="/login/login.js" type="text/javascript" charset="utf-8"></script>
	</head>

	<body>
		<div class="big-container" style="background-color: #FFFFFF;">
			<!--头部开始-->
			@include('layout.auth_header')
			<!--头部结束-->

			<!--表单开始-->
			<form action="http://www.mingheyaoye.com/auth/login" method="post" id="form">
				<input type="hidden" name="_token" value="1Rmxv6hdCXovo6EaiMt3V3xJTqsrtRogj7jvtLI2">
				<div class="site-content">
					<div class="content-box">

						<div class="right">
							<div class="right-title fn_clear">
								登录
							</div>

							<p class="input-box">
								<span class="ico"></span><label for="username"> <span class="codes2"
																					  style="display: block;">用户名或手机号</span>
									<input class="username txt" id="username" name="user_name" type="text"
										   style="color: rgb(51, 51, 51);"></label>
								<span class="prompt2">请输入用户名或手机号</span>
							</p>
							<p class="input-box"><span class="ico pas"></span> <label for="password"> <span class="codes"
																											style="display: block;">密　码</span>
									<input class="password txt" id="password" name="password" type="password"
										   style="color: rgb(51, 51, 51);"></label>
								<span class="prompt2">请输入密码</span>
							</p>
							
							<div class="box clearfix">
								<span>
									<i class="check_box"></i>
									<input style="display: none;" type="checkbox" value="1" name="remember" id="remember">
									&nbsp;&nbsp;记住密码
								</span>
								<a href="http://47.107.103.86/password/email">忘记密码</a>
							</div>

							<a href="javascript:void(0)" class="login">登　录</a>
							
							<div style="height: 1px;width: 274px;margin: 20px auto 0;background-color: #B7B7B7;"></div>
							<input type="hidden" name="act" class="act" value="ajax_act_login">
							<input type="hidden" name="back_act" class="back_act" value="/index.php">
							
							<a href="{{url('/xin/register/old')}}" style="color: #0090D2;font-size: 12px;width: 274px;margin: 19px auto 0;display: block;text-align: right;">立即注册 >></a>
						</div>

					</div>

				</div>

			</form>
			<!--表单结束-->

			<!--footer开始-->
			@include('layout.auth_footer')
			<!--footer结束-->
		</div>
	</body>

</html>