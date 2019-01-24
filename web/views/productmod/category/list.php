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
                        'name': $.trim($('input[name="name"]').val()),
                        'p_id': $.trim($('input[name="p_id"]').val()),
                        'status': $.trim($('input[name="status"]').val()),
                    });
                },
            };

            $('#datagrid').datagrid({
                url: '/productmod/category/get-category-list',
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
                        field: 'category_id',
                        title: '类别ID',
                        width: 40,
                        align: 'center'
                    },{
                        field: 'name',
                        title: '类别名称',
                        width: 80,
                        align: 'center'
                    },{
                        field: 'p_name',
                        title: '父级类别',
                        width: 80,
                        sortable: true,
                        align: 'center'
                    },{
                        field: 'sort',
                        title: '排序',
                        width: 40,
                        sortable: true,
                        align: 'center'
                    },{
                        field: 'status',
                        title: '使用状态',
                        width: 40,
                        align: 'center',
                        sortable: true,
                        formatter: statusFormatter
                    },{
                        field: 'create_time',
                        title: '创建时间',
                        width: 80,
                        sortable: true,
                        align: 'center'
                    },{
                        field: 'opt',
                        title: '操作',
                        width: 100,
                        align: 'center',
                        formatter: optFormatter,
                    }
                    ]
                ],
                onLoadSuccess:function(data){
                    // controlBtn();
                    $("a[name='up']").linkbutton({text:'启用',iconCls:'fa fa-edit'});
                    $("a[name='down']").linkbutton({text:'禁用',iconCls:'fa fa-edit'});
                }
            });
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
                if(row.status ==0){
                    str += '<a href="#" name="up" style="margin-left: 5px" class="easyui-linkbutton info  auth adminAdminChangeStatus" iconCls="fa fa-refresh" onclick="change_status('+row.category_id+','+row.status+')">启用</a>';
                }else if(row.status == 1){
                    str += '<a href="#" name="down"  style="margin-left: 5px" class="easyui-linkbutton error  auth adminAdminChangeStatus" iconCls="fa fa-refresh" onclick="change_status('+row.category_id+','+row.status+')">禁用</a>';
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
            <a href="#" class="easyui-linkbutton primary auth adminAuthAdd" iconCls="fa fa-plus"  onclick="add_dialog('dlg','/productmod/views/to-category-add','/productmod/category/add','datagrid',500,300);">新增</a>
            <a href="#" class="easyui-linkbutton primary auth adminAuthEdit" iconCls="fa fa-edit"  onclick="update_dialog('dlg','/productmod/views/to-category-edit','/productmod/category/edit',500,300);">编辑</a>
            <a href="#" id="remove" class="easyui-linkbutton error auth adminAuthDelete" iconCls="fa fa-remove" plain="true" onclick="deleteAll('/productmod/category/delete');">删除</a>
            <a href="#" class="easyui-linkbutton primary" iconCls="fa fa-search" onclick="obj.search();"> 查 询 </a>
        </div>
        <div class="tb-column">
            <div class="tb_item">
                <span>类别名称：</span>
                <input type="text"  name="name" class="easyui-textbox">
            </div>
            <div class="tb_item">
                <span>所属类别：</span>
                <input name="p_id" class="easyui-combotree" data-options="url:'/productmod/category/get-category-tree?type=1',method:'get',lines: true,animate:true,checkbox:true">
            </div>
            <div class="tb_item">
                <span>状态：</span>
                <select class="easyui-combobox" name="status" style="width: 100px" data-options="editable:false">
                    <option value="" selected>全部</option>
                    <option value="1">正常</option>
                    <option value="0">禁用</option>
                </select>
            </div>
        </div>

    </div>
    <script>
        function change_status(id,status){
            var statusStr = "启用";
            if(status==1){
                statusStr='禁用'
            }
            changeStatus('您确定要 ('+statusStr+') 该类别吗?',"/productmod/category/change-status",id,status);
        }

        /**
         * 查看二维码
         */
        function read(url) {
            create_window('dlg','机器二维码','/usermod/views/to-terminal-qrcode?url='+url,550,400);
        }
    </script>
</body>
</html>