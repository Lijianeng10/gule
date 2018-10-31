<!DOCTYPE html>
<html style="height: 100%;">
	<head>
		<meta charset="UTF-8">
		<title></title>
        <!--easyui-->
        <link rel="stylesheet" href="/easyui/themes/super/css/font-awesome.min.css">
		<link rel="stylesheet" href="/easyui/themes/super/superBlue.css" id="themeCss">
        <link rel="stylesheet" href="/css/jquery.magnify.css">
        <link rel="stylesheet" href="/css/basis.css">
		<script src="/easyui/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="/easyui/js/jquery.easyui.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="/easyui/locale/easyui-lang-zh_CN.js" type="text/javascript" charset="utf-8"></script>
		<script src="/easyui/extensions/curdtool.js" type="text/javascript" charset="utf-8"></script>
        <script src="/js/jquery.magnify.js" type="text/javascript" charset="utf-8"></script>
	</head>
<body style="height: 100%;">
    <script type="text/javascript">
        $(function() {
            //搜索
            obj = {
                editRow: undefined,
                search: function () {
                    $('#datagrid').datagrid('load', {
                        'order_code': $.trim($('input[name="order_code"]').val()),
                        'user_name': $.trim($('input[name="user_name"]').val()),
                        'order_status': $.trim($('input[name="order_status"]').val()),
                        'pay_status': $.trim($('input[name="pay_status"]').val()),
                        'start_order_time': $.trim($('input[name="start_order_time"]').val()),
                        'end_order_time': $.trim($('input[name="end_order_time"]').val()),
                    });
                },
            };
			
			//订单状态下拉框
			$('#order_status').combobox({
				url:'/ordersmod/orders/get-order-status',
				valueField:'id',
				textField:'text',
				panelHeight:'auto',
				editable:false,//不可编辑，只能选择
				value:-1,
			});
			
			//支付状态下拉框
			$('#pay_status').combobox({
				url:'/ordersmod/orders/get-pay-status',
				valueField:'id',
				textField:'text',
				panelHeight:'auto',
				editable:false,//不可编辑，只能选择
				value:-1,
			});
			
            //数据表格
            $('#datagrid').datagrid({
                url: '/ordersmod/orders/get-list',
                fit: true,
                pagination: true,
                pageSize: 20,
                singleSelect:true,
                fitColumns: true,
                rownumbers: true,
                loadMsg: '数据加载中...',
                toolbar: '#tb',
                columns: [
                    [ {
                        field:'order_code',
                        title: '订单编号',
                        width: 160,
                        align: 'center',
                        sortable: true
                    },{
                        field:'cust_no',
                        title: '门店编号',
                        width: 70,
                        align: 'center',
                        sortable: true
                    }, {
                        field:'order_num',
                        title: '商品总数',
                        width: 70,
						align: 'center',
                        sortable: true
                    },{
                        field: 'order_money',
                        title: '订单总金额',
                        width: 80,
						align: 'center',
                        sortable: true
                    }, {
                        field: 'address_xs',
                        title: '收货地址',
                        //width: 300,
                        halign: 'center',
						align: 'left',
						formatter: addressXsFormatter
                    },  {
                        field: 'order_status',
                        title: '订单状态',
                        width: 70,
                        align: 'center',
						sortable: true,
						formatter: orderStatusFormatter
                    }, {
                        field: 'pay_status',
                        title: '支付状态',
                        width: 70,
                        align: 'center',
						sortable: true,
						formatter: payStatusFormatter
                    }, {
                        field: 'shipping_fee',
                        title: '配送费',
                        width: 60,
                        align: 'center',
                        sortable: true
                    },{
                        field: 'remark_xs',
                        title: '留言',
                        width: 80,
						align: 'center',
                        //sortable: true,
						formatter: remarkXsFormatter
                    },{
                        field: 'order_time',
                        title: '下单时间',
                        width: 130,
                        align: 'center',
                        sortable: true
                    },{
                        field: 'pay_time',
                        title: '支付时间',
                        width: 130,
                        align: 'center',
                        sortable: true
                    },{
                        field: 'send_time',
                        title: '发货时间',
                        width: 130,
                        align: 'center',
                        sortable: true
                    },{
                        field: 'receive_time',
                        title: '收货时间',
                        width: 130,
                        align: 'center',
                        sortable: true
                    }, {
                        field: 'opt',
                        title: '操作',
                        width: 130,
                        align: 'center',
                        formatter: optFormatter
                    }]
                ],
                onLoadSuccess:function(data){
                    $("a[name='sure_send']").linkbutton({text:'发货'});
					$("a[name='read_user']").linkbutton({text:'查看'});
                }
            });
			
			//地址
			function addressXsFormatter(value, row) {
				var str = '';
				if(row.address != ''){
					str += "<span style='cursor:pointer' title='"+row.address+"'>"+value+"</span>";
				}
                return str;
            }
			
			//订单状态
			function orderStatusFormatter(value, row) {
				var str = row.order_status_val;
                return str;
            }
			
			//支付状态
			function payStatusFormatter(value, row) {
				var str = row.pay_status_val;
                return str;
            }
			
			//留言
			function remarkXsFormatter(value, row) {
				var str = '';
				if(value!= null){
					str += "<span style='cursor:pointer' title='"+row.remark+"'>"+value+"</span>";
				}
                return str;
            }
			
			//操作
            function optFormatter(value, row) {
				var str = '';
				if(row.pay_status == 1 && row.order_status == 1){
					str += "<a href='#' name='sure_send' class='easyui-linkbutton info courieradd' onclick=\"courier_add('"+row.order_code+"','"+row.order_id+"')\"></a>&nbsp";
				}
                str += '<a href="#" name="read_user" class="easyui-linkbutton info orderdetail" onclick="create_window(\'orderdetail\',\'订单详情\',\'/ordersmod/views/to-orders-details?order_id='+row.order_id+'\',900,600)"></a>';
                return str;
            }
        });
		function courier_add(order_code,order_id){
            $('#add_win').dialog({
                width : '50%',
                height : '30%',
                modal : true,
                href : '/ordersmod/views/to-courier-add?order_id='+order_id+'&order_code='+order_code,
                resizable : true,
                title : '填写快递信息',
				buttons: [{
					text: '提交',
					iconCls: 'fa fa-check',
					handler: function () {
						if ($('#myform').form('validate')) {
							$.ajax({
								url: '/ordersmod/orders/sure-send?order_id='+order_id+'&order_code='+order_code,
								type: 'post',
								data: $('#myform').serialize(),
								beforeSend: function () {
									$.messager.progress({
										msg: '正在提交中。。。'
									});
								},
								success: function (data) {
									var data = eval('(' + data + ')');
									$.messager.progress('close');
									if (data.code == 600) {
										$.messager.show({
											title: '提示',
											msg: '发货成功！',
										});
										$('#add_win').dialog('close').form('clear');
										$('#datagrid').datagrid('reload');
									} else {
										var msg = '操作失败！';
										if (data.msg != null && data.msg != '') {
											msg = data.msg;
										}
										$.messager.show({
											title: '错误',
											msg: msg,
										});
										$('#add_win').dialog('close').form('clear');
										$('#datagrid').datagrid('reload');
									}
								}
							});
						} else {
							$.messager.show({
								title: '错误',
								msg: '没有有效提交数据！！！',
								// timeout: 3000,
							});
						}
					},
				}, {
					text: '取消',
					iconCls: 'fa fa-close',
					handler: function () {
						$('#add_win').dialog('close').form('clear');
						$('#datagrid').datagrid('reload');
					},
				}],
			});
		}
    </script>


    <!-- <div "> -->
	<div class="dgdiv">
		<table id="datagrid"></table>
	</div>

	<div id="tb">
	
		<div>
            <a href="#" class="easyui-linkbutton primary goodsCategorySearch" iconCls="fa fa-search" onclick="obj.search();"> 查 询 </a>
            <a href="#" class="easyui-linkbutton primary goodsCategorySearch" iconCls="fa fa-search" onclick="create_window('dlg','新增订单','/ordersmod/views/to-add-orders',800,600)"> 新 增 </a>
        </div>
		
    	<div class="tb-column">
            <div class="tb_item">
                <span>订单编号:</span>
                <input type="text" id="order_code" name="order_code" class="easyui-textbox" placeholder="订单编号" >
            </div>
            <div class="tb_item">
                <span>下单用户:</span>
                <input type="text" id="user_name" name="user_name" class="easyui-textbox" placeholder="下单用户名称" >
            </div>
            <div class="tb_item">
                <span>订单状态:</span>
                <input class="easyui-validatebox easyui-combobox" id="order_status" name="order_status">
            </div>
            <div class="tb_item">
                <span>支付状态:</span>
				<input class="easyui-validatebox easyui-combobox" id="pay_status" name="pay_status">
            </div>
            <div class="tb_item">
                <span>下单时间:</span>
                <input type="text" id="start_order_time" name="start_order_time" class="easyui-datebox">
                -
                <input type="text" id="end_order_time" name="end_order_time" class="easyui-datebox" value="<?php echo date('Y-m-d')?>">
            </div>
        </div>
		
		<div id="add_win" style="display: none"></div>
    </div>
</body>
</html>