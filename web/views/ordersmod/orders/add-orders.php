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
<!--    <script>-->
<!--        var editor;-->
<!--        KindEditor.ready(function (K) {-->
<!--            editor = K.create('#editor_id', {-->
<!--                minWidth: '550px',-->
<!--                height: '350px',-->
<!--                items: [-->
<!--                    'undo', 'redo', '|', 'preview', 'template', 'cut', 'copy', 'paste',-->
<!--                    '|', 'justifyleft', 'justifycenter', 'justifyright',-->
<!--                    'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',-->
<!--                    'superscript', 'clearhtml', 'quickformat', 'selectall', '|', '/',-->
<!--                    'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',-->
<!--                    'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|',-->
<!--                    'insertfile', 'table', 'hr', 'emoticons', 'pagebreak',-->
<!--                    'anchor', 'link', 'unlink', '|'-->
<!--                ],-->
<!--                //     关闭过滤模式，保留所有标签-->
<!--                filterMode: false,-->
<!--            });-->
<!--            // 设置HTML内容-->
<!--            editor.html();-->
<!--        });-->
<!--    </script>-->
<div class="super-theme-example">
    <form id="myform">
        <div class="form-item" style="width:80%">
            <label for="" class="label-top" style="font-size:16px;font-weight: bold">订购网点信息</label>
        </div>
        <div class="form-item" style="width:80%">
            <label for="" class="label-top">网点编号：</label>
            <input type="text" name="cust_no" class="easyui-textbox" prompt="请输入网点编号" style="width:60%">
        </div>
        <!--            <div class="form-item" style="width:80%">-->
        <!--                <label for="" class="label-top">商品副标题：</label>-->
        <!--                <input type="text" name="sub_title" id="sub_title" class="easyui-validatebox  easyui-textbox"  prompt="最多输入50个字" data-options="validType:'length[1,50]'" style="width:80%" maxlength="50">-->
        <!--            </div>-->
        <!--            <div class="form-item" style="width:80%">-->
        <!--                <label for="" class="label-top">商品货号：</label>-->
        <!--                <input type="text" name="product_no" id="product_no" class="easyui-validatebox  easyui-textbox"  data-options="validType:'length[1,25]'" maxlength="25">-->
        <!--            </div>-->
        <div class="form-item" style="width:80%">
            <label for="" class="label-top" style="font-size:16px;font-weight: bold">彩票信息</label>
        </div>
<!--        <div class="form-item" style="width:80%">-->
<!--            <label for="" class="label-top">彩种：</label>-->
<!--            <span>-->
<!--                    --><?php //foreach ($lotteryData as $lottery): ?>
<!--                        <input id="lotteryType" type="radio" name="lotteryType" class="easyui-validatebox"-->
<!--                               value="--><?php //echo $lottery['lottery_id']; ?><!--" data-options="required:true"-->
<!--                               style="width:20px;"><label>--><?php //echo $lottery['lottery_name']; ?><!--</label>-->
<!--                    --><?php //endforeach; ?>
<!--                <a href="#" class="easyui-linkbutton primary" id="addLottery">添加</a>-->
<!--                </span>-->
<!--        </div>-->
        <div class="form-item" style="width:80%;">
            <a href="#" class="easyui-linkbutton primary" id="addTable" style="margin-left: 100px;margin-bottom: 5px;">添 加</a>
<!--            <label for="" class="label-top">彩票面额：</label>-->
<!--            <span style="height:30px;">-->
<!--                    <input type="checkbox" name="lotteryValue" class="l_value" value="2" style="width:20px">2元-->
<!--                    <input type="checkbox" name="lotteryValue" class="l_value" value="3" style="width:20px">3元-->
<!--                    <input type="checkbox" name="lotteryValue" class="l_value" value="5" style="width:20px">5元-->
<!--                    <input type="checkbox" name="lotteryValue" class="l_value" value="10" style="width:20px">10元-->
<!--                    <input type="checkbox" name="lotteryValue" class="l_value" value="20" style="width:20px">20元-->
<!--                    <input type="checkbox" name="lotteryValue" class="l_value" value="30" style="width:20px">30元-->
<!--                </span>-->
            <table id="value_table" border='1px' cellspacing="0" style="width:80%;text-align:center;margin-left: 100px;">
                <tr>
                    <th style="width:15%">彩种</th>
                    <th style="width:15%">彩票面额</th>
                    <th style="width:17%">购买数量(包)</th>
                    <th style="width:17%">每包张数</th>
                    <th style="width:17%">价格(包)</th>
                    <th style="width:17%" class="lottery">价格(包)</th>
                </tr>
            </table>
        </div>
        <div class="form-item" style="width:80%">
            <label for="" class="label-top" style="font-size:16px;font-weight: bold">收货信息</label>
        </div>
        <div class="form-item" style="width:80%">
            <label for="" class="label-top">收货人：</label>
            <input type="text" name="consignee_name" class="easyui-textbox" prompt="请输入收货人姓名" style="width:60%">
        </div>
        <div class="form-item" style="width:80%">
            <label for="" class="label-top">手机号：</label>
            <input type="text" name="consignee_tel" class="easyui-textbox" prompt="请输入收货人手机号" style="width:60%">
        </div>
        <div class="form-item" style="width:80%">
            <label for="" class="label-top">收货地址：</label>
            <input type="text" name="consignee_address" class="easyui-textbox" prompt="请输入收货地址" style="width:60%">
        </div>
        <div class="form-item">
            <button class="easyui-linkbutton primary" style="margin-left: 10px;" id="sureBtn">提 交</button>
        </div>
    </form>
</div>
<iframe id="rfFrame" name="rfFrame" src="about:blank" style="display:none;"></iframe>
<script>
    $(function () {
        //彩种下拉框
        $('.lottery').combobox({
            url:'/ordersmod/orders/get-lottery',
            valueField:'id',
            textField:'text',
            panelHeight:'auto',
            editable:false,//不可编辑，只能选择
        });
        //新增彩票订单
        $("#addTable").click(function () {
            var str = '';
            str = '<tr style="height: 30px;">';
            str +='<td><span class="lottery"></span></td>'
            str +='</tr>'
            $("#value_table").append(str);
        })



        //彩种面值选择
        $(".l_value").click(function () {

            if ($(this).is(':checked')) {
                var l_val = $(this).val();
                var tr = '';
                tr = '<tr id="value_' + l_val + '">\n\
                                                <td>' + l_val + '元</td> <td><input type="number" style="width:80%;border: 0px;" min="0"></td> \n\
                                                <td><input type="number" class="s_stock" style="width:80%;border: 0px;" min="0"></td>\n\
                                                <td><input type="text" style="width:80%;border: 0px;" maxlength="25"></td>\n\
                                            </tr>';
                $("#value_table").append(tr);
                $("#value_table").show();
            } else {
                var l_val = $(this).val();
                $("#value_" + l_val).remove();
            }
        });
        $(".l_value").click(function () {
            var checkedNums = 0;
            $.each($(".l_value"), function () {
                if ($(this).is(':checked')) {
                    checkedNums += 1;
                }
            });
            if (checkedNums == 0) {
                $("#value_table").hide();
            }
            var stockNums = 0;
            $.each($(".s_stock"), function () {
                var l_stock = $(this).val();
                if (l_stock) {
                    stockNums = stockNums + parseInt(l_stock);
                }
            });
            $("#product_stock").val(stockNums);
        });

        $("#addLottery").click(function () {
            $("#addWin").dialog('open');
        });

        $("#value_table").on('change', '.s_stock', function () {
            var stockNums = 0;
            $.each($(".s_stock"), function () {
                var l_stock = $(this).val();
                if (l_stock) {
                    stockNums = stockNums + parseInt(l_stock);
                }
            })
            $("#product_stock").val(stockNums);
        })

    });
    //提交保存信息
    $("#sureBtn").click(function () {
        document.forms[0].target = "rfFrame";
        editor.sync();
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
        }
        var title = $("#title").val();
        var subTitle = $("#sub_title").val();
        var productNo = $("#product_no").val();
        var productPrice = $("#product_price").val();
        var productStock = $("#product_stock").val();
        var status = $("#status").val();
        var lotteryType = $("input[name='lotteryType']:checked").val();

        if (!title) {
            $.messager.show({
                title: '提示',
                msg: '商品标题不可为空',
            });
            return false;
        }
        if (!productPrice) {
            $.messager.show({
                title: '提示',
                msg: '商品价格不可为空',
            });
            return false;
        }
        if (!masterPic) {
            $.messager.show({
                title: '提示',
                msg: '商品主图不可为空',
            });
            return false;
        }
        if ($('#myform').form('validate')) {
            $.ajax({
                url: '/productmod/product/add',
                type: 'post',
                data: {
                    title: title,
                    srcArr: srcArr,
                    productSub: productSub,
                    subTitle: subTitle,
                    productNo: productNo,
                    productPrice: productPrice,
                    productStock: productStock,
                    remark: remark,
                    status: status,
                    lotteryType: lotteryType,
                    masterPic: masterPic
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
