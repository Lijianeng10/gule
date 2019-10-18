<?php $admin = \YII::$app->session['admin'];?>
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
	</head>
<body style="height: 100%;">
    <script type="text/javascript">
        $(function() {
            obj = {
                editRow: undefined,
                search: function () {
                    $('#datagrid').datagrid('load', {
                        'admin_name': $.trim($('input[name="admin_name"]').val()),
                        'admin_nickname': $.trim($('input[name="admin_nickname"]').val()),
                        'admin_tel': $.trim($('input[name="admin_tel"]').val()),
                        'admin_type': $.trim($('input[name="admin_type"]').val()),
                        'status': $.trim($('input[name="status"]').val()),
                        'start_time': $.trim($('input[name="start_time"]').val()),
                        'end_time': $.trim($('input[name="end_time"]').val()),
                    });
                },
            };

            $('#datagrid').datagrid({
                url: '/adminmod/admin/get-admin-list',
                fit: true,
                pagination: true,
                pageSize: 20,
                singleSelect:true,
                fitColumns: true,
                rownumbers: true,
                striped:true,
                loadMsg: '数据加载中...',
                toolbar: '#tb',
                columns: [
                    [{
                        field: 'admin_name',
                        title: '管理员登录名',
                        width: 50,
                        sortable: true,
						align: 'center'
                    },{
                        field: 'nickname',
                        title: '管理员昵称',
                        width: 60,
						align: 'center'
                    },{
                        field: 'type',
                        title: '所属类型',
                        width: 50,
                        align: 'center',
                        formatter: typeFormatter
                    },{
                        field: 'role_name',
                        title: '所属角色',
                        width: 50,
                        align: 'center',
                    },{
                        field: 'status',
                        title: '状态',
                        width: 50,
                        align: 'center',
                        formatter: statusFormatter
                    },{
                        field: 'admin_tel',
                        title: '联系方式',
                        width: 50,
						align: 'center'
                    },{
                        field: 'create_time',
                        title: '创建时间',
                        sortable: true,
                        width: 60,
						align: 'center'
                    }, {
                        field: 'opt',
                        title: '操作',
                        width: 80,
						align: 'left',
                        formatter: optFormatter,
                    }]
                ],
                // onBeforeLoad:function () {
                //     // alert(1);
                //     $.parser.parse();
                // },
                onLoadSuccess:function(data){
                    controlBtn();
					$("a[name='up']").linkbutton({text:'启用',iconCls:'fa fa-edit'});
                    $("a[name='down']").linkbutton({text:'禁用',iconCls:'fa fa-edit'});
                }
            });
            function typeFormatter(value,row){
                if(value==1){
                    return "渠道用户";
                }
                return "内部用户";
            }
            function statusFormatter(value,row){
                var str= "";
                if(row.status ==0){
                    str ="禁用"
                }else if(row.status == 1){
                    str ="启用"
                }
                return str;
            }
            function optFormatter(value, row) {
                var str = "";
                if(row.status ==0){
                    str += '<a href="#" name="up" style="margin-left: 5px" class="easyui-linkbutton info  auth adminAdminChangeStatus" onclick="change_status('+row.admin_id+','+row.status+')"></a>';
                }else if(row.status == 1){
                    str += '<a href="#" name="down" style="margin-left: 5px" class="easyui-linkbutton error  auth adminAdminChangeStatus" onclick="change_status('+row.admin_id+','+row.status+')"></a>';
                }
                 return str;
            }
            // $('#datagrid').datagrid('reload');
        });
	</script>


    <!-- <div "> -->
	<div class="dgdiv" id="dgdiv">
		<table id="datagrid"></table>
	</div>

	<div id="tb">
        <div class="tb-menu">
            <a href="#" class="easyui-linkbutton info auth adminAdminAdd" iconCls="fa fa-plus"  onclick="add_dialog('dlg','/adminmod/views/to-admin-add','/adminmod/admin/add');">新增</a>
            <a href="#" class="easyui-linkbutton info auth adminAdminEdit" iconCls="fa fa-edit"  onclick="update_dialog('dlg','/adminmod/views/to-admin-edit','/adminmod/admin/update');">修改</a>
            <a href="#" id="remove" class="easyui-linkbutton error auth adminAdminDelete" iconCls="fa fa-remove" plain="true" onclick="deleteAll('/adminmod/admin/delete');">删除</a>
            <a href="#" class="easyui-linkbutton primary auth adminAdminSearch" iconCls="fa fa-search" onclick="obj.search();"> 查 询 </a>
        </div>
    	<div class="tb-column">
            <div class="tb_item">
                <span>登录名：</span>
                <input type="text"  name="admin_name" class="easyui-textbox" >
            </div>
            <div class="tb_item">
                <span>昵称：</span>
                <input type="text"  name="admin_nickname" class="easyui-textbox" >
            </div>

            <div class="tb_item">
                <span>手机号：</span>
                <input type="text"  name="admin_tel" class="easyui-textbox" >
            </div>
			<?php if($login_type == '0'){?>
				<div class="tb_item">
					<span>用户类型：</span>
					<select class="easyui-combobox" name="admin_type" id="admin_type" data-options="panelHeight:'auto',editable:false">
						<option value="" selected>全部</option>
						<option value="0">内部用户</option>
						<option value="1">渠道</option>
					</select>
				</div>
			<?php }?>
            <div class="tb_item">
                <span>状态：</span>
                <select class="easyui-combobox" name="status" id="status" data-options="panelHeight:'auto',editable:false">
					<option value="" selected>全部</option>
					<option value="0">禁用</option>
					<option value="1">启用</option>
                </select>
            </div>
            <div class="tb_item">
                <span>创建时间：</span>
                <input type="text" id="start_time" name="start_time" class="easyui-datetimebox">
                -
                <input type="text" id="end_time" name="end_time" class="easyui-datetimebox" value="<?php echo date('Y-m-d H:i:s')?>" >
            </div>
    	</label>
    </div>
    <script>
        function change_status(admin_id,status){
            var statusStr = "启用";
            if(status==1){
                statusStr='禁用'
            }
            changeStatus('您确定要 ('+statusStr+') 该管理员吗?',"/adminmod/admin/change-status",admin_id,status);
        }
    </script>
</body>
</html>