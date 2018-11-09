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
        <input name="admin_id" type="hidden"  value="<?php echo $admin['admin_id'];?>">
<!--                </div>-->
        <div class="form-item">
            <label for="" class="label-top">管理员登录名：</label>
            <input name="admin_name" class="easyui-textbox" disabled value="<?php echo $admin['admin_name'];?>">
        </div>
<!--                <div class="form-item">-->
<!--                    <label for="" class="label-top">管理员密码</label>-->
<!--                    <input class="easyui-textbox" data-options="iconCls:'fa fa-user',iconAlign:'left'" prompt="请输入文本">-->
<!--                </div>-->
        <div class="form-item">
            <label for="" class="label-top">管理员昵称：</label>
            <input name="admin_nickname" class="easyui-textbox" disabled value="<?php echo $admin['admin_nickname'];?>">
        </div>
        </div>
        <div class="form-item">
            <label for="" class="label-top">启用状态：</label>
            <select id="ec" class="easyui-combobox" data-options="editable:false,panelHeight:null" name="status">
                <option value="0" <?php if($admin['status'] !=1){?>selected <?php }?>>禁用</option>
                <option value="1" <?php if($admin['status'] ==1){?>selected <?php }?>>启用</option>
            </select>
        </div>
    </form>
</div>