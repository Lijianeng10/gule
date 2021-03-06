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
        <!--        视频播放-->
        <link href="http://vjs.zencdn.net/c/video-js.css" rel="stylesheet">
        <script src="http://vjs.zencdn.net/c/video.js"></script>
    </head>
<body style="height: 100%;">
<script type="text/javascript">
        $(function() {
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
                url: '/websitemod/video/get-video-list',
                fit: true,
                pagination: true,
                pageSize: 20,
                // singleSelect:true,
                // fitColumns: true,
                rownumbers: true,
                loadMsg: '数据加载中...',
                toolbar: '#tb',
                columns: [
                    [{
                        field: 'video',
                        title: '视频',
                        width: 300,
                        align: 'center',
                        formatter: videoFormatter,
                    },{
                        field: 'url',
                        title: '视频URL',
                        width: 500,
                        align: 'center',
                    },{
                        field: 'create_time',
                        title: '创建时间',
                        sortable: true,
                        width: 150,
                        align: 'center',
                    }, {
                        field: 'opt',
                        title: '操作',
                        width: 200,
                        align: 'left',
                        formatter: optFormatter,
                    }]
                ],
                onLoadSuccess:function(data){
                    controlBtn();
                    // $("a[name='edit_banner']").linkbutton({text:'编辑'});
                    $("a[name='del_banner']").linkbutton({text:'删除'});
                    // $("a[name='up']").linkbutton({text:'上线'});
                    $("a[name='down']").linkbutton({text:'查看'});
                }
            });
            function picFormatter(value, row) {
                if(value==='' || value == undefined){
                    return "";
                }
                return '<img data-magnify="gallery" data-src="'+row.pic_url+'" data-caption="APP首页图片" src="'+row.pic_url+'" width="40px" height="40px" style="text-align: center">';
            }
            function jumpTypeFormatter(value,row){
                if(value==1){
                    return "跳转软文";
                }
                return "跳转链接";
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
            function videoFormatter(value, row) {
                var str = '';
                str += '<div style ="position:relative;">';
                str += '<video id ="video" class="videoContent" controls style="width:200px;height: 200px;">';
                str += '<source src="'+row.url+'" type="video/mp4"/>';
                str += '</video>';
                str += '<div id ="output" style ="position:absolute;left:0;left:0"></div>';
                str += '</div>';
                return str;
            }
            function optFormatter(value, row) {
                var str = "";
                str += '<a href="'+row.url+'" name="down" style="margin-left: 5px" class="easyui-linkbutton info  websiteBananerChangeStatus"></a>'
                str += '<a href="#" name="del_banner" style="margin-left: 5px" class="easyui-linkbutton info  websiteBananerDelete" onclick="delData('+row.video_id+',\'/websitemod/video/delete\');"></a>';
                 return str;
            }
        });
</script>
	<div class="dgdiv">
		<table id="datagrid"></table>
	</div>

	<div id="tb" style="padding:5px;">
        <div class="tb_menu">
            <a href="#" class="easyui-linkbutton primary  websiteBananerSearch" iconCls="fa fa-search" onclick="obj.search();"> 查 询 </a>
            <a href="#" class="easyui-linkbutton info  websiteBananerAdd" iconCls="fa fa-plus"  onclick="create_window('dlg','新增视频','/websitemod/views/to-video-add','',700);">新增</a>
        </div>
    </div>
    <div id="dlg"></div>
    <script>
        function change_status(bananer_id,status){
            var statusStr = "下线";
            if(status==1){
                statusStr='发布'
            }
            changeStatus('您确定要 ('+statusStr+') 该广告吗?',"/websitemod/banner/change-status",bananer_id,status);
        }
    </script>
</body>
</html>