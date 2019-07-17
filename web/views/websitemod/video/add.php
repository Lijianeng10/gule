<div class="super-theme-example">
    <form id="myform" enctype="multipart/form-data">
        <div class="form-item">
            <label for="" class="label-top">视频：</label>
            <input type="file" id="file">
        </div>
        <div class="form-item">
            <label for="" class="label-top">类型：</label>
            <select name="type" class="easyui-combobox" value="" data-options="panelHeight:'auto',editable:false">
                <option value="1" selected>普通</option>
                <option value="2">VIP</option>
            </select>
        </div>
        <div class="form-item">
            <button class="easyui-linkbutton primary" style="margin-left: 100px;" id="sureBtn" >提交</button>
            <button class="easyui-linkbutton primary" id="closeBtn">关闭<button>
        </div>
    </form>
    <iframe id="rfFrame" name="rfFrame" src="about:blank" style="display:none;"></iframe>
</div>

<script>
    //添加幻灯片
    $('#sureBtn').click(function () {
        document.forms[0].target = "rfFrame";
        var formData = new FormData();
        var data = $("#myform").serializeArray();
        // getBase64Image($("#file").get(0).files[0],function () {
        //     alert(111)
        // });
        formData.append("upfile", $("#file").get(0).files[0]);
        $.each(data, function (i, field){
            formData.append(field.name, field.value);
        });
        $.ajax({
            // url: '/websitemod/video/test-baidu',
            url: '/websitemod/video/add-video',
            async: false,
            type: 'POST',
            processData: false,
            contentType: false,
            data: formData,
            dataType: 'json',
            beforeSend : function() {
                $.messager.progress({
                    msg : '正在提交中。。。'
                });
            },
            success: function (data) {
                $.messager.progress('close');
                if (data.code == 600) {
                    $.messager.show({
                        title: '成功',
                        msg: data.msg,
                    });
                    $('#dlg').dialog('close');
                    $('#datagrid').datagrid('reload');
                } else {
                    $.messager.show({
                        title: '错误',
                        msg: data.msg,
                    });
                }
            }
        });
    })
    /**
     * 根据跳转类型显示隐藏
     */
    $("#jumpType").change(function () {
        var type = $(this).val();
        if(type==1){
            $("#jump").css("display","none")
            $("#adContent").css("display","block");
        }else if(type==2){
            $("#jump").css("display","block");
            $("#adContent").css("display","none");
        }else{
            $("#adContent").css("display","none");
            $("#jump").css("display","none");
        }


    })
    function getBase64Image(imgs,callback) {
        var windowURL = window.URL || window.webkitURL;
        var dataUrl  = windowURL.createObjectURL(imgs);
        var canvas = document.createElement("canvas");
        var ctx = canvas.getContext("2d");
        var img = new Image();
        img.src = dataUrl;
        img.onload = function (ev) {
            canvas.width = img.width;
            canvas.height = img.height;
            ctx.drawImage(img,0,0);
            var dataURL = canvas.toDataURL("image/jpg");
            console.log(dataURL)
        }
    }

</script>

