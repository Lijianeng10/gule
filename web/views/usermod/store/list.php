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
        <script charset="utf-8" src="/js/jquery.cxselect.min.js"></script>
	</head>
<body style="height: 100%;">
    <script type="text/javascript">
        $(function() {
            obj = {
                editRow: undefined,
                search: function () {
                    $('#datagrid').datagrid('load', {
                        'cust_no': $.trim($('input[name="cust_no"]').val()),
                        'status': $.trim($('input[name="status"]').val()),
                        'start_time': $.trim($('input[name="start_time"]').val()),
                        'end_time': $.trim($('input[name="end_time"]').val()),
                        'province': $.trim($('select[name="province"]').val()),
                        'city': $.trim($('select[name="city"]').val()),
                        'area': $.trim($('select[name="area"]').val()),
                    });
                },
            };
			
			//网点信息
			$('#cust_no').combobox({
				url:'/usermod/store/get-cust-no',
				valueField:'id',
				textField:'text',
				panelHeight:'auto',
				editable:true
			});

            $('#datagrid').datagrid({
                url: '/usermod/store/get-store-list',
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
                        title: '网点信息',
                        width: 150,
                        align: 'center',
                        formatter:infoFormatter
                    },{
                        field: 'nickname',
                        title: '所属渠道',
                        width: 100,
                        align: 'center',
                    },{
                        field: 'code',
                        title: '代销证编号',
                        width: 200,
                        align: 'center',
                        hidden:true
                    },{
                        field: 'area',
                        title: '所属区域',
                        width: 200,
                        align: 'center',
                        formatter:areaFormatter
                    },{
                        field: 'agents',
                        title: '区域经理信息',
                        width: 200,
                        align: 'center',
                    },{
                        field: 'machineNums',
                        title: '总机器数',
                        width: 60,
                        // sortable: true,
                        align: 'center',
                    },{
                        field: 'saleMoneys',
                        title: '总销量(元)',
                        width: 80,
                        // sortable: true,
                        align: 'center',
                    },{
                        field: 'status',
                        title: '状态',
                        width: 60,
                        align: 'center',
                        formatter: statusFormatter
                    },{
                        field: 'create_time',
                        title: '开户时间',
                        width: 150,
                        align: 'center',
                    },{
                        field: 'opt',
                        title: '操作',
                        width: 200,
                        align: 'center',
                        formatter: optFormatter,
                    }
                    ]
                ],
                onLoadSuccess:function(data){
                    controlBtn();
					$("a[name='up']").linkbutton({text:'启用',iconCls:'fa fa-edit'});
                    $("a[name='down']").linkbutton({text:'禁用',iconCls:'fa fa-edit'});
					$("a[name='storedetail']").linkbutton({text:'查看',iconCls:'fa fa-search'});
                }
            });
            function infoFormatter(value, row) {
                str = '';
                str+= row.store_name+'<br>'+row.cust_no+'<br>'+row.user_tel;
                return str;
            }

            function areaFormatter(value, row) {
                if(row.province!=null && row.city!=null && row.area!=null){
                    return "<span>" +row.province+'-'+row.city + '-' + row.area + "</span>";
                }
                return '';
            }
            function statusFormatter(value,row){
                var str= "";
                if(value ==1){
                    str ="激活"
                } else if(value==2){
                    str ="禁用"
                }else{
                    str ="未激活"
                }
                return str;
            }
            function optFormatter(value, row) {
                var str = "";
                if(row.status == 1){
                    str += '<a href="#" name="down" style="margin-left: 5px" class="easyui-linkbutton info  auth adminAdminChangeStatus" onclick="change_status('+row.store_id+','+row.status+')"></a>&nbsp';
                }else{
                    str += '<a href="#" name="up" style="margin-left: 5px" class="easyui-linkbutton info  auth adminAdminChangeStatus" onclick="change_status('+row.store_id+','+row.status+')"></a>&nbsp';
                }
				str += '<a href="#" name="storedetail" class="easyui-linkbutton info storedetail" onclick="create_window(\'dlg\',\'网点彩种详情\',\'/usermod/views/to-stock-lottery-details?cust_no='+row.cust_no+'\',900,600)"></a>';
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
                <span>网点信息：</span>
                <input name="cust_no" id="cust_no" class="easyui-validatebox easyui-combobox">
            </div>
            <div class="tb_item">
                <span>状态：</span>
                <select class="easyui-combobox" name="status" style="width: 100px" data-options="panelHeight:'auto',editable:false">
                    <option value="" selected>全部</option>
					<option value="0">未激活</option>
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
            <div class="tb_item" id="element_id">
                <span>所属区域：</span>
                <select class="province" name="province"></select>
                <select class="city" name="city"></select>
                <select class="area" name="area"></select>
            </div>
        </div>

    </div>
    <div id="dlg"></div>
    <script>
        $('#element_id').cxSelect({
            url: '/js/cityData.min.json',
            selects: ['province', 'city', 'area'],
            emptyStyle: 'none'
        });
        function change_status(store_id,status){
            var statusStr = "启用";
            if(status==1){
                statusStr='禁用'
            }
            changeStatus('您确定要 ('+statusStr+') 该网点吗?',"/usermod/store/change-status",store_id,status);
        }
    </script>
</body>
</html>