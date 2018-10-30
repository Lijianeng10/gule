<!DOCTYPE html>
<html style="height: 100%;">
	<head>
		<meta charset="UTF-8">
		<title></title>
		<!--easyui-->
        <link rel="stylesheet" href="/easyui/themes/super/css/font-awesome.min.css">
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
            <form id="ff" method="post">
                <div class="form-item">
                    <label for="" class="label-top">用户名：</label>
                    <input id="username" class="easyui-validatebox easyui-textbox" prompt="请输入用户名" data-options="required:true,validType:'length[3,10]'">
                </div>
                <div class="form-item">
                    <label for="" class="label-top">文本输入框：</label>
                    <input class="easyui-textbox" data-options="iconCls:'fa fa-user',iconAlign:'left'" prompt="请输入文本">
                </div>
                <div class="form-item">
                    <label for="" class="label-top">密码输入框：</label>
                    <input class="easyui-passwordbox" prompt="Password" iconWidth="28">
                </div>
                <div class="form-item">
                    <label for="" class="label-top">下拉框：</label>
                    <select id="ec" class="easyui-combobox" data-options="editable:false,panelHeight:null" name="dept">
                        <option value="aa">选项1</option>
                        <option>选项2</option>
                        <option>伤害</option>
                        <option>电风扇</option>
                        <option>共担风险</option>
                    </select>
                </div>
                <!-- <div class="form-item">
                    <label for="">树形下拉框：</label>
                    <select class="easyui-combotree" data-options="data:treeJson"></select>
                </div> -->
                <div class="form-item">
                    <label for="">表格下拉框</label>
                    <input id="ccGrid" />
                </div>
                <div class="form-item">
                    <label for="" class="label-top">数值输入框：</label>
                    <input type="text" class="easyui-numberbox" value="100" data-options="min:0,precision:2" />
                </div>

                <div class="form-item">
                    <label for="" class="label-top">日历：</label>
                    <input id="dd" type="text" class="easyui-datebox" required="required" />
                </div>
                <div class="form-item">
                    <label for="" class="label-top">数字微调：</label>
                    <input id="ss" class="easyui-numberspinner" required="required" data-options="min:10,max:100,editable:false">
                </div>
                <div class="form-item">
                    <label for="" class="label-top">时间微调：</label>
                    <input id="ss" class="easyui-timespinner" required="required" data-options="min:'08:30',showSeconds:true" />
                </div>
                <div class="form-item">
                    <label for="" class="label-top">文件选择：</label>
                    <input class="easyui-filebox" data-options="buttonText:'上传头像',buttonIcon:'fa fa-upload'">
                </div>
                <div class="form-item">
                    <label for="" class="label-top">开关：</label>
                    <input class="easyui-switchbutton" checked>
                    <input class="easyui-switchbutton" data-options="onText:'开',offText:'关'">
                    <input class="easyui-switchbutton" data-options="disabled:true">
                </div>
                <div class="form-item">
                </div>
                <div class="form-item">
                    <input class="easyui-slider" value="12" style="width:250px" data-options="showTip:true" />
                </div>
            </form>
        </div>
    </body>
</html>