<?php
/**
 * Name：会员开通页面模版
 * Date：2017-03-02
 * Author:晨星博客
 * Version: 0.1
 */

global $get_tab,$oneself,$curauth;

if( $get_tab=='guanzhu' && $oneself) {?>
<style>
.udy_guanzhu_user {
    height: 120px;
    overflow: hidden;
}
.udy_guanzhu_user img {
    height: 100px;
    width: 100px;
    border-radius: 5px;
}
.udy_guanzhu_user h3 {
    font-weight: normal;
    height: 40px;
    line-height: 40px;
}
.udy_guanzhu_user h3 span {
    border: solid 1px #f7b5b5;
    font-size: 12px;
    padding: 2px 5px;
    border-radius: 2px;
    color: #f7a3a3;
    margin-left: 10px;
    cursor: pointer;
}
.udy_guanzhu_user p {
    font-size: 15px;
    height: 50px;
    line-height: 25px;
    overflow: hidden;
    color: #999;
}
</style>
<?php
	if(isset($_GET['sh']) && $_GET['sh'] == 'fs'){
		$get_content = get_user_meta( $curauth->ID, 'user_guanzhu', true );
		if(!empty($get_content) && is_array($get_content)){
			$item_html = '共有'.count($get_content).'位用关注了你！';
		}
		$item_author_kz = false;
	}else{
		$get_content = get_user_meta( $curauth->ID, 'author_guanzhu', true );
		if(!empty($get_content) && is_array($get_content)){
			$item_html = '您共关注了'.count($get_content).'位作者！';
		}
		$item_author_kz = true;
	}
	if(!empty($get_content) && is_array($get_content)){
		echo '<div class="header_tips"> <i class="fa fa-warning" style="color:#ffbb33"></i> '.$item_html.' </div>';
		echo '<ul class="ul_author_list cl">';
		$html = '';
		foreach ($get_content as $user_id) {
			$user_meta = get_user_by( 'id', $user_id );
			if(is_object($user_meta)){
				$html .= '<li class="udy_guanzhu_user">';
				$html .= '<a href="'.chenxing_get_user_url( 'post', $user_meta->ID ).'">';
				$html .= chenxing_get_avatar($user_meta->ID , '150' , chenxing_get_avatar_type($user_meta->ID) );
				$html .= '</a>';
				$html .= '<h3><a href="'.chenxing_get_user_url( 'post', $user_meta->ID ).'">'.$user_meta->display_name.'</a>';
				if($item_author_kz){
					$html .= '<span id="move_guanzhu" data-author="'.$user_id.'"> 取消关注</span>';
				}				
				$html .= '</h3>';
				$html .= '<p>';
				if(!empty($user_meta->description)){
					$html .= $user_meta->description;
				}else{
					$html .= '该用户很懒，没有填写任何描述！';
				}				
				$html .= '</p>';
				$html .= '</li>';
			}
		}
		echo $html;
		echo "</ul>";
		?>
		<script type="text/javascript">
			$('#move_guanzhu').click(function() {
				var _this = $(this),
					_author_id = _this.data('author');
					_this.html('正在取消关注 <i class="fa fa-spinner fa-spin"></i>');
					$.ajax({
						url: chenxing.ajax_url,
						type: 'POST',
						dataType: 'json',
						data: {
							'action': 'kz_author_gz_move',
            				'author_id': _author_id
						},
						success:function(b) {
							if(b.success == 2){
								_this.html('已取消');
								_this.parents('li').css("background","#f66");
				                setTimeout(function () {
				                    _this.parents('li').fadeOut();
				                }, 1000);
							}else{
								alert(b.msg);
								_this.html('取消关注');
							}
							console.log(b);
						}
					});
					
				});
				</script>
	<?php
	}else{
		echo '<div class="weizhaodao"><img src="'.cx_loading("weizhaodao").'"></div>';
	}
}