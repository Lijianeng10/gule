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
                        'auth_name': $.trim($('input[name="auth_name"]').val()),
                        'auth_pid': $.trim($('input[name="auth_pid"]').val()),
                        'status': $.trim($('input[name="status"]').val()),
                        'auth_type': $.trim($('input[name="auth_type"]').val()),
                    });
                },
            };

            $('#datagrid').datagrid({
                url: '/adminmod/auth/get-auth-list',
                fit: true,
                pagination: true,
                pageSize:20,
                singleSelect:true,
                fitColumns: true,
                rownumbers: true,
                loadMsg: '数据加载中...',
                toolbar: '#tb',
                columns: [
                    [{
                        field: 'auth_id',
                        title: '权限ID',
                        width: 30,
                        align: 'center',
                        sortable: true
                    }, {
                        field: 'auth_name',
                        title: '权限名称',
                        width: 50,
                        sortable: true,
						align: 'center',
                    }, {
                        field: 'auth_pname',
                        title: '父级权限',
                        width: 50,
                        align: 'center',
                    }, {
                        field: 'auth_url',
                        title: '对应链接',
                        width: 100,
						align: 'center',
                    },{
                        field: 'auth_sort',
                        title: '排序',
                        align: 'center',
                        width: 30,
                        sortable: true
                    },{
                        field: 'auth_type',
                        title: '权限类型',
                        width: 60,
                        sortable: true,
						align: 'center',
                        formatter: typeFormatter,
                    }, {
                        field: 'auth_status',
                        title: '权限状态',
                        align: 'center',
                        width: 30,
                        formatter: statusFormatter,
                    },{
                        field: 'auth_create_at',
                        title: '创建时间',
                        width: 60,
						align: 'center',
                    },{
                        field: 'auth_update_at',
                        title: '更新时间',
                        width: 60,
						align: 'center',
                    },
                        {
                        field: 'opt',
                        title: '操作',
                        width: 80,
                        align: 'center',
                        formatter: optFormatter,
                    }]
                ],
                onLoadSuccess:function(data){
                    controlBtn();
                    $("a[name='up']").linkbutton({text:'启用',iconCls:'fa fa-edit'});
                    $("a[name='down']").linkbutton({text:'禁用',iconCls:'fa fa-edit'});
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
                if(row.auth_status ==0){
                    str ="禁用"
                }else if(row.auth_status == 1){
                    str ="启用"
                }
                return str;
            }
            function typeFormatter(value, row) {
                if(value==1){
                    return '导航栏菜单';
                }else if(value==2){
                    return '页面功能';
                }
            }
            function optFormatter(value, row) {
                var str = '';
                if(row.auth_status ==0){
                    str += '<a href="#" name="up" style="margin-left: 5px" class="easyui-linkbutton info auth adminAuthChangeStatus" onclick="change_status('+row.auth_id+','+row.auth_status+')"></a>';
                }else if(row.auth_status == 1){
                    str += '<a href="#" name="down" style="margin-left: 5px" class="easyui-linkbutton info auth adminAuthChangeStatus" onclick="change_status('+row.auth_id+','+row.auth_status+')"></a>';
                }
                // str += '<a href="#" name="edit" style="margin-left: 5px" class="easyui-linkbutton info" onclick="edit_auth('+row+')"></a>';
                return str;
            }
        });
	</script>

	<div class="dgdiv">
		<table id="datagrid"></table>
	</div>

	<div id="tb" style="padding:5px;">
        <div class="tb-menu">
            <a href="#" class="easyui-linkbutton info auth adminAuthAdd" iconCls="fa fa-plus"  onclick="add_dialog('dlg','/adminmod/views/to-auth-add','/adminmod/auth/add');">新增</a>
            <a href="#" class="easyui-linkbutton info auth adminAuthEdit" iconCls="fa fa-edit"  onclick="update_dialog('dlg','/adminmod/views/to-auth-edit','/adminmod/auth/edit-save');">编辑</a>
            <a href="#" id="remove" class="easyui-linkbutton error auth adminAuthDelete" iconCls="fa fa-remove" plain="true" onclick="deleteAll('/adminmod/auth/delete');">删除</a>
            <a href="#" class="easyui-linkbutton primary auth adminAuthSearch" iconCls="fa fa-search" onclick="obj.search();"> 查 询 </a>
        </div>

    	<div style="margin: 5px 0px 5px 0px; color:#000000;">
    	    权限名称：<input type="text"  name="auth_name" class="textbox" style="height: 24px;"  >
            <label for="" class="label-top">所属权限：</label>
            <input name="auth_pid" class="easyui-combotree" data-options="url:'/adminmod/auth/get-auth-tree?type=1',method:'get',lines: true,animate:true,checkbox:true">
            状态<select class="easyui-combobox" name="status" style="width: 100px;">
    	          <option value="" selected>全部</option>
                  <option value="0">禁用</option>
                  <option value="1">启用</option>
               </select>
            权限类型<select class="easyui-combobox" name="auth_type" style="width: 100px;">
                <option value="" selected>全部</option>
                <option value="1">导航栏菜单</option>
                <option value="2">页面功能</option>
            </select>
        </div>
    </div>
	<div id="dlg"></div>
    <script>
        function change_status(id,status){
            var statusStr = "启用";
            if(status==1){
                statusStr='禁用'
            }
            changeStatus('您确定要 ('+statusStr+') 该权限菜单吗?',"/adminmod/auth/change-status",id,status);
        }
    </script>


</body>
</html>