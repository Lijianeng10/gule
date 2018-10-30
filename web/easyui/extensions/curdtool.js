/**
 * 权限按钮控制
 */
function controlBtn() {
    $.ajax({
        url: '/adminmod/auth/get-my-auths',
        type: 'post',
        success: function (data) {
            var data = eval('(' + data + ')');
            $.each(data, function (index, value) {
                var auth = document.getElementsByClassName(value);
                if (auth.length > 0) {
                    for (var i = 0; i < auth.length; i++) {
                        auth[i].style.display = "inline-block";
                    }
                }
            });
            window.dispatchEvent(new Event("resize"));
        }
    });
}

/**
 * 创建普通浏览窗口
 * @param obj_id 标签id
 * @param title 窗口标题
 * @param url    内容页面地址
 * @param width 窗口宽度 (可选)
 * @param height 窗口高度 (可选)
 * @param subObj  子窗口ID
 */
function create_window(obj, title, url, width='', height='') {
    create_div(obj);
	width = width ? width : 700;
	height = height ? height : 400;
	if (width == "100%" || height == "100%") {
		width = document.body.offsetWidth;
		height = document.body.offsetHeight - 100;
	}
	$('#'+obj).dialog({
		width : width,
		height : height,
		modal : true,
		href : url,
		resizable : true,
		title : title,
        buttons : [{
			text : '关闭',
			iconCls : 'fa fa-close',
			handler : function() {
				$('#'+obj).dialog('close').form('clear');
				$('#datagrid').datagrid('reload');
			},
    	}]
	});
}

/**
 * 创建普通浏览窗口
 * @param obj_id 标签id
 * @param title 窗口标题
 * @param url    内容页面地址
 * @param width 窗口宽度 (可选)
 * @param height 窗口高度 (可选)
 *
 */
function create_subwindow(obj, title, url, posturl,width='', height='') {
    create_div(obj);
    width = width ? width : 700;
    height = height ? height : 400;
    if (width == "100%" || height == "100%") {
        width = document.body.offsetWidth;
        height = document.body.offsetHeight - 100;
    }
    $('#'+obj).dialog({
        width : width,
        height : height,
        modal : true,
        href : url,
        resizable : true,
        title : title,
        buttons : [{
            text: '提交',
            iconCls: 'fa fa-check',
            handler: function () {
                if ($('#myform').form('validate')) {
                    $.ajax({
                        url: posturl,
                        type: 'post',
                        data: $('#myform').serialize(),
                        beforeSend: function () {
                            $.messager.progress({
                                msg: '正在提交中。。。'
                            });
                        },
                        success: function (data) {
                            var data = eval('(' + data + ')');
                            $.messager.progress('close');
                            if (data.code == 600) {
                                $.messager.show({
                                    title: '提示',
                                    msg: data.msg,
                                });
                                $('#' + obj).dialog('close').form('clear');
                            } else {
                                var msg = '操作失败！';
                                if (data.msg != null && data.msg != '') {
                                    msg = data.msg;
                                }
                                $.messager.show({
                                    title: '错误',
                                    msg: msg,
                                });
                                $('#' + obj).dialog('close').form('clear');
                            }
                        }
                    });
                } else {
                    $.messager.show({
                        title: '错误',
                        msg: '没有有效提交数据！！！',
                        // timeout: 3000,
                    });
                }
            },
        }, {
            text : '关闭',
            iconCls : 'fa fa-close',
            handler : function() {
                $('#'+obj).dialog('close').form('clear');
            },
        }]
    });
}

//动态创建div
function create_div(obj) {
    if ($("#" + obj).length <= 0) {
        $div = '<div id="' + obj + '"></div>';
        $(document.body).append($div);
    }
}

/**
 * 创建普通浏览窗口(数据表格外)
 * @param obj_id 标签id
 * @param title 窗口标题
 * @param url    内容页面地址
 * @param width 窗口宽度 (可选)
 * @param height 窗口高度 (可选)
 *
 */
function detail(obj, url, width='', height='') {
    create_div(obj);
    var rows = $('#datagrid').datagrid('getSelections');
    if (rows.length == 1) {
        var pid = Object.keys(rows[0])[0];
        url = url + '?' + pid + '=' + rows[0][pid];
    } else {
        $.messager.alert('警告!', '对不起,请选择一条数据!', 'waring');
        return;
    }
    alert(url);
    width = width ? width : 700;
    height = height ? height : 400;
    if (width == "100%" || height == "100%") {
        width = document.body.offsetWidth;
        height = document.body.offsetHeight - 100;
    }
    $('#' + obj).dialog({
        width: width,
        height: height,
        modal: true,
        href: url,
        resizable: true,
        title: '查看',
    });
}

/**
 * 创建普通浏览窗口(数据表格内)
 * @param obj_id 标签id
 * @param title 窗口标题
 * @param url    内容页面地址
 * @param width 窗口宽度 (可选)
 * @param height 窗口高度 (可选)
 *
 */
function detail_row(id, obj, url, width='', height='') {
    // var rows = $('#datagrid').datagrid('getSelections');
    url = url + '?id=' + id;
    width = width ? width : 700;
    height = height ? height : 400;
    if (width == "100%" || height == "100%") {
        width = document.body.offsetWidth;
        height = document.body.offsetHeight - 100;
    }
    $('#' + obj).dialog({
        width: width,
        height: height,
        modal: true,
        href: url,
        resizable: true,
        title: '查看',
    });
}

/**
 * 创建提交对话窗口
 * @param obj_id 标签id
 * @param title 窗口标题
 * @param addurl 窗口页面内容地址
 * @param posturl 窗口表单提交地址
 * @param width 窗口宽度 (可选)
 * @param height 窗口高度 (可选)
 *
 */
function add_dialog(obj, addurl, posturl,postDg='datagrid', width='', height='') {
    create_div(obj);
    width = width ? width : 700;
    height = height ? height : 400;
    if (width == "100%" || height == "100%") {
        width = document.body.offsetWidth;
        height = document.body.offsetHeight - 100;
    }
    $('#' + obj).dialog({
        width: width,
        height: height,
        modal: true,
        href: addurl,
        resizable: true,
        title: '新增页面',
        buttons: [{
            text: '提交',
            iconCls: 'fa fa-check',
            handler: function () {
                // console.log($('#myform').serialize());
                if ($('#myform').form('validate')) {
                    $.ajax({
                        url: posturl,
                        type: 'post',
                        data: $('#myform').serialize(),
                        beforeSend: function () {
                            $.messager.progress({
                                msg: '正在提交中。。。'
                            });
                        },
                        success: function (data) {
                            var data = eval('(' + data + ')');
                            $.messager.progress('close');
                            if (data.code == 600) {
                                $.messager.show({
                                    title: '提示',
                                    msg: '保存成功！',
                                });
                                $('#' + obj).dialog('close').form('clear');
                                $('#' + postDg).datagrid('reload');
                            } else {
                                var msg = '操作失败！';
                                if (data.msg != null && data.msg != '') {
                                    msg = data.msg;
                                }
                                $.messager.show({
                                    title: '错误',
                                    msg: msg,
                                });
                                $('#' + obj).dialog('close').form('clear');
                                $('#' + postDg).datagrid('reload');
                            }
                        }
                    });
                } else {
                    $.messager.show({
                        title: '错误',
                        msg: '没有有效提交数据！！！',
                        // timeout: 3000,
                    });
                }
            },
        }, {
            text: '取消',
            iconCls: 'fa fa-close',
            handler: function () {
                $('#' + obj).dialog('close').form('clear');
                $('#' + postDg).datagrid('reload');
            },
        }],
    });
}

function test_create_dialog(){
    $.dialog({
        content : '/goodsmod/views/to-attr-list',
        title : 'chuangjian',
        cache : false,
        lock : true,
        width : 'auto',
        height : '90%',
    });
}


/**
 * 创建一个修改窗口(获取选择id) 不带提交按钮
 * @author kevi
 */
function update_dialog(obj, url, posturl, width='', height='') {
    create_div(obj);
    var rows = $('#datagrid').datagrid('getSelections');
    if (rows.length == 1) {
        var pid = Object.keys(rows[0])[0];
        url = url + '?' + pid + '=' + rows[0][pid];
    } else if (rows.length == 0) {
        $.messager.alert('警告!', '对不起,请选择一条数据!', 'waring');
        return;
    } else if (rows.length > 1) {
        $.messager.alert('警告!', '对不起,只能选择一条数据进行修改!', 'waring');
        return;
    }
    width = width ? width : 700;
    height = height ? height : 400;
    if (width == "100%" || height == "100%") {
        width = document.body.offsetWidth;
        height = document.body.offsetHeight - 100;
    }
    $('#' + obj).dialog({
        width: width,
        height: height,
        modal: true,
        href: url,
        resizable: true,
        title: '修改页面',
        buttons: [{
            text: '提交',
            iconCls: 'fa fa-check',
            handler: function () {
                if ($('#myform').form('validate')) {
                    $.ajax({
                        url: posturl,
                        type: 'post',
                        data: $('#myform').serialize(),
                        beforeSend: function () {
                            $.messager.progress({
                                msg: '正在提交中。。。'
                            });
                        },
                        success: function (data) {
                            var data = eval('(' + data + ')');
                            $.messager.progress('close');
                            if (data.code == 600) {
                                $.messager.show({
                                    title: '提示',
                                    msg: '保存成功！',
                                });
                                $('#' + obj).dialog('close').form('clear');
                                $('#datagrid').datagrid('reload');
                            } else {
                                var msg = '操作失败！';
                                if (data.msg != null && data.msg != '') {
                                    msg = data.msg;
                                }
                                $.messager.show({
                                    title: '错误',
                                    msg: msg,
                                });
                                $('#' + obj).dialog('close').form('clear');
                                $('#datagrid').datagrid('reload');
                            }
                        }
                    });
                } else {
                    $.messager.show({
                        title: '错误',
                        msg: '没有有效提交数据！！！',
                        // timeout: 3000,
                    });
                }
            },
        }, {
            text: '取消',
            iconCls: 'fa fa-close',
            handler: function () {
                $('#' + obj).dialog('close').form('clear');
                $('#datagrid').datagrid('reload');
            },
        }],
    });
}


/**
 * 删除一条记录
 * @param url
 * @return
 */
function deleteOne(url) {
    var rows = $('#datagrid').datagrid('getSelections');
    if (rows.length == 1) {
        var pid = Object.keys(rows[0])[0];
        id = rows[0][pid];
    } else if (rows.length == 0) {
        $.messager.alert('警告!', '对不起,请选择一条数据!', 'waring');
        return;
    } else if (rows.length > 1) {
        $.messager.alert('警告!', '对不起,只能选择一条数据进行操作!', 'waring');
        return;
    }
    $.messager.confirm('确认', '您确定要删除此数据吗?', function (r) {
        if (r) {
            $.ajax({
                url: url,
                type: 'post',
                data: {
                    id: id
                },
                cache: false,
                success: function (data) {
                    var data = eval('(' + data + ')');
                    if (data.code == 600) {
                        $.messager.show({
                            title: '提示',
                            msg: '删除成功！',
                        });
                        $('#datagrid').datagrid('reload');

                    } else {
                        var msg = '操作失败！';
                        if (data.msg != null && data.msg != '') {
                            msg = data.msg;
                        }
                        $.messager.show({
                            title: '错误',
                            msg: msg,
                        });
                    }

                }
            });
        }
    });
}

/**
 * 多记录刪除請求
 * @param url
 * @return
 */
function deleteAll(url) {
    var ids = [];
    var rows = $("#datagrid").datagrid('getSelections');
    for (var i = 0; i < rows.length; i++) {
        var pid = Object.keys(rows[i])[0];
        id = rows[i][pid];
        ids.push(id);
    }
    if (rows.length > 0) {
        $.messager.confirm('确认', '您确定要永久删除勾选数据吗?', function (r) {
            if (r) {
                $.ajax({
                    url: url,
                    type: 'post',
                    data: {
                        ids: ids.join(',')
                    },
                    cache: false,
                    success: function (data) {
                        var data = eval('(' + data + ')');
                        if (data.code == 600) {
                            $.messager.show({
                                title: '提示',
                                msg: '删除成功！',
                            });
                            $('#datagrid').datagrid('reload');

                        } else {
                            $.messager.show({
                                title: '错误',
                                msg: data.msg,
                            });
                        }

                    }
                });
            }
        });
    } else {
        $.messager.alert('警告!', '请选择需要删除的数据!', 'waring');
    }
}

/**
 * 创建提交对话窗口
 * @param obj_id 标签id
 * @param title 窗口标题
 * @param addurl 窗口页面内容地址
 * @param posturl 窗口表单提交地址
 * @param width 窗口宽度 (可选)
 * @param height 窗口高度 (可选)
 * @param title 页面标题(可选)
 *
 */
function add_dialog_page(obj, addurl, posturl, width='', height='', title='新增页面') {
    create_div(obj);
    width = width ? width : 700;
    height = height ? height : 400;
    if (width == "100%" || height == "100%") {
        width = document.body.offsetWidth;
        height = document.body.offsetHeight - 100;
    }
    $('#' + obj).dialog({
        width: width,
        height: height,
        modal: true,
        href: addurl,
        resizable: true,
        title: title,
        buttons: [{
            text: '提交',
            iconCls: 'fa fa-check',
            handler: function () {
                if ($('#myform').form('validate')) {
                    $.ajax({
                        url: posturl,
                        type: 'post',
                        data: $('#myform').serialize(),
                        beforeSend: function () {
                            $.messager.progress({
                                msg: '正在提交中。。。'
                            });
                        },
                        success: function (data) {
                            var data = eval('(' + data + ')');
                            $.messager.progress('close');
                            if (data.code == 600) {
                                $.messager.show({
                                    title: '提示',
                                    msg: '保存成功！',
                                });
                                $('#' + obj).dialog('close').form('clear');
                                $('#datagrid').datagrid('reload');
                            } else {
                                var msg = '操作失败！';
                                if (data.msg != null && data.msg != '') {
                                    msg = data.msg;
                                }
                                $.messager.show({
                                    title: '错误',
                                    msg: msg,
                                });
                                $('#' + obj).dialog('close').form('clear');
                                $('#datagrid').datagrid('reload');
                            }
                        }
                    });
                } else {
                    $.messager.show({
                        title: '错误',
                        msg: '没有有效提交数据！！！',
                        // timeout: 3000,
                    });
                }
            },
        }, {
            text: '取消',
            iconCls: 'fa fa-close',
            handler: function () {
                $('#' + obj).dialog('close').form('clear');
                $('#datagrid').datagrid('reload');
            },
        }],
    });
}

/**
 * 修改状态（启用、禁用）
 * @param showMsg 确认框提示语
 * @param url 提交地址
 * @param id 修改的数据ID
 * @param status 修改的状态
 */
function changeStatus(showMsg, url, id, status) {
    $.messager.confirm('确认', showMsg, function (r) {
        if (r) {
            $.ajax({
                url: url,
                type: 'post',
                data: {"id": id, "status": status},
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
                            msg: data.msg,
                        });
                        $('#datagrid').datagrid('reload');
                    } else {
                        var msg = '操作失败！';
                        if (data.msg != null && data.msg != '') {
                            msg = data.msg;
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
        } else {
            $('#datagrid').datagrid('reload');
        }
    });
}

/**
 * 删除单条数据
 */
function delData(id, url) {
    $.messager.confirm('确认', '您确定要删除此数据吗?', function (r) {
        if (r) {
            $.ajax({
                url: url,
                type: 'post',
                data: {
                    id: id
                },
                cache: false,
                success: function (data) {
                    var data = eval('(' + data + ')');
                    if (data.code == 600) {
                        $.messager.show({
                            title: '提示',
                            msg: data.msg,
                        });
                        $('#datagrid').datagrid('reload');

                    } else {
                        var msg = '操作失败！';
                        if (data.msg != null && data.msg != '') {
                            msg = data.msg;
                        }
                        $.messager.show({
                            title: '错误',
                            msg: msg,
                        });
                    }

                }
            });
        }
    });
}
