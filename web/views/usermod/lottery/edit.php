<!DOCTYPE html>
<html style="height: 100%;">
	<head>
		<meta charset="UTF-8">
		<title></title>
        <!--easyui-->
        <!--        <link rel="stylesheet" href="/easyui/themes/super/css/font-awesome.min.css">-->
		<link rel="stylesheet" href="/easyui/themes/super/superBlue.css" id="themeCss">
		<script src="/easyui/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="/easyui/js/jquery.easyui.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="/easyui/locale/easyui-lang-zh_CN.js" type="text/javascript" charset="utf-8"></script>
		<script src="/easyui/extensions/curdtool.js" type="text/javascript" charset="utf-8"></script>
	</head>
    <body style="height: 100%;">
        <style type="text/css">
            .form-item {
                margin-bottom: 15px;
                width: 50%;
                float: left;
            }

            .form-item>label {
                min-width: 72px;
                display: inline-block;
            }

            .form-item input,
            select {
                width: 170px;
            }
        </style>
        <div class="super-theme-example">
            <form id="myform">
                <input type="hidden" name ="lottery_id" value="<?php echo $lotteryData['lottery_id'];?>">
                <div class="form-item">
                    <label for="" class="label-top">彩种名称：</label>
                    <input type="text" name="lottery_name" class="easyui-validatebox easyui-textbox" prompt="请输入文本" data-options="required:true,validType:'length[1,25]'" value="<?php echo $lotteryData['lottery_name'];?>" maxlength="25">
                </div>
            </form>
        </div>
    </body>
</html>