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
<script>
    var editor;
    KindEditor.ready(function (K) {
        editor = K.create('#editor_id', {
            minWidth: '550px',
            height: '350px',
            items: [
                'undo', 'redo', '|', 'preview', 'template', 'cut', 'copy', 'paste',
                '|', 'justifyleft', 'justifycenter', 'justifyright',
                'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
                'superscript', 'clearhtml', 'quickformat', 'selectall', '|', '/',
                'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
                'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|',
                'insertfile', 'table', 'hr', 'emoticons', 'pagebreak',
                'anchor', 'link', 'unlink', '|'
            ],
            //     关闭过滤模式，保留所有标签
            filterMode: false,
        });
        // 设置HTML内容
        editor.html();
    });
</script>
<div class="super-theme-example">
    <form id="myform">
        <input type="hidden" name="product_id" id="product_id" value="<?php echo $productData['product_id'] ?>">
        <div class="form-item" style="width:80%">
            <label for="" class="label-top" style="font-size:16px">基本信息</label>
        </div>
        <div class="form-item" style="width:80%">
            <label for="" class="label-top">商品标题：</label>
            <input type="text" name="title" id="title" class="easyui-validatebox easyui-textbox" prompt="请输入商品标题,最多输入50个字"
                   data-options="required:true,validType:'length[1,50]',missingMessage:'请输入商品标题'" style="width:80%"
                   value="<?php echo $productData['product_title']; ?>" maxlength="50">
        </div>
        <div class="form-item" style="width:80%">
            <label for="" class="label-top">商品副标题：</label>
            <input type="text" name="sub_title" id="sub_title" class="easyui-validatebox easyui-textbox" prompt="最多输入50个字"
                   data-options="validType:'length[1,50]'" style="width:80%"
                   value="<?php echo $productData['product_sub_title']; ?>" maxlength="50">
        </div>
        <div class="form-item" style="width:80%">
            <label for="" class="label-top">商品货号：</label>
            <input name="product_no" id="product_no" class="easyui-validatebox easyui-textbox"
                   data-options="validType:'length[1,25]'" value="<?php echo $productData['art_no']; ?>" maxlength="25">
        </div>
        <div class="form-item" style="width:80%">
            <label for="" class="label-top" style="font-size:16px">销售属性</label>
        </div>
        <div class="form-item" style="width:80%">
            <label for="" class="label-top">商品价格：</label>
            <input type="number" name="product_price" id="product_price" class="easyui-validatebox easyui-numberbox"
                   prompt="请输入金额" data-options="required:true,min:0,missingMessage:'请输入金额'" value="<?php echo $productData['product_price']; ?>" min="0">
        </div>
        <div class="form-item" style="width:80%">
            <label for="" class="label-top">彩种：</label>
            <span>
                <input id="lotteryType" type="radio" name="lotteryType" id="lotteryType" class="easyui-validatebox"
                       value="<?php echo $productData['lottery_id']; ?>" data-options="required:true"
                       style="width:20px;" checked="true"><label><?php echo $productData['lottery_name']; ?></label>
            </span>

        </div>
        <div class="form-item" style="width:80%">
            <label for="" class="label-top">彩票面额：</label>
            <span style="height:30px;">
                <input type="checkbox" name="lotteryValue" class="l_value" id="lotteryValue2"
                       value="2" <?php if (in_array(2, $subValue)): ?> checked="true" <?php endif; ?>
                       style="width:20px">2元
                <input type="checkbox" name="lotteryValue" class="l_value" id="lotteryValue3"
                       value="3" <?php if (in_array(3, $subValue)): ?> checked="true" <?php endif; ?>
                       style="width:20px">3元
                <input type="checkbox" name="lotteryValue" class="l_value" id="lotteryValue5"
                       value="5" <?php if (in_array(5, $subValue)): ?> checked="true" <?php endif; ?>
                       style="width:20px">5元
                <input type="checkbox" name="lotteryValue" class="l_value" id="lotteryValue10"
                       value="10" <?php if (in_array(10, $subValue)): ?> checked="true" <?php endif; ?>
                       style="width:20px">10元
                <input type="checkbox" name="lotteryValue" class="l_value" id="lotteryValue20"
                       value="20" <?php if (in_array(20, $subValue)): ?> checked="true" <?php endif; ?>
                       style="width:20px">20元
                <input type="checkbox" name="lotteryValue" class="l_value" id="lotteryValue30"
                       value="30" <?php if (in_array(30, $subValue)): ?> checked="true" <?php endif; ?>
                       style="width:20px">30元
            </span>
            <table id="value_table" border='1px' cellspacing="0" style="width:80%;text-align:center;display: none"
                   align='center'>
                <tr>
                    <th style="width:15%">彩票面额</th>
                    <th style="width:17%">价格(包)</th>
                    <!--<th style="width:17%">价格(箱)</th>-->
                    <th style="width:17%">库存(包)</th>
                    <!--<th style="width:17%">库存(箱)</th>-->
                    <th style="width:17%">商家SKU</th>
                </tr>

            </table>
        </div>
        <div class="form-item" style="width:80%">
            <label for="" class="label-top">商品库存：</label>
            <input type="number" name="product_stock" id="product_stock" class="easyui-validatebox"
                   data-options="required:true" value="<?php echo $productData['product_stock']; ?>" min="0" disabled="true">
        </div>
        <div class="form-item" style="width:80%;">
            <label for="" class="label-top" style="font-size:16px">商品主图</label><span style="color:red">(图片尺寸为720*360，单张大小不超过 1024K。)</span>
        </div>
        <div class="form-item product_master_pic" style="width:80%;">
            <?php if ($productData['img_url']): ?>
                <div style="width: 120px;height: 160px; text-align: right;border: 1px solid #BECDD5;position: relative;float: left;margin-right:5px">
                    <img class="productMasterPic" style="width: 100%; height: 100%;float: left;"
                         src="<?php echo $productData['img_url']; ?>">
                    <a href="#"
                       style="width:20px;height:20px;position:absolute;top:-5px;right:-5px;border-radius:100%;border:1px solid #fff;background-color:#666;text-align:center;color:#fff;"
                       class="delMasterPic">X</a>
                </div>
            <?php endif; ?>
            <div style="width: 120px;height: 160px; text-align: center;border: 1px solid #BECDD5;position: relative;float: left;padding-left: 5px;<?php if ($productData['img_url']): ?>display:none;<?php endif; ?>"
                 id="master_pic_up">
                <img style="width: 100%; height: 100%"
                     src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAAEsCAMAAAACbCSWAAAAM1BMVEUAAACZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZlkqvaGAAAAEHRSTlMAf0C/EO8g3zDPcGCfUI+v73TYnwAAAnRJREFUeNrszzENACAQADEk4F8tWCBM92kddAEAAAAAAAAAAAAAAAAAwKd9rdEM+wz7DPsM+wz7DPsM+wz7DPsM+wxD9ovk29Awa9LFcCrDPsM+wz7DPsM+wz7DPsM+w775QwAAAAA47NvbrqowFIXhMWdnDxwd7/+0uwgtyMaVdUmz+C5Qg2n4rbXRxMfjDwiacNYrFibyyyECNiK4HaHDidFjocdTKqsQZFeGqF13/Gn8onDgWK+8Eq5UuWu10HGCZh17XQVAqCjHgYrMtVoYGAF+kM/CufFCeQeJjIyy0c/C6LHoGi00T8ViZo/qWCgcTRMGukYKOy0M2cCtsGPCTt6LcqSipzfjYiqnotuQ623CfQiLtcwiqUEyUiqtz1NHnwDJdB/iTHEfQu+KtF2uKk8EwlFEHLX3vRZliBvu81/XYfAcqVb2iiIc1qGwarHwRVlb4GnYHQtLetdk4Ri3lokvfCtUvLkmCzXVloOfC+d7/xPqVFhbBld4+nVXyffj1bvU5VNFQ4XVQJ/2Ob36pOmouPGW/61wmvbA48ym/+bQSDRYaJFOa+AiKKqAbNLyGnQtFiKM5Bj2QAh7wDlkXTQgMB8Xjn2ThYB29HugeW/AyKFuDzNnZBNpdyx0vKS1cCGeUZHVqsBYay1SgeApaLYQwZEvQ4nKXpxq7rTkdox2y8JvSmHR+zVg8oKFvhIAE0M2B2DwCa0VBrXjoy3ADNcMR3qn702Px+PxeDz+sQcHAgAAAABA/q+NoKqqqqqqqirswYEAAAAAAJD/ayOoqqqqqqqqqqqqqqqqqirtwQEJAAAAgKD/r9sRqAAAAAAAAMwFyhc2VqCXau0AAAAASUVORK5CYII=">
                <input type="file" style="width:100%;height: 100%;opacity: 0;position: absolute;top:0;left:0;"
                       id="uploadMasterPic" name="uploadMasterPic">
            </div>
        </div>
        <div class="form-item" style="width:80%;">
            <label for="" class="label-top" style="font-size:16px">商品图片</label><span style="color:red">(图片尺寸为720*360，单张大小不超过 1024K。)</span>
        </div>
        <div class="form-item product_pic" style="width:80%;">
            <?php foreach ($imgData as $img): ?>
                <div style="width: 120px;height: 160px; text-align: right;border: 1px solid #BECDD5;position: relative;float: left;margin-right:5px">
                    <img class="productPic" style="width: 100%; height: 100%;float: left;"
                         src="<?php echo $img['img_url']; ?>">
                    <a href="#"
                       style="width:20px;height:20px;position:absolute;top:-5px;right:-5px;border-radius:100%;border:1px solid #fff;background-color:#666;text-align:center;color:#fff;"
                       class="delPic">X</a>
                </div>
            <?php endforeach; ?>
            <div style="width: 120px;height: 160px; text-align: center;border: 1px solid #BECDD5;position: relative;float: left;padding-left: 5px"
                 id="pic_up">
                <img style="width: 100%; height: 100%"
                     src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAAEsCAMAAAACbCSWAAAAM1BMVEUAAACZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZlkqvaGAAAAEHRSTlMAf0C/EO8g3zDPcGCfUI+v73TYnwAAAnRJREFUeNrszzENACAQADEk4F8tWCBM92kddAEAAAAAAAAAAAAAAAAAwKd9rdEM+wz7DPsM+wz7DPsM+wz7DPsM+wxD9ovk29Awa9LFcCrDPsM+wz7DPsM+wz7DPsM+w775QwAAAAA47NvbrqowFIXhMWdnDxwd7/+0uwgtyMaVdUmz+C5Qg2n4rbXRxMfjDwiacNYrFibyyyECNiK4HaHDidFjocdTKqsQZFeGqF13/Gn8onDgWK+8Eq5UuWu10HGCZh17XQVAqCjHgYrMtVoYGAF+kM/CufFCeQeJjIyy0c/C6LHoGi00T8ViZo/qWCgcTRMGukYKOy0M2cCtsGPCTt6LcqSipzfjYiqnotuQ623CfQiLtcwiqUEyUiqtz1NHnwDJdB/iTHEfQu+KtF2uKk8EwlFEHLX3vRZliBvu81/XYfAcqVb2iiIc1qGwarHwRVlb4GnYHQtLetdk4Ri3lokvfCtUvLkmCzXVloOfC+d7/xPqVFhbBld4+nVXyffj1bvU5VNFQ4XVQJ/2Ob36pOmouPGW/61wmvbA48ym/+bQSDRYaJFOa+AiKKqAbNLyGnQtFiKM5Bj2QAh7wDlkXTQgMB8Xjn2ThYB29HugeW/AyKFuDzNnZBNpdyx0vKS1cCGeUZHVqsBYay1SgeApaLYQwZEvQ4nKXpxq7rTkdox2y8JvSmHR+zVg8oKFvhIAE0M2B2DwCa0VBrXjoy3ADNcMR3qn702Px+PxeDz+sQcHAgAAAABA/q+NoKqqqqqqqirswYEAAAAAAJD/ayOoqqqqqqqqqqqqqqqqqirtwQEJAAAAgKD/r9sRqAAAAAAAAMwFyhc2VqCXau0AAAAASUVORK5CYII=">
                <input type="file" style="width:100%;height: 100%;opacity: 0;position: absolute;top:0;left:0;"
                       id="uploadPic" name="uploadPic">
            </div>
        </div>
        <div class="form-item" style="width:80%">
            <label for="" class="label-top" style="font-size:16px">商品描述</label>
        </div>
        <div class="form-item" style="width:80%">
            <textarea style="width:100%;height:100px " name="remark"
                      id="editor_id"> <?php echo $productData['remark']; ?></textarea>
        </div>
        <div class="form-item" style="width:80%">
            <label for="" class="label-top" style="font-size:16px">商品状态</label>
        </div>
        <div class="form-item" style="width:80%">
            <label for="" class="label-top">状态：</label>
            <select name="status" id="status" class="easyui-combobox" value="">
                <option value="0" <?php if ($productData['product_status'] == 0): ?> selected="selected" <?php endif; ?> >
                    下架
                </option>
                <option value="1" <?php if ($productData['product_status'] == 1): ?> selected="selected" <?php endif; ?> >
                    上架
                </option>
            </select>
        </div>
        <div class="form-item">
            <button class="easyui-linkbutton primary" style="margin-left: 10px;" id="sureBtn" >提交</button>
            <button class="easyui-linkbutton primary" id="closeBtn"  onclick=" $('#dlg').dialog('close');">关闭<button>
                    </div>
                    <iframe id="rfFrame" name="rfFrame" src="about:blank" style="display:none;"></iframe>
                    </form>
                    </div>

                    <script>
                        $(function () {
                            alert(23);
                            var allStock = 0;
                            $.each($(".l_value"), function () {
                                if ($(this).is(':checked')) {
                                    var l_val = $(this).val();
                                    doAppend(l_val);
                                    var tdArr = $('#value_' + l_val).find("td");
                                    var l_stock = tdArr.eq(2).find('input').val();//库存
                                    allStock = allStock + parseInt(l_stock);
                                }
                            });
                            $("#product_stock").val(allStock);
                            $(".l_value").click(function () {
                                if ($(this).is(':checked')) {
                                    var l_val = $(this).val();
                                    doAppend(l_val);
                                } else {
                                    var l_val = $(this).val();
                                    $("#value_" + l_val).remove();
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
                            var picArr = [];
                            $("#addLottery").click(function () {
                                $("#addWin").dialog('open');
                            });

                            $("#uploadPic").change(function () {
                                var file = this.files[0];
                                var formData = new FormData()
                                formData.append("uploadPic", file);
                                $.ajax({
                                    url: "/productmod/product/upload-pic",
                                    type: 'post',
                                    data: formData,
                                    contentType: false,
                                    processData: false,
                                    beforeSend: function () {
                                        $.messager.progress({
                                            msg: '正在提交中。。。'
                                        });
                                    },
                                    success: function (ret) {
                                        var retArr = eval('(' + ret + ')');
                                        if (retArr.code == 600) {
                                            var html = '';
                                            html = '<div style="width: 120px;height: 160px; text-align: right;border: 1px solid #BECDD5;position: relative;float: left;margin-right:5px">\n\
                                                        <img class="productPic" style="width: 100%; height: 100%;float: left;" src="' + retArr.result + '">\n\
                                                        <a href="#" style="width:20px;height:20px;position:absolute;top:-5px;right:-5px;border-radius:100%;border:1px solid #fff;background-color:#666;text-align:center;color:#fff;" class="delPic">X</a>\n\
                                                    </div>';
                                            $("#pic_up").before(html);
                                            picArr.push(retArr.result);
                                        } else {
                                            $.messager.show({
                                                title: '提示',
                                                msg: retArr.msg
                                            });
                                        }
                                        $.messager.progress('close');
                                    }
                                })
                            });

                            $('.product_pic').on('click', '.delPic', function () {
                                $("#uploadPic").val("");
                                $(this).parent().remove();
                            });

                            $("#value_table").on('change', '.s_stock', function () {
                                var stockNums = 0;
                                $.each($(".s_stock"), function () {
                                    var l_stock = $(this).val();
                                    if (l_stock) {
                                        stockNums = stockNums + parseInt(l_stock);
                                    }
                                });
                                $("#product_stock").val(stockNums);
                            })

                            function doAppend(l_val) {
                                var tr = '';
                                var subPrice = '';
                                var subStock = '';
                                var subSku = '';
                                if (l_val == 2) {
<?php if (in_array(2, $subValue)): ?>
                                        subPrice = <?php echo $subData[2]['sub_price'] ?>;
                                        subStock = <?php echo $subData[2]['sub_stock']; ?>;
                                        subSku = '<?php echo $subData[2]['sub_sku']; ?>';
<?php endif; ?>
                                } else if (l_val == 3) {
<?php if (in_array(3, $subValue)): ?>
                                        subPrice = <?php echo $subData[3]['sub_price'] ?>;
                                        subStock = <?php echo $subData[3]['sub_stock']; ?>;
                                        subSku = '<?php echo $subData[3]['sub_sku']; ?>';
<?php endif; ?>
                                } else if (l_val == 5) {
<?php if (in_array(5, $subValue)): ?>
                                        subPrice = <?php echo $subData[5]['sub_price'] ?>;
                                        subStock = <?php echo $subData[5]['sub_stock']; ?>;
                                        subSku = '<?php echo $subData[5]['sub_sku']; ?>';
<?php endif; ?>
                                } else if (l_val == 10) {
<?php if (in_array(10, $subValue)): ?>
                                        subPrice = <?php echo $subData[10]['sub_price'] ?>;
                                        subStock = <?php echo $subData[10]['sub_stock']; ?>;
                                        subSku = '<?php echo $subData[10]['sub_sku']; ?>';
<?php endif; ?>
                                } else if (l_val == 20) {
<?php if (in_array(20, $subValue)): ?>
                                        subPrice = <?php echo $subData[20]['sub_price'] ?>;
                                        subStock = <?php echo $subData[20]['sub_stock']; ?>;
                                        subSku = '<?php echo $subData[20]['sub_sku']; ?>';
<?php endif; ?>
                                } else if (l_val == 30) {
<?php if (in_array(30, $subValue)): ?>
                                        subPrice = <?php echo $subData[30]['sub_price'] ?>;
                                        subStock = <?php echo $subData[30]['sub_stock']; ?>;
                                        subSku = '<?php echo $subData[30]['sub_sku']; ?>';
<?php endif; ?>
                                }
                                tr = '<tr id="value_' + l_val + '">\n\
                                                    <td>' + l_val + '元</td> <td><input type="number" style="width:80%;border: 0px;" value="' + subPrice + '" min="0"></td> \n\
                                                    <td><input type="number" class="s_stock" style="width:80%;border: 0px;" value="' + subStock + '" min="0"></td>\n\
                                                    <td><input type="text" style="width:80%;border: 0px;" value="' + subSku + '" maxlength="25"></td>\n\
                                                </tr>';
                                $("#value_table").append(tr);
                                $("#value_table").show();
                            }

                            $("#uploadMasterPic").change(function () {
                                var file = this.files[0];
                                var formData = new FormData()
                                formData.append("uploadPic", file);
                                $.ajax({
                                    url: "/productmod/product/upload-pic",
                                    type: 'post',
                                    data: formData,
                                    contentType: false,
                                    processData: false,
                                    beforeSend: function () {
                                        $.messager.progress({
                                            msg: '正在提交中。。。'
                                        });
                                    },
                                    success: function (ret) {
                                        var retArr = eval('(' + ret + ')');
                                        if (retArr.code == 600) {
                                            var html = '';
                                            html = '<div style="width: 120px;height: 160px; text-align: right;border: 1px solid #BECDD5;position: relative;float: left;margin-right:5px">\n\
                                                        <img class="productMasterPic" style="width: 100%; height: 100%;float: left;" src="' + retArr.result + '">\n\
                                                        <a href="#" style="width:20px;height:20px;position:absolute;top:-5px;right:-5px;border-radius:100%;border:1px solid #fff;background-color:#666;text-align:center;color:#fff;" class="delMasterPic">X</a>\n\
                                                    </div>';
                                            $("#master_pic_up").before(html);
                                            $("#master_pic_up").hide();
                                        } else {
                                            $.messager.show({
                                                title: '提示',
                                                msg: retArr.msg
                                            });
                                        }
                                        $.messager.progress('close');
                                    }
                                })
                            });

                            $('.product_master_pic').on('click', '.delMasterPic', function () {
                                $(this).parent().remove();
                                $("#uploadMasterPic").val("");
                                $("#master_pic_up").show();
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
                                var productSub = [];
                                var valueSub = [];
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
                                        valueSub.push(l_val);
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
                                var remark = $("#remark").val();
                                var status = $("#status option:selected").val();
                                var lotteryType = $("input[name='lotteryType']:checked").val();
                                var productId = $('#product_id').val();
                                editor.sync();
                                var remark = $.trim($("#editor_id").val());
                                var masterPic = $('.productMasterPic').attr('src');
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
                                        url: '/productmod/product/update',
                                        type: 'post',
                                        data: {productId: productId, title: title, srcArr: srcArr, productSub: productSub, subTitle: subTitle, productNo: productNo, productPrice: productPrice, productStock: productStock, remark: remark, status: status, lotteryType: lotteryType, valueSub: valueSub, masterPic: masterPic},
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
