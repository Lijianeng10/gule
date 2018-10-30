<script type="text/javascript">
    $(function() {
        $("#auth_pid").combotree({//加载一个combotree,并展开所有节点，因为展开后才能显示选中的值
            url:'/adminmod/auth/get-auth-tree',
            editable:false,
            method:'get',
            lines: true,
            onLoadSuccess:function(node,data){
                var t = $("#auth_pid").combotree('tree');//获取tree
                for (var i=0;i<data.length ;i++ ){
                    node= t.tree("find",data[i].id);
                    t.tree('expandAll',node.target);//展开所有节点
                }
            }
        });

        $("#auth_pid").combotree('setValue',<?php echo $auth['auth_pid'];?>);

    });

</script>
<div class="super-theme-example">
    <form id="myform">
        <input name="auth_id" type="hidden"  value=" <?php echo $auth['auth_id'];?> ">
        <div class="form-item">
            <label for="" class="label-top">上级权限：</label>
            <input id="auth_pid" name="auth_pid" style="width:200px;"></input>
        </div>
        <div class="form-item">
            <label for="" class="label-top">权限名称：</label>
            <input name="auth_name" class="easyui-validatebox easyui-textbox" prompt="请输入权限名称" data-options="required:true,validType:'length[2,10]'" value="<?php echo $auth['auth_name'];?>">
        </div>
        <div class="form-item">
            <label for="" class="label-top">对应路径：</label>
            <input name="auth_url" class="easyui-validatebox easyui-textbox" prompt="请输入对应路径"  value="<?php echo $auth['auth_url'];?>" style="width: 220px;">
        </div>
        <div class="form-item">
            <label for="" class="label-top">权限类型：</label>
            <select name="auth_type" class="easyui-combobox" value="">
                <option value="2" <?php if($auth['auth_type'] ==2){?>selected <?php }?>>页面功能</option>
                <option value="1" <?php if($auth['auth_type'] ==1){?>selected <?php }?>>导航栏菜单</option>
<!--                <option value="2">页面功能</option>-->
<!--                <option value="1">导航栏菜单</option>-->
            </select>
        </div>
        <div class="form-item">
            <label for="" class="label-top">启用状态：</label>
            <select id="ec" class="easyui-combobox" data-options="editable:false,panelHeight:null" name="auth_status">
                <option value="0" <?php if($auth['auth_status'] !=1){?>selected <?php }?>>禁用</option>
                <option value="1" <?php if($auth['auth_status'] ==1){?>selected <?php }?>>启用</option>
            </select>
        </div>
        <div class="form-item">
            <label for="" class="label-top">排序：</label>
            <input name="auth_sort" class="easyui-validatebox easyui-textbox" prompt="请输入排序"  value="<?php echo $auth['auth_sort'];?>">
        </div>
    </form>
</div>