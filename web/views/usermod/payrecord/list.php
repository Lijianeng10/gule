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
                        'orderInfo': $.trim($('input[name="orderInfo"]').val()),
                        'cust_no': $.trim($('input[name="cust_no"]').val()),
                        'lotteryInfo': $.trim($('input[name="lotteryInfo"]').val()),
                        'status': $.trim($('input[name="status"]').val()),
                        'start_time': $.trim($('input[name="start_time"]').val()),
                        'end_time': $.trim($('input[name="end_time"]').val()),
                        'pay_start_time': $.trim($('input[name="pay_start_time"]').val()),
                        'pay_end_time': $.trim($('input[name="pay_end_time"]').val()),
                    });
                },
            };
			
			//网点信息
			$('#cust_no').combobox({
				url:'/usermod/payrecord/get-cust-no',
				valueField:'id',
				textField:'text',
				panelHeight:'auto',
				editable:true
			});

            $('#datagrid').datagrid({
                url:'/usermod/payrecord/get-payrecord-list',
                fit: true,
                pagination: true,
                singleSelect:true,
                striped:true,
                rownumbers: true,
                loadMsg: '数据加载中...',
                toolbar: '#tb',
                columns: [
                    [{
                        field: 'order_code',
                        title: '订单编号',
                        width: 200,
                        align: 'center',
                    },{
                        field: 'cust_no',
                        title: '网点信息',
                        width: 100,
                        align: 'center',
                        formatter: mainFormatter
                    },{
                        field: 'terminal_num',
                        title: '终端号',
                        width: 80,
                        align: 'center',
                    },{
                        field: 'lottery_name',
                        title: '彩种名称',
                        width: 80,
                        align: 'center',
                    },{
                        field: 'lottery_value',
                        title: '彩种面额',
                        width: 80,
                        align: 'center',
                    },{
                        field: 'buy_nums',
                        title: '购买数量',
                        width: 80,
                        align: 'center',
                        sortable: true
                    },{
                        field: 'pre_pay_money',
                        title: '预付金额',
                        width: 80,
                        align: 'center',
                    },{
                        field: 'pay_money',
                        title: '实付金额',
                        width: 80,
                        align: 'center',
                        sortable: true
                    },{
                        field: 'status',
                        title: '状态',
                        width: 50,
                        align: 'center',
                        formatter: statusFormatter
                    },{
                        field: 'area',
                        title: '所属区域',
                        width: 200,
                        align: 'center',
                        formatter: areaFormatter
                    },{
                        field: 'create_time',
                        title: '创建时间',
                        width: 130,
                        align: 'center',

                    },{
                        field: 'pay_time',
                        title: '支付时间',
                        width: 130,
                        align: 'center',
                    },
                    //     {
                    //     field: 'opt',
                    //     title: '操作',
                    //     width: 100,
                    //     align: 'left',
                    //     formatter: optFormatter,
                    // }
                    ]
                ],
                onLoadSuccess:function(data){
                    controlBtn();
//                    $("a[name='edit']").linkbutton({text:'编辑',iconCls:'fa fa-edit'});
//                     $("a[name='up']").linkbutton({text:'启用',iconCls:'fa fa-edit'});
//                     $("a[name='down']").linkbutton({text:'禁用',iconCls:'fa fa-edit'});
//                    $("a[name='del']").linkbutton({text:'删除',iconCls:'fa fa-delete'});
                }
            });


            function mainFormatter(value,row){
                str = '';
                str = row.store_name+'<br>'+row.cust_no+'<br>'+row.user_tel;
                return str;
            }

            function statusFormatter(value,row){
                if(value==1){
                    return "<span>已支付<span>";
                }else{
                    return "<span>未支付<span>";
                }
            }
            function areaFormatter(value, row) {
                if(row.province!=null && row.city!=null && row.area!=null){
                    return "<span>" +row.province+'-'+row.city + '-' + row.area + "</span>";
                }
                return '';
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
            function logoFormatter(value, row) {
                var info = '';
                if (row.lottery_img) {
                    info = '<img style="height:40px;width:40px;" src="' + row.lottery_img + '"/>'
                }
                return info;
            }
            // $('#centerlist').combobox('reload', '/centermod/center/get-center-list-options');
        });

	</script>


    <!-- <div "> -->
	<div class="dgdiv">
		<table id="datagrid"></table>
	</div>

	<div id="tb" style="padding:5px;">
        <div class="tb_menu">
            <a href="#" class="easyui-linkbutton primary auth lotterySearch" iconCls="fa fa-search" onclick="obj.search();"> 查 询 </a>
        </div>
        <div class="tb-column">
            <div class="tb_item">
                <span>订单信息：</span>
                <input type="text"  name="orderInfo" class="easyui-textbox" prompt="请输入订单编号">
            </div>
            <div class="tb_item">
                <span>网点信息：</span>
                <input name="cust_no" id="cust_no" class="easyui-validatebox easyui-combobox">
            </div>
            <div class="tb_item">
                <span>彩种信息：</span>
                <input type="text"  name="lotteryInfo" class="easyui-textbox" >
            </div>
            <div class="tb_item">
                <span>支付状态</span>
                <select class="easyui-combobox" data-options="panelHeight:'auto'" name="status" style="width: 100px">
                    <option value="" selected>全部</option>
                    <option value="0">未支付</option>
                    <option value="1">已支付</option>
                </select>
            </div>
<!--            <div class="tb_item">-->
<!--                <span>创建时间：</span>-->
<!--                <input type="text" name="start_time" class="easyui-datetimebox">-->
<!--                --->
<!--                <input type="text" name="end_time" class="easyui-datetimebox">-->
<!--            </div>-->
            <div class="tb_item">
                <span>支付时间：</span>
                <input type="text" name="pay_start_time" class="easyui-datetimebox">
                -
                <input type="text" name="pay_end_time" class="easyui-datetimebox">
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