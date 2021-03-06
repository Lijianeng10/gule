<body style="height: 100%;">
<style type="text/css">
    .form-item {
        margin-bottom: 15px;
        width: 50%;
        float: left;
    }

    .form-item > label {
        min-width: 72px;
        display: inline-block;
    }

    .form-item input, select {
        width: 170px;
    }

    .label-top {
        text-align: right;
    }
</style>
<div class="super-theme-example">
    <form id="myform">
        <div class="form-item" style="width:80%">
            <label for="" class="label-top" style="font-size:16px;font-weight: bold">订购网点信息</label>
        </div>
        <div class="form-item" style="width:80%">
            <label for="" class="label-top">网点信息：</label>
            <input name="cust_no_new" id="cust_no_new" class="easyui-validatebox easyui-combobox" style="width:60%" data-options="required:true">
        </div>
        <div class="form-item" style="width:80%">
            <label for="" class="label-top" style="font-size:16px;font-weight: bold">彩票信息</label>
        </div>
        <div class="form-item" style="width:100%;">
            <a href="#" class="easyui-linkbutton primary" id="addTable" style="margin-left: 100px;margin-bottom: 5px;">新增记录行</a>
            <table id="value_table" border='1px' cellspacing="0" style="width:80%;text-align:center;margin-left: 100px;">
                <tr>
					<td style="width:15%">行数</td>
                    <td style="width:25%">彩种</td>
                    <!--<td style="width:15%">彩票面额</td>-->
                    <td style="width:17%">购买数量(包)</td>
                    <td style="width:17%">每包张数</td>
                    <td style="width:17%">价格(包)</td>
                </tr>
				<tr>
					<td style="width:15%" style="width:30px">1</td>
					<td style="width:25%">
						<input class="easyui-validatebox easyui-combobox" style="width:150px" id="lottery_id1" name="lottery_id1" data-options="required:true">
					</td>
					<!--<td style="width:15%">
						<input class="easyui-validatebox easyui-combobox" style="width:80px" id="sub_value1" name="sub_value1">
					</td>-->
					<td style="width:17%">
						<input type="text" id="nums1" name="nums1" style="width:100px" class="easyui-numberbox" data-options="required:true,min:0" >
					</td>
					<td style="width:17%">
						<input type="text" id="sheet_nums1" style="width:100px" name="sheet_nums1" class="easyui-numberbox" data-options="required:true,min:0" >
					</td>
					<td style="width:17%">
						<input type="text" id="price1" name="price1" style="width:100px" class="easyui-numberbox" data-options="required:true,min:0,precision:2">
					</td>
				</tr>
            </table>
        </div>
        <div class="form-item" style="width:80%">
            <label for="" class="label-top" style="font-size:16px;font-weight: bold">收货信息</label>
        </div>
        <div class="form-item" style="width:80%">
            <label for="" class="label-top">收货人：</label>
            <input type="text" name="consignee_name" class="easyui-textbox" prompt="请输入收货人姓名" style="width:60%" data-options="required:true">
        </div>
        <div class="form-item" style="width:80%">
            <label for="" class="label-top">手机号：</label>
            <input type="text" name="consignee_tel" class="easyui-textbox" prompt="请输入收货人手机号" style="width:60%" data-options="required:true">
        </div>
        <div class="form-item" style="width:80%">
            <label for="" class="label-top">收货地址：</label>
            <input type="text" name="consignee_address" class="easyui-textbox" prompt="请输入收货地址" style="width:60%" data-options="required:true">
        </div>
        <div class="form-item">
            <button class="easyui-linkbutton primary" style="margin-left: 10px;" id="sureBtn">提 交</button>
        </div>
		
		<input type="hidden" name="count" id="count" value="1">
		<input type="hidden" name="lottery_id_str" id="lottery_id_str" value="">
    </form>
</div>
<iframe id="rfFrame" name="rfFrame" src="about:blank" style="display:none;"></iframe>
<script>
    $(function () {

		toAdd();
		function toAdd(){
			var count = parseFloat($("#count").val());
			var lottery_id_str = $("#lottery_id_str").val();
				
			//彩种下拉框
			$('#lottery_id' + count).combobox({
				url:'/ordersmod/orders/get-lottery?lottery_id_str='+lottery_id_str,
				valueField:'id',
				textField:'text',
				panelHeight:'auto',
				editable:false,//不可编辑，只能选择
				onSelect: function (row) {
					if (row.id != '') {
						var lottery_id_str = $("#lottery_id_str").val();
						var lottery_id = $("#lottery_id" + count).val();
						if(lottery_id != ''){
							var lottery_id_str_new='';
							lottery_id_str=lottery_id_str.substring(0,lottery_id_str.length-1)
							var arr = lottery_id_str.split(',');
							for(var i in arr){
								if(arr[i]!=lottery_id){
									lottery_id_str_new+=arr[i]+",";
								}
							}
							lottery_id_str_new = lottery_id_str_new + row.id + ',';
							$("#lottery_id_str").val(lottery_id_str_new);
						}else{
							var lottery_id_str_new = lottery_id_str + row.id + ',';
							$("#lottery_id_str").val(lottery_id_str_new);
						}
					}
				},
				onChange:function (n,o) {
					var count_now = parseFloat($("#count").val());
					var lottery_id_str = $("#lottery_id_str").val();
					for(var i=1;i<=count_now;i++){
						if(i != count){
							var lottery_id = $("#lottery_id" + i).val();
							if(lottery_id != ''){
								var lottery_id_new = lottery_id_str.replace(lottery_id+',','');
							}else{
								var lottery_id_new = lottery_id_str;
							}
							$('#lottery_id' + i).combobox('reload', '/ordersmod/orders/get-lottery?lottery_id_str='+lottery_id_new);
						}
					}
				},
			});
			
			/*//面值下拉框
			$('#sub_value' + count).combobox({
				url:'/ordersmod/orders/get-sub-value',
				valueField:'id',
				textField:'text',
				panelHeight:'auto',
				editable:false,//不可编辑，只能选择
			});*/
			
		}
		
		//网点信息
		$('#cust_no_new').combobox({
			url:'/ordersmod/orders/get-store',
			valueField:'id',
			textField:'text',
			panelHeight:'auto',
			editable:true,
		});
			
		//新增彩票订单
		$("#addTable").click(function () {
			var count = parseFloat($("#count").val());
			var new_count = count + 1;
			var str = '';
			str = '<tr>';
			str +='<td style="width:15%" style="width:30px">'+new_count+'</td>'
			str +='<td style="width:25%"><input class="easyui-validatebox easyui-combobox" style="width:150px" id="lottery_id'+new_count+'" name="lottery_id'+new_count+'" data-options="required:true"></td>'
			//str +='<td style="width:15%"><input class="easyui-validatebox easyui-combobox" style="width:80px" id="sub_value'+new_count+'" name="sub_value'+new_count+'"></td>'
			str +='<td style="width:17%"><input type="text" id="nums'+new_count+'" name="nums'+new_count+'" style="width:100px" class="easyui-numberbox" data-options="required:true,min:0"></td>'
			str +='<td style="width:17%"><input type="text" id="sheet_nums'+new_count+'" name="sheet_nums'+new_count+'" style="width:100px" class="easyui-numberbox" data-options="required:true,min:0"></td>'
			str +='<td style="width:17%"><input type="text" id="price'+new_count+'" name="price'+new_count+'" style="width:100px" class="easyui-numberbox" data-options="required:true,min:0,precision:2"></td>'
			str +='</tr>'
			$("#value_table").append(str);
			$('input[name="nums'+new_count+'"]',$("#value_table")).each(function(){  
				$(this).numberbox();  
			});
			$('input[name="sheet_nums'+new_count+'"]',$("#value_table")).each(function(){  
				$(this).numberbox();  
			});
			$('input[name="price'+new_count+'"]',$("#value_table")).each(function(){  
				$(this).numberbox();  
			});
			$("#count").val(new_count);
			toAdd();
		})

    });
    //提交保存信息
    $("#sureBtn").click(function () {
        document.forms[0].target = "rfFrame";
        /*editor.sync();
        var remark = $.trim($("#editor_id").val());
        var srcArr = [];
        $(".productPic").each(function () {
            srcArr.push(this.src);
        })
        var masterPic = $('.productMasterPic').attr('src');
        var productSub = [];
        var error = true;
        $.each($(".l_value"), function () {
            if ($(this).is(':checked')) {
                var lArr = [];
                var l_val = $(this).val();
                var tdArr = $('#value_' + l_val).find("td");
                var l_price = tdArr.eq(1).find('input').val();//价格
                var l_stock = tdArr.eq(2).find('input').val();//库存
                var l_sku = tdArr.eq(3).find('input').val();//  商品SKU
                lArr.push(l_val);
                lArr.push(l_price);
                lArr.push(l_stock);
                lArr.push(l_sku);
                productSub.push(lArr);
                if (l_price < 0 || l_stock < 0) {
                    error = false;
                    return false;
                }
            }
        });
        if (!error) {
            $.messager.show({
                title: '提示',
                msg: '所输价格库存的数值均不可小于0'
            });
            return false;
        }*/
		var cust_no = $("input[name='cust_no_new']").val();
		if (!cust_no) {
            $.messager.show({
                title: '提示',
                msg: '网点编号不可为空',
            });
            return false;
        }
		
		var count = parseFloat($("#count").val());
		var content = [];
		var order_num = 0;//用于记录商品总数
		var order_money = 0;//用于记录订单总金额
		for(var i=1;i<=count;i++){
			var lottery_id = $("#lottery_id" + i).val();//获取彩种的value值
			var lottery_name_str = $('#lottery_id' + i).combobox('getText');//获取彩种的text值
			//var sub_value = $("#sub_value" + i).val();//获取彩票面额的值
			var nums = $("#nums" + i).val();//获取购买数量的值
			var sheet_nums = $("#sheet_nums" + i).val();//获取每包张数的值
			var price = $("#price" + i).val();//获取价格的值
			if(lottery_id != '' || nums != '' || sheet_nums != '' || price != ''){
				if(lottery_id == ''){
					$.messager.show({
						title: '提示',
						msg: "彩票信息-第"+i+"行彩种不能为空！",
					});
					return (false);
				}
				if(nums == ''){
					$.messager.show({
						title: '提示',
						msg: "彩票信息-第"+i+"行购买数量不能为空！",
					});
					return (false);
				}
				if(sheet_nums == ''){
					$.messager.show({
						title: '提示',
						msg: "彩票信息-第"+i+"行每包张数不能为空！",
					});
					return (false);
				}
				if(price == ''){
					$.messager.show({
						title: '提示',
						msg: "彩票信息-第"+i+"行价格不能为空！",
					});
					return (false);
				}
				order_num = order_num + parseFloat(nums);
				order_money = order_money + (parseFloat(nums) * parseFloat(price));
				
				lottery_name_str = lottery_name_str.split("-");
				var lottery_name = lottery_name_str[0];
				var sub_value = lottery_name_str[1].replace("元","");
				
				var lArr = {};
				lArr['lottery_id'] = lottery_id;
				lArr['lottery_name'] = lottery_name;
				lArr['sub_value'] = sub_value;
				lArr['nums'] = parseFloat(nums);
				lArr['sheet_nums'] = parseFloat(sheet_nums);
				lArr['price'] = parseFloat(price);
				content.push(lArr);
			}
		}
		if(!content.length){
			$.messager.show({
				title: '提示',
				msg: "彩票信息不能为空！",
			});
			return (false);
		}
        
        var consignee_name = $("input[name='consignee_name']").val();
        var consignee_tel = $("input[name='consignee_tel']").val();
        var address = $("input[name='consignee_address']").val();
		var consignee_address = consignee_name + ' ' + consignee_tel + ' ' + address;
		
        if ($('#myform').form('validate')) {
            $.ajax({
                url: '/ordersmod/orders/play-order',
                type: 'post',
                data: {
                    cust_no: cust_no,
                    content: content,
                    consignee_name: consignee_name,
                    consignee_tel: consignee_tel,
                    consignee_address: consignee_address,
                    order_num: order_num,
                    order_money: order_money
                },
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
                            msg: '保存成功！',
                        });
                        $('#dlg').dialog('close').form('clear');
                        $('#addWin').dialog('close').form('clear');
                        $('#datagrid').datagrid('reload');
                    } else {
//                                            var msg = data.msg;
//                                            if (data.result != null && data.result != '') {
//                                                msg = data.result;
//                                            }
                        $.messager.show({
                            title: '错误',
                            msg: data.msg,
                        });
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

    })
</script>
</body>
