<?php $admin = \Yii::$app->session['admin'];?>
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
                        'lotteryInfo': $.trim($('input[name="lotteryInfo"]').val()),
                        'center_id': $.trim($('input[name="center_id"]').val()),
                        'status': $.trim($('input[name="status"]').val())
                    });
                },
            };

            $('#datagrid').datagrid({
                url:'/usermod/lottery/get-lottery-list',
                fit: true,
                pagination: true,
                singleSelect:true,
                fitColumns: true,
                rownumbers: true,
                loadMsg: '数据加载中...',
                toolbar: '#tb',
                columns: [
                    [{
                        field: 'lottery_code',
                        title: '彩种编号',
                        width: 25,
                        align: 'center',
                        sortable: true
                    }, {
                        field: 'lottery_name',
                        title: '彩种名称',
                        width: 50,
                        align: 'center',
                        sortable: true
                    },
                    //     {
                    //     field: 'center_name',
                    //     title: '所属中心',
                    //     width: 50,
                    //     align: 'center',
                    //     sortable: true
                    // }, {
                    //     field: 'area',
                    //     title: '省市',
                    //     width: 50,
                    //     align: 'center',
                    //     formatter:areaFormatter
                    // },
                        {
                        field: 'status',
                        title: '状态',
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
//                    $("a[name='edit']").linkbutton({text:'编辑',iconCls:'fa fa-edit'});
                    $("a[name='up']").linkbutton({text:'启用',iconCls:'fa fa-edit'});
                    $("a[name='down']").linkbutton({text:'禁用',iconCls:'fa fa-edit'});
//                    $("a[name='del']").linkbutton({text:'删除',iconCls:'fa fa-delete'});
                }
            });
            
            function statusFormatter(value,row){
                if(value==1){
                    return "<spen>正常<spen>";
                }
                return "<spen>禁用<spen>";
            }
            function areaFormatter(value, row) {
                return "<span>" + row.province + '-' + row.city + "</span>";
            }
            function optFormatter(value, row) {
                var str = '<a href="#" name="detail" class="easyui-linkbutton success"></a>';
//                str += '<a href="#" name="edit" style="margin-left: 5px" class="easyui-linkbutton success" onclick="product_edit('+ row.producr_id +')"> 编辑</a>';
                if(row.status ==0){
                    str += '<a href="#" name="up" style="margin-left: 5px" class="easyui-linkbutton success auth productLotteryChangeStatus" onclick="change_status('+row.lottery_id+','+row.status+')"> 启用</a>';
                }else if(row.status == 1){
                    str += '<a href="#" name="down" style="margin-left: 5px" class="easyui-linkbutton error auth productLotteryChangeStatus" onclick="change_status('+row.lottery_id+','+row.status+')">禁用</a>';
                }
//                str += '<a href="#" name="del" style="margin-left: 5px" class="easyui-linkbutton success" onclick="delete('+ row.producr_id +')">删除</a>';
                return str;
            }

            $('#centerlist').combobox('reload', '/centermod/center/get-center-list-options');
        });

	</script>


    <!-- <div "> -->
	<div class="dgdiv">
		<table id="datagrid"></table>
	</div>

	<div id="tb" style="padding:5px;">
        <div class="tb_menu">
            <a href="#" class="easyui-linkbutton primary auth lotterySearch" iconCls="fa fa-search" onclick="obj.search();"> 查 询 </a>
            <a href="#" class="easyui-linkbutton info auth productLotteryAdd" iconCls="fa fa-plus"  onclick="add_dialog('dlg','/usermod/views/to-lottery-add','/usermod/lottery/add', 'datagrid',500,300);">新增</a>
            <a href="#" class="easyui-linkbutton info auth productLotteryEdit" iconCls="fa fa-edit"  onclick="update_dialog('dlg','/productmod/views/to-lottery-edit','/productmod/lottery/update', 'datagrid', 400,300);">修改</a>
            <a href="#" id="remove" class="easyui-linkbutton error auth productLotteryDelete" iconCls="fa fa-remove" plain="true" onclick="deleteAll('/productmod/lottery/delete');">删除</a>
        </div>
        <div class="tb-column">
            <div class="tb_item">
                <span>彩种信息：</span>
                <input type="text"  name="lotteryInfo" class="easyui-textbox" >
            </div>
            <div class="tb_item">
                <span>状态</span>
                <select class="easyui-combobox" data-options="panelHeight:'auto'" name="status" style="width: 100px">
                    <option value="" selected>全部</option>
                    <option value="0">禁用</option>
                    <option value="1">启用</option>
                </select>
            </div>
        </div>
    </div>
	<div id="dlg"></div>
    <script>

        function change_status(id,status){
            var statusStr = "启用";
            if(status==1){
                statusStr='禁用';
            }
            changeStatus('您确定要 ('+statusStr+') 该彩种吗?',"/usermod/lottery/change-status",id,status);
        }
    </script>
</body>
</html>