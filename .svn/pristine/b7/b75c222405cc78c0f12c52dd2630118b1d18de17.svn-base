		<div class="panel panel-danger">
			<div class="panel-heading"><?php echo __('查讯充值卡详细信息','cx-udy');?></div>
			<div class="panel-body">
				<form id="chen_dian_chaxun" role="form"  method="post">
					<input type="hidden" name="promoteNonce" value="<?php echo  wp_create_nonce( 'promote-nonce' );?>" >
					<div class="form-inline">
					<!--
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-addon"><?php _e('充值卡号','cx-udy');?></div>
								<input class="form-control" type="text" name="promote_num_cha" aria-required='true' required value="">
							</div>
						</div>
						-->
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-addon"><?php _e('查询类型','cx-udy');?></div>
								<select name="promote_num_cha" id="promote_num_cha" class="form-control">
									<option value="ka">充值卡号</option>
									<option value="id">用户ID</option>
									<option value="login">用户名</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="input-group">
								<input class="form-control" type="text" name="count_value_id" aria-required='true' value="" required>
							</div>
						</div>
						<button class="btn btn-default" id="chen_dianka_cha" type="submit"><?php _e('查询','cx-udy');?></button>
					</div>
					<p class="help-block"><?php _e('只输入卡号时返回充值卡的详细信息<br/>只输入用户编号（ID）时返回该用户所使用过的充值卡信息！','cx-udy');?></p>
				</form>
			</div>
		</div>

		<div class="dianka_list">

		</div>