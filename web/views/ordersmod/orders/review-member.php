<div class="super-theme-example">
    <form id="myform">
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
        <input type="hidden" id="user_authen" name="user_authen">
        <div class="form-item">
            <label>审核说明：</label>
            <textarea  id="authen_remark" rows="5" style="width:380px" maxlength="250"></textarea>
            <span style="display:block;color:#8A8A91;padding-left: 100px;">审核说明不可超过250个字符</span>
        </div>
        <div class="form-item">
            <button class="easyui-linkbutton primary" style="margin-left: 100px;" onclick="review(<?php echo $user_id; ?>, 1)">审核通过</button>
            <button class="easyui-linkbutton error"  onclick="review(<?php echo $user_id; ?>, 3)">审核拒绝</button>
        </div>
    </form>
    <iframe id="rfFrame" name="rfFrame" src="about:blank" style="display:none;"></iframe>
</div>
<script>
    function review(user_id,val) {
        document.forms[0].target = "rfFrame";//防止自动刷新
        var authen_remark = $("#authen_remark").val();
        $.ajax({
            url: "/membermod/user/review-member",
            type: 'post',
            data: {user_id: user_id,user_authen:val,authen_remark:authen_remark},
            async: false,
            beforeSend : function() {
                $.messager.progress({
                    msg : '正在提交中。。。'
                });
            },
            success: function (data) {
                $.messager.progress('close');
                var data = eval('(' + data + ')');
                if (data.code == 600) {
                    $.messager.show({
                        title: '成功',
                        msg: data.msg,
                    });
                    $('#win').dialog('close');
                    $('#datagrid').datagrid('reload');
                } else {
                    $.messager.show({
                        title: '错误',
                        msg: data.msg,
                    });
                }
            }
        });
    }
</script>