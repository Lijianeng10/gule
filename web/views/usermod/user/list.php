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
<!--        <script charset="utf-8" src="/js/qrcode.min.js"></script>-->
        <script charset="utf-8" src="/js/jquery.qrcode.js"></script>
        <script charset="utf-8" src="/js/utf.js"></script>
	</head>
<body style="height: 100%;">
    <script type="text/javascript">
        $(function() {
            obj = {
                editRow: undefined,
                search: function () {
                    $('#datagrid').datagrid('load', {
                        'userInfo': $.trim($('input[name="userInfo"]').val()),
                        'status': $.trim($('input[name="status"]').val()),
                        'all_balance': $.trim($('input[name="all_balance"]').val()),
                        'all_funds': $.trim($('input[name="all_funds"]').val()),
                        'able_balance': $.trim($('input[name="able_balance"]').val()),
                        'able_funds': $.trim($('input[name="able_funds"]').val()),
                    });
                },
            };

            $('#datagrid').datagrid({
                url: '/usermod/user/get-user-list',
                fit: true,
                pagination: true,
                pageSize: 20,
                singleSelect:true,
                // fitColumns: true,
                rownumbers: true,
                loadMsg: '数据加载中...',
                toolbar: '#tb',
                columns: [
                    [{
                        field: 'cust_no',
                        title: '会员编号',
                        width: 100,
                        sortable: true,
                        align: 'center'
                    },{
                        field: 'nickname',
                        title: '会员昵称',
                        width: 100,
                        align: 'center'
                    },{
                        field: 'phone',
                        title: '手机号',
                        width: 120,
                        align: 'center'
                    },{
                        field: 'province',
                        title: '省份',
                        width: 70,
                        align: 'center'
                    },{
                        field: 'city',
                        title: '城市',
                        width: 70,
                        align: 'center'
                    },{
                        field: 'real_name',
                        title: '真实姓名',
                        width: 120,
                        align: 'center'
                    },{
                        field: 'id_card_num',
                        title: '身份证号码',
                        width: 200,
                        align: 'center'
                    },{
                        field: 'status',
                        title: '状态',
                        width: 80,
                        align: 'center',
                        sortable: true,
                        formatter: statusFormatter
                    },{
                        field: 'create_time',
                        title: '注册时间',
                        width: 150,
                        sortable: true,
                        align: 'center'
                    },{
                        field: 'opt',
                        title: '操作',
                        width: 250,
                        align: 'left',
                        formatter: optFormatter,
                    }
                    ]
                ],
                onLoadSuccess:function(data){
                    controlBtn();
                    $("a[name='up']").linkbutton({text:'启用',iconCls:'fa fa-edit'});
                    $("a[name='down']").linkbutton({text:'禁用',iconCls:'fa fa-edit'});
                    // $("a[name='del_banner']").linkbutton({text:'删除'});
                }
            });
            function statusFormatter(value,row){
                var str= "";
                if(row.status ==1){
                    str ="<span style='color: green'>正常</span>"
                } else{
                    str ="<span style='color: red'>禁用</span>"
                }
                return str;
            }
            function optFormatter(value, row) {
                var str = "";
                if(row.status ==2){
                    str += '<a href="#" name="up" style="margin-left: 5px" class="easyui-linkbutton info  auth usermodUserChangeStatus" iconCls="fa fa-refresh" onclick="change_status('+row.user_id+','+row.status+')">启用</a>';
                }else if(row.status == 1){
                    str += '<a href="#" name="down"  style="margin-left: 5px" class="easyui-linkbutton error  auth usermodUserChangeStatus" iconCls="fa fa-refresh" onclick="change_status('+row.user_id+','+row.status+')">禁用</a>';
                }
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
            <a href="#" class="easyui-linkbutton info  productLotteryAdd" iconCls="fa fa-plus"  onclick="create_window('dlg','新增彩种','/usermod/views/to-datamatrix-add',500,500);">新增</a>
        </div>
        <div class="tb-column">
            <div class="tb_item">
                <span>会员信息：</span>
                <input type="text"  name="userInfo" class="easyui-textbox" prompt="会员编号、手机号、昵称">
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
                <span>总余额：</span>
                <select class="easyui-combobox" name="all_balance" style="width: 80px" data-options="editable:false">
                    <option value="" selected>全部</option>
                    <option value="<"><</option>
                    <option value="=">=</option>
                    <option value=">">></option>
                </select>
                <input type="text"  name="all_funds" class="easyui-textbox" style="width: 100px">
            </div>
            <div class="tb_item">
                <span>可用余额：</span>
                <select class="easyui-combobox" name="able_balance" style="width: 80px" data-options="editable:false">
                    <option value="" selected>全部</option>
                    <option value="<"><</option>
                    <option value="=">=</option>
                    <option value=">">></option>
                </select>
                <input type="text"  name="able_funds" class="easyui-textbox" style="width: 100px">
            </div>
        </div>

    </div>
    <script>
        function change_status(id,status){
            var statusStr = "启用";
            if(status==1){
                statusStr='禁用';
            }
            changeStatus('您确定要 ('+statusStr+') 该用户吗?',"/usermod/user/change-status",id,status);
        }
    </script>
</body>
</html>