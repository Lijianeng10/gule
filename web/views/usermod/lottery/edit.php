<body style="height: 100%;">
<div class="super-theme-example">
    <form id="myform">
        <input type="hidden" name ="lottery_id" value="<?php echo $lotteryData['lottery_id'];?>">
        <div class="form-item">
            <label for="" class="label-top">彩种名称：</label>
            <input type="text" name="lottery_name" class="easyui-validatebox easyui-textbox" prompt="请输入文本"
                   data-options="required:true,validType:'length[1,25]'" maxlength="25" value="<?php echo $lotteryData['lottery_name'];?>">
        </div>
        <div class="form-item">
            <label for="" class="label-top">彩种面额：</label>
            <input type="text" name="lottery_value" class="easyui-validatebox easyui-numberbox" prompt="请输入面额"
                   data-options="required:true" value="<?php echo $lotteryData['lottery_value'];?>">
        </div>
        <div class="form-item">
            <label for="" class="label-top">彩种图片：</label>
            <div class="form-item product_pic" style="width:80%;">
                <?php if ($lotteryData['lottery_img']): ?>
                <div style="width: 120px;height: 160px; text-align: center;border: 1px solid #BECDD5;position: relative;float: left;margin-left: 100px;"
                     id="pic_up">
                    <img style="width: 100%; height: 100%"
                         src="<?php echo $lotteryData['lottery_img'];?>">
                    <a href="#"
                       style="width:20px;height:20px;position:absolute;top:-5px;right:-5px;border-radius:100%;border:1px solid #fff;background-color:#666;text-align:center;color:#fff;"
                       class="delPic">X</a>

                </div>
                <?php endif; ?>
                <div style="width: 120px;height: 160px; text-align: center;border: 1px solid #BECDD5;position: relative;float: left;margin-left: 100px;<?php if ($lotteryData['lottery_img']): ?>display:none;<?php endif; ?>"
                     id="pic_up">
                    <img style="width: 100%; height: 100%"
                         src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAAEsCAMAAAACbCSWAAAAM1BMVEUAAACZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZmZlkqvaGAAAAEHRSTlMAf0C/EO8g3zDPcGCfUI+v73TYnwAAAnRJREFUeNrszzENACAQADEk4F8tWCBM92kddAEAAAAAAAAAAAAAAAAAwKd9rdEM+wz7DPsM+wz7DPsM+wz7DPsM+wxD9ovk29Awa9LFcCrDPsM+wz7DPsM+wz7DPsM+w775QwAAAAA47NvbrqowFIXhMWdnDxwd7/+0uwgtyMaVdUmz+C5Qg2n4rbXRxMfjDwiacNYrFibyyyECNiK4HaHDidFjocdTKqsQZFeGqF13/Gn8onDgWK+8Eq5UuWu10HGCZh17XQVAqCjHgYrMtVoYGAF+kM/CufFCeQeJjIyy0c/C6LHoGi00T8ViZo/qWCgcTRMGukYKOy0M2cCtsGPCTt6LcqSipzfjYiqnotuQ623CfQiLtcwiqUEyUiqtz1NHnwDJdB/iTHEfQu+KtF2uKk8EwlFEHLX3vRZliBvu81/XYfAcqVb2iiIc1qGwarHwRVlb4GnYHQtLetdk4Ri3lokvfCtUvLkmCzXVloOfC+d7/xPqVFhbBld4+nVXyffj1bvU5VNFQ4XVQJ/2Ob36pOmouPGW/61wmvbA48ym/+bQSDRYaJFOa+AiKKqAbNLyGnQtFiKM5Bj2QAh7wDlkXTQgMB8Xjn2ThYB29HugeW/AyKFuDzNnZBNpdyx0vKS1cCGeUZHVqsBYay1SgeApaLYQwZEvQ4nKXpxq7rTkdox2y8JvSmHR+zVg8oKFvhIAE0M2B2DwCa0VBrXjoy3ADNcMR3qn702Px+PxeDz+sQcHAgAAAABA/q+NoKqqqqqqqirswYEAAAAAAJD/ayOoqqqqqqqqqqqqqqqqqirtwQEJAAAAgKD/r9sRqAAAAAAAAMwFyhc2VqCXau0AAAAASUVORK5CYII=">
                    <input type="file" style="width:100%;height: 100%;opacity: 0;position: absolute;top:0;left:0;"
                           id="uploadPic" name="uploadPic">
                </div>
            </div>
        </div>
        <div class="form-item">
            <button class="easyui-linkbutton primary" style="margin-left: 100px;" id="sureBtn" >提交</button>
        </div>
    </form>
    <iframe id="rfFrame" name="rfFrame" src="about:blank" style="display:none;"></iframe>
</div>
<script type="text/javascript">
    //图片上传
    $("#uploadPic").change(function () {
        var file = this.files[0];
        var formData = new FormData()
        formData.append("uploadPic", file);
        $.ajax({
            url: "/usermod/lottery/upload-pic",
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
                                                    <img class="productPic" style="width: 100%; height: 100%;float: left;" src="' + retArr.result + '">\n\
                                                    <a href="#" style="width:20px;height:20px;position:absolute;top:-5px;right:-5px;border-radius:100%;border:1px solid #fff;background-color:#666;text-align:center;color:#fff;" class="delPic">X</a>\n\
                                                </div>';
                    $("#pic_up").before(html);
                    $("#pic_up").hide();
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
    //删除图片
    $('.product_pic').on('click', '.delPic', function () {
        $(this).parent().remove();
        $("#uploadPic").val("");
        $("#pic_up").show();
    });
    //提交保存
    $("#sureBtn").click(function () {
        document.forms[0].target = "rfFrame";
        var lottery_pic = $('.productPic').attr('src');
        var lottery_id = $.trim($('input[name="lottery_id"]').val());
        var lottery_name = $.trim($('input[name="lottery_name"]').val());
        var lottery_value = $.trim($('input[name="lottery_value"]').val());
        if ($('#myform').form('validate')) {
            $.ajax({
                url: '/usermod/lottery/update',
                type: 'post',
                data: {lottery_pic: lottery_pic, lottery_name: lottery_name, lottery_value: lottery_value,lottery_id:lottery_id},
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