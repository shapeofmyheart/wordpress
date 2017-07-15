<?php
/**
 * Name：充值卡管理
 * Date：2017-03-02
 * Author:晨星博客
 * Version: 0.1
 */

//~ 充值卡start
global $get_tab,$admin;

// 优惠码start	
if( isset($_POST['promoteNonce']) && current_user_can('edit_users') ){
	if ( ! wp_verify_nonce( $_POST['promoteNonce'], 'promote-nonce' ) ) {
		$message = __('安全认证失败，请重试！','cx-udy');
	}else{
		$p_type_title = __('一次性','cx-udy');
		$p_discount =  intval($_POST['discount_value']);
		$p_expire_date =  sanitize_text_field($_POST['expire_date']);
		$p_code = sanitize_text_field($_POST['promote_code']);
		$p_type = substr(md5(base64_encode($p_code.$p_expire_date)),5,16);
		add_chenxing_promotecode($p_code,$p_type,$p_discount,$p_expire_date);
		setcookie('discount_value',$p_discount, time()+3600);			
		$message = sprintf(__('操作成功！已成功添加优惠码%1$s，卡密：%2$s 折扣：%3$s 有效期至：%4$s。','cx-udy'), $p_code, $p_type, $p_discount, date('Y/m/d H:i:s',strtotime($p_expire_date)));
	}
}
	
if( isset($_POST['dpromoteNonce']) && current_user_can('edit_users') ){
	if ( ! wp_verify_nonce( $_POST['dpromoteNonce'], 'dpromote-nonce' ) ) {
		$message = __('安全认证失败，请重试！','cx-udy');
	}else{
		$promote_id = intval($_POST['promote_id']);
		delete_chenxing_promotecode($promote_id);
		$message = __('操作成功！已成功删除指定优惠码','cx-udy');
	}		
}
//~ 优惠码end
if($message) echo '<div class="header_tips">'.$message.'</div>'; 
if( $get_tab=='promote' && $admin) {
	if(isset($_GET['pl']) && $_GET['pl']=='all'){
		require 'web-dianka.php';
	}elseif(isset($_GET['pl']) && $_GET['pl']=='cha'){
		require 'web-dianka_chaxun.php';
	}else{
		if ( current_user_can('edit_users') ) {
			 $discount_value_cook = isset($_COOKIE['discount_value'])? $_COOKIE['discount_value']:'10';
		?>
		<div class="panel panel-danger">
			<div class="panel-heading"><?php echo __('管理员添加充值卡','cx-udy');?></div>
			<div class="panel-body">
				<form id="promoteform" role="form"  method="post">
					<input type="hidden" name="promoteNonce" value="<?php echo  wp_create_nonce( 'promote-nonce' );?>" >
					<p style="display:none;">
						<label class="radio-inline"><input type="radio" name="promote_type" value="once" aria-required='true' required checked><?php _e('一次性','cx-udy');?></label>
					</p>
					<div class="form-inline">
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-addon"><?php _e('充值卡','cx-udy');?></div>
								<input class="form-control" type="text" name="promote_code" aria-required='true' required value="<?php echo chr(mt_rand(65, 90)).time().mt_rand(11, 99);?>">
							</div>
						</div>
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-addon"><?php _e('面值','cx-udy');?></div>
								<input class="form-control" type="text" name="discount_value" aria-required='true' value="<?php echo $discount_value_cook;?>"required>
							</div>
						</div>
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-addon"><?php _e('截止有效期','cx-udy');?></div>
								<input class="form-control" type="text" name="expire_date" aria-required='true' required value="<?php $period = 3600*24*365; $endTime = time()+$period;echo strftime('%Y-%m-%d %X',$endTime);?>">
							</div>
						</div>
						<button class="btn btn-default" type="submit"><?php _e('添加','cx-udy');?></button>
					</div>
					<p class="help-block"><?php _e('请谨慎操作！面值等于能充值的积分数量。每张充值卡只能给你一个账号充值一次！','cx-udy');?></p>
				</form>
			</div>
		</div>

		<table class="table table-bordered promote-table">
		  <input type="hidden" name="dpromoteNonce" value="<?php echo  wp_create_nonce( 'dpromote-nonce' );?>" >
	      <thead>
	        <tr class="active">
	          <th><?php _e('卡号','cx-udy');?></th>
	          <th><?php _e('卡密','cx-udy');?></th>
	          <th><?php _e('面值','cx-udy');?></th>
			  <th><?php _e('有效期','cx-udy');?></th>
			  <th><?php _e('状态','cx-udy');?></th>
			  <th><?php _e('操作','cx-udy');?></th>
	        </tr>
	      </thead>
	      <tbody>
		  <?php $pcodes=output_chenxing_promotecode(); 
			foreach($pcodes as $pcode){
		  ?>
	        <tr>
			  <input type="hidden" name="promote_id" value="<?php echo $pcode['id']; ?>" >
			 	<td><?php echo $pcode['promote_code'];?></td>
				<td><?php echo $pcode['promote_type'];?></td>
				<td><?php echo (int)$pcode['discount_value'];?></td>
				<td><?php echo date('Y年m月d日 H时i分s秒',strtotime($pcode['expire_date'])) ;?></td>
				<td>
					<?php 
					if(strtotime($pcode['expire_date'])<=time()){
						echo '<span style="color: #AFACAC">已过期</span>';
					}elseif($pcode['promote_status']!=0){
						echo '<span style="color: #44BD30">未使用</span>';
					}else{
						echo '<span style="color: #E345F5">已使用</span>';
					}
					?>
				</td>
				<td class="delete_promotecode"><a><?php _e('删除','cx-udy');?></a></td>
	        </tr>
		  <?php
			}
		  ?>
	      </tbody>
	    </table>	
	<?php
		}
	}
}
// 充值卡end
