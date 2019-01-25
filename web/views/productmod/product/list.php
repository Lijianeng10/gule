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
        <link rel="stylesheet" href="/js/kindeditor/themes/default/default.css" />
        <script charset="utf-8" src="/js/kindeditor/kindeditor-all.js"></script>
        <script charset="utf-8" src="/js/kindeditor/lang/zh_CN.js"></script>
        <link rel="stylesheet" href="/css/jquery.magnify.css">
        <script src="/js/jquery.magnify.js" type="text/javascript" charset="utf-8"></script>
    </head>
    <body style="height: 100%;">
        <script type="text/javascript">
            $(function () {
                obj = {
                    editRow: undefined,
                    search: function () {
                        $('#datagrid').datagrid('load', {
                            'productInfo': $.trim($('input[name="productInfo"]').val()),
                            'p_id': $.trim($('input[name="p_id"]').val()),
                            'status': $.trim($('input[name="status"]').val()),
                        });
                    },
                };

                $('#datagrid').datagrid({
                    url: '/productmod/product/get-product-list',
                    fit: true,
                    pagination: true,
//                    singleSelect: true,
                    fitColumns: true,
                    rownumbers: true,
                    loadMsg: '数据加载中...',
                    toolbar: '#tb',
                    columns: [
                        [{
                                field: 'product_name',
                                title: '产品名称',
                                width: 50,
                                align: 'center',
                            },{
                                field: 'p_name',
                                title: '所属类别',
                                width: 50,
                                align: 'center',
                            },{
                                field: 'product_price',
                                title: '产品价格',
                                width: 50,
                                align: 'center',
                            }, {
                                field: 'product_pic',
                                title: '产品图片',
                                width: 40,
                                align: 'center',
                                formatter: picFormatter
                            },{
                                field: 'status',
                                title: '状态',
                                width: 50,
                                align: 'center',
                                formatter: statusFormatter
                            },{
                                field: 'is_hot',
                                title: '是否推荐',
                                width: 30,
                                align: 'center',
                                formatter: isHotFormatter
                            }, {
                                field: 'create_time',
                                title: '创建时间',
                                width: 50,
                                align: 'center',
                            },{
                                field: 'opt',
                                title: '操作',
                                width: 60,
                                align: 'left',
                                formatter: optFormatter,
                            }]
                    ],
                    onLoadSuccess: function (data) {
                        // controlBtn();
                        //                    $("a[name='edit']").linkbutton({text:'编辑',iconCls:'fa fa-edit'});
                       $("a[name='up']").linkbutton({text: '下架', iconCls: 'fa fa-edit'});
                       $("a[name='down']").linkbutton({text: '上架', iconCls: 'fa fa-edit'});
                        $("a[name='hot_up']").linkbutton({text: '取消推荐', iconCls: 'fa fa-edit'});
                        $("a[name='hot_down']").linkbutton({text: '开始推荐', iconCls: 'fa fa-edit'});
//                        $("a[name='limit']").linkbutton({text: '限制区域', iconCls: 'fa fa-edit'});
                        //                    $("a[name='del']").linkbutton({text:'删除',iconCls:'fa fa-delete'});
                    }
                });
                function picFormatter(value, row) {
                    if(value==='' || value == undefined){
                        return "";
                    }
                    return '<img data-magnify="gallery" data-src="'+row.product_pic+'" data-caption="产品图片" src="'+row.product_pic+'" width="40px" height="40px" style="text-align: center">';
                };

                function statusFormatter(value, row) {
                    if (value == 1) {
                        return "<spen style='color: blue'>上架<spen>";
                    }
                    return "<spen style='color: red'>下架<spen>";
                }
                ;
                };
                function isHotFormatter(value, row) {
                    if (value == 1) {
                        return "<spen style='color: blue'>是<spen>";
                    }
                    return "<spen style='color: red'>否<spen>";
                };
                function optFormatter(value, row) {
                    var str = '<a href="#" name="detail" class="easyui-linkbutton success"></a>';
                    // str += '<a href="#" name="edit" style="margin-left: 5px" class="easyui-linkbutton success auth productProductEdit" onclick="productEdit(' + row.product_id + ')"> 编辑</a>';
                    if (row.status == 1) {
                        str += '<a href="#" name="up" style="margin-left: 5px" class="easyui-linkbutton error auth productProductChangeStatus" onclick="change_status(' + row.product_id + ',0)"> 下架</a>';
                    } else if (row.status == 0) {
                        str += '<a href="#" name="down" style="margin-left: 5px" class="easyui-linkbutton primary auth productProductChangeStatus" onclick="change_status(' + row.product_id + ',1)">上架</a>';
                    }
                    if (row.is_hot == 1) {
                        str += '<a href="#" name="hot_up" style="margin-left: 5px" class="easyui-linkbutton error auth productProductChangeStatus" onclick="change_hot_status(' + row.product_id + ',0)"> 取消推荐</a>';
                    } else if (row.is_hot == 0) {
                        str += '<a href="#" name="hot_down" style="margin-left: 5px" class="easyui-linkbutton primary auth productProductChangeStatus" onclick="change_hot_status(' + row.product_id + ',1)">开始推荐</a>';
                    }
                    return str;
                }
            });
        </script>

        <!-- <div "> -->
        <div class="dgdiv">
            <table id="datagrid"></table>
        </div>

        <div id="tb" style="padding:5px;">
            <div class="tb_menu">
                <div style="margin: 5px 0px 5px 0px; color:#000000;">
                    <a href="#" class="easyui-linkbutton primary auth productProductAdd" iconCls="fa fa-plus"  onclick="create_window('dlg', '新增产品', '/productmod/views/to-product-add', '50%', '80%');">新增</a>
                    <a href="#" id="remove" class="easyui-linkbutton error auth productProductDelete" iconCls="fa fa-remove" plain="true" onclick="deleteAll('/productmod/product/delete');">删除</a>
                    <a href="#" class="easyui-linkbutton primary auth productSearch" iconCls="fa fa-search" onclick="obj.search();"> 查 询 </a>
            </div>
                <div class="tb-column">
                    <div class="tb_item">
                        <span>产品信息：</span>
                        <input type="text"  name="productInfo" class="easyui-textbox">
                    </div>
                    <div class="tb_item">
                        <span>所属类别：</span>
                        <input name="p_id" class="easyui-combotree" data-options="url:'/productmod/category/get-category-tree?type=1',method:'get',lines: true,animate:true,checkbox:true">
                    </div>
                    <div class="tb_item">
                        <span>状态：</span>
                        <select class="easyui-combobox" name="status" style="width: 100px" data-options="editable:false">
                            <option value="" selected>全部</option>
                            <option value="1">上架</option>
                            <option value="0">下架</option>
                        </select>
                    </div>
                </div>
        </div>
        <div id="dlg"></div>
        <script>

            $(function () {
                KindEditor.options.filterMode = false;
                var editor;
                KindEditor.ready(function (K) {
                    editor = K.create('#editor_id', {
                        minWidth: '550px',
                        height: '350px',
                        items: [
                            'undo', 'redo', '|', 'preview', 'template', 'cut', 'copy', 'paste',
                            '|', 'justifyleft', 'justifycenter', 'justifyright',
                            'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
                            'superscript', 'clearhtml', 'quickformat', 'selectall', '|', '/',
                            'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
                            'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|',
                            'insertfile', 'table', 'hr', 'emoticons', 'pagebreak',
                            'anchor', 'link', 'unlink', '|'
                        ],
                    });
                });
            })
            function change_status(product_id, status) {
                var statusStr = "下架";
                if (status == 1) {
                    statusStr = '上架'
                }
                changeStatus('您确定要 ('+statusStr+') 该产品吗?',"/productmod/product/change-status",product_id,status);
            }

            function change_hot_status(product_id, status) {
                var statusStr = "取消推荐";
                if (status == 1) {
                    statusStr = '开始推荐'
                }
                changeStatus('您确定要 ('+statusStr+') 该产品吗?',"/productmod/product/change-hot-status",product_id,status);
            }
            function productEdit(productId) {
                create_window('p_dlg', '编辑', '/productmod/views/to-product-edit?product_id=' + productId, '70%', '98%');
            };

            function editSub(pId, subId) {
                create_window('s_dlg', '子商品编辑', '/productmod/views/to-sub-edit?pId=' + pId + '&subId=' + subId, '400px', '300px');
            }

            function upSub(pId, subId, status) {
                var statusStr = "下架";
                if (status == 0) {
                    statusStr = '上架'
                    status = 1;
                }else {
                    status = 0;
                }
                $.messager.confirm('确认', '您确定要 (' + statusStr + ') 该商品吗?', function (r) {
                    if (r) {
                        $.ajax({
                            url: "/productmod/product/sub-change-status",
                            type: 'post',
                            data: {"productId": pId, "subId":subId, "status": status},
                            beforeSend: function () {
                                $.messager.progress({
                                    msg: '正在提交中。。。'
                                });
                            },
                            success: function (data) {
                                var data = eval('(' + data + ')');
                                if (data.code == 600) {
                                    $.messager.show({
                                        title: '提示',
                                        msg: '保存成功！',
                                    });
                                    $('#datagrid').datagrid('reload');
                                } else {
                                    var msg = '操作失败！';
                                    if (data.result != null && data.result != '') {
                                        msg = data.result;
                                    }
                                    $.messager.show({
                                        title: '错误',
                                        msg: msg,
                                    });
                                    $('#datagrid').datagrid('reload');
                                }
                                $.messager.progress('close');
                            }
                        });
                    }
                });
            }

//            function productDel() {
//                deleteAll('/productmod/product/delete');
//            }
        </script>
    </body>
</html>