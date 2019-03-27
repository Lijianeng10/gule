<script>
    $(function () {
        window.editor = KindEditor.create('#editor_id', {
            minWidth: '550px',
            height: '350px',
            items: [
                'undo', 'redo', '|', 'preview', 'template', 'cut', 'copy', 'paste',
                '|', 'justifyleft', 'justifycenter', 'justifyright',
                'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
                'superscript', 'clearhtml', 'quickformat', 'selectall', '|', '/',
                'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
                'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|','image',
                'insertfile', 'table', 'hr', 'emoticons', 'pagebreak',
                'anchor', 'link', 'unlink', '|'
            ],
            //     关闭过滤模式，保留所有标签
            filterMode: false,
            uploadJson:"/tools/img/upload-img",
            afterUpload: function(){this.sync();}, //图片上传后，将上传内容同步到textarea中
            afterBlur: function(){this.sync();},   ////失去焦点时，将上传内容同步到textarea中
        });
        // 设置HTML内容
        window.editor.html();
    })
</script>
<div class="super-theme-example">
    <form id="myform">
        <input type="hidden" value="<?php echo $banner["banner_id"]; ?>" name="banner_id">
        <div class="form-item">
            <label for="" class="label-top">标题：</label>
            <input name="articleTitle" id="articleTitle" type="text" class="easyui-validatebox easyui-textbox" placeholder="文章标题" style="width: 230px;"
                   data-options="required:true,validType:'length[1,100]'" value="<?php echo $banner['pic_name'];?>">
        </div>
        <div class="form-item">
            <label for="" class="label-top">图片：</label>
                <a class="buttomspan" onclick="$('#picture').click();">上传</a>
                <a class="buttomspan" onclick="javascript:$('#picture').val('');$('#showimg').attr('src', '/images/u1529.png');$('#showimg').css({ width:'140px',height:'140px',})">| 删除</a>
                <img src="<?php echo $banner["pic_url"];?>" id="showimg" style="width: 140px;height: 140px" class="am-img-thumbnail">
                <span style="color:red;font-size:14px; display: block;margin-left: 100px;">图片宽高最佳为720x315,大小限制为200k以下</span>
                <input type="file" id="picture" class="imgupload">
        </div>
        <div class="form-item">
            <label for="" class="label-top">跳转类型：</label>
            <select class="easyui-combobox" id="jumpType">
                <?php
                foreach ($picJump as $k => $v){
                    if( $banner['jump_type']==$k){
                        echo "<option value='".$k."' selected = 'selected'>".$v."</option>";
                    }else{
                        echo "<option value='".$k."'>".$v."</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="form-item">
            <label for="" class="label-top">跳转标题：</label>
            <input name="jumpTitle" id="jumpTitle" type="text" class="easyui-validatebox easyui-textbox" placeholder="跳转标题" style="width: 230px;" value="<?php echo $banner['jump_title'];?>">
        </div>
        <div class="form-item">
            <label for="" class="label-top">跳转地址：</label>
            <input name="jumpUrl" id="jumpUrl" type="text" class="easyui-validatebox easyui-textbox" placeholder="跳转地址" style="width: 230px;" value="<?php echo $banner['jump_url'];?>">
            <span style="color:red;font-size:14px;">跳转地址开头请加上http或者https</span>
        </div>
        <div  class="form-item" id="adContent">
            <label for="" class="label-top">广告内容：</label>
            <textarea id="editor_id"  style="width:550px;height:350px;margin-left: 102px;">
                <?php echo $banner["content"];?>
            </textarea>
        </div>
        <div class="form-item">
            <button class="easyui-linkbutton primary" style="margin-left: 100px;" id="sureBtn" >提交</button>
            <button class="easyui-linkbutton primary" id="closeBtn">关闭<button>
        </div>
    </form>
    <iframe id="rfFrame" name="rfFrame" src="about:blank" style="display:none;"></iframe>
</div>

<script>
    //关闭模态框
    $("#closeBtn").click(function () {
        $("#dlg").dialog('close');
    })
    //APP图片
    $('#picture').change(function () {
        var file = this.files[0];
        var scr = $('#showimg').attr("src");
        var objUrl = getObjectURL(this.files[0]);
        if (objUrl) {
            $('#showimg').attr("src", objUrl);
        }
        var imgType=["image/png","image/jpg","image/jpeg","image/gif"];
        if ($.inArray(file.type,imgType)=="-1") {
            $.messager.show({
                title : '提示',
                msg : '图片类型必须是.jpeg,jpg,png,gif中的一种！',
            });
            $('#showimg').attr("src", "/images/u1529.png")
            return false;
        }
        if (file.size > 1024 * 200) {
            var now =  Math.ceil(file.size/1024);
            $.messager.show({
                title : '提示',
                msg : "当前图片约为"+now+"k,图片大小不可超过200k",
            });
            $('#showimg').attr("src", "/images/u1529.png");
            return false;
        }
        $('#showimg').css({
            width:"140px",
            height:"140px",
        })
    });
    function getObjectURL(file) {
        var url = null;
        if (window.createObjectURL != undefined) { // basic
            url = window.createObjectURL(file);
        } else if (window.URL != undefined) { // mozilla(firefox)
            url = window.URL.createObjectURL(file);
        } else if (window.webkitURL != undefined) { // webkit or chrome
            url = window.webkitURL.createObjectURL(file);
        }
        return url;
    }
    //添加幻灯片
    $('#sureBtn').click(function () {
        // 同步数据后可以直接取得textarea的value
        editor.sync();
        var filterContent =$.trim($("#editor_id").val());
        var jumpType  = $("#jumpType").val();
        var jumpUrl  = $("#jumpUrl").val();
        var jumpTitle  = $("#jumpTitle").val();
        if(jumpType==""){
            $.messager.show({
                title : '提示',
                msg : '请选择跳转类型',
            });
            return false;
        }
        //判断跳转类型
        if(jumpType==1){
            if (filterContent=="") {
                $.messager.show({
                    title : '提示',
                    msg : '文章内容不得为空',
                });
                return false;
            }
        }else if(jumpType==2){
            if (jumpTitle=="") {
                $.messager.show({
                    title : '提示',
                    msg : '跳转标题不得为空',
                });
                return false;
            }
            if (jumpUrl=="") {
                $.messager.show({
                    title : '提示',
                    msg : '跳转链接不得为空',
                });
                return false;
            }
        }
        if ($('#showimg').attr("src") == '/images/u1529.png') {
            $.messager.show({
                title : '提示',
                msg : '请上传图片',
            });
            return false;
        }
        document.forms[0].target = "rfFrame";
        var formData = new FormData();
        var data = $("#myform").serializeArray();
        formData.append("upfile", $("#picture").get(0).files[0]);
        formData.append("content", filterContent);
        formData.append("jumpUrl", jumpUrl);
        formData.append("jumpType", jumpType);
        formData.append("jumpTitle", jumpTitle);
        $.each(data, function (i, field){
            formData.append(field.name, field.value);
        });
        $.ajax({
            url: '/websitemod/banner/edit-banner',
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
</script>

