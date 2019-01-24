<div class="super-theme-example">
    <form id="myform">
        <div class="form-item">
            <label for="" class="label-top">上级类别：</label>
            <input name="p_id" class="easyui-combotree"
                   data-options="url:'/productmod/category/get-category-tree?type=2',method:'get',lines: true,animate:true,checkbox:true">
        </div>
        <div class="form-item">
            <label for="" class="label-top">类别名称：</label>
            <input type="text" class="easyui-textbox" name="name"  data-options="required:true">
        </div>
        <div class="form-item">
            <label for="" class="label-top">类别排序：</label>
            <input type="text" class="easyui-textbox" name="sort" value="99">
        </div>
        <div class="form-item">
            <label for="" class="label-top">启用状态：</label>
            <select name="status" class="easyui-combobox" value="" data-options="panelHeight:'auto',editable:false">
                <option value="1">启用</option>
                <option value="0">禁用</option>
            </select>
        </div>
    </form>
</div>