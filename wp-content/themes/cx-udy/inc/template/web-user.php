		<div class="pay-history">
			<?php 
			$user_vip = get_user_vip_records();
			if($user_vip){
				echo '站内共有 '.count($user_vip).' 位VIP用户！';
			?>
			<table width="100%" border="0" cellspacing="0" class="table table-bordered orders-table">
				<thead>
					<tr>
						<th scope="col"><?php _e('用户ID','cx-udy'); ?></th>
						<th scope="col"><?php _e('用户名','cx-udy'); ?></th>
						<th scope="col"><?php _e('会员级别','cx-udy'); ?></th>
						<th scope="col"><?php _e('开通时间','cx-udy'); ?></th>
						<th scope="col"><?php _e('过期时间','cx-udy'); ?></th>
						
					</tr>
				</thead>
				<tbody class="the-list">
				<?php foreach($user_vip as $vip){ ?>
                    <tr>
						<td><?php echo $vip['user_id']; ?></td>
						<td><?php get_vip_meta($vip['user_id']); ?></td>
						<td><?php echo output_order_vipType($vip['user_type']); ?></td>
						<td><?php echo $vip['startTime']; ?></td>
						<td><?php echo (strtotime($vip['endTime'])>time())?$vip['endTime']:'<span style="color:#f00">(已过期)</span>'; ?></td>						
					</tr>
				<?php } ?>
                </tbody>
			</table>
			<?php 
			}else{
				echo '站内还没有用户开通VIP！';
			}
			?>
		</div>