<!--<!DOCTYPE html>-->
<!--<html lang="zh">-->
<!--<head>-->
<!--	<meta charset="UTF-8">-->
<!--	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> -->
<!--	<meta name="viewport" content="width=device-width, initial-scale=1.0">-->
<!--	<title>咕啦即开管理系统</title>-->
<!--	<link href="http://cdn.bootcss.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">-->
<!--	<link rel="stylesheet" type="text/css" href="/css/htmleaf-demo.css">-->
<!--    <script src="/easyui/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>-->
<!--    <script src="/easyui/js/jquery.easyui.min.js" type="text/javascript" charset="utf-8"></script>-->
<!--</head>-->
<body>
	<div class="htmleaf-container">
		<header class="htmleaf-header">
			<h1>欢迎来到即开管理系统</h1>
		</header>
		<div class="signin">
			<div class="signin-head"><img src="/images/login/test/head_120.png" alt="" class="img-circle"></div>
			<!-- <div class="signin-head"><h3>请登录</h3></div> -->
            <form  class="form-signin" onsubmit="return false">
				<input type="text" name="admin_name" class="form-control" placeholder="用户名" required autofocus />
				<input type="password" name="admin_pwd" class="form-control" placeholder="密码" required />
                <span style="color: red;display: inline-block;text-align: center;width: 100%;" id="msg"></span>
				<button class="btn btn-lg btn-warning btn-block" onclick="login()">登录</button>
				<label class="checkbox">
					<input type="checkbox" value="remember-me"> 记住我
				</label>
			</form>
		</div>
	</div>
</body>
<script>
    function login() {
        var admin_name = $('input[name="admin_name"]').val();
        var admin_pwd = $('input[name="admin_pwd"]').val();
        $("#msg").html("");
        $.ajax({
            url: '/adminmod/admin/login',
            header:{
                contentType: 'application/x-www-form-urlencoded'
            },
            async: false,
            type: 'post',
            data:{'admin_name':admin_name,'admin_pwd':admin_pwd},
            dataType: 'json',
            success: function (data) {
                if(data["code"]!=600){
                    $("#msg").html(data["msg"])
                }else{
                    location.href = "/mainmod/main/index";
                }
            }
        });
    }
</script>
</html>