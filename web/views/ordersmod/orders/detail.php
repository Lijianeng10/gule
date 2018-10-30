<body style="height: 100%;">
    <script type="text/javascript">
        $(function() {
			
			//搜索
            obj2 = {
                editRow: undefined,
                search: function () {
                    $('#datagrid2').datagrid('load', {
                        'goods_code': $.trim($('input[name="goods_code"]').val()),
                        'goods_name': $.trim($('input[name="goods_name"]').val()),
                    });
                },
            };

            $('#datagrid2').datagrid({
                url:'/ordersmod/orders/get-order-detail-list?order_id=<?=$goodsData['order_id']?>&order_code=<?=$goodsData['order_code']?>',
                fit: true,
                pagination: true,
                pageSize: 20,
                singleSelect:true,
                fitColumns: true,
                rownumbers: true,
                loadMsg: '数据加载中...',
                toolbar: '#tb2',
                columns: [
                    [{
                        field: 'goods_code',
                        title: '商品编号',
                        width: 70,
                        align: 'center',
						sortable: true,
                    }, {
                        field: 'goods_name_xs',
                        title: '商品名称',
                        width: 80,
                        halign: 'center',
						align: 'left',
						formatter: goodsNameXsFormatter
                    }, {
                        field: 'attr_name_xs',
                        title: '商品属性',
                        width: 80,
                        halign: 'center',
						align: 'left',
                        //sortable: true,
						formatter: attrNameXsFormatter
                    }, {
                        field: 'stock',
                        title: '库存',
                        width: 50,
                        align: 'center',
                        sortable: true,
                    }, {
                        field: 'sku_price',
                        title: '单价',
                        width: 50,
                        align: 'center',
                        sortable: true,
                    }, {
                        field: 'sku_num',
                        title: '购买数量',
                        width: 50,
                        align: 'center',
                        sortable: true,
                    }, {
                        field: 'is_gift',
                        title: '是否参与优惠',
                        width: 60,
                        align: 'center',
                        sortable: true,
                        formatter: isGiftFormatter
                    }, {
                        field: 'total_money',
                        title: '总金额',
                        width: 50,
                        align: 'center',
                        sortable: true,
                    }]
                ],
            });
			
			//商品名称
			function goodsNameXsFormatter(value, row) {
				var str = '';
				if(row.goods_name != ''){
					str += "<span style='cursor:pointer' title='"+row.goods_name+"'>"+value+"</span>";
				}
                return str;
            }
			
			//商品属性
			function attrNameXsFormatter(value, row) {
				var str = '';
				if(row.attr_name_str != ''){
					str += "<span style='cursor:pointer' title='"+row.attr_name_str+"'>"+value+"</span>";
				}
                return str;
            }
			
			function isGiftFormatter(value,row){
				if(value == 0){
					var str = '否';
				}else{
					var str = '是';
				}
                return str;
            }
        });

	</script>

	<div style="margin-top:20px;">
		<span style="font-weight:bold;font-size:15px;">订单编号：<?=$goodsData['order_code']?></span>
	</div>
	<div id="tb2">
	
		<div>
            <a href="#" class="easyui-linkbutton primary goodsCategorySearch" iconCls="fa fa-search" onclick="obj2.search();"> 查 询 </a>
        </div>
		
    	<div class="tb-column">
            <div class="tb_item">
                <span>商品编号:</span>
                <input type="text" id="goods_code" name="goods_code" class="textbox" placeholder="商品编号" >
            </div>
            <div class="tb_item">
                <span>商品名称:</span>
                <input type="text" id="goods_name" name="goods_name" class="textbox" placeholder="商品名称" >
            </div>
        </div>
    </div>
	<div class="dgdiv" style="height: 98%;margin-top:10px;">
		<table id="datagrid2"></table>
	</div>
</body>