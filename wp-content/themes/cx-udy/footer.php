		<!--footer-->
		<?php
		$footer = cx_options('_cx_tongji');
		if(isset($footer) && $footer == 'off'){?>
		<div class="foot" id="footer">
			<div class="foot_list">
				<div class="foot_num">
					<div>文章总数</div> <div><?php $count_posts = wp_count_posts(); echo $published_posts = $count_posts->publish;?>+</div>
				</div>
						<div class="foot_num">
					<div>评论总数</div> <div><?php echo $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->comments");?>+</div>
				</div>

				<div class="foot_num">
					<div>专题栏目</div> <div><?php $zt = wp_count_posts('zhuanti_type'); echo $zt->publish;?>+</div>
				</div>

				<div class="foot_num">
					<div>运营天数</div> <div>
					<?php 
					$user_admin_info = get_userdata(1);
					$admin_time = ($user_admin_info)?$user_admin_info->user_registered:'2016-11-22';
					echo floor((time()-strtotime($admin_time))/86400);
					 ?>+</div>
				</div>
			</div>
		</div>
		<?php } ?>
		<footer class="w100 cl">
			<?php echo cx_foot(); ?>
		 </footer>
		<?php wp_footer();?>
		<!--移动侧边导航-->	
	</body>
</html>otime($admin_time))/86400);
					 ?>+</div>
				</div>
			</div>
		</div>
		<?php } ?>
		<footer class="w100 cl">
			<?php echo cx_foot(); ?>
		 </footer>
		<?php wp_footer();?>
		<!--移动侧边导航-->	
	</body>
</html>