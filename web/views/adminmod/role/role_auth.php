<div class="super-theme-example">
    <input type="hidden" id="role_id" value="<?php echo $role_id; ?>">
    <div  id="dd" class="easyui-tree" data-options="url:'/adminmod/role/auths?role_id=<?php echo $role_id;?>',method:'get',lines: true,animate:true,checkbox:true"></div>
    <div style="margin:20px 0;">
        <a href="#" class="easyui-linkbutton info l-btn l-btn-small" onclick="getChecked()">确定</a>
        <a href="#" class="easyui-linkbutton info l-btn l-btn-small" onclick="$('#win').dialog('close')">取消</a>
    </div>
</div>
<script>
    //权限配置--点击事件在弹窗页面
    function getChecked(){
        var roleId = $("#role_id").val();
        var nodes = $('#dd').tree('getChecked', ['checked','indeterminate']);
        var authIds = [];
        for(var i=0; i<nodes.length; i++){
            authIds.push(nodes[i].id);
        }
        // console.log(authIds);
        // return;
        $.ajax({
            url: '/adminmod/role/upauth',
            async: false,
            type: 'POST',
            data: {
                role_id: roleId,
                authIds: JSON.stringify(authIds)
            },
            dataType: 'json',
            success: function (data) {
                if (data.code == 600) {
                    $.messager.show({
                        title : '提示',
                        msg : '保存成功！',
                    });
                    $('#win').dialog('close').form('clear');
                    $('#datagrid').datagrid('reload');
                } else {
                    var msg = '操作失败！';
                    if(data.result != null && data.result != ''){
                        msg = data.result;
                    }
                    $.messager.show({
                        title : '错误',
                        msg : msg,
                    });
                }
                $.messager.progress('close');
            }
        });
    }
</script>
