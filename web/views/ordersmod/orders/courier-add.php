<body style="height: 100%;">
    <style type="text/css">
        .form-item {
            margin-bottom: 15px;
            width: 50%;
            float: left;
        }
		
		.form-item>span {
            display: inline-block;
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
    <div class="super-theme-example">
        <form id="myform">
			<div class="form-item" style="width:100%">
                <span style="font-size:16px">订单编号：<?=$ordersData['order_code']?></span>
            </div>
            <div class="form-item">
                <label for="" class="label-top">快递单号：</label>
                <input name="courier_code" id="courier_code" class="easyui-validatebox easyui-textbox" prompt="请输入快递单号" data-options="required:true" >
            </div>
            <div class="form-item">
                <label for="" class="label-top">快递名称：</label>
                <input id="courier_name" name="courier_name" class="easyui-validatebox easyui-textbox">
            </div>
        </form>
    </div>
</body>