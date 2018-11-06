<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>咕啦体育-刮刮彩管理系统</title>
        <!--easyui-->
		<link rel="stylesheet" href="/easyui/themes/super/css/font-awesome.min.css">
		<link rel="stylesheet" href="/easyui/themes/super/superBlue.css" id="themeCss">
        <link rel="stylesheet" href="/easyui/themes/icon.css">
		<script src="/easyui/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="/easyui/js/jquery.easyui.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="/easyui/extensions/superDemo.js" type="text/javascript" charset="utf-8"></script>
        <!--非easyui-->
        <link rel="stylesheet" href="/css/left-nav.css">

	</head>
	<body id="main" class="easyui-layout">
<!--    background: url(/images/link-bg.png) center no-repeat;-->
		<div data-options="region:'north',border:true" class="super-north" style="border: none;">
            <?php include("head.php");?>
		</div>
		<div data-options="region:'west',border:false,split:true"  style="width: 200px;background: #3C3F41; font-size: 14px">
            <?php include("left.php");?>
		</div>
		</div>
		<div data-options="region:'center'" style="padding-top: 2px;z-index: 1">
			<!--主要内容-->
			<div id="tt" class="easyui-tabs" data-options="border:false,fit:true">
				<div title="首页" data-options="iconCls:'fa fa-home'">
<!--                    --><?php //include("user_info.php") ?>
				</div>
			</div>
		</div>
<!--		<div data-options="region:'south'" class="super-south">-->
<!--			<!--页脚-->-->
<!--			<div class="super-footer-info">-->
<!--				<span><i class="fa fa-info-circle"></i> 作者：咕啦体育</span>-->
<!--				<span><i class="fa fa-copyright"></i> CopyRight 2018 版权所有 <i class="fa fa-caret-right"></i></span>-->
<!--			</div>-->
<!--		</div>-->

		<!--主题设置弹窗-->
		<div id="win">
			<div class="themeItem">
				<ul>
					<li>
						<div class="superBlue" style="background: #3498db;">blue</div>
					</li>
					<li class="themeActive">
						<div class="superGreen" style="background: #1abc9c;">green</div>
					</li>
					<li>
						<div class="superGray" style="background: #95a5a6;">gray</div>
					</li>
					<li>
						<div class="superAmethyst" style="background: #9b59b6;">amethyst</div>
					</li>
					<li>
						<div class="superBlack" style="background: #34495e;">black</div>
					</li>
					<li>
						<div class="superYellow" style="background: #e67e22;">yellow</div>
					</li>
					<li>
						<div class="superEmerald" style="background: #2ecc71;">emerald</div>
					</li>
					<li>
						<div class="superRed" style="background: #e74c3c;">red</div>
					</li>
				</ul>
			</div>
		</div>

	</body>
</html>