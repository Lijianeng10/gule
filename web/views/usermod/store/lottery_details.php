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
            <label for="" class="label-top">网点编号：</label>
            <?php echo $cust_no;?>
        </div>
		<div class="form-item" style="width:80%">
            <label for="" class="label-top" style="font-size:16px;font-weight: bold">在售彩种信息</label>
        </div>
        <div class="form-item" style="width:100%;">
            <table id="value_table" border='1px' cellspacing="0" style="width:80%;text-align:center;margin-left: 100px;">
                <tr>
					<td style="width:15%">彩种图片</td>
					<td style="width:15%">机器设备号</td>
                    <td style="width:15%">彩种</td>
                    <td style="width:15%">彩票面额</td>
                    <td style="width:17%">剩余库存</td>
                </tr>
				<?php 
				foreach($machineLotteryData as $key => $val){
				?>
				<tr>
					<td style="width:15%">
						<img style="height:30px;width:30px;" src="<?php echo $val['lottery_img'];?>"/>
					</td>
					<td style="width:15%">
						<?php echo $val['machine_code'];?>
					</td>
					<td style="width:15%">
						<?php echo $val['lottery_name'];?>
					</td>
					<td style="width:15%">
						<?php echo $val['lottery_value'];?>元
					</td>
					<td style="width:17%">
						<?php echo $val['stock'];?>
					</td>
				</tr>
				<?php 
				}
				?>
            </table>
        </div>
		<div class="form-item" style="width:80%">
            <label for="" class="label-top" style="font-size:16px;font-weight: bold">可选彩种信息</label>
        </div>
        <div class="form-item" style="width:100%;">
            <table id="value_table" border='1px' cellspacing="0" style="width:80%;text-align:center;margin-left: 100px;">
                <tr>
					<td style="width:15%">彩种图片</td>
                    <td style="width:15%">彩种</td>
                    <td style="width:15%">彩票面额</td>
                    <td style="width:17%">剩余库存</td>
                </tr>
				<?php 
				foreach($storeLotteryData as $key => $val){
				?>
				<tr>
					<td style="width:15%">
						<img style="height:30px;width:30px;" src="<?php echo $val['lottery_img'];?>"/>
					</td>
					<td style="width:15%">
						<?php echo $val['lottery_name'];?>
					</td>
					<td style="width:15%">
						<?php echo $val['lottery_value'];?>元
					</td>
					<td style="width:17%">
						<?php echo $val['stock'];?>
					</td>
				</tr>
				<?php 
				}
				?>
            </table>
        </div>
    </form>
</div>
</body>


