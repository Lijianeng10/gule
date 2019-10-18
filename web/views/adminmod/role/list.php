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
        <style type="text/css"> body { height: 100%; } </style>
	</head>
<body>
    <script type="text/javascript">
        $(function() {
            obj = {
                editRow: undefined,
                search: function () {
                    $('#datagrid').datagrid('load', {
                        'role_name': $.trim($('input[name="role_name"]').val()),
                        'status': $.trim($('input[name="status"]').val()),
                        'start_time': $.trim($('input[name="start_time"]').val()),
                        'end_time': $.trim($('input[name="end_time"]').val()),
                    });
                },
            };

            $('#datagrid').datagrid({
                url: '/adminmod/role/get-role-list',
                fit: true,
                pagination: true,
                pageSize: 20,
                singleSelect:true,
                fitColumns: true,
                rownumbers: true,
                loadMsg: '数据加载中...',
                toolbar: '#tb',
                columns: [
                    [{
                        field: 'role_id',
                        title: 'role_id',
                        width: 50,
                        sortable: true
                    }, {
                        field: 'role_name',
                        title: '角色名称',
                        width: 50,
                        sortable: true
                    }, {
                        field: 'nickname',
                        title: '创建人',
                        width: 50,
                        sortable: true
                    }, {
                        field: 'status',
                        title: '角色状态',
                        width: 50,
                        align: 'center',
                        formatter: statusFormatter
                    }, {
                        field: 'create_time',
                        title: '创建时间',
                        width: 60,
                    }, {
                        field: 'opt',
                        title: '操作',
                        width: 100,
                        align: 'left',
                        formatter: optFormatter,
                    }]
                ],
                onLoadSuccess:function(data){
                    controlBtn();
                    $("a[name='up']").linkbutton({text:'启用',iconCls:'fa fa-edit'});
                    $("a[name='down']").linkbutton({text:'禁用',iconCls:'fa fa-edit'});
                    $("a[name='add_role']").linkbutton({text:'权限分配',iconCls:'fa fa-edit'});
                }
            });
            function picFormatter(value, row) {
                if(value==='' || value == undefined){
                    return "";
                }
                return "<img src='"+value+"' height='30' width='30'/>";
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
                var str = '';
                if(row.status ==0){
                    str += '<a href="#" name="up" style="margin-left: 5px" class="easyui-linkbutton info  auth adminRoleChangeStatus" onclick="change_status('+row.role_id+','+row.status+')"></a>';
                }else if(row.status == 1){
                    str += '<a href="#" name="down" style="margin-left: 5px" class="easyui-linkbutton error  auth adminRoleChangeStatus" onclick="change_status('+row.role_id+','+row.status+')"></a>';
                }
                str += '<a href="#" name="add_role" style="margin-left: 5px" class="easyui-linkbutton info auth adminRoleAuth" onclick="role_admin('+row.role_id+',\''+row.role_name+'\')"></a>';
                return str;
            }
        });
	</script>

	<div class="dgdiv">
		<table id="datagrid"></table>
	</div>

	<div id="tb">
        <div class="tb-menu">
            <a href="#" class="easyui-linkbutton info auth adminRoleAdd" iconCls="fa fa-plus"  onclick="add_dialog('dlg','/adminmod/views/to-role-add','/adminmod/role/add');">新增</a>
            <a href="#" class="easyui-linkbutton info auth adminRoleEdit" iconCls="fa fa-edit"  onclick="update_dialog('dlg','/adminmod/views/to-role-edit','/adminmod/role/update');">修改</a>
            <a href="#" id="remove" class="easyui-linkbutton error auth adminRoleDelete" iconCls="fa fa-remove" plain="true" onclick="deleteAll('/adminmod/role/delete');">删除</a>
            <a href="#" class="easyui-linkbutton primary auth adminRoleSearch" iconCls="fa fa-search" onclick="obj.search();"> 查 询 </a>
        </div>
    	<div class="tb-column">
            <div class="tb_item">
                <span>角色名：</span>
                <input type="text"  name="role_name" class="easyui-textbox" >
            </div>
            <div class="tb_item">
                <span>状态：</span>
                <select class="easyui-combobox" name="status" style="width: 100px">
                    <option value="" selected>全部</option>
                    <option value="0">禁用</option>
                    <option value="1">启用</option>
                </select>
            </div>
            <div class="tb_item">
                <span>创建时间：</span>
                <input type="text" id="start_time" name="start_time" class="easyui-datetimebox" style="width:150px" >
                -
                <input type="text" id="end_time" name="end_time" class="easyui-datetimebox"  style="width:150px">
            </div>
        </div>
    </div>
    <script>
        function role_admin(role_id,role_name){
            create_window('win','权限配置--'+role_name,'/adminmod/views/to-role-auth?role_id='+role_id);
        }

        function change_status(id,status){
            var statusStr = "启用";
            if(status==1){
                statusStr='禁用'
            }
            changeStatus('您确定要 ('+statusStr+') 该角色吗?',"/adminmod/role/change-status",id,status);
        }
    </script>
</body>
</html>