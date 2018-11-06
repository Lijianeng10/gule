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
        <script charset="utf-8" src="/js/qrcode.min.js"></script>
	</head>
<body style="height: 100%;">
    <script type="text/javascript">
        $(function() {
            obj = {
                editRow: undefined,
                search: function () {
                    $('#datagrid').datagrid('load', {
                        'terminal_num': $.trim($('input[name="terminal_num"]').val()),
                        'status': $.trim($('input[name="status"]').val()),
                        'use_status': $.trim($('input[name="use_status"]').val()),
                    });
                },
            };

            $('#datagrid').datagrid({
                url: '/usermod/terminal/get-terminal-list',
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
                        field: 'terminal_num',
                        title: '终端号',
                        width: 80,
                        sortable: true,
                        align: 'center'
                    },{
                        field: 'machine_code',
                        title: '机器设备号',
                        width: 80,
                        sortable: true,
                        align: 'center'
                    },{
                        field: 'create_time',
                        title: '创建时间',
                        width: 80,
                        sortable: true,
                        align: 'center'
                    },{
                        field: 'use_status',
                        title: '使用状态',
                        width: 40,
                        align: 'center',
                        sortable: true,
                        formatter: useStatusFormatter
                    },{
                        field: 'status',
                        title: '状态',
                        width: 40,
                        align: 'center',
                        sortable: true,
                        formatter: statusFormatter
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
                    $("a[name='qrcode']").linkbutton({text:'二维码'});
                    // $("a[name='del_banner']").linkbutton({text:'删除'});
                }
            });
            function useStatusFormatter(value,row){
                var str= "";
                if(value ==1){
                    str ="已使用"
                } else{
                    str ="未使用"
                }
                return str;
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
                if(row.status ==0){
                    str += '<a href="#" name="up" style="margin-left: 5px" class="easyui-linkbutton info  auth adminAdminChangeStatus" iconCls="fa fa-refresh" onclick="change_status('+row.terminal_id+','+row.status+')">启用</a>';
                }else if(row.status == 1){
                    str += '<a href="#" name="down"  style="margin-left: 5px" class="easyui-linkbutton info  auth adminAdminChangeStatus" iconCls="fa fa-refresh" onclick="change_status('+row.terminal_id+','+row.status+')">禁用</a>';
                }
                str += '<a href="#" name="qrcode"  style="margin-left: 5px" class="easyui-linkbutton info  auth adminAdminChangeStatus" iconCls="fa fa-search" onclick="read(\''+row.qrcode_url+'\')">二维码</a>';
                 return str;
            }
        });
	</script>
	<div class="dgdiv">
		<table id="datagrid"></table>
	</div>

	<div id="tb" >
        <div class="tb_menu">
            <a href="#" class="easyui-linkbutton info" iconCls="fa fa-plus" onclick="add()"> 新 增 </a>
            <a href="#" class="easyui-linkbutton primary" iconCls="fa fa-search" onclick="obj.search();"> 查 询 </a>
        </div>
        <div class="tb-column">
            <div class="tb_item">
                <span>终端号：</span>
                <input type="text"  name="terminal_num" class="easyui-textbox">
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
                <span>使用状态：</span>
                <select class="easyui-combobox" name="use_status" style="width: 100px" data-options="editable:false">
                    <option value="" selected>全部</option>
                    <option value="0">未使用</option>
                    <option value="1">已使用</option>
                </select>
            </div>
        </div>

    </div>
    <script>
        function change_status(id,status){
            var statusStr = "启用";
            if(status==1){
                statusStr='禁用';
            }
            changeStatus('您确定要 ('+statusStr+') 该终端号吗?',"/usermod/terminal/change-status",id,status);
        }

        /**
         * 新增终端号
         */
        function add() {
            add_dialog('win','/usermod/views/to-terminal-add','/usermod/terminal/add-terminal-num','datagrid',500,300);
        }

        /**
         * 查看二维码
         */
        function read(url) {
            create_window('win','机器二维码','/usermod/views/to-terminal-qrcode?url='+url,500,300);
        }
    </script>
</body>
</html>