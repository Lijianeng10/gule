<style>
   #view div{
        margin-top: 5px;
    }
    .infoSpan{
        display: inline-block;
        width: 110px;
        text-align: right;
    }
    .doc-read{
        display: inline-block;
        width: 200px;
    }
    #storeInfo th,#storeInfo td{
        font-size: 14px;
        text-align: center;
    }
    #addBtn{
        margin: 5px 5px;
    }
</style>
<div style="margin-left:10px" id="view">
    <strong>基础信息</strong>
    <div>
        <span  class="infoSpan">网点编号：</span>
        <span class="doc-read" id="cust_no"><?php echo $user_data['cust_no']; ?></span>
        <span  class="infoSpan">网点昵称：</span>
        <span class="doc-read"><?php echo $user_data['user_name']; ?></span>
    </div>
    <div>
        <span class="infoSpan">手机号码：</span>
        <span class="doc-read"><?php echo $user_data['user_tel']; ?></span>
        <span class="infoSpan">所在城市：</span>
        <span class="doc-read"><?php echo $user_data['province'] . '- ' . $user_data['city'] . '- ' . $user_data['area'] . $user_data['address']; ?></span>
    </div>
    <div>
        <span class="infoSpan">使用状态：</span>
        <span class="doc-read"><?php echo $user_data['status']==1?'正常':'禁用'; ?></span>
        <span class="infoSpan">认证状态：</span>
        <span class="doc-read"><?php echo $authen[$user_data['authen_status']]; ?></span>
    </div>
    <div>
        <span class="infoSpan">所属体彩中心：</span>
        <span class="doc-read"><?php echo $user_data['center_name']; ?></span>
    </div>
    <div>
        <span class="infoSpan">备注：</span>
        <span class="doc-read"><?php echo $user_data['user_remark']; ?></span>
    </div>
    <legend></legend>
    <strong>结算账户</strong>
    <div>
        <span class="infoSpan">总金额：</span>
        <span class="doc-read"><?php echo  $user_data['all_funds']; ?></span>
        <span class="infoSpan">可用余额：</span>
        <span class="doc-read"><?php echo $user_data['able_funds']; ?></span>
    </div>
    <div>
        <span class="infoSpan">冻结金额：</span>
        <span class="doc-read"><?php echo  $user_data['ice_funds']; ?></span>
        <span class="infoSpan">不可提现金额：</span>
        <span class="doc-read"><?php echo $user_data['no_withdraw']; ?></span>
    </div>
    <div>
        <span class="infoSpan">可提现金额：</span>
        <span class="doc-read"><?php echo  $user_data['all_funds']-$user_data['no_withdraw']; ?></span>
    </div>
    <div>
        <span class="infoSpan">户名：</span>
        <span class="doc-read"><?php echo $user_data["real_name"];?></span>
        <span class="infoSpan">账号：</span>
        <span class="doc-read"><?php echo $user_data["recv_bank_acct_num"]; ?></span>
    </div>
    <div>
        <span class="infoSpan">开户行：</span>
        <span class="doc-read"><?php echo $user_data["recv_bank_name"]; ?></span>
        <span class="infoSpan">支行名称：</span>
        <span class="doc-read"><?php echo $user_data["recv_bank_branch_name"]; ?></span>
    </div>
    <legend></legend>
    <strong>网点说明信息</strong>
    <div>
        <span class="infoSpan">代销证编号：</span>
        <span class="doc-read"><?php echo $user_data["sports_lottery_num"]; ?></span>
    </div>
    <div>
        <span class="infoSpan">代销证图片：</span>
        <span class="doc-read"><?php echo !empty($user_data["sports_lottery_img"])?"<img data-magnify='gallery' data-src='".$user_data['sports_lottery_img']."' data-caption='代销证图片' src='".$user_data["sports_lottery_img"]."' width=150px height=150px>":""; ?></span>
    </div>
    <div>
        <span class="infoSpan">真实姓名：</span>
        <span class="doc-read"><?php echo $user_data["real_name"]; ?></span>
    </div>
    <div>
        <span class="infoSpan">身份证号：</span>
        <span class="doc-read"><?php echo $user_data["card_no"]; ?></span>
    </div>
    <div>
        <span class="infoSpan" >身份证：</span>
        <span class="doc-read"><?php echo !empty($user_data["card_front"])?"<img  data-magnify='gallery' data-src='".$user_data['card_front']."' data-caption='身份证正面' src='".$user_data["card_front"]."' width=150px height=150px>":""; ?></span>
        <span class="doc-read"><?php echo !empty($user_data["card_back"])?"<img data-magnify='gallery' data-src='".$user_data['card_back']."' data-caption='身份证背面' src='".$user_data["card_back"]."' width=150px height=150px>":""; ?></span>
    </div>
    <legend></legend>
    <strong>其他信息</strong>
    <div>
<!--        <div>-->
<!--            <span class="infoSpan">上级名称：</span>-->
<!--            <span class="doc-read">--><?php //echo  $user_data['agent_name'];; ?><!--</span>-->
<!--        </div>-->
        <div>
            <span class="infoSpan">创建时间：</span>
            <span class="doc-read"><?php echo  $user_data['create_time'];; ?></span>
        </div>
        <div>
            <span class="infoSpan">最后登录时间：</span>
            <span class="doc-read"><?php echo  $user_data['last_login'];; ?></span>  
         </div>
    </div>
    <legend></legend>
</div>
<div id="addWin"></div>
<!--<div id="addWinTb">-->
<!--    <a href="#" class="easyui-linkbutton" iconCls="icon-add" onclick="addStore()">新增</a>-->
<!--</div>-->


<script>
    function addStore(){
        var cust_no=$("#cust_no").html();
       $('#addWin').dialog({
        width : 600,
        height : 300,
        modal : true,
        // closed : true, //默认关闭
        href : '/member/views/to-list-add-store?cust_no=' + cust_no,
        resizable : true,
        title : "新增门店",
        buttons : [ {
            text : '提交',
            iconCls : 'icon-save',
            handler : function() {
                if ($('#myform').form('validate')) {
                    $.ajax({
                        url : '/member/list/addstore',
                        type : 'post',
                        data : $('#myform').serialize(),
                        beforeSend : function() {
                            $.messager.progress({
                                text : '正在提交中。。。'
                            });
                        },
                        success : function(data) {
                            var data = eval('(' + data + ')');
                            $.messager.progress('close');
                            if (data.code == 600) {
                                $.messager.show({
                                    title : '提示',
                                    msg : '保存成功！',
                                });
                                $('#addWin').dialog('close').form('clear');
                                $('#storeInfo').datagrid('reload');
                            } else {
                                $.messager.show({
                                    title : '错误',
                                    msg : data.msg,
                                });
                                $('#addWin').dialog('close').form('clear');
                                $('#storeInfo').datagrid('reload');
                            }
                        }
                    });
                }
            },
        }, {
            text : '取消',
            iconCls : 'icon-redo',
            handler : function() {
                $('#addWin').dialog('close').form('clear');
                $('#storeInfo').datagrid('reload');
            },
        } ],
    });
    }
</script>