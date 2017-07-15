<?php
//~ 投稿start	
	if( isset($_GET['id']) && is_numeric($_GET['id']) && get_post($_GET['id']) && intval(get_post($_GET['id'])->post_author) === get_current_user_id() ){
		$action = 'edit';
		$the_post = get_post($_GET['id']);
		$post_title = $the_post->post_title;
		$post_content = $the_post->post_content;
		foreach((get_the_category($_GET['id'])) as $category) { 
			$post_cat[] = $category->term_id; 
		}
	}else{
		$action = 'new';
		$post_title = !empty($_POST['post_title']) ? $_POST['post_title'] : '';
		$post_content = !empty($_POST['post_content']) ? $_POST['post_content'] : '';
		$post_cat = !empty($_POST['post_cat']) ? $_POST['post_cat'] : array();
	}

//投稿表单部分
	echo '<div class="header_tips"> <i class="fa fa-warning" style="color:#ffbb33"></i> 在这里撰写您的稿件。 </div>';
	wp_enqueue_script('my_quicktags',get_stylesheet_directory_uri().'/js/my_quicktags.js',array('quicktags'));
	?>
				<article class="panel panel-default archive" role="main">
					<div class="panel-body" style="width:100%">
						<!--<h3 class="page-header"><?php //_e('投稿','cx-udy');?> <small><?php //_e('POST NEW','cx-udy');?></small></h3>-->
						<form role="form" method="post" id="chen_post_meta">
							<div class="form-group">
								<input type="text" class="form-control" name="post_title" id="chen_post_title" placeholder="<?php _e('在此输入标题','cx-udy');?>" value="<?php echo $post_title;?>" aria-required='true' required>
							</div>

							<div class="form-group">
								<?php wp_editor(  wpautop($post_content), 'post_content', array('media_buttons'=>true, 'quicktags'=>true, 'editor_class'=>'form-control', 'editor_css'=>'<style>.wp-editor-container{border:1px solid #ddd;}.switch-html, .switch-tmce{height:25px !important}</style>' ) ); ?>
							</div>
							<div class="form-group">
								<p class="help-block"><?php _e('填写描述文本:','cx-udy');?></p>
								<?php
								$cc = '';
								if(isset($_GET['id'])) $cc = get_post_meta( intval($_GET['id']), '_post_txt', true );
								$copyright_content = $cc ? $cc : '';
								?>
								<textarea name="post_copyright" id="post_excerpt" rows="2" cols="50" class="form-control"><?php echo $copyright_content;?></textarea>
							</div>
							<div class="form-group cl" style="margin-top: 30px;">
							   <div class="chenxing_field_au">
								   <div class="cx_field_area">
									   <div class="cx_file_preview" id="_cx_post_images_preview"></div>
									   <input type="text" class="_cx_post_images" value="" name="_cx_post_images" id="_feng_images_upload">
									   <a id="_cx_post_images" class="chenxing_upload_button button" href="#">点击设置封面图像</a>
								   </div>
							   </div>

							   <div class="cat_format">

								   <div class="cat_post_group">
									<?php
										$post_cat_output = '<p class="help-block">'.__('选择文章分类：','cx-udy').'</p>';
										$post_cat_output .= '<select name="post_cat[]" id="chen_post_cat" class="form-control">';
										if(!empty($can_post_cat) && is_array($can_post_cat)){
											foreach ( $can_post_cat as $term_id ) {
												$category = get_category( $term_id );
												$post_cat_output .= '<option value="'.$category->term_id.'">'. $category->name.'</option>';
											}
										}else{
											$post_cat_output .= '<option value="">暂无可投稿分类</option>';
										}
										$post_cat_output .= '</select>';
										echo $post_cat_output;
									?>
									</div>
									<div class="cat_post_group">
									<?php
										$post_f = '<p class="help-block">'.__('选择文章类型：','cx-udy').'</p>';
										$post_f .= '<select name="post-formats" id="post-formats" class="form-control">';
										$post_f .= '<option value="0">博客文章</option>';
										$post_f .= '<option value="image">图片集</option>';
										$post_f .= '<option value="video">视频</option>';
										$post_f .= '</select>';
										echo $post_f;
									?>
									</div>
									<div class="cat_post_group">
										<p class="help-block"><?php echo __('自动分页设置：','cx-udy');?></p>
										<select class="form-control" id="cx_auto_page_num" name="auto-page">
											<option value="0">默认不分页</option>
											<option value="1">每页1张图片</option>
											<option value="2">每页2张图片</option>
											<option value="4">每页4张图片</option>
											<option value="6">每页6张图片</option>
											<option value="8">每页8张图片</option>
											<option value="10">每页10张图片</option>
										</select>
									</div>
								</div>
							</div>

							<div class="form-group">
								<p class="help-block">文章推荐位置：</p>
								<div class="chen_field_area cl" style="margin-bottom: 20px;">
									<label for="_id_radio_bg"><input type="radio" class="ashuwp_field_radio" value="bg" id="_id_radio_bg" name="_chen_tuijian">编辑推荐</label>
									<label for="_id_radio_sy"><input type="radio" class="ashuwp_field_radio" value="sy" id="_id_radio_sy" name="_chen_tuijian">首页精选</label>
									<label for="_id_radio_qx"><input type="radio" class="ashuwp_field_radio" value="qx" id="_id_radio_qx" name="_chen_tuijian">取消设置</label>
								</div>
							</div>
							<?php do_action('post_single_web');?>

							<div class="form-group cl" style="background: #f1f1f1;padding: 15px 20px;">
								<div class="help-block"><?php _e('设置文章TAG标签：','cx-udy');?></div>
								<div class="tag_mun"></div>
								<div class="post_tag_a">
									<input type="text" class="form-control" id="post_tag__input" name="_post_tag_to" value="">
									<a href="#" id="post_tag_tianjia">添 加</a>
								</div>
								<div class="post_tag_h2">
									站内热门标签（点击添加）
								</div>
								<ul class="post_rm_tag">
									<?php wp_tag_cloud('smallest=12&largest=14&number=50&orderby=count'); ?>
								</ul>
								
							</div>
							
							<div class="form-group">
								<div class="db_form_chen">
									<p class="help-block"><?php _e('资源类型:','cx-udy');?></p>
									<div class="chen_field_area cl">
										<label for="_id_radio_zhijie"><input type="radio" class="ashuwp_field_radio" value="zhijie" id="_id_radio_zhijie" name="_cx_post_down">直接下载</label>
										<label for="_id_radio_jifen"><input type="radio" class="ashuwp_field_radio" value="jifen" id="_id_radio_jifen" name="_cx_post_down">积分下载</label>
										<label for="_id_radio_off"><input type="radio" class="ashuwp_field_radio" value="off" id="_id_radio_off" name="_cx_post_down">关闭下载</label>
									</div>
									
									<p class="help-block"><?php _e('填写资源名称:','cx-udy');?></p>
									<input type="text" class="form-control" name="down_name" id="down_name" value="">
									<p class="help-block"><?php _e('资源介绍文本:','cx-udy');?></p>
									<textarea name="down_meta" rows="2" cols="50" id="down_meta" class="form-control"></textarea>
									<div class="col_block">
										<p class="help-block"><?php _e('资源售价(积分):','cx-udy');?></p>
										<input type="text" class="form-control" id="down_pay" name="down_pay" value="">
									</div>
									<p class="help-block"><?php _e('资源下载URL:','cx-udy');?></p>
									<input type="text" class="form-control" id="down_url" name="down_url" value="">
									<p class="help-block"><?php _e('资源提取密码:','cx-udy');?></p>
									<input type="text" class="form-control" id="down_mima" name="down_mima" value="">
									<div class="col_block">
										<p class="help-block"><?php _e('会员是否可免费下载:','cx-udy');?></p>
										<div class="chen_field_area cl">
											<label for="_id_radio_bs"><input type="radio" class="ashuwp_field_radio" value="bg" id="_id_radio_bs" checked name="down_rad">需购买</label>
											<label for="_id_radio_bt"><input type="radio" class="ashuwp_field_radio" value="bq" id="_id_radio_bt" name="down_rad">会员免费</label>
										</div>
										<div class="col_vip" style="display: none">										
											<p class="help-block"><?php _e('会员免费资源信息:','cx-udy');?></p>
											<textarea name="down_vip" id="down_vip" rows="2" cols="50" class="form-control"></textarea>
										</div>
									</div>
								</div>
								<div class="db_none_chen">点击设置附件资源<br /><i class="fa fa-angle-down"></i></div>
							</div>

							<div class="form-group text-right">
								<select name="post_status" id="post_status">
									<?php if(current_user_can('edit_users')){?>
									<option value ="publish"><?php _e('直接发布','cx-udy');?></option>
									<?php } ?>
									<option value ="pending"><?php _e('提交审核','cx-udy');?></option>
									<option value ="draft"><?php _e('保存草稿','cx-udy');?></option>
								</select>
								<input type="hidden" name="wpaction" id="post_action" value="update">
								<input type="hidden" name="post_id" id="post_id" value="<?php echo ($_GET['id'])?$_GET['id']:'';?>">
								<input type="hidden" id="_wpnonce" name="_wpnonce" value="<?php echo wp_create_nonce( 'check-nonce' );?>">
								<button type="submit" class="btn btn-success" id="chen_tougao_submit"><?php _e('确认操作','cx-udy');?></button>
							</div>	
						</form>
					</div>
			 </article>
