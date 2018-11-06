<!DOCTYPE html>
<html style="height: 100%;">
	<head>
		<meta charset="UTF-8">
		<title></title>
        <!--easyui-->
        <link rel="stylesheet" href="/easyui/themes/super/css/font-awesome.min.css">
		<link rel="stylesheet" href="/easyui/themes/super/superBlue.css" id="themeCss">
        <link rel="stylesheet" href="/css/basis.css">
		<script src="/easyui/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="/easyui/js/jquery.easyui.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="/easyui/locale/easyui-lang-zh_CN.js" type="text/javascript" charset="utf-8"></script>
		<script src="/easyui/extensions/curdtool.js" type="text/javascript" charset="utf-8"></script>
        <link rel="stylesheet" href="/css/jquery.magnify.css">
        <script src="/js/jquery.magnify.js" type="text/javascript" charset="utf-8"></script>
        <link rel="stylesheet" href="/js/kindeditor/themes/default/default.css" />
        <script charset="utf-8" src="/js/kindeditor/kindeditor-all.js"></script>
        <script charset="utf-8" src="/js/kindeditor/lang/zh_CN.js"></script>
	</head>
<body style="height: 100%;">
    <script type="text/javascript">
        $(function() {
            //     关闭过滤模式，保留所有标签
            KindEditor.options.filterMode = false;
            var editor;
            KindEditor.ready(function(K) {
                editor = K.create('#editor_id',{
                    minWidth :'550px',
                    height:'350px',
                    items:[
                        'undo', 'redo', '|', 'preview', 'template', 'cut', 'copy', 'paste',
                        '|', 'justifyleft', 'justifycenter', 'justifyright',
                        'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
                        'superscript', 'clearhtml', 'quickformat', 'selectall', '|','/',
                        'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
                        'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|',
                        'insertfile', 'table', 'hr', 'emoticons', 'pagebreak',
                        'anchor', 'link', 'unlink', '|'
                    ],
                });
            });

            obj = {
                editRow: undefined,
                search: function () {
                    $('#datagrid').datagrid('load', {
                        'pic_name': $.trim($('input[name="pic_name"]').val()),
                        'status': $.trim($('input[name="status"]').val()),
                    });
                },
            };

            $('#datagrid').datagrid({
                url: '/websitemod/found/get-found-list',
                fit: true,
                pagination: true,
                pageSize: 20,
                // singleSelect:true,
                fitColumns: true,
                rownumbers: true,
                loadMsg: '数据加载中...',
                toolbar: '#tb',
                columns: [
                    [{
                        field: 'pic_name',
                        title: '标题名称',
                        width: 50,
                        sortable: true
                    }, {
                        field: 'pic_url',
                        title: '广告图片',
                        width: 50,
                        formatter: picFormatter
                    },  {
                        field: 'status',
                        title: '状态',
                        width: 50,
                        align: 'center',
                        formatter: statusFormatter
                    }, {
                        field: 'create_time',
                        title: '创建时间',
                        sortable: true,
                        width: 60,
                    }, {
                        field: 'opt',
                        title: '操作',
                        width: 100,
                        align: 'left',
                        formatter: optFormatter,
                    }]
                ],
                onLoadSuccess:function(data){
                    controlBtn();
                    $("a[name='up']").linkbutton({text:'上线'});
                    $("a[name='down']").linkbutton({text:'下线'});
                    $("a[name='edit_found']").linkbutton({text:'编辑'});
                    $("a[name='del_found']").linkbutton({text:'删除'});
                }
            });
            function picFormatter(value, row) {
                if(value==='' || value == undefined){
                    return "";
                }
                return '<img data-magnify="gallery" data-src="'+row.pic_url+'" data-caption="发现界面图片" src="'+row.pic_url+'" width="40px" height="40px" style="text-align: center">';
            }
            function typeFormatter(value,row){
                if(value==1){
                    return "中心管理员";
                }
                return "系统管理员";
            }
            function statusFormatter(value,row){
                var str= "";
                if(row.status ==1){
                    str ="在线"
                }else if(row.status == 2){
                    str ="下线"
                }else{
                    str ="未发布"
                }
                return str;
            }
            function optFormatter(value, row) {
                var str = "";
                str += '<a href="#" name="edit_found" style="margin-left: 5px" class="easyui-linkbutton info auth websiteFoundEdit" onclick="create_window(\'dlg\',\'编辑\',\'/websitemod/views/to-found-edit?bananer_id='+row.bananer_id+' \',\'\',700)"></a>';
                str += '<a href="#" name="del_found" style="margin-left: 5px" class="easyui-linkbutton info auth websiteFoundDelete" onclick="delData('+row.bananer_id+',\'/websitemod/found/delete\');"></a>';
                if(row.status ==0 ||row.status ==2){
                    str += '<a href="#" name="up" style="margin-left: 5px" class="easyui-linkbutton info auth websiteFoundChangeStatus" onclick="change_status('+row.bananer_id+',1)"></a>';
                }else if(row.status == 1){
                    str += '<a href="#" name="down" style="margin-left: 5px" class="easyui-linkbutton info auth websiteFoundChangeStatus" onclick="change_status('+row.bananer_id+',2)"></a>';
                }
                 return str;
            }
        });
	</script>
	<div class="dgdiv">
		<table id="datagrid"></table>
	</div>

	<div id="tb" style="padding:5px;">
        标题名称：<input type="text"  name="pic_name" class="textbox" >
        状态：<select class="easyui-combobox" name="status" style="width: 100px">
              <option value="" selected>全部</option>
              <option value="1">在线</option>
            <option value="2">下线</option>
           </select>
        <a href="#" class="easyui-linkbutton primary auth websiteFoundSearch" iconCls="fa fa-search" onclick="obj.search();"> 查 询 </a>
        <a href="#" class="easyui-linkbutton info auth websiteFoundAdd" iconCls="fa fa-plus"  onclick="create_window('dlg','新增广告','/websitemod/views/to-found-add','',700);">新增</a>
    </div>
    <div id="dlg"></div>
    <script>
        function change_status(bananer_id,status){
            var statusStr = "下线";
            if(status==1){
                statusStr='发布'
            }
            changeStatus('您确定要 ('+statusStr+') 该广告吗吗?',"/websitemod/found/change-status",bananer_id,status);
        }
    </script>
</body>
</html>