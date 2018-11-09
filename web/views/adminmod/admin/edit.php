<div class="super-theme-example">
    <form id="myform">
        <!--                <div class="form-item" >-->
        <input name="admin_id" type="hidden" value=" <?php echo $admin['admin_id']; ?> ">
        <!--                </div>-->
        <div class="form-item">
            <label for="" class="label-top">管理员登录名：</label>
            <?php echo $admin['admin_name'];?>
        </div>
        <div class="form-item">
            <label for="" class="label-top">管理员密码：</label>
            <input name="admin_pwd" class="easyui-textbox" data-options="iconCls:'fa fa-user',iconAlign:'left'" prompt="请输入密码" value="********">
        </div>
        <div class="form-item">
            <label for="" class="label-top">管理员昵称：</label>
            <input name="nickname" class="easyui-validatebox easyui-textbox"
                   value="<?php echo $admin['nickname']; ?>">
        </div>
        <div class="form-item">
            <label for="" class="label-top">管理员手机号：</label>
            <input name="admin_tel" class="easyui-validatebox easyui-textbox"
                   value="<?php echo $admin['admin_tel']; ?>">
        </div>
<!--        <div class="form-item">-->
<!--            <label for="" class="label-top">管理员头像：</label>-->
<!--            <img height='50' width='50' src="--><?php //echo $admin['admin_pic'] ?><!-- ">-->
<!--        </div>-->
        <div class="form-item">
            <label for="" class="label-top">所属角色：</label>
            <input class="easyui-validatebox easyui-combobox" name="admin_role[]" id="admin_role" data-options="required:true,panelHeight:'auto',editable:false">
        </div>
		<?php if($login_type == '0'){?>
			<div class="form-item">
				<label for="" class="label-top">所属类型：</label>
				<select id="ec" class="easyui-combobox" data-options="editable:false,panelHeight:null" name="admin_type" data-options="panelHeight:'auto',editable:false">
					<option value="0" <?php if ($admin['type'] == 0){ ?>selected <?php } ?>>内部用户</option>
					<option value="1" <?php if ($admin['type'] == 1){ ?>selected <?php } ?>>渠道用户</option>
				</select>
			</div>
		<?php }?>
        <div class="form-item">
            <label for="" class="label-top">启用状态：</label>
            <select id="ec" class="easyui-combobox" data-options="editable:false,panelHeight:null" name="status" data-options="panelHeight:'auto',editable:false">
                <option value="0" <?php if ($admin['status'] != 1){ ?>selected <?php } ?>>禁用</option>
                <option value="1" <?php if ($admin['status'] == 1){ ?>selected <?php } ?>>启用</option>
            </select>
        </div>
		
		<input type="hidden" name="admin_name_old" id="admin_name_old" value="<?php echo $admin['admin_name']; ?>">
    </form>
</div>
<script>
    $("#admin_role").combobox({
        url : '/adminmod/admin/get-role-list?id='+<?php echo $admin['admin_id'];?>,
        valueField : 'id',
        textField : 'text',
        multiple:true,//是否可以多选
        panelHeight:'auto',//面板高度
        editable:false, //不可编辑
    });

</script>
