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
                        'user_info': $.trim($('input[name="user_info"]').val()),
                        'goods_info': $.trim($('input[name="goods_info"]').val()),
                        'star': $.trim($('input[name="star"]').val()),
                        'stat_time': $.trim($('input[name="stat_time"]').val()),
                        'end_time': $.trim($('input[name="end_time"]').val()),
                    });
                },
            };
			
            //数据表格
            $('#datagrid').datagrid({
                url: '/ordersmod/comment/get-list',
                fit: true,
                pagination: true,
                pageSize: 20,
                singleSelect:true,
                fitColumns: true,
                rownumbers: true,
                loadMsg: '数据加载中...',
                toolbar: '#tb',
                columns: [
                    [  {
                        field: 'cust_no',
                        title: '用户编号',
                        align: 'center',
                        width: 50,
                        sortable: true
                    },{
                        field:'user_name',
                        title: '昵称',
                        width: 50,
						align: 'center',
                    },{
                        field: 'goods_name',
                        title: '商品名称',
                        width: 80,
						align: 'center',
                    }, {
                        field: 'attName',
                        title: '商品规格',
                        width: 80,
                        // halign: 'center',
						align: 'center',
                    },  {
                        field: 'star',
                        title: '评价星级',
                        width: 30,
                        align: 'center',
						sortable: true,
                    }, {
                        field: 'content',
                        title: '评价内容',
                        width: 80,
                        align: 'center',
                    }, {
                        field: 'create_time',
                        title: '评价时间',
                        width: 60,
                        align: 'center',
                        sortable: true
                    },{
                        field: 'pic',
                        title: '评价图片',
                        width: 100,
						align: 'center',
						formatter: picFormatter
                    },{
                        field: 'opt',
                        title: '操作',
                        width: 130,
                        align: 'center',
                        formatter: optFormatter
                    }
                    ]
                ],
                onLoadSuccess:function(data){
                    $("a[name='up']").linkbutton({text:'隐藏'});
					$("a[name='down']").linkbutton({text:'显示'});
                    $("a[name='answer']").linkbutton({text:'回复列表'});
                }
            });
			
			//评价图片
			function picFormatter(value, row) {
				var str = '';
				if(row.picAry != ''){
				    for(var i=0;i<row.picAry.length;i++){
                        str += '<img data-magnify="gallery" data-src="'+row.picAry[i]+'"  src="'+row.picAry[i]+'" width="40px" height="40px" style="text-align: center">';
                    }

				}
                return str;
            }
			//操作
            function optFormatter(value, row) {
				var str = '';
                str += '<a href="#" name="answer" class="easyui-linkbutton info orderdetail" onclick="create_window(\'win\',\'回复列表\',\'/ordersmod/views/to-answer-list?id='+row.shop_goods_comment_id+'\',900,600)"></a>';
                if(row.is_show ==1){
                    str += '<a href="#" name="up" style="margin-left: 5px" class="easyui-linkbutton info  websiteBananerChangeStatus" onclick="change_status('+row.shop_goods_comment_id+',0)"></a>';
                }else if(row.is_show == 0){
                    str += '<a href="#" name="down" style="margin-left: 5px" class="easyui-linkbutton info  websiteBananerChangeStatus" onclick="change_status('+row.shop_goods_comment_id+',1)"></a>';
                }
                return str;
            }
        });
        function change_status(id,status){
            var statusStr = "隐藏";
            if(status==1){
                statusStr='显示'
            }
            changeStatus('您确定要 ('+statusStr+') 该评论吗?',"/ordersmod/comment/change-status",id,status);
        }
    </script>


    <!-- <div "> -->
	<div class="dgdiv">
		<table id="datagrid"></table>
	</div>

	<div id="tb">
	
		<div>
            <a href="#" class="easyui-linkbutton primary goodsCategorySearch" iconCls="fa fa-search" onclick="obj.search();"> 查 询 </a>
        </div>
		
    	<div class="tb-column">
            <div class="tb_item">
                <span>用户信息:</span>
                <input type="text" name="user_info" class="easyui-textbox" prompt="编号、昵称、手机号" >
            </div>
            <div class="tb_item">
                <span>商品信息:</span>
                <input class="easyui-textbox" name="goods_info" prompt="商品名称、规格名称">
            </div>
            <div class="tb_item">
                <span>评价星级:</span>
                <select class="easyui-combobox"  name="star" data-options="editable:false">
                    <option value="">请选择</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            <div class="tb_item">
                <span>评价时间:</span>
                <input type="text"  name="start_time" class="easyui-datetimebox">
                -
                <input type="text"  name="end_time" class="easyui-datetimebox" value="<?php echo date('Y-m-d H:i:s')?>">
            </div>
        </div>
    </div>
</body>
</html>