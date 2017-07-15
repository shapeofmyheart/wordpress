		<div class="panel panel-danger">
			<div class="panel-heading"><?php echo __('批量添加充值卡','cx-udy');?></div>
			<div class="panel-body">
				<form id="chen_dian" role="form"  method="post">
					<input type="hidden" name="promoteNonce" value="<?php echo  wp_create_nonce( 'promote-nonce' );?>" >
					<div class="form-inline">
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-addon"><?php _e('张数','cx-udy');?></div>
								<input class="form-control" type="text" name="promote_num" aria-required='true' required value="10">
							</div>
						</div>
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-addon"><?php _e('面值','cx-udy');?></div>
								<input class="form-control" type="text" name="count_value" aria-required='true' value="10" required>
							</div>
						</div>
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-addon"><?php _e('截止有效期','cx-udy');?></div>
								<input class="form-control" type="text" name="dexpire_date" aria-required='true' required value="<?php $period = 3600*24*365; $endTime = time()+$period;echo strftime('%Y-%m-%d %X',$endTime);?>">
							</div>
						</div>
						<button class="btn btn-default" id="chen_dianka" type="submit"><?php _e('添加','cx-udy');?></button>
					</div>
					<p class="help-block"><?php _e('请谨慎操作！批量操作请尽量避开网站峰值，以免影响网站正常访问！','cx-udy');?></p>
				</form>
			</div>
		</div>

		<div class="dianka_list">

		</div>