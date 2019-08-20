<!doctype html>
<head>
	<meta charset="UTF-8">
	<title>谷乐账云管理系统</title>
	<link rel="stylesheet" href="/css/login/login.css">
    <script src="/easyui/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
</head>
<body>
	<div class="ji-wrap">
			<div class="contain">
				<div class="tit">
					<h3>欢迎来到</h3>
					<p>谷乐账云管理后台</p>
				</div>
				<div class="login-box">
					<h2>用户登录</h2>
					<div class="input-wrap user">
						<input type="text" placeholder="用户名/手机" name="admin_name" value="">
					</div>
					<div class="input-wrap password">
						<input type="password" id='admin_pwd' placeholder="密码" name="admin_pwd" value="">
					</div>
					<div class="attention" id="attention">
						<span id="msg" style="color: red ; font-size: 14px; "></span>
					</div>
					<button class="btn" id="login" onclick="login();">登录</button>
<!--					<label class="check-box">-->
<!--						<input type="checkbox" >-->
<!--						<span class="remember-pw">记住密码</span>-->
<!--					</label>-->
				</div>
			</div>
	</div>
<script>
    $(document).ready(
        function() {
            $("#admin_pwd").keydown(function(event) {
                if (event.keyCode == 13) {
                    login();
                }
            });
            $(".input-wrap").click(function(){
                document.getElementById('attention').style.display = 'none';
            });
        }
    );
    function login() {
        var admin_name = $('input[name="admin_name"]').val();
        var admin_pwd = $('input[name="admin_pwd"]').val();
        $.ajax({
            url: '/adminmod/admin/login',
            // header:{
            //     contentType: 'application/x-www-form-urlencoded'
            // },
            async: false,
            type: 'post',
            data:{'admin_name':admin_name,'admin_pwd':admin_pwd},
            dataType: 'json',
            success: function (data) {
                if(data["code"]!=600){
                    $("#msg").html(data["msg"])
                    document.getElementById('attention').style.display = 'block'
                }else{
                    location.href = "/mainmod/main/index";
                }
            }
        });
    };
</script>
</body>
</html>