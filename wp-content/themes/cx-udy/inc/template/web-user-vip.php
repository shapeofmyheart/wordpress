<?php
/**
 * Name：会员开通页面模版
 * Date：2017-03-02
 * Author:晨星博客
 * Version: 0.1
 */

global $get_tab,$oneself,$curauth;
// 会员start
	if( isset($_POST['promoteVipNonce']) && current_user_can('edit_users') ){
		if ( ! wp_verify_nonce( $_POST['promoteVipNonce'], 'promotevip-nonce' ) ) {
			$message = __('安全认证失败，请重试！','cx-udy');
		}else{
			if( isset($_POST['promotevip_type']) && sanitize_text_field($_POST['promotevip_type'])=='3' ){
				$pv_type = 3;
				$pv_type_title = __('钻石会员','cx-udy');
			}elseif(isset($_POST['promotevip_type']) && sanitize_text_field($_POST['promotevip_type'])=='2'){
				$pv_type = 2;
				$pv_type_title = __('白金会员','cx-udy');
			}else{
				$pv_type = 1;
				$pv_type_title = __('普通会员','cx-udy');
			}
			$pv_expire_date =  sanitize_text_field($_POST['vip_expire_date']);

			chenxing_manual_promotevip($curauth->ID,$curauth->display_name,$curauth->user_email,$pv_type,$pv_expire_date);
			
			$message = sprintf(__('操作成功！已成功将%1$s提升至%2$s，有效期至 %3$s。','cx-udy'), $curauth->display_name, $pv_type_title, date('Y年m月d日 H时i分s秒',strtotime($pv_expire_date)));
			$message .= ' <a href="'.chenxing_get_current_page_url().'">'.__('点击刷新','cx-udy').'</a>';
		}
	}
//~ 会员end

if($message) echo '<div class="header_tips">'.$message.'</div>'; 
if( $get_tab=='membership' && $oneself) {
	//判断是是查看全部会员
	if(isset($_GET['sh']) && $_GET['sh'] == 'user' && current_user_can('edit_users')){
		require 'web-user.php';
	}else{
		$member = getUserMemberInfo($curauth->ID);
		if($member['user_type'] == '非会员'){
			$hyxixi = '您还不是会员用户哦！';
		}else{
			$hyxixi = '当前等级：'.$member['user_type'].'  到期时间'.$member['endTime'];
		}
	?>
		<div class="header_tips">
	        <i class="fa fa-warning" style="color:#ffbb33"></i> <?php echo $hyxixi;?> 
		</div>

	<?php if(current_user_can('edit_users')){ ?>
		<div class="panel panel-danger">
			<div class="panel-heading"><?php echo __('会员操作（本选项卡及内容仅管理员可见）','cx-udy');?></div>
			<div class="panel-body">
				<form id="promotevipform" role="form"  method="post">
					<input type="hidden" name="promoteVipNonce" value="<?php echo  wp_create_nonce( 'promotevip-nonce' );?>" >
					<p>
						<label class="radio-inline"><input type="radio" name="promotevip_type" value="1" aria-required='true' required checked><?php _e('普通会员','cx-udy');?></label>
						<label class="radio-inline"><input type="radio" name="promotevip_type" value="2" aria-required='true' required><?php _e('白金会员','cx-udy');?></label>
						<label class="radio-inline"><input type="radio" name="promotevip_type" value="3" aria-required='true' required><?php _e('钻石会员','cx-udy');?></label>
					</p>
					<div class="form-inline">
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-addon"><?php _e('会员截止有效期','cx-udy');?></div>
								<input class="form-control" type="datetime-local" name="vip_expire_date" aria-required='true' required>
							</div>
						</div>
						<button class="btn btn-default" id="promotevipform-submit" type="submit" style="margin-bottom:20px;"><?php _e('确认操作','cx-udy');?></button>
					</div>
					<p class="help-block" style="text-align: center;"><?php _e('请谨慎操作！会员截止有效期格式2015-01-01','cx-udy');?></p>
				</form>
			</div>
		</div>
	<?php } ?>
	<div class="panel">
		<div class="panel-body" style="padding-top:50px;">
			<form id="joinvip" role="form" method="post" onsubmit="return false;">
				<p>
					<input type="hidden" name="vipNonce" value="<?php echo wp_create_nonce( 'vip-nonce' );?>" >
					<input type = "hidden" id="order_id" name="order_id" readonly="" value="0">
					<label class="radio-inline"><input type="radio" name="product_id" value="-1" aria-required="true" required="" checked=""> <?php _e('普通会员'); ?>(<?php cx_options('CX_VIP_MONTHLY_PRICE',1,'100'); ?> 积分/月 )</label>
					<label class="radio-inline"><input type="radio" name="product_id" value="-2" aria-required="true" required=""> <?php _e('白金会员'); ?>(<?php cx_options('CX_VIP_QUARTERLY_PRICE',1,'280'); ?> 积分/季)</label>
					<label class="radio-inline"><input type="radio" name="product_id" value="-3" aria-required="true" required=""> <?php _e('钻石会员'); ?>(<?php cx_options('CX_VIP_ANNUAL_PRICE',1,'800'); ?> 积分/年)</label>
				</p>
				<p class="butpal">
					<button class="btn btn-primary" id="joinvip-submit" type=""><?php _e('确认开通','cx-udy'); ?></button>
				</p>
				<p class="help-block" style="font-size:14px;margin-bottom: 50px;text-align: center;"><?php _e('提示:若已开通会员则按照选择开通的类型自动续费,若会员已到期,则按重新开通计算有效期','cx-udy'); ?></p>
			</form>
		</div>

	</div>

	<?php if(current_user_can('edit_users')){ 
	$vip_orders = getUserMemberOrders($curauth->ID);
	if($vip_orders){
	 ?>
	 <div class="pay-history">
				<table width="100%" border="0" cellspacing="0" class="table table-bordered orders-table">
					<thead>
						<tr>
							<th scope="col"><?php _e('订单号','cx-udy'); ?></th>
							<th scope="col"><?php _e('订单日期','cx-udy'); ?></th>
							<th scope="col"><?php _e('支付金额','cx-udy'); ?></th>
							<th scope="col"><?php _e('开通类型','cx-udy'); ?></th>	
							<th scope="col"><?php _e('交易状态','cx-udy'); ?></th>
						</tr>
					</thead>
					<tbody class="the-list">
					<?php foreach($vip_orders as $vip_order){ ?>
	                    <tr>
							<td><?php echo $vip_order['order_id']; ?></td>
							<td><?php echo $vip_order['order_time']; ?></td>
							<td><?php echo $vip_order['order_total_price']; ?></td>
							<td><?php echo output_order_vipType($vip_order['product_id']*(-1)); ?></td>
							<td><?php echo output_order_status($vip_order['order_status']); ?></td>
							</tr>
					<?php } ?>
	                </tbody>
				</table>
			</div>
			
	<?php
			} 
		}
	}
}
// 会员end