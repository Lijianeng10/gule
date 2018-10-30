<div class="super-theme-example">
    <form id="myform">
        <div class="form-item">
            <label for="" class="label-top">上级权限：</label>
            <input name="auth_pid" class="easyui-combotree"
                   data-options="url:'/adminmod/auth/get-auth-tree?type=2',method:'get',lines: true,animate:true,checkbox:true">
        </div>
        <div class="form-item">
            <label for="" class="label-top">权限名称：</label>
            <input name="auth_name" class="easyui-validatebox easyui-textbox" prompt="请输入权限名称"
                   data-options="required:true,validType:'length[3,10]'">
        </div>
        <div class="form-item">
            <label for="" class="label-top">对应路径：</label>
            <input name="auth_url" class="easyui-validatebox easyui-textbox" prompt="请输入权限路径">
        </div>
        <div class="form-item">
            <label for="" class="label-top">权限类型：</label>
            <select name="auth_type" class="easyui-combobox" value="">
                <option value="2">页面功能</option>
                <option value="1">导航栏菜单</option>
            </select>
        </div>
        <div class="form-item">
            <label for="" class="label-top">启用状态：</label>
            <select name="auth_status" class="easyui-combobox" value="">
                <option value="1">启用</option>
                <option value="0">禁用</option>
            </select>
        </div>
    </form>
</div>