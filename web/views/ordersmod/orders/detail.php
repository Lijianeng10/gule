<div class="super-theme-example">
    <form id="myform">
		<div class="form-item" style="width:80%">
            <label for="" class="label-top">订单编号：</label>
            <?php echo $ordersData['order_code'];?>
        </div>
<!--        <div class="form-item" style="width:80%">-->
<!--            <label for="" class="label-top">网点编号：</label>-->
<!--            --><?php //echo $ordersData['cust_no'];?>
<!--        </div>-->
        <div class="form-item" style="width:80%">
            <label for="" class="label-top" style="font-size:16px;font-weight: bold">订单信息</label>
        </div>
        <div class="form-item" style="width:100%;">
            <table id="value_table" border='1px' cellspacing="0" style="width:80%;text-align:center;margin-left: 100px;">
                <tr>
					<td style="width:15%">产品名称</td>
                    <td style="width:15%">产品图片</td>
                    <td style="width:17%">产品价格</td>
                    <td style="width:17%">购买数量</td>
                </tr>
				<?php 
				foreach($orderDetailData as $key => $val){
				?>
				<tr>
                    <td style="width:15%">
                        <?php echo $val['product_name'];?>
                    </td>
					<td style="width:15%">
						<img style="height:30px;width:30px;" src="<?php echo $val['product_pic'];?>"/>
					</td>
					<td style="width:15%">
						<?php echo $val['product_price'];?>元
					</td>
					<td style="width:17%">
						<?php echo $val['num'];?>
					</td>
				</tr>
				<?php 
				}
				?>
            </table>
        </div>
<!--        <div class="form-item" style="width:80%">-->
<!--            <label for="" class="label-top" style="font-size:16px;font-weight: bold">收货信息</label>-->
<!--        </div>-->
<!--        <div class="form-item" style="width:80%">-->
<!--            <label for="" class="label-top">收货地址：</label>-->
<!--            --><?php //echo $ordersData['address'];?>
<!--        </div>-->
		
<!--		--><?php //if(in_array($ordersData['order_status'],array('2','3','4'))){?>
<!--			<div class="form-item" style="width:80%">-->
<!--				<label for="" class="label-top" style="font-size:16px;font-weight: bold">物流信息</label>-->
<!--			</div>-->
<!--			<div class="form-item" style="width:80%">-->
<!--				<label for="" class="label-top">物流名称：</label>-->
<!--				--><?php //echo $ordersData['courier_name'];?>
<!--			</div>-->
<!--			<div class="form-item" style="width:80%">-->
<!--				<label for="" class="label-top">物流单号：</label>-->
<!--				--><?php //echo $ordersData['courier_code'];?>
<!--			</div>-->
<!--		--><?php //}?>
    </form>
</div>


