
<div class="super-theme-example">
    <form id="myform">
        <div class="form-item">
            <label for="" class="label-top">管理员登录名：</label>
            <input name="admin_name" class="easyui-validatebox easyui-textbox" prompt="请输入用户名" data-options="required:true,validType:'length[3,20]'" >
        </div>
        <div class="form-item">
            <label for="" class="label-top">管理员密码：</label>
            <input name="admin_pwd" class="easyui-textbox" data-options="iconCls:'fa fa-user',iconAlign:'left'" prompt="请输入密码">
        </div>
        <div class="form-item">
            <label for="" class="label-top">管理员昵称：</label>
            <input name="admin_nickname" class="easyui-validatebox easyui-textbox">
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
            <input type="text" class="easyui-combobox" id="admin_type_add" name="admin_type" >
        </div>
        <div class="form-item" id="add_hidden" style="display: none">
            <label for="" class="label-top">所属中心：</label>
            <input type="text" id="center_id" name="center_id" >
        </div>

        <div class="form-item">
            <label for="" class="label-top">启用状态：</label>
            <select name="status" class="easyui-combobox" value="">
                <option value="0" >禁用</option>
                <option value="1" >启用</option>
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
    $("#admin_type_add").combobox({
        valueField:'id', //值字段
        textField:'text', //显示的字段
        panelHeight:'auto',
        data:[{
            'id':'',
            'text':"全部",
            "selected":true
        },{
            'id':'0',
            'text':"系统管理员"
        },{
            'id':'1',
            'text':"中心管理员"
        }],
        editable:false,//不可编辑，只能选择
        onSelect:function(row){
            if(row.id == 1){
                $("#add_hidden").show();
                var url = '/centermod/center/get-center-list-options';
                $('#center_id').combobox('reload', url);
            }else{
                $("#add_hidden").hide();
            }
        }
    });
    $('#center_id').combobox({
        valueField:'id', //值字段
        textField:'text', //显示的字段
        panelHeight:'auto',
        editable:false,//不可编辑，只能选择
    });
</script>