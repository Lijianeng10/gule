<!DOCTYPE html>
<html style="height: 100%;">
	<head>
		<meta charset="UTF-8">
		<title></title>
        <!--easyui-->
        <link rel="stylesheet" href="/easyui/themes/super/css/font-awesome.min.css">
		<link rel="stylesheet" href="/easyui/themes/super/superBlue.css" id="themeCss">
        <link rel="stylesheet" href="/css/basis.css">
		<script src="/easyui/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="/easyui/js/jquery.easyui.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="/easyui/locale/easyui-lang-zh_CN.js" type="text/javascript" charset="utf-8"></script>
		<script src="/easyui/extensions/curdtool.js" type="text/javascript" charset="utf-8"></script>
        <link rel="stylesheet" href="/css/jquery.magnify.css">
        <script src="/js/jquery.magnify.js" type="text/javascript" charset="utf-8"></script>
        <link rel="stylesheet" href="/js/kindeditor/themes/default/default.css" />
        <script charset="utf-8" src="/js/kindeditor/kindeditor-all.js"></script>
        <script charset="utf-8" src="/js/kindeditor/lang/zh_CN.js"></script>
	</head>
<body style="height: 100%;">
    <script type="text/javascript">
        $(function() {
            obj = {
                editRow: undefined,
                search: function () {
                    $('#datagrid').datagrid('load', {
                        'user_info': $.trim($('input[name="user_info"]').val()),
                        'status': $.trim($('input[name="status"]').val()),
                        'start_time': $.trim($('input[name="start_time"]').val()),
                        'end_time': $.trim($('input[name="end_time"]').val()),
                        'authen_status': $.trim($('input[name="authen_status"]').val()),
                        'vxstatus': $.trim($('input[name="vxstatus"]').val()),
                    });
                },
            };

            $('#datagrid').datagrid({
                url: '/usermod/user/get-user-list',
                fit: true,
                pagination: true,
                pageSize: 20,
                // singleSelect:true,
                fitColumns: true,
                rownumbers: true,
                loadMsg: '数据加载中...',
                toolbar: '#tb',
                columns: [
                    [{
                        field: 'cust_no',
                        title: '会员编号',
                        width: 50,
                        align: 'center',
                        sortable: true
                    }, {
                        field: 'user_tel',
                        title: '手机号',
                        width: 50,
                        align: 'center',
                    },{
                        field: 'user_name',
                        title: '会员昵称',
                        width: 50,
                        align: 'center',
                    },{
                        field: 'agent_code',
                        title: '上级代理编号',
                        width: 50,
                        align: 'center',
                    },{
                        field: 'agent_name',
                        title: '上级代理昵称',
                        width: 50,
                        align: 'center',
                    },{
                        field: 'all_funds',
                        title: '总金额',
                        width: 50,
                        sortable: true,
                        align: 'center',
                    },{
                        field: 'able_funds',
                        title: '可用余额',
                        width: 50,
                        sortable: true,
                        align: 'center',
                    },{
                        field: 'ice_funds',
                        title: '冻结余额',
                        width: 50,
                        align: 'center',
                    },{
                        field: 'no_withdraw',
                        title: '不可提现余额',
                        width: 50,
                        align: 'center',
                    },{
                        field: 'draw',
                        title: '可提现余额',
                        width: 50,
                        align: 'center',
                        formatter: drawFormatter
                    }, {
                        field: 'third_uid',
                        title: '微信绑定',
                        width: 40,
                        align: 'center',
                        formatter: function (value) {
                            return (value != "" && value != null ? "已绑定" : "未绑定")
                        },
                    }, {
                        field: 'level_name',
                        title: '会员等级',
                        width: 40,
                        align: 'center'
                    },{
                        field: 'create_time',
                        title: '开户时间',
                        width: 80,
                        sortable: true,
                        align: 'center'
                    },{
                        field: 'authen_status',
                        title: '认证状态',
                        width: 40,
                        align: 'center',
                        formatter: function (value) {
                            return value == 1 ? "已通过" : (value == 2 ? "审核中" : (value == 3 ? "审核失败" : "未认证"));
                        },
                    },{
                        field: 'status',
                        title: '使用状态',
                        width: 40,
                        align: 'center',
                        sortable: true,
                        formatter: statusFormatter
                    },{
                        field: 'opt',
                        title: '操作',
                        width: 100,
                        align: 'left',
                        formatter: optFormatter,
                    }
                    ]
                ],
                onLoadSuccess:function(data){
                    controlBtn();
                    $("a[name='edit_banner']").linkbutton({text:'编辑'});
                    $("a[name='del_banner']").linkbutton({text:'删除'});
                    $("a[name='up']").linkbutton({text:'上线'});
                    $("a[name='down']").linkbutton({text:'下线'});
                }
            });
            function picFormatter(value, row) {
                if(value==='' || value == undefined){
                    return "";
                }
                return '<img data-magnify="gallery" data-src="'+row.pic_url+'" data-caption="APP首页图片" src="'+row.pic_url+'" width="40px" height="40px" style="text-align: center">';
            }
            function drawFormatter(value,row){
                return (row.able_funds - row.no_withdraw).toFixed(2);
            }
            function statusFormatter(value,row){
                var str= "";
                if(row.status ==1){
                    str ="正常"
                } else{
                    str ="禁用"
                }
                return str;
            }
            function optFormatter(value, row) {
                var str = "";

                 return str;
            }
        });
	</script>
	<div class="dgdiv">
		<table id="datagrid"></table>
	</div>

	<div id="tb" >
        <div class="tb_menu">
            <a href="#" class="easyui-linkbutton primary" iconCls="fa fa-search" onclick="obj.search();"> 查 询 </a>
        </div>
        <div class="tb-column">
            <div class="tb_item">
                <span>用户信息：</span>
                <input type="text"  name="user_info" class="easyui-textbox">
            </div>
            <div class="tb_item">
                <span>状态：</span>
                <select class="easyui-combobox" name="status" style="width: 100px" data-options="editable:false">
                    <option value="" selected>全部</option>
                    <option value="1">正常</option>
                    <option value="2">禁用</option>
                </select>
            </div>
            <div class="tb_item">
                <span>开户日期：</span>
                <input type="text" name="start_time" class="easyui-datetimebox">
                -
                <input type="text" name="end_time" class="easyui-datetimebox" value="<?php echo date('Y-m-d H:i:s');?>">
            </div>
            <div class="tb_item">
                <span>认证状态：</span>
                <select class="easyui-combobox" name="authen_status" style="width: 100px" data-options="editable:false">
                    <option value="" selected>全部</option>
                    <option value="0">未认证</option>
                    <option value="1">已通过</option>
                    <option value="2">审核中</option>
                    <option value="3">未通过</option>
                </select>
            </div>
            <div class="tb_item">
                <span>微信绑定：</span>
                <select class="easyui-combobox" name="vxstatus" style="width: 100px" data-options="editable:false">
                    <option value="" selected>全部</option>
                    <option value="1">已绑定</option>
                    <option value="2">未绑定</option>
                </select>
            </div>
        </div>

    </div>
    <div id="dlg"></div>
    <script>
        function change_status(bananer_id,status){
            var statusStr = "下线";
            if(status==1){
                statusStr='发布'
            }
            changeStatus('您确定要 ('+statusStr+') 该广告吗吗?',"/shopwebsitemod/banner/change-status",bananer_id,status);
        }
    </script>
</body>
</html>