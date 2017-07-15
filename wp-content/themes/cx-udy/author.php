<?php
global $wp_query;

$curauth = $wp_query->get_queried_object();
$user_name = filter_var($curauth->user_url, FILTER_VALIDATE_URL) ? '<a href="'.$curauth->user_url.'" target="_blank" rel="external">'.$curauth->display_name.'</a>' : $curauth->display_name;
$user_info = get_userdata($curauth->ID);
$posts_count =  $wp_query->found_posts;
$comments_count = get_comments( array('status' => '1', 'user_id'=>$curauth->ID, 'count' => true) );
$collects = $user_info->chenxing_collect?$user_info->chenxing_collect:0;
$collects_array = explode(',',$collects);
$collects_count = $collects!=0?count($collects_array):0;
$credit = intval($user_info->chenxing_credit);
$credit_void = intval($user_info->chenxing_credit_void);
$current_user = wp_get_current_user();
$can_post_cat = cx_options('_tougao_post_user',0,false);//接受投稿的分类
$cat_count = ($can_post_cat)?count($can_post_cat):0;

$oneself = $current_user->ID==$curauth->ID || current_user_can('edit_users') ? 1 : 0;
$admin = $current_user->ID==$curauth->ID&&current_user_can('edit_users') ? 1 : 0;

$tab_menu = apply_filters( 'Author-menu-class', array());
$get_tab = (isset($_GET['tab']) && in_array($_GET['tab'], $tab_menu))?$_GET['tab']:'post';

//分页参数
$argspage = array(
	'prev_text'          =>'<i class="fa fa-chevron-left"></i>',
	'next_text'          =>'<i class="fa fa-chevron-right"></i>',
	'mid_size' => 3,
	'before_page_number' => '<span class="meta-nav screen-reader-text">第 </span>',
	'after_page_number' => '<span class="meta-nav screen-reader-text"> 页</span>',
);


	// 提示
	$message = $pages = '';
	
	if($get_tab=='profile' && ($current_user->ID!=$curauth->ID && current_user_can('edit_users')) ) $message = sprintf(__('你正在查看的是%s的资料，修改请慎重！','cx-udy'), $curauth->display_name);
	
	// 积分start
	
	if( isset($_POST['creditNonce']) && current_user_can('edit_users') ){
		if ( ! wp_verify_nonce( $_POST['creditNonce'], 'credit-nonce' ) ) {
			$message = __('安全认证失败，请重试！','cx-udy');
		}else{
			$c_user_id =  $curauth->ID;
			if( isset($_POST['creditChange']) && sanitize_text_field($_POST['creditChange'])=='add' ){
				$c_do = 'add';
				$c_do_title = __('增加','cx-udy');
			}else{
				$c_do = 'cut';
				$c_do_title = __('减少','cx-udy');
			}

			$c_num =  intval($_POST['creditNum']);
			$c_desc =  sanitize_text_field($_POST['creditDesc']);
			
			$c_desc = empty($c_desc) ? '' : __('备注','cx-udy') . ' : '. $c_desc;

			update_chenxing_credit( $c_user_id , $c_num , $c_do , 'chenxing_credit' , sprintf(__('%1$s将你的积分%2$s %3$s 分。%4$s','cx-udy') , $current_user->display_name, $c_do_title, $c_num, $c_desc) );
			
			$message = sprintf(__('操作成功！已将%1$s的积分%2$s %3$s 分。','cx-udy'), $user_name, $c_do_title, $c_num);
		}
	}	
	
	//~ 积分end
	
	
	//~ 私信start
	$get_pm = isset($_POST['pm']) ? trim($_POST['pm']) : '';
	if( isset($_POST['pmNonce']) && $get_pm && is_user_logged_in() ){
		if ( ! wp_verify_nonce( $_POST['pmNonce'], 'pm-nonce' ) ) {
			$message = __('安全认证失败，请重试！','cx-udy');
		}else{
			$pm_title = json_encode(array(
				'pm' => $curauth->ID,
				'from' => $current_user->ID
			));
			if( add_chenxing_message( $curauth->ID, 'unrepm', '', $pm_title, $get_pm ) ) $message = __('发送成功！','cx-udy');
		}
	}
	
	//~ 私信end

//~ 页码start
$paged = max( 1, get_query_var('page') );
$number = 15;
$offset = ($paged-1)*$number;


//~ 页码end

$item_html = '<li class="tip">'.__('没有找到记录','cx-udy').'</li>';

wp_get_header();

?>
<!-- Main Wrap -->
<div class="setting_main">
	<div id="sitenews-wrap" class="container"></div>
	<div class="setting_inner pagewrapper clr" id="author-page">
		<div class="yscd avatar">
			<i class="fa fa-angle-double-right"></i>
		</div>
		<div class="yinxsh"></div>
		<aside class="user-left">
			<div class="usertitle">
			<?php 
			echo chenxing_get_avatar( $curauth->ID , '50' , chenxing_get_avatar_type($curauth->ID)); ?>
				<h2><?php echo $curauth->display_name;?></h2>
			</div>
			<div class="usermenus">
			<?php 
				//会员中心菜单
				do_action( 'Author-menu');
			?>
			</div>
		</aside>
		<div class="user-right">
		<!-- Content -->
		<div class="setting_header">
			<?php 
			//会员中心标题显示
			$b_title = apply_filters( 'Author-title', $get_tab,$posts_count, $cat_count, $current_user, $qq ,$weibo);
			?>
		</div>
		<div class="settin">
<?php
if($message) echo '<div class="header_tips">'.$message.'</div>'; 
//~ 积分列表start
if( $get_tab=='credit' ) {
	$cx_alipay = get_option('ashu_alipay_code');
	$create_int = intval($cx_alipay['alipay_create_int']);
	//~ 积分变更
	if ( current_user_can('edit_users') ) {

	?>
	<div class="panel panel-danger">
		<div class="panel-heading"><?php echo $curauth->display_name.__('积分调整（仅管理员可见）','cx-udy');?></div>
		<div class="panel-body">
			<form id="creditform" role="form"  method="post">
				<input type="hidden" name="creditNonce" value="<?php echo  wp_create_nonce( 'credit-nonce' );?>" >
				<p>
					<label class="radio-inline"><input type="radio" name="creditChange" value="add" aria-required='true' required checked=""><?php _e('增加积分','cx-udy');?></label>
					<label class="radio-inline"><input type="radio" name="creditChange" value="cut" aria-required='true' required><?php _e('减少积分','cx-udy');?></label>
				</p>
				<div class="form-inline">
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-addon"><?php _e('积分','cx-udy');?></div>
							<input class="form-control" type="text" name="creditNum" aria-required='true' required>
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-addon"><?php _e('备注','cx-udy');?></div>
							<input class="form-control" type="text" name="creditDesc" aria-required='true' required>
						</div>
					</div>
					<button class="btn btn-default" type="submit" style="margin-bottom:20px;"><?php _e('提交','cx-udy');?></button>
				</div>
				<p class="help-block"><?php _e('请谨慎操作！积分数只能填写数字，备注将显示在用户的积分记录中。','cx-udy');?></p>
			</form>
		</div>
	</div>

	<?php
	} 
	
	//~ 积分充值
	if ( $current_user->ID==$curauth->ID ) {

	?>
<style>
.panel-success {
    border-color: #b1b1b1;
    overflow: hidden;
}
.panel-success .alipay-cz {
    color: #f66;
    font-size: 16px;
}
#panel-tab-tab {
    background-color: #e1dfdf;
    height: 50px;
    line-height: 50px;
}
#panel-tab-tab li {
    float: left;
    list-style-type: none;
    padding: 0 20px;
    border-right: solid 1px #c0c0c0;
    color: #607D8B;
    font-size: 16px;
    cursor: pointer;
}
#panel-tab-tab li.current{
    background: #fff
}
#panel-tab-content ul {
    display: none;
    padding: 20px 0;
}
.panel-success .help-block{
	text-align: center;
}
</style>
	<div class="panel panel-success">
		<ul id="panel-tab-tab" class="cl">
		<?php if($cx_alipay['alipay_jiekou'] == 'alipay'){?>
 			<li class="current"><img src="<?php echo CX_JUEDUI_URL;?>/images/alipay.svg" width='25' height='25' alt="alipay"> 积分充值</li>
 			<li>充值卡充值</li>
		<?php }else{ ?>
			<li class="current">充值卡充值</li>
		<?php  } ?>        
	    </ul>
	    <div id="panel-tab-content">
	    <?php if($cx_alipay['alipay_jiekou'] == 'alipay'){?>
		    <ul style="display:block;" class="zaixian_cz">
		    	<div class="panel-body">
		           <form action="<?php echo CX_JUEDUI_URL;?>/inc/alipay-sdk/alipayapi.php" class="alipayform" method="post" target="_blank">
						<input type="hidden" name="alipayNonce" value="<?php echo  wp_create_nonce( 'alipay-nonce' );?>" >
						<input type = "hidden" name="alipay_product_id" readonly="" value="-4">
						<input type = "hidden" name="order_id" readonly="" value="0">
						<p>
							<label class="alipay-cz">充值可得：<?php echo intval(10*$create_int);?>积分</label>
						</p>
						<div class="form-inline">
							<div class="form-group">
								<div class="input-group">
									<div class="input-group-addon"><?php _e('充值金额 (元)','cx-udy');?></div>
									<input class="form-control" type="text" name="alipay-money" id="alipay-money" value="10" aria-required='true' required>
								</div>
							</div>
							<button class="btn btn-default" type="submit" id="alipay-ceredit" style="margin-bottom:20px;"><?php _e('支付宝充值','cx-udy');?></button>
						</div>
						<p class="help-block"><?php _e('积分换算比例：1元='.$create_int.'积分','cx-udy');?></p>
					</form>
				</div>
	        </ul>
	    <?php }
	    $chonzhiak_cz_style = ($cx_alipay['alipay_jiekou'] != 'alipay')?' style="display:block;"':'';
	     ?>
	        <ul class="chonzhiak_cz" <?php echo $chonzhiak_cz_style;?>>
	            <div class="panel-body">
					<form id="creditrechargeform" role="form"  method="post" onsubmit="return false;">
						<input type="hidden" name="creditrechargeNonce" value="<?php echo  wp_create_nonce( 'creditrecharge-nonce' );?>" >
						<input type = "hidden" id="order_id" name="order_id" readonly="" value="0">
						<input type = "hidden" id="product_id" name="product_id" readonly="" value="-4">
						<p>
							<label><a href="<?php 
							if($cx_alipay && isset($cx_alipay['alipay_create_dk_url']) && $cx_alipay['alipay_create_dk_url'] != 'http://'){
								echo $cx_alipay['alipay_create_dk_url'];
							}else{
								echo get_url_help('dianka');
							}
							?>">充值卡获取请查看这里</a></label>
						</p>
						<div class="form-inline">
							<div class="form-group">
								<div class="input-group">
									<div class="input-group-addon"><?php _e('充值卡号','cx-udy');?></div>
									<input class="form-control" type="text" name="creditrechargeNum" value="" aria-required='true' required>
								</div>
							</div>
							<button class="btn btn-default" type="submit" id="creditrechargesubmit" style="margin-bottom:20px;"><?php _e('充值','cx-udy');?></button>
						</div>
						<p class="help-block"><?php _e('充值的积分数量根据您充值卡的面值决定！','cx-udy');?></p>
					</form>
				</div>
	        </ul>
	    </div>
		<script>
			$(function(){
				var $li = $('#panel-tab-tab li');
				var $ul = $('#panel-tab-content ul');
				$li.click(function(){
					var $this = $(this);
					var $t = $this.index();
					$li.removeClass();
					$this.addClass('current');
					$ul.css('display','none');
					$ul.eq($t).css('display','block');
				})

				$('#alipay-money').on('input propertychange',function() {
					var _money = $(this).val(),
						_box   = $('.alipay-cz');
						if(_money >0){
							_box.html('充值可得：'+(_money*<?php echo $create_int;?>)+'积分');
						}
				});

			});
		</script>

	</div>

	<?php
	} 
	
	$item_html = '<li class="tip user_tip">' . sprintf(__('共有 %1$s 个积分，其中 %2$s 个已消费， %3$s 个可用。','cx-udy'), ($credit+$credit_void), $credit_void, $credit) ;
	if($current_user->ID==$curauth->ID){$item_html .= '<br/>&nbsp;&nbsp;每日签到送积分：'.chenxing_whether_signed($current_user->ID).'&nbsp;';}
	$item_html .= '</li>';

	if($oneself){
		$all = get_chenxing_message($curauth->ID, 'count', "msg_type='credit'");
		$pages = ceil($all/$number);
		
		$creditLog = get_chenxing_credit_message($curauth->ID, $number,$offset);

		if($creditLog){
			foreach( $creditLog as $log ){
				$item_html .= '<li>'.$log->msg_date.' <span class="message-content" style="background:transparent;">'.$log->msg_title.'</span></li>';
			}
			if($pages>1) $item_html .= '<li class="tip">' . sprintf(__('第 %1$s 页，共 %2$s 页，每页显示 %3$s 条。','cx-udy'),$paged, $pages, $number). '</li>';
		}
	}
	
	echo '<ul class="user-msg">'.$item_html.'</ul>';
	
	if($oneself) echo chenxing_pager($paged, $pages);
} 
//~ 积分列表end

//挂载函数
do_action('chen_author',$get_tab);



//~ 评论start
if( $get_tab=='comment' ) {

	$comments_status = $oneself ? '' : 'approve';
	
	$all = get_comments( array('status' => '', 'user_id'=>$curauth->ID, 'count' => true) );
	$approve = get_comments( array('status' => '1', 'user_id'=>$curauth->ID, 'count' => true) );
	
	$pages = $oneself ? ceil($all/$number) : ceil($approve/$number);

	$comments = get_comments(array(
		'status' => $comments_status,
		'order' => 'DESC',
		'number' => $number,
		'offset' => $offset,
		'user_id' => $curauth->ID
	));

	if($comments){
		echo '<div class="header_tips"> <i class="fa fa-warning" style="color:#ffbb33"></i> ' . sprintf(__('您有 %2$s 条已获准， %3$s 条正等待审核。','cx-udy'),$all, $approve, $all-$approve) . ' </div>';
		$item_html = '';
		foreach( $comments as $comment ){
			$item_html .= ' <li class="comment_author">';
			if($comment->comment_approved!=1) $item_html .= '<small class="text-danger">'.__( '这条评论正在等待审核','cx-udy').'</small>';
			$item_html .= '<div class="message-content">'.$comment->comment_content . '</div>';
			$item_html .= '<a class="info" href="'.htmlspecialchars( get_comment_link( $comment->comment_ID) ).'">'.sprintf(__('%1$s  发表在  %2$s','cx-udy'),$comment->comment_date,get_the_title($comment->comment_post_ID)).'</a>';
			$item_html .= '</li>';
		}
		if($pages>1) $item_html .= '<li class="tip">'.sprintf(__('第 %1$s 页，共 %2$s 页，每页显示 %3$s 条。','cx-udy'),$paged, $pages, $number).'</li>';
		echo '<ul class="user-msg">'.$item_html.'</ul>';
		echo chenxing_pager($paged, $pages);
	}else{
		echo '<div class="weizhaodao"><img src="'.cx_loading("weizhaodao").'"></div>';
	}
}
//~ 评论end

// 收藏start
if( $get_tab=='collect'){
	$item_html = __('共收藏了','cx-udy').$collects_count.'篇文章';
	//global $wp_query;
	//$args = array_merge( $wp_query->query_vars, array( 'post__in' => $collects_array, 'post_status' => 'publish' ) );
	query_posts( array( 'post__not_in'=>get_option('sticky_posts'), 'post__in' => $collects_array, 'post_status' => 'publish' ) );
	if(have_posts()){
	echo '<div class="header_tips"> <i class="fa fa-warning" style="color:#ffbb33"></i> '.$item_html.' </div>';
	echo '<ul class="ul_author_list cl">';
		while ( have_posts() ) : the_post();
			cx_themes_switch(4000,$post);
		endwhile; // end of the loop. 
	echo "</ul>";
		the_posts_pagination($argspage);
	}else{
		echo '<div class="weizhaodao"><img src="'.cx_loading("weizhaodao").'"></div>';
	}
	wp_reset_query();
	
}
// 收藏end

//~ 订单start
if( $get_tab=='orders' ) {
	if($oneself && !isset($_GET['sh'])){
		//$order_records = get_user_order_records(0,$curauth->ID);
		$oall = get_chenxing_orders(0, 'count');
		$pages = ceil($oall/$number);
		$order_records = get_chenxing_orders($curauth->ID, '', '', $number,$offset);
		echo '<div class="header_tips"> <i class="fa fa-warning" style="color:#ffbb33"></i> ' . sprintf(__('与 %1$s 相关订单记录。','cx-udy'), $curauth->display_name) . ' </div>';

?>
<ul class="site-order-list">
<div class="shop">
	<div id="history" class="wrapbox">
		<form id="continue-pay" name="continue-pay" action="<?php echo CX_JUEDUI_URL;?>/inc/alipay-sdk/alipayapi.php" method="post" style="height:0;">
			<input type="hidden" name="alipayNonce" value="<?php echo  wp_create_nonce( 'alipay-nonce' );?>" >
            <input type = "hidden" name="order_id" id="order_id" readonly="" value="0">
		</form>
		<div class="pay-history">
			<table width="100%" border="0" cellspacing="0" class="table table-bordered orders-table">
				<thead>
					<tr>
						<th scope="col" style="width:20%;"><?php _e('商品名','cx-udy'); ?></th>
						<th scope="col"><?php _e('订单号','cx-udy'); ?></th>
						<th scope="col"><?php _e('购买时间','cx-udy'); ?></th>
						<th scope="col"><?php _e('总价','cx-udy'); ?></th>
						<th scope="col"><?php _e('交易状态','cx-udy'); ?></th>
					</tr>
				</thead>
				<tbody class="the-list">
				<?php foreach($order_records as $order_record){ ?>
                    <tr>
						<td>
						<?php 
							if($order_record->product_id > 0){
								echo '<a href="'.get_permalink($order_record->product_id).'" target="_blank" title="'.$order_record->product_name.'">'.$order_record->product_name.'</a>';
							}else{
								echo $order_record->product_name;
							} 
						?>
						</td>
						<td><?php echo $order_record->order_id; ?></td>
						<td><?php echo $order_record->order_time; ?></td>
						<td><?php echo $order_record->order_total_price; ?></td>
						<td>
						<?php 
							if($order_record->order_status==1){
								echo '<a href="javascript:" data-id="'.$order_record->id.'" class="continue-pay">继续付款</a>';
							}else{
								echo output_order_status($order_record->order_status);
							} ?>
						</td>
						</tr>
				<?php } ?>
                </tbody>
			</table>
		</div>
	</div>	
</div>
<?php
	}
if(current_user_can('edit_users') && isset($_GET['sh'])){
	$oall = get_chenxing_orders(0, 'count');
	$pages = ceil($oall/$number);
	$oLog = get_chenxing_orders(0, '', '', $number,$offset);
	if($oLog){
		echo '<div class="header_tips"> <i class="fa fa-warning" style="color:#ffbb33"></i> ' . sprintf(__('全站共有 %1$s 条订单记录（该栏目仅管理员可见）。','cx-udy'), $oall) . ' </div>';

		$item_html = '';
		$item_html .= '<div class="site-orders">
			<table width="100%" border="0" cellspacing="0" class="table table-bordered orders-table">
				<thead>
					<tr>
						<th scope="col" style="width:20%;">'.__('商品名','cx-udy').'</th>
						<th scope="col">'.__('订单号','cx-udy').'</th>
						<th scope="col">'.__('买家','cx-udy').'</th>
						<th scope="col">'.__('购买时间','cx-udy').'</th>
						<th scope="col">'.__('总价','cx-udy').'</th>
						<th scope="col">'.__('交易状态','cx-udy').'</th>
					</tr>
				</thead>
				<tbody class="the-list">';
				foreach($oLog as $Log){
					$item_html .= '
                    <tr>
						<td>'.$Log->product_name.'</td>
						<td>'.$Log->order_id.'</td>
						<td>'.$Log->user_name.'</td>
						<td>'.$Log->order_time.'</td>
						<td>'.$Log->order_total_price.'</td>
						<td>';
					if($Log->order_status){$item_html .= output_order_status($Log->order_status);}
					$item_html .= '</td>';
					$item_html .= '</tr>';
				}
				$item_html .= '</tbody>
			</table>
		</div>';
		if($pages>1) $item_html .= '<li class="tip">'.sprintf(__('第 %1$s 页，共 %2$s 页，每页显示 %3$s 条。','cx-udy'),$paged, $pages, $number).'</li>';
	}
	echo $item_html.'</ul>';
	echo chenxing_pager($paged, $pages);

?>
<?php }
}
// 订单end

//~ 消息start
if( $get_tab=='message' ) {

	if($current_user->ID==$curauth->ID){
		$all_sql = "( msg_type='read' OR msg_type='unread' OR msg_type='repm' OR msg_type='unrepm' )";

		$all = get_chenxing_message($curauth->ID, 'count', $all_sql);
		
		$pages = ceil($all/$number);		

		$mLog = get_chenxing_message($curauth->ID, '', $all_sql, $number,$offset);

		$unread = intval(get_chenxing_message($curauth->ID, 'count', "msg_type='unread' OR msg_type='unrepm'"));
		
		if($mLog){
			echo '<div class="header_tips"> <i class="fa fa-warning" style="color:#ffbb33"></i> ' . sprintf(__('共有 %1$s 条消息， %2$s 条未读（绿色标注）。','cx-udy'), $all, $unread) . '</div>';
			$item_html = '';
			foreach( $mLog as $log ){
				$unread_tip = $unread_class = '';
				if(in_array($log->msg_type, array('unread', 'unrepm'))){
					$unread_tip = '<span class="tag">'.__('新！','cx-udy').'</span>';
					$unread_class = ' class="unread"';
					update_chenxing_message_type( $log->msg_id, $curauth->ID , ltrim($log->msg_type, 'un') );
				}
				$msg_title =  $log->msg_title;
				if(in_array($log->msg_type, array('repm', 'unrepm'))){
					$msg_title_data = json_decode($log->msg_title);
					$msg_title = get_the_author_meta('display_name', intval($msg_title_data->from));
					$msg_title = sprintf(__('%s发来的私信','cx-udy'), $msg_title).' <a href="'.add_query_arg('tab', 'message', get_author_posts_url(intval($msg_title_data->from))).'#'.$log->msg_id.'">'.__('查看对话','cx-udy').'</a>';
				}
				$item_html .= '<li'.$unread_class.'><div class="message-content">'.htmlspecialchars_decode($log->msg_content).' </div><p class="info">'.$unread_tip.'  '.$msg_title.'  '.$log->msg_date.'</p></li>';
			}
			if($pages>1) $item_html .= '<li class="tip">'.sprintf(__('第 %1$s 页，共 %2$s 页，每页显示 %3$s 条。','cx-udy'),$paged, $pages, $number).'</li>';
			echo '<ul class="user-msg">'.$item_html.'</ul>'.chenxing_pager($paged, $pages);
		}else{
			echo '<div class="weizhaodao"><img src="'.cx_loading("weizhaodao").'"></div>';
		}
		
	}else{
		
		if( is_user_logged_in() ){
			
			echo '<div class="header_tips"> <i class="fa fa-warning" style="color:#ffbb33"></i> '.sprintf(__('与 %s 对话','cx-udy'), $user_info->display_name).'</div>';
			$item_html = '<li><form id="pmform" role="form" method="post"><input type="hidden" name="pmNonce" value="'.wp_create_nonce( 'pm-nonce' ).'" ><p><textarea class="form-control" rows="3" name="pm" required></textarea></p><p class="clearfix cl"><a class="btn btn-link pull-left" href="'.add_query_arg('tab', 'message', get_author_posts_url($current_user->ID)).'">'.__('查看我的消息','cx-udy').'</a><button type="submit" class="btn btn-primary pull-right">'.__('确定发送','cx-udy').'</button></p></form></li>';
			$all = get_chenxing_pm( $curauth->ID, $current_user->ID, true );
			$pages = ceil($all/$number);
			
			$pmLog = get_chenxing_pm( $curauth->ID, $current_user->ID, false, false, $number, $offset );
			if($pmLog){
				foreach( $pmLog as $log ){
					$pm_data = json_decode($log->msg_title);
					if( $pm_data->from==$curauth->ID ){
						update_chenxing_message_type( $log->msg_id, $curauth->ID , 'repm' );
					}
					$item_html .= '<li id="'.$log->msg_id.'"><div class="message-content clearfix"><a class="'.( $pm_data->from==$current_user->ID ? 'pull-right' : 'pull-left' ).'" href="'.get_author_posts_url($pm_data->from).'">'.chenxing_get_avatar( $pm_data->from , '34' , chenxing_get_avatar_type($pm_data->from), false ).'</a><div class="pm-box"><div class="pm-content'.( $pm_data->from==$current_user->ID ? '' : ' highlight' ).'">'.htmlspecialchars_decode($log->msg_content).'</div><p class="pm-date">'.date_i18n( get_option( 'date_format' ).' '.get_option( 'time_format' ), strtotime($log->msg_date)).'</p></div></div></li>';
				}
			}
			
			if($pages>1) $item_html .= '<li class="tip">'.sprintf(__('第 %1$s 页，共 %2$s 页，每页显示 %3$s 条。','cx-udy'),$paged, $pages, $number).'</li>';
			echo '<ul class="user-msg">'.$item_html.'</ul>'.chenxing_pager($paged, $pages);
		}else{
			$item_html = '<li class="tip">'.sprintf(__('私信功能需要<a href="%s">登录</a>才可使用！','cx-udy'), wp_login_url() ).'</li>';
			echo '<ul class="user-msg">'.$item_html.'</ul>';
		}
	}

}
//~ 消息end
?>
		 </div>
		<!-- /.Content -->
		</div>
	</div>
</div>
<!--/.Main Wrap -->
<?php get_footer();消息end
?>
		 </div>
		<!-- /.Content -->
		</div>
	</div>
</div>
<!--/.Main Wrap -->
<?php get_footer();