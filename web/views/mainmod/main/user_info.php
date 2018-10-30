<?php $admin = \Yii::$app->session['admin'];?>
<div style="width:100%;height:100%;">
    <div style="float:left;width:45%;height:80%;margin:20px 40px 10px 10px;">
        <div id="p1" class="easyui-panel" title="个人信息概述" style="height:100%;padding: 10px;"
             data-options="iconCls:'icon-man',tools:[{
					iconCls:'icon-reload',
					handler:function(){
						$('#p1').panel('refresh', '/mainmod/views/to-userinfo1');
					}
				}]">
        </div>
    </div>

<?php if($admin['type']==0){ ?>
    <div style="float:left;width:45%;height:80%;margin:20px 10px 10px 0px;">
    <div id="p3" class="easyui-panel" title="业务信息概述" style="height:100%;padding: 10px;"
         data-options="iconCls:'icon-man',tools:[{
                iconCls:'icon-reload',
                handler:function(){
                    $('#p3').panel('refresh', '/mainmod/views/to-userinfo3');
                }
            }]">
    </div>
</div>
<?php }?>

<?php if($admin['type']==1){ ?>
    <div style="float:left;width:45%;height:80%;margin:20px 10px 10px 0px;">
        <div id="p2" class="easyui-panel" title="业务信息概述" style="height:100%;padding: 10px;"
             data-options="iconCls:'icon-man',tools:[{
					iconCls:'icon-reload',
					handler:function(){
						$('#p2').panel('refresh', '/mainmod/views/to-userinfo2');
					}
				}]">
        </div>
    </div>
<?php }?>
</div>

<script>
    $(function(){
        $('#p1').panel('refresh', '/mainmod/views/to-userinfo1');
        $('#p2').panel('refresh', '/mainmod/views/to-userinfo2');
        $('#p3').panel('refresh', '/mainmod/views/to-userinfo3');
    });
</script>