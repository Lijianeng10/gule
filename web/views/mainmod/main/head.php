
<style>
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 27px;
    height: 100%;

}
.header ul {
    overflow: hidden;
    position: fixed;
    top: -150px;
    right: 20px;
    width: 155px;
    z-index: -1;
    text-align: center;
    background: linear-gradient(#4a4d77,#41558b, #2a69bd);
    /*border: 1px solid #ddd;*/
}
.header ul li {
    list-style: none;
    margin-top: -1px;
    /*border-top: 1px solid #7c93b5;*/
    line-height: 30px;
    cursor: pointer;
    color: #fff;
}
.header ul li:hover {
    background-color: #7c93b5;
}
h2 {
    font-size: 24px;
    color: #fff;
}
.box {
    /*display: flex;*/
    position: relative;
    margin-right: 20px;
    position: relative;
    height: 100%;
    cursor: pointer;
}
.icon {
    position: absolute;
    top: 50%;
    right: -20px;
    transform: translateY(-50%);
    width: 13px;
    height: 8px;
    display: inline-block;
    content: '';
    background: url(/images/icon_arror.png) no-repeat;
    background-size: 100%;
    transition: all .5s ease-in-out;
    transform-origin: 50% 0%;
}
.turn {
    transform: rotate(180deg) translateY(-50%);
}
.user {
    display: flex;
    align-items: center;
}
.user .user-img {
    width: 40px;
    height: 40px;
    margin-right: 10px;
    padding-top: 5px;
    border-radius: 50%;
}
.user h3 {
    color: #fff;
    font-size: 16px;
    font-weight: normal;
}

</style>
	<div class="header">
		<h2>谷乐账云管理系统</h2>
		<div class="box">
			<div class="user">
				<img class="user-img" src="./images/photo.jpg" alt="" title="">
				<h3><?php echo \Yii::$app->session['admin']['nickname']?></h3>
			</div>
			<i class="icon"></i>
		</div>
        <ul class="head-menu">
            <li>个人信息</li>
            <li>更换主题</li>
            <li id="logout">退出</li>
        </ul>
	</div>
<script>
	var t = true;
    $(".box").on('click', function(e) {
        var e=window.event || event;
        if(e.stopPropagation){
            e.stopPropagation();
        }
        if (t) {
            $(this).children('.icon').addClass('turn');
            $(".head-menu").stop().animate({
                "top": '49px',
            }, 500)
            t = false;
        }else {

            close($(this));

        }
    })
    function close(ele) {
        t = true;
        ele.children('.icon').removeClass('turn');
        $(".head-menu").stop().animate({
            "top": '-150px',
        }, 500)
    }
    document.onclick = function(){
        close($(".box"));
    };
    $(".head-menu").mouseleave(function(){
        close($(".box"));
    });
</script>
</html>