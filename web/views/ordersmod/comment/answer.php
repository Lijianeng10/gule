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
                url:'/ordersmod/comment/get-answer-list?comment_id=<?=$commentId?>',
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
                        field: 'admin_name',
                        title: '回复人昵称',
                        width: 70,
                        align: 'center',
                    }, {
                        field: 'content',
                        title: '回复内容',
                        width: 80,
                        align: 'center',
                    }, {
                        field: 'create_time',
                        title: '回复时间',
                        width: 80,
						align: 'center',
                        sortable: true,
                    }, ]
                ],
            });
        });

	</script>
    <div id="tb">
        <div>
            <a href="#" class="easyui-linkbutton primary " iconCls="fa  fa-plus" onclick="add_dialog('win2','/ordersmod/views/to-add-answer?id='+<?=$commentId?>,'/ordersmod/comment/add-answer','datagrid2')"> 新 增 </a>
        </div>
    </div>
	<div class="dgdiv" style="height: 98%;margin-top:10px;">
		<table id="datagrid2"></table>
	</div>
</body>