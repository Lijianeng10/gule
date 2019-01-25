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
    $(function() {
        $("#category").combotree({//加载一个combotree,并展开所有节点，因为展开后才能显示选中的值
            url:'/productmod/category/get-category-tree',
            editable:false,
            method:'get',
            lines: true,
            onLoadSuccess:function(node,data){
                var t = $("#category").combotree('tree');//获取tree
                for (var i=0;i<data.length ;i++ ){
                    node= t.tree("find",data[i].id);
                    t.tree('expandAll',node.target);//展开所有节点
                }
            }
        });
        $("#category").combotree('setValue',<?php echo $data['category'];?>);

    });
</script>
<div class="super-theme-example">
    <form id="myform">
        <input name="product_id" type="hidden"  value=" <?php echo $data['product_id'];?> ">
        <div class="form-item" style="width:80%">
            <label for="" class="label-top" style="font-size:16px">基本信息</label>
        </div>
        <div class="form-item" style="width:80%">
            <label for="" class="label-top">产品名称：</label>
            <input type="text" name="product_name" id="product_name" class="easyui-validatebox  easyui-textbox"
                   prompt="请输入产品名称" data-options="required:true,validType:'length[1,150]',missingMessage:'请输入产品名称'"
                   style="width:80%" maxlength="50" value="<?php echo $data['product_name'];?>">
        </div>
        <div class="form-item" style="width:80%">
            <label for="" class="label-top">产品描述：</label>
            <input type="text" name="description" id="description" class="easyui-textbox" style="width:80%" value="<?php echo $data['description'];?>">
        </div>
        <div class="form-item">
            <label for="" class="label-top">所属类别：</label>
            <input name="category" id="category">
        </div>
        <div class="form-item" style="width:80%">
            <label for="" class="label-top">产品价格：</label>
            <input type="number" name="product_price" id="product_price" class="easyui-numberbox"
                   data-options="required:true,min:0.00,missingMessage:'请输入金额且额度大于0'" min="0.00" precision="2" value="<?php echo $data['product_price'];?>">
        </div>
        <div class="form-item" style="width:80%;">
            <label for="" class="label-top" style="font-size:16px">产品主图</label><span style="color:red">(图片尺寸为720*360，单张大小不超过 1024K。)</span>
        </div>
        <div class="form-item product_master_pic" style="width:80%;">
            <?php if ($data['product_pic']): ?>
                <div style="width: 120px;height: 160px; text-align: right;border: 1px solid #BECDD5;position: relative;float: left;margin-left:100px">
                    <img class="productMasterPic" style="width: 100%; height: 100%;float: left;"
                         src="<?php echo $data['product_pic']; ?>">
                    <a href="#"
                       style="width:20px;height:20px;position:absolute;top:-5px;right:-5px;border-radius:100%;border:1px solid #fff;background-color:#666;text-align:center;color:#fff;"
                       class="delMasterPic">X</a>
                </div>
            <?php endif; ?>
            <div style="width: 120px;height: 160px; text-align: center;border: 1px solid #BECDD5;position: relative;float: left;margin-left: 100px;<?php if ($data['product_pic']): ?>display:none;<?php endif; ?>"
                 id="master_pic_up">
                <img style="width: 100%; height: 100%"
                     src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAAEsCAMAAAACbCSWAAAAM1BMVEUAAACZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZlkqvaGAAAAEHRSTlMAf0C/EO8g3zDPcGCfUI+v73TYnwAAAnRJREFUeNrszzENACAQADEk4F8tWCBM92kddAEAAAAAAAAAAAAAAAAAwKd9rdEM+wz7DPsM+wz7DPsM+wz7DPsM+wxD9ovk29Awa9LFcCrDPsM+wz7DPsM+wz7DPsM+w775QwAAAAA47NvbrqowFIXhMWdnDxwd7/+0uwgtyMaVdUmz+C5Qg2n4rbXRxMfjDwiacNYrFibyyyECNiK4HaHDidFjocdTKqsQZFeGqF13/Gn8onDgWK+8Eq5UuWu10HGCZh17XQVAqCjHgYrMtVoYGAF+kM/CufFCeQeJjIyy0c/C6LHoGi00T8ViZo/qWCgcTRMGukYKOy0M2cCtsGPCTt6LcqSipzfjYiqnotuQ623CfQiLtcwiqUEyUiqtz1NHnwDJdB/iTHEfQu+KtF2uKk8EwlFEHLX3vRZliBvu81/XYfAcqVb2iiIc1qGwarHwRVlb4GnYHQtLetdk4Ri3lokvfCtUvLkmCzXVloOfC+d7/xPqVFhbBld4+nVXyffj1bvU5VNFQ4XVQJ/2Ob36pOmouPGW/61wmvbA48ym/+bQSDRYaJFOa+AiKKqAbNLyGnQtFiKM5Bj2QAh7wDlkXTQgMB8Xjn2ThYB29HugeW/AyKFuDzNnZBNpdyx0vKS1cCGeUZHVqsBYay1SgeApaLYQwZEvQ4nKXpxq7rTkdox2y8JvSmHR+zVg8oKFvhIAE0M2B2DwCa0VBrXjoy3ADNcMR3qn702Px+PxeDz+sQcHAgAAAABA/q+NoKqqqqqqqirswYEAAAAAAJD/ayOoqqqqqqqqqqqqqqqqqirtwQEJAAAAgKD/r9sRqAAAAAAAAMwFyhc2VqCXau0AAAAASUVORK5CYII=">
                <input type="file" style="width:100%;height: 100%;opacity: 0;position: absolute;top:0;left:0;"
                       id="uploadMasterPic" name="uploadMasterPic">
            </div>
        </div>
        <div class="form-item" style="width:80%">
            <label for="" class="label-top" style="font-size:16px">产品详情</label>
        </div>
        <div class="form-item" style="width:80%">
            <textarea style="width:100%;height:100px " name="product_detail" id="editor_id"> <?php echo $data['product_detail'];?></textarea>
        </div>
        <div class="form-item" style="width:80%">
            <label for="" class="label-top">状态：</label>
            <select name="status" id="status" class="easyui-combobox" value="">
                <option value="0" <?php if($data['status'] !=1){?>selected <?php }?>>下架</option>
                <option value="1" <?php if($data['status'] ==1){?>selected <?php }?>>上架</option>
            </select>
        </div>
        <div class="form-item">
            <button class="easyui-linkbutton primary" style="margin-left: 95px;" id="sureBtn">提交</button>
        </div>
    </form>
</div>
<iframe id="rfFrame" name="rfFrame" src="about:blank" style="display:none;"></iframe>
<script>
    $(function () {
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
            $(this).parent().remove();
            $("#uploadPic").val("");
        });


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
                        html = '<div style="width: 120px;height: 160px; text-align: right;border: 1px solid #BECDD5;position: relative;float: left;margin-left:100px">\n\
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

    });
    //提交保存信息
    $("#sureBtn").click(function () {
        document.forms[0].target = "rfFrame";
        editor.sync();
        var remark = $.trim($("#editor_id").val());
        // var srcArr = [];
        // $(".productPic").each(function () {
        //     srcArr.push(this.src);
        // })
        var productId = $('input[name="product_id"]').val();
        var masterPic = $('.productMasterPic').attr('src');
        var productName = $("#product_name").val();
        var description = $("#description").val();
        var category = $("#category").val();
        var productPrice = $("#product_price").val();
        var status = $("#status").val();
        if (!masterPic) {
            $.messager.show({
                title: '提示',
                msg: '产品主图不可为空',
            });
            return false;
        }
        if ($('#myform').form('validate')) {
            $.ajax({
                url: '/productmod/product/update',
                type: 'post',
                data: {
                    productId:productId,
                    productName: productName,
                    description: description,
                    category: category,
                    productPrice: productPrice,
                    masterPic: masterPic,
                    remark: remark,
                    status: status,
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
            });
        }

    })
</script>
</body>