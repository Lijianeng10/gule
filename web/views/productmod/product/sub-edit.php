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

    .form-item input,
    select {
        width: 170px;
    }
</style>

<div class="super-theme-example">
    <form id="myform">
        <input type="hidden" name="product_id" id="product_id" value="<?php echo $subData['product_id'] ?>">
        <input type="hidden" name="sub_id" id="sub_id" value="<?php echo $subData['sub_id'] ?>">
        <div class="form-item" style="width:80%">
            <label for="" class="label-top">面额：</label>
            <input type="text" name="sub_value" id="sub_value"  value="<?php echo $subData['sub_value'] . '元'; ?>" disabled="true">
        </div>
        <div class="form-item" style="width:80%">
            <label for="" class="label-top">售价：</label>
            <input type="number" name="sub_price" id="sub_price" class="easyui-validatebox"
                   data-options="required:true" value="<?php echo $subData['sub_price']; ?>" min="0">
        </div>
        <div class="form-item" style="width:80%">
            <label for="" class="label-top">库存：</label>
            <input type="number" name="sub_stock" id="sub_stock" class="easyui-validatebox"
                   data-options="required:true" value="<?php echo $subData['sub_stock']; ?>" min="0">
        </div>
        <div class="form-item" style="width:80%">
            <label for="" class="label-top">SKU：</label>
            <input type="text" name="sub_sku" id="sub_sku" class="easyui-validatebox" value="<?php echo $subData['sub_sku']; ?>" min="0">
        </div>
        <div class="form-item" style="width:80%">
            <label for="" class="label-top">状态：</label>
            <select name="status" id="status" class="easyui-combobox" value="">
                <option value="0" <?php if ($subData['sub_status'] == 0): ?> selected="selected" <?php endif; ?> >
                    下架
                </option>
                <option value="1" <?php if ($subData['sub_status'] == 1): ?> selected="selected" <?php endif; ?> >
                    上架
                </option>
            </select>
        </div>
        <div class="form-item">
            <button class="easyui-linkbutton primary" style="margin-left: 70px;" id="subBtn" >提交</button>
            <button class="easyui-linkbutton primary" id="closeBtn"  onclick=" $('#dlg').dialog('close');">关闭<button>
        </div>
                    <iframe id="rfFrame" name="rfFrame" src="about:blank" style="display:none;"></iframe>
                    </form>
                    </div>

                    <script>
                        $(function () {
                            //提交保存信息
                            $("#subBtn").click(function () {
                                document.forms[0].target = "rfFrame";
                                var price = $("#sub_price").val();
                                var stock = $("#sub_stock").val();
                                var sku = $("#sub_sku").val();
                                var status = $("#status option:selected").val();
                                if (price < 0 || stock < 0) {
                                    $.messager.show({
                                        title: '提示',
                                        msg: '所输价格库存的数值均不可小于0'
                                    });
                                    return false;
                                }
                                var pId = $("#product_id").val();
                                var subId = $("#sub_id").val();
                                if ($('#myform').form('validate')) {
                                    $.ajax({
                                        url: '/productmod/product/sub-edit',
                                        type: 'post',
                                        data: {productId: pId, subId: subId, price: price, stock: stock, sku: sku, status: status},
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
//                                            var msg = '操作失败！';
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
                        });

                    </script>
