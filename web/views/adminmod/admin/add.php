
<div class="super-theme-example">
    <form id="myform">
        <div class="form-item">
            <label for="" class="label-top">管理员登录名：</label>
            <input name="admin_name" class="easyui-validatebox easyui-textbox" prompt="请输入用户名" data-options="required:true,validType:'length[3,20]'" >
        </div>
        <div class="form-item">
            <label for="" class="label-top">管理员密码：</label>
            <input name="password" class="easyui-textbox" data-options="iconCls:'fa fa-user',iconAlign:'left'" prompt="请输入密码">
        </div>
        <div class="form-item">
            <label for="" class="label-top">管理员昵称：</label>
            <input name="nickname" class="easyui-validatebox easyui-textbox">
        </div>
        <div class="form-item">
            <label for="" class="label-top">管理员手机号：</label>
            <input name="admin_tel" class="easyui-validatebox easyui-textbox"  data-options="required:true,validType:'length[3,15]'" value="">
        </div>
        <div class="form-item">
            <label for="" class="label-top">所属角色：</label>
            <input class="easyui-combobox" name="admin_role[]" id="admin_role" data-options="required:true">
        </div>
        <div class="form-item">
            <label for="" class="label-top">所属类型：</label>
			<select name="type" class="easyui-combobox" value="">
                <option value="0" selected>内部用户</option>
                <option value="1">渠道用户</option>
            </select>
        </div>

        <div class="form-item">
            <label for="" class="label-top">启用状态：</label>
            <select name="status" class="easyui-combobox" value="">
                <option value="0" >禁用</option>
                <option value="1"  selected>启用</option>
            </select>
        </div>
    </form>
</div>
<script>
    $("#admin_role").combobox({
        url : '/adminmod/admin/get-role-list',
        valueField : 'id',
        textField : 'text',
        multiple:true,//是否可以多选
        panelHeight:'auto',
    });
</script>