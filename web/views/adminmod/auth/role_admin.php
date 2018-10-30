<!DOCTYPE html>
<html>
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
        <style type="text/css"> body { height: 100%; } </style>
	</head>
    <body>
        <style type="text/css">
            html body {
                height: 100%;
            }
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
        <script>
            $('#datagrid2').datagrid({
                url: '/adminmod/role/get-role-admins?id='+<?php echo $role['role_id'];?>,
                fit: true,
                pagination: true,
                singleSelect:true,
                fitColumns: true,
                rownumbers: true,
                loadMsg: '数据加载中...',
                toolbar: '#tb',
                columns: [
                    [{
                        field: 'admin_id',
                        title: 'admin_id',
                        width: 50,
                        sortable: true,
                        hidden:true
                    }, {
                        field: 'admin_name',
                        title: '角色名称',
                        width: 50,
                        sortable: true
                    }, {
                        field: 'status',
                        title: '角色状态',
                        width: 50,
                        align: 'center',
                        formatter: statusFormatter
                    }]
                ],
            });
            function statusFormatter(value,row){
                if(value==1){
                    return "<spen style='color: blue'>启用<spen>";
                }
                return "<spen style='color: red'>禁用<spen>";
            }

            $('#datagrid3').datagrid({
                url: '/adminmod/role/get-role-admins?id='+<?php echo $role['role_id'];?>,
                fit: true,
                pagination: true,
                singleSelect:true,
                fitColumns: true,
                rownumbers: true,
                loadMsg: '数据加载中...',
                toolbar: '#tb',
                columns: [
                    [{
                        field: 'admin_id',
                        title: 'admin_id',
                        width: 50,
                        sortable: true,
                        hidden:true
                    }, {
                        field: 'admin_name',
                        title: '角色名称',
                        width: 50,
                        sortable: true
                    }, {
                        field: 'status',
                        title: '角色状态',
                        width: 50,
                        align: 'center',
                        formatter: statusFormatter
                    }]
                ],
            });
        </script>

        <div style="height: 50%">
            <table id="datagrid2"></table>
        </div>
        <div style="height: 50%">
            <table id="datagrid3"></table>
        </div>
    </body>
</html>