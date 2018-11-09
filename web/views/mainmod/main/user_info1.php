<?php $admin = \Yii::$app->session['admin'];?>
<div style="width:100%;height:100%;">
    <ul>
<!--        <li><span>头像：</span></li>-->
        <div class="form-item" style="width:80%">
            <label for="" class="label-top" style="font-size:16px">昵称:</label>
            <span id="nickname"><?php echo $admin['admin_name']?></span>
        </div>

        <?php if($admin['admin_type']==1){?>
            <div class="form-item" style="width:80%">
                <label for="" class="label-top" style="font-size:16px">所属中心:</label>
                <span>
                    <?php foreach($adminInfo1['centers'] as $center){
                        echo $center['center_name'].' | ';
                    }?>
                </span>
            </div>
        <?php }?>
        <div class="form-item" style="width:80%">
            <label for="" class="label-top" style="font-size:16px">联系方式:</label>
            <span id="user_tel"><?php echo $admin['admin_tel']?></span>
        </div>
        <div class="form-item" style="width:80%">
            <label for="" class="label-top" style="font-size:16px">所属角色:</label>
            <span>
                <?php foreach($adminInfo1['roles'] as $role){
                    echo $role['role_name'].' | ';
                }?>
            </span>
        </div>
        <div class="form-item" style="width:80%">
            <label for="" class="label-top" style="font-size:16px">用户状态：</label>
            <span id="user_type"><?php echo $admin['status']==1?'正常':'禁用'; ?></span>
        </div>
        <div class="form-item" style="width:80%">
            <label for="" class="label-top" style="font-size:16px">上次登录时间:</label>
            <span id="last_login"><?php echo $admin['last_login_time']?></span>
        </div>
    </ul>
</div>