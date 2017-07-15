<?php
/**
 * Name：会员开通页面模版
 * Date：2017-03-02
 * Author:晨星博客
 * Version: 0.1
 */

global $get_tab,$oneself,$curauth;
//~ 个人资料
if( $oneself ){
	$user_id = $curauth->ID;
	$user_info = get_userdata($curauth->ID);
	$qq = chenxing_is_open_qq();
	$weibo = chenxing_is_open_weibo();
	if( isset($_POST['update']) && wp_verify_nonce( trim($_POST['_wpnonce']), 'check-nonce' ) ) {
		$message = __('没有发生变化','cx-udy');	
		$update = sanitize_text_field($_POST['update']);
		if($update=='info'){
			$update_user_id = wp_update_user( array(
				'ID' => $user_id, 
				'user_email' => sanitize_text_field($_POST['email']),
				'nickname' => sanitize_text_field($_POST['display_name']),
				'display_name' => sanitize_text_field($_POST['display_name']),
				'user_url' => esc_url($_POST['url']),
				'description' => $_POST['description']
			 ) );
			 if ( ! is_wp_error( $update_user_id )) $message = __('基本信息已更新','cx-udy');	
		}
		if($update=='pass'){
			$data = array();
			$data['ID'] = $user_id;
			if( !empty($_POST['pass1']) && !empty($_POST['pass2']) && $_POST['pass1']===$_POST['pass2'] ) $data['user_pass'] = sanitize_text_field($_POST['pass1']);
			$user_id = wp_update_user( $data );
			if ( ! is_wp_error( $user_id ) ) $message = __('安全信息已更新','cx-udy');
		}
		$header_url = cx_host_page_url();
		Header("Location: $header_url"); 
	}
	//~ 个人资料end


	//~ 资料start
	if( $get_tab=='profile' ) {	
		if(!isset($_GET['sh']) && !isset($_GET['wq'])){	
		?>
		<div class="header_tips"><i class="fa fa-warning" style="color:#ffbb33"></i>请如实填写以下内容。</div>
	<div class="setting_form">
		<form id="info-form" class="form-horizontal" role="form" method="POST" action="" class="fv-form fv-form-bootstrap">
		<input type="hidden" name="update" value="info">
		<input type="hidden" name="_wpnonce" value="<?php echo wp_create_nonce( 'check-nonce' );?>">
	        <div class="setting_form_left">
	        <div class="user_uidt">
	            <div class="user_udiv">
		            <div class="udiv1"> 用户ID： </div>
		            <div class="udiv2"> <?php echo $user_info->user_login;?> </div>
	            </div>
	            <div class="xser_udiv">
		            <div class="udiv1"> 当前等级： </div>
		            <div class="udiv2"> 
					  <?php 
					  $member = getUserMemberInfo($user_id);
					  echo $member['user_type'];
						if($member['user_type'] == '非会员' || $member['user_type'] == '过期会员' )
							echo '   <a href="'.add_query_arg(array('tab'=>'membership'), get_author_posts_url($user_id)).'" class="hyfu" style="margin-left: 10px;">点我升级</a>';
						else
							echo '   <a class="hyfu" style="margin-left: 10px;">'.$member['user_status'].'</a>';
					  ?>
		            </div>
	            </div>
	        </div>
	    <div class="form-group height_72">
			<label for="display_name" class="col-sm-3 control-label"><?php _e('昵称','cx-udy');?></label>
			<div class="col-sm-9">
				<input type="text" class="form-control" id="display_name" name="display_name" value="<?php echo $user_info->display_name;?>">
			</div>
		</div>
		<div class="form-group height_72">
			<label for="email" class="col-sm-3 control-label"><?php _e('邮箱 (必填)','tin');?></label>
			<div class="col-sm-9">
				<input type="text" class="form-control" id="email" name="email" value="<?php echo $user_info->user_email;?>" aria-required='true' required>
			</div>
		</div>

		<div class="form-group height_72">
			<label for="url" class="col-sm-3 control-label"><?php _e('站点','cx-udy');?></label>
			<div class="col-sm-9">
				<input type="text" class="form-control" id="url" name="url" value="<?php echo $user_info->user_url;?>">
			</div>
		</div>
		
		<div class="form-group" style="height: 120px;">
			<label for="description" class="col-sm-3 control-label"><?php _e('个人说明','cx-udy');?></label>
			<div class="col-sm-9"style="max-width: 400px;">
				<textarea class="form-control" rows="3" cols="50" name="description" id="description"><?php echo $user_info->description;?></textarea>
			</div>
		</div>
		<div style="text-align: center;padding-top: 30px;padding-bottom:40px;">
			<button type="submit" class="edit_btn"><?php _e('保存更改','cx-udy');?></button>
		</div>
	        </div>
	   </form>
			<div class="setting_form_right">
	        <div id="crop-avatar">
	          <!-- Current avatar -->
	          <div class="avatar-view" title="上传头像">
			  <?php echo chenxing_get_avatar($user_id , '150' , chenxing_get_avatar_type($user_id) ); ?>
			  </div>
			  <span style="display: block;text-align: center;">我的头像</span>


				<!-- Cropping modal -->
			    <div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
			      <div class="modal-dialog modal-lg">
			        <div class="modal-content">
			          <form class="avatar-form" action="crop.php" enctype="multipart/form-data" method="post">
			            <div class="modal-header">
			              <button type="button" class="close" data-dismiss="modal">&times;</button>
			              <h4 class="modal-title" id="avatar-modal-label">上传头像裁切</h4>
			            </div>
			            <div class="modal-body">
			              <div class="avatar-body">

			                <!-- Upload image and data -->
			                <div class="avatar-upload">
			                  <input type="hidden" class="avatar-src" name="avatar_src">
			                  <input type="hidden" class="avatar-data" name="avatar_data">
			                  <input type="hidden" class="avatar-action" name="action" value="avatar_file">
			                  <label for="avatarInput">上传图片</label>
			                  <input type="file" class="avatar-input" id="avatarInput" name="avatar_file">
			                </div>

			                <!-- Crop and preview -->
			                <div class="row">
			                  <div class="col-md-9">
			                    <div class="avatar-wrapper"></div>
			                  </div>
			                  <div class="col-md-3">
			                    <div class="avatar-preview preview-lg"></div>
			                    <div class="avatar-preview preview-md"></div>
			                    <div class="avatar-preview preview-sm"></div>
			                  </div>
			                </div>

			                <div class="row avatar-btns">
			                  <div class="col-md-3">
			                    <button type="submit" class="btn btn-primary btn-block avatar-save">Done</button>
			                  </div>
			                </div>
			              </div>
			            </div>
			            <!-- <div class="modal-footer">
			              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			            </div> -->
			          </form>
			        </div>
			      </div>
			    </div><!-- /.modal -->

			 	<!-- Loading state -->
			    <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>

	        </div>
	      </div>
		  
	    </div>
		<?php }elseif(isset($_GET['sh']) && $_GET['sh']=='pwd' ){ ?>
	<div class="header_tips"> <i class="fa fa-warning" style="color:#ffbb33"></i> 密码可以是6-16位字符（字母、数字、符号），请注意区分大小写。 </div>
		<div class="setting_form" style="padding-top:20px;">	
			<form id="pass-form" class="form-horizontal" role="form" method="post">
				<input type="hidden" name="update" value="pass">
				<input type="hidden" name="_wpnonce" value="<?php echo wp_create_nonce( 'check-nonce' );?>">
				<div class="form-group has-feedback">
					<label for="pass1" class="col-sm-3 control-label"><?php _e('新密码','tin');?></label>
					<div class="col-sm-9">
						<input type="password" class="form-control" id="pass1" name="pass1" >
					</div>
				</div>
				<div class="form-group has-feedback">
					<label for="pass2" class="col-sm-3 control-label"><?php _e('重复新密码','tin');?></label>
					<div class="col-sm-9">
						<input type="password" class="form-control" id="pass2" name="pass2" >
					</div>
				</div>
				<div style="text-align: center;padding-top: 30px;padding-bottom:40px;"> 
					<button type="submit" class="edit_btn">保存更改</button>
				</div>
			</form>
		</div>
		<?php
		}elseif(isset($_GET['wq']) && $qq || $weibo ){?>
	<div class="header_tips"> <i class="fa fa-warning" style="color:#ffbb33"></i> 您可以绑定微博和QQ账号，前台可以用第三方快速登陆。 </div>
		<div class="setting_form" style="padding-top:20px;">	
			<form id="pass-form" class="form-horizontal" role="form" method="post">
				<?php if($qq){ ?>
			<div class="form-group cl">
				<label class="col-sm-3 control-label"><?php _e('QQ账号','tin');?></label>
				<div class="col-sm-9" style="padding-top:0">
			<?php  if(chenxing_is_open_qq($user_id)) { ?>
				<span class="help-block"><?php _e('已绑定','tin');?> <a href="<?php echo home_url('/?connect=qq&action=logout'); ?>"><?php _e('点击解绑','tin');?></a></span>
				<?php echo chenxing_get_avatar($user_id, '100' , 'qq' ); ?>
			<?php }else{ ?>
				<a class="btn btn-primary" href="<?php echo home_url('/?connect=qq&action=login&redirect='.urlencode(get_edit_profile_url())); ?>"><?php _e('绑定QQ账号','tin');?></a>
			<?php } ?>
				</div>
			</div>
		<?php } ?>

		<?php if($weibo){ ?>
			<div class="form-group cl">
				<label class="col-sm-3 control-label"><?php _e('微博账号','tin');?></label>
				<div class="col-sm-9" style="padding-top:0">
			<?php if(chenxing_is_open_weibo($user_id)) { ?>
				<span class="help-block"><?php _e('已绑定','tin');?> <a href="<?php echo home_url('/?connect=weibo&action=logout'); ?>"><?php _e('点击解绑','tin');?></a></span>
				<?php echo chenxing_get_avatar($user_id, '100' , 'weibo' ); ?>
			<?php }else{ ?>
				<a class="btn btn-danger" href="<?php echo home_url('/?connect=weibo&action=login&redirect='.urlencode(get_edit_profile_url())); ?>"><?php _e('绑定微博账号','tin');?></a>
			<?php } ?>
				</div>
			</div>
		<?php } ?>
			</form>
		</div>			
				
		<?php
		}
	}
} 
//~ 资料end