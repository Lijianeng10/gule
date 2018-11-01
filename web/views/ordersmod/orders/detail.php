<body style="height: 100%;">
<style type="text/css">
    .form-item {
        margin-bottom: 15px;
        width: 50%;
        float: left;
    }

    .form-item > label {
        min-width: 72px;
        display: inline-block;
    }

    .form-item input, select {
        width: 170px;
    }

    .label-top {
        text-align: right;
    }
</style>
<div class="super-theme-example">
    <form id="myform">
		<div class="form-item" style="width:80%">
            <label for="" class="label-top">订单编号：</label>
            <?php echo $ordersData['order_code'];?>
        </div>
        <div class="form-item" style="width:80%">
            <label for="" class="label-top">网点编号：</label>
            <?php echo $ordersData['cust_no'];?>
        </div>
        <div class="form-item" style="width:80%">
            <label for="" class="label-top" style="font-size:16px;font-weight: bold">彩票信息</label>
        </div>
        <div class="form-item" style="width:100%;">
            <table id="value_table" border='1px' cellspacing="0" style="width:80%;text-align:center;margin-left: 100px;">
                <tr>
                    <td style="width:15%">彩种</td>
                    <td style="width:15%">彩票面额</td>
                    <td style="width:17%">购买数量(包)</td>
                    <td style="width:17%">每包张数</td>
                    <td style="width:17%">价格(包)</td>
                </tr>
				<?php 
				foreach($orderDetailData as $key => $val){
				?>
				<tr>
					<td style="width:15%">
						<?php echo $val['lottery_name'];?>
					</td>
					<td style="width:15%">
						<?php echo $val['sub_value'];?>元
					</td>
					<td style="width:17%">
						<?php echo $val['nums'];?>
					</td>
					<td style="width:17%">
						<?php echo $val['sheet_nums'];?>
					</td>
					<td style="width:17%">
						<?php echo $val['price'];?>
					</td>
				</tr>
				<?php 
				}
				?>
            </table>
        </div>
        <div class="form-item" style="width:80%">
            <label for="" class="label-top" style="font-size:16px;font-weight: bold">收货信息</label>
        </div>
        <div class="form-item" style="width:80%">
            <label for="" class="label-top">收货地址：</label>
            <?php echo $ordersData['address'];?>
        </div>
		
		<?php if(in_array($ordersData['order_status'],array('2','3','4'))){?>
			<div class="form-item" style="width:80%">
				<label for="" class="label-top" style="font-size:16px;font-weight: bold">物流信息</label>
			</div>
			<div class="form-item" style="width:80%">
				<label for="" class="label-top">物流名称：</label>
				<?php echo $ordersData['courier_name'];?>
			</div>
			<div class="form-item" style="width:80%">
				<label for="" class="label-top">物流单号：</label>
				<?php echo $ordersData['courier_code'];?>
			</div>
		<?php }?>
		
		<input type="hidden" name="count" id="count" value="1">
    </form>
</div>
</body>


