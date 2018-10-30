<style type="text/css">
    .form-item {
        margin-bottom: 15px;
        width: 50%;
        float: left;
    }

    .form-item>label {
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
<!--                <div class="form-item" >-->
        <input name="role_id" type="hidden"  value="<?php echo $role['role_id'];?>">
<!--                </div>-->
        <div class="form-item">
            <label for="" class="label-top">管理员登录名：</label>
            <input name="role_name" class="easyui-validatebox easyui-textbox" prompt="请输入名称" data-options="required:true,validType:'length[3,10]'" value="<?php echo $role['role_name'];?>">
        </div>
        <div class="form-item">
            <label for="" class="label-top">启用状态：</label>
            <select id="ec" class="easyui-combobox" data-options="editable:false,panelHeight:null" name="status">
                <option value="0" <?php if($role['status'] !=1){?>selected <?php }?>>禁用</option>
                <option value="1" <?php if($role['status'] ==1){?>selected <?php }?>>启用</option>
            </select>
        </div>
    </form>
</div>