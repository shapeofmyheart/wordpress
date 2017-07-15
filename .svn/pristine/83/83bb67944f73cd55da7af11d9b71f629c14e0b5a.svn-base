<?php
/**
 * Theme Name: CX-UDY
 * Theme URI: http://www.chenxingweb.com/store/1910.html
 * Author: 晨星博客
 * Author URI: http://www.chenxingweb.com
 * Description: 简洁时尚自适应图片主题，适合各种图片展示类网站，有问题请加QQ群565616228请求帮助。
 * Version: 0.5
 * Text Domain: cx-udy
 * Domain Path: /languages
 */

class ChenDownAjax extends ChenUser{
	function __construct(){
		add_action( 'wp_ajax_nopriv_chen_down_ajax',array( $this, 'chen_down_ajax') );
		add_action( 'wp_ajax_chen_down_ajax',array( $this, 'chen_down_ajax') );
		add_action( 'wp_ajax_chen_down_ajax_buy',array( $this, 'chen_ajax_post_buy') );
		add_action( 'wp_ajax_chen_down_vip_log',array( $this, 'down_vip_log') );
		add_action( 'wp_ajax_nopriv_chen_down_user_log',array( $this, 'down_user_log') );
		add_action( 'wp_ajax_chen_down_user_log',array( $this, 'down_user_log') );
		add_action( 'wp_ajax_down_log_query',array( $this, 'down_log_query') );		
		add_action('chen_author',array( $this, 'down_log'));
		add_action('admin_menu',array( $this, 'create_downlog_table'));
	}

	public function create_downlog_table(){
		global $wpdb;
		include_once(ABSPATH.'/wp-admin/includes/upgrade.php');
		$table_charset = '';
		$prefix = $wpdb->prefix;
		$users_table = $prefix.'chenxing_down_log';
		if($wpdb->has_cap('collation')) {
			if(!empty($wpdb->charset)) {
				$table_charset = "DEFAULT CHARACTER SET $wpdb->charset";
			}
			if(!empty($wpdb->collate)) {
				$table_charset .= " COLLATE $wpdb->collate";
			}		
		}
		$create_orders_sql = "CREATE TABLE $users_table (id int(11) NOT NULL auto_increment,product_id int(20) NOT NULL,product_name varchar(250),log_time datetime NOT NULL default '0000-00-00 00:00:00',user_id int(11) NOT NULL,user_name varchar(60),user_ip varchar(250),user_web varchar(10),user_txt varchar(20),user_other varchar(20),user_message text,PRIMARY KEY (id),INDEX productid_index(product_id),INDEX uid_index(user_id)) ENGINE = MyISAM $table_charset;";
		maybe_create_table($users_table,$create_orders_sql);			
	}

	public function chen_down_ajax(){
		$pid = ($_POST['post_id'])?(int)$_POST['post_id']:'';
		$msg = '没有可下载的资源!';
		$post_meta = array();
		$success = 0;
		$uid = 0;
		$vip_type = '游客';
		$vip_num = 0;
		if($pid){
			$P_M = $this->post_meta($pid);
			if($P_M['off'] !='off' && $P_M['url']!=''){
				if(is_user_logged_in()){
					$current_user = wp_get_current_user();
					$uid = $current_user->ID;
					$vip_num = $this->get_vip($uid);
					$vip_type = $this->get_vip_name($vip_num,$uid);
				}
				
				switch ($P_M['off']) {
					case 'zhijie':
						$success = 1;
						$msg = '免费资源下载';
						$post_meta = array('d_link'=>$P_M['url'],'d_an'  =>'立即下载','d_fa'  =>'fa-cloud-download','d_msg' =>'您是'.$vip_type.'用户可免费下载该资源','d_txt' =>$P_M['desc'],'d_mima'=>$P_M['mima'],'d_jf'  =>'','d_vip' =>'免费资源','d_cs'  =>'ajax_post_num');
						break;
					case 'jifen':
						if(is_user_logged_in()){
							if($P_M['vip_url']!='' && $vip_num>0 && $vip_num<4){
								$success = 1;
								$msg = 'VIP资源下载';
								if($this->get_vip_down($uid)){
									$post_meta = array('d_link'=>$P_M['vip_url'],'d_an'  =>'立即下载','d_fa'  =>'fa-cloud-download','d_msg' =>'您是'.$vip_type.'用户可免费下载该资源','d_txt' =>$P_M['desc'],'d_mima'=>$P_M['vip_mima'],'d_jf'  =>'','d_vip' =>'VIP专享','d_cs'  =>'ajax_post_vip');
								}else{
									$v_url = add_query_arg(array('tab'=>'membership'), get_author_posts_url($uid));
									$post_meta = array('d_link'=>$v_url,'d_an'  =>'升级会员','d_fa'  =>'fa-send','d_msg' =>'下载次数已用完！'.$this->get_vip_time($uid).'后可免费下载','d_txt' =>$P_M['desc'],'d_mima'=>'','d_jf'  =>'您是'.$vip_type.'每日可免费下载'.$this->get_vip_shu($uid).'次<br />会员等级越高免费次数越多！','d_vip' =>'VIP专享','d_cs'  =>'ajax_post_vip_2');
								}

							}else{
								global $wpdb;
								$prefix = $wpdb->prefix;
								$table = $prefix.'chenxing_orders';
								$row = $wpdb->get_row("select * from ".$table." where product_id=".$pid." and user_id=".$uid." and order_status=4",'ARRAY_A');
								if($row){
									$success = 1;
									$msg = '积分资源';
									$post_meta = array('d_link'=>$P_M['url'],'d_an'  =>'立即下载','d_fa'  =>'fa-cloud-download','d_msg' =>'您已成功换购该资源！','d_txt' =>$P_M['desc'],'d_mima'=>$P_M['mima'],'d_jf'  =>'','d_vip' =>'VIP专享','d_cs'  =>'ajax_post_num');
								}else{
									$success = 1;
									$msg = '积分资源';
									$credit = (int)get_user_meta($uid,'chenxing_credit',true);
									$url = ($credit<$P_M['pay'])?add_query_arg(array('tab'=>'credit'), get_author_posts_url($uid)):'#';
									$name = ($credit<$P_M['pay'])?'充值积分':'立即换购';
									$zy_class = ($credit<$P_M['pay'])?'ajax_cz':'ajax_shop_down';
									$vip_zk = $this->get_vip_pay('',$uid);
									if($vip_zk<1 && $vip_zk>0){
										$vip_to = '您是'.$this->get_vip_name('',$uid).'已享'.($vip_zk*10).'折优惠';
										$pm_pay = floor($P_M['pay']*$vip_zk);
									}else{
										$vip_to = (isset($P_M['vip_url']) && $P_M['vip_url']!='')?'VIP会员可免费下载':'VIP会员可享购买折扣';
										$pm_pay = $P_M['pay'];
									}
									
									$post_meta = array('d_link'=>$url,'d_an'  =>$name,'d_fa'  =>'fa-shopping-cart','d_msg' =>'您可用<span style="color:#f00">'.$pm_pay.'积分</span> 换购该资源','d_txt' =>$P_M['desc'].'<br /><span style="color:#f00"> '.$vip_to.'！</span>','d_mima'=>'','d_jf'  =>'您当前积分数量：'.$credit,'d_vip' =>'VIP专享','d_cs'  =>$zy_class);
								}
							}							
						}else{
							$success = 1;
							$msg = '积分资源';
							$user_vip_tip = (!empty($P_M['vip_url']))?'这是VIP资源会员用户可免费下载！':'开通VIP会员可享购买折扣哦！';
							$post_meta = array(
								'd_link'=>geturl('login').'?r='.get_permalink($pid),'d_an'  =>'登录购买','d_fa'  =>'fa-sign-in','d_msg' =>'登录帐号后可用 <span style="color:#f00">'.$P_M['pay'].'积分</span> 换购该资源','d_txt' =>$P_M['desc'].'<br /><span style="color:#f00"> '.$user_vip_tip.'</span>','d_mima'=>'','d_jf'  =>'','d_vip' =>'VIP专享','d_cs'  =>'ajax_post_num');
						}

					break;
				}
			}		
		}
		$return = array('success'=>$success,'msg'=>$msg,'post_meta'=>$post_meta);
		$return = apply_filters( 'post_down_ajax',$return,$P_M,$uid,$pid);
		echo json_encode($return);
		exit;
	}
	public function chen_ajax_post_buy(){
		$success = 0;
		$msg = '';
		$post_meta = array();
		$pid = ($_POST['post_id'])?(int)$_POST['post_id']:'';
		$current_user = wp_get_current_user();
		$uid = $current_user->ID;
		$credit = (int)get_user_meta($uid,'chenxing_credit',true);
		$P_M = $this->post_meta($pid);
		if(isset($P_M['pay']) && !$credit<$P_M['pay']){
			$vip_zk = $this->get_vip_pay('',$uid);
			if($vip_zk<1 && $vip_zk>0){
				$user_jf = floor($P_M['pay']*$vip_zk);
				$vip_msg = '您是会员用户本次节省 '.$P_M['pay']-$user_jf.' 积分！';
			}else{
				$user_jf = (int)$P_M['pay'];
				$vip_msg = '开通VIP会员可免费下载！';
			}			
			update_chenxing_credit($uid,$user_jf, 'cut' , 'chenxing_credit' , '下载资源消费'.$user_jf.'积分 资源编号：'.$pid );
			if(get_user_meta($uid,'chenxing_credit_void',true)){
				$void = get_user_meta($uid,'chenxing_credit_void',true);
				$void = $void + $user_jf;
				update_user_meta($uid,'chenxing_credit_void',$void);
			}else{
				add_user_meta( $uid,'chenxing_credit_void',$user_jf,true );
			}
			$insert = insert_order($pid,$P_M['name'],$P_M['pay'],1,$P_M['pay'],4,'',$uid,$current_user->display_name,$current_user->user_email,'','','','','');
			if($insert){
				$success = 1;
				$msg = '您已成功换购该资源！';
				$post_meta = array(
					'd_link'=>$P_M['url'],
					'd_an'  =>'立即下载',
					'd_fa'  =>'fa-cloud-download',
					'd_msg' =>'您已成功换购该资源！',
					'd_txt' =>$P_M['desc'].'<br /><span style="color:#f00"> 本次购买节省'.($P_M['pay']-$user_jf).'积分！</span>',
					'd_mima'=>$P_M['mima'],
					'd_cs'  =>'ajax_post_num',
				);

			}else{
				$msg = '程序出错，请联系管理员！';
			}
			
		}else{
			$msg = '积分数量不足，请充值后购买！';
		}
		$return = array('success'=>$success,'msg'=>$msg,'post_meta'=>$post_meta);
		echo json_encode($return);
		exit;
	}
	public function down_vip_log(){
		$pid = $_POST['pid'];
		$current_user = wp_get_current_user();
		$uid = $current_user->ID;
		$success = 0;
		$msg = '';	
		if($this->get_vip_date($uid)){
			$vip_num = get_user_meta($uid,'chenxing_vip_num',true);
			$vip_num = ($vip_num)?$vip_num:0;
			if($vip_num < $this->get_vip_shu($uid)){
				$success = 1;
				update_user_meta($uid, 'chenxing_vip_num', $vip_num+1);
				$this->insert_log($pid,$uid);
			}else{
				$msg = '您今日的下载次数已用完！';
			}			
		}else{
			$success = 1;
			update_user_meta($uid, 'chenxing_vip_num', 1);
			update_user_meta($uid, 'chenxing_vip_time', time());
			$this->insert_log($pid,$uid);
		}
		$return = array('success'=>$success,'msg'=>$msg);
		echo json_encode($return);
		exit;
		
	}
	public function down_user_log(){
		$pid = $_POST['pid'];
		$current_user = wp_get_current_user();
		if($current_user){
			$uid = $current_user->ID;
		}else{
			$uid = 0;
		}
		$this->insert_log($pid,$uid);
		exit;		
	}
	public function down_log(){
		if($_GET['tab'] == 'down'){
			$html = '';
			if($_GET['sh'] && $_GET['sh'] == 'cx'){
				$html .= '<div class="panel panel-danger">';
				$html .= '<div class="panel-heading">用户下载记录查询</div>';
				$html .= '<div class="panel-body">';
				$html .= '<form id="chen_log_chaxun" role="form"  method="post">';
				$html .= '		<input type="hidden" name="downNonce" value="'.wp_create_nonce( 'down-nonce' ).'" >';
				$html .= '		<div class="form-inline">';
				$html .= '			<div class="form-group">';
				$html .= '				<div class="input-group">';
				$html .= '					<div class="input-group-addon">查询类型</div>';
				$html .= '					<select name="down_type" id="down_type" class="form-control">';
				$html .= '						<option value="Post">资源ID</option>';
				$html .= '						<option value="Uid">用户ID</option>';
				$html .= '						<option value="Name">用户名</option>';
				$html .= '					</select>';
				$html .= '				</div>';
				$html .= '			</div>';
				$html .= '			<div class="form-group">';
				$html .= '				<div class="input-group">';
				$html .= '					<input class="form-control" type="text" name="down_value_id" aria-required="true" value="" required>';
				$html .= '				</div>';
				$html .= '			</div>';
				$html .= '			<button class="btn btn-default" id="chen_log_cha" type="submit">查询</button>';
				$html .= '		</div>';
				$html .= '		<p class="help-block">输入资源ID时返回该资源的下载记录<br/>输入用户名（ID）时返回该用户所有的下载记录！</p>';
				$html .= '	</form>';
				$html .= '</div>';
				$html .= '</div>';
				$html .= '<div class="dianka_list">';
				$html .= '</div>';
			}else{
				$paged = max( 1, get_query_var('page') );
				$number = 20;
				$offset = ($paged-1)*$number;
				$oall = $this->get_log(0,0,'cont');
				$pages = ceil($oall/$number);
				$orders = $this->get_log(0, 0, '', $number,$offset);
				$html .= '<div class="pay-history">';
				$html .= '	<table width="100%" border="0" cellspacing="0" class="table table-bordered orders-table">';
				$html .= '		<thead>';
				$html .= '			<tr>';
				$html .= '				<th scope="col">资源名称</th>';
				$html .= '				<th scope="col">资源ID</th>';
				$html .= '				<th scope="col">下载用户</th>';
				$html .= '				<th scope="col">用户ID</th>';
				$html .= '				<th scope="col">下载时间</th>';	
				$html .= '				<th scope="col">下载IP</th>';
				$html .= '			</tr>';
				$html .= '		</thead>';
				$html .= '		<tbody class="the-list">';
				if($orders){
					foreach($orders as $vip_order){
		                $html .= '		<tr>';
						$html .= '			<td>'.$vip_order->product_name.'</td>';
						$html .= '			<td>'.$vip_order->product_id.'</td>';
						$html .= '			<td>'.$vip_order->user_name.'</td>';
						$html .= '			<td>'.$vip_order->user_id.'</td>';
						$html .= '			<td>'.$vip_order->log_time.'</td>';
						$html .= '			<td>'.$vip_order->user_ip.'</td>';
						$html .= '		</tr>';
					}
				}				
	            $html .= '		</tbody>';
				$html .= '	</table>';
				$html .= '</div>';
			}
			if($pages>1){
				$html .= '<li class="tip">'.sprintf(__('第 %1$s 页，共 %2$s 页，每页显示 %3$s 条。','cx-udy'),$paged, $pages, $number).'</li>';
			}				
		}
		$html .= $this->log_pager($paged, $pages);
		echo $html;					
	}
	public function down_log_query(){
		$nonce = $_POST['down-nonce'];
		$type = $_POST['down_type'];
		$pid = intval($_POST['pid']);
		$success = 0;
		$msg = '验证信息失败';
		if(wp_verify_nonce($nonce,'down-nonce')){
			switch ($type) {
				case 'Post':
					$orders = $this->get_log($pid);
					break;
				case 'Name':
					$users = get_user_by( 'login',$user_id);
					$user_id = $users->ID;
					$orders = $this->get_log(0,$user_id);
					break;
				case 'Uid':
					$orders = $this->get_log(0,$pid);
					break;
			}
			if($orders){
				$html = '';
				foreach ($orders as $vip_order) {
					$html .= '<tr>';
					$html .= '<td>'.$vip_order->product_name.'</td>';
					$html .= '<td>'.$vip_order->product_id.'</td>';
					$html .= '<td>'.$vip_order->user_name.'</td>';
					$html .= '<td>'.$vip_order->user_id.'</td>';
					$html .= '<td>'.$vip_order->log_time.'</td>';
					$html .= '<td>'.$vip_order->user_ip.'</td>';
					$html .= '</tr>';
				}
				$msg = $html;
				$success = 1;
			}else{
				$msg = '未获取到相关内容！';
			}
		}
		$return = array('success'=>$success,'msg'=>$msg);
		echo json_encode($return);
		exit;		
	}
}
$chen_down = new ChenDownAjax();