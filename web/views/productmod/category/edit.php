<script type="text/javascript">
    $(function() {
        $("#p_id").combotree({//加载一个combotree,并展开所有节点，因为展开后才能显示选中的值
            url:'/productmod/category/get-category-tree',
            editable:false,
            method:'get',
            lines: true,
            onLoadSuccess:function(node,data){
                var t = $("#p_id").combotree('tree');//获取tree
                for (var i=0;i<data.length ;i++ ){
                    node= t.tree("find",data[i].id);
                    t.tree('expandAll',node.target);//展开所有节点
                }
            }
        });

        $("#p_id").combotree('setValue',<?php echo $auth['p_id'];?>);

    });

</script>
<div class="super-theme-example">
    <form id="myform">
        <input name="category_id" type="hidden"  value=" <?php echo $auth['category_id'];?> ">
        <div class="form-item">
            <label for="" class="label-top">上级类别：</label>
            <input id="p_id" name="p_id" style="width:200px;"></input>
        </div>
        <div class="form-item">
            <label for="" class="label-top">类别名称：</label>
            <input name="name" class="easyui-validatebox easyui-textbox" prompt="请输入类别名称" data-options="required:true" value="<?php echo $auth['name'];?>">
        </div>
        <div class="form-item">
            <label for="" class="label-top">启用状态：</label>
            <select id="ec" class="easyui-combobox" data-options="editable:false,panelHeight:null" name="status">
                <option value="0" <?php if($auth['status'] !=1){?>selected <?php }?>>禁用</option>
                <option value="1" <?php if($auth['status'] ==1){?>selected <?php }?>>启用</option>
            </select>
        </div>
        <div class="form-item">
            <label for="" class="label-top">排序：</label>
            <input name="sort" class="easyui-validatebox easyui-textbox" prompt="请输入排序"  value="<?php echo $auth['sort'];?>">
        </div>
    </form>
</div>