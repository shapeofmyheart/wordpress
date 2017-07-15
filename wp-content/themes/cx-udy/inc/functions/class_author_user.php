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

class Author_Web extends ChenUser{	
	/** 构造函数 */
	function __construct(){
		$this->dir = get_template_directory();
		add_filter( 'Author-title', array($this,'get_tab_author'));
		add_action( 'chen_author', array($this,'get_user_vip'));
		add_action( 'chen_author', array($this,'get_user_profile'));
		add_action( 'chen_author', array($this,'get_post_list'));
		add_action( 'chen_author', array($this,'get_dianka_list'));
		add_action( 'Author-menu', array($this,'Author_nav'));
		add_action( 'Author-menu', array($this,'Author_Nav_ad'));
		add_filter( 'Author-menu-class', array($this,'Author_nav_class'));
		add_filter( 'Author-menu-class', array($this,'Author_nav_ad_class'));
		add_action( 'wp_ajax_chenxing_tougao', array($this,'chenxing_tougao_post'));
		add_action( 'wp_ajax_nopriv_create_credit_recharge_order', array($this,'create_order'));
		add_action( 'wp_ajax_create_credit_recharge_order', array($this,'create_order'));
		add_action( 'wp_ajax_chen_dianka_zz', array($this,'create_dianka_order'));
		add_action( 'wp_ajax_nopriv_create_credit_chongzhi', array($this,'create_chongzhi' ));
		add_action( 'wp_ajax_create_credit_chongzhi', array($this,'create_chongzhi' ));
		add_action( 'wp_ajax_pl_chonzhika', array($this,'piliang_dianka' ));
	}
	public function get_user_vip($get_tab) {
		if($get_tab == 'membership'){
            include $this->dir.'/inc/template/web-user-vip.php';	
		}		
	}
	public function get_post_list($get_tab) {
		if($get_tab == 'post'){
            include $this->dir.'/inc/template/web-post-list.php';	
		}		
	}
	public function get_user_profile($get_tab) {
		if($get_tab == 'profile'){
            include $this->dir.'/inc/template/web-user-profile.php';	
		}		
	}
	public function get_dianka_list($get_tab) {
		if($get_tab == 'promote'){
            include $this->dir.'/inc/template/web-dianka-list.php';	
		}		
	}
	public function get_tab_author($get_tab) {	
		global $posts_count, $cat_count, $current_user, $qq ,$weibo;	
		$html = '';
		switch ($get_tab) {
			case 'post':
				$numetar = isset($_GET['sh']) ? 1 : 2 ;
				$numetar2 = !isset($_GET['sh'])&&!isset($_GET['wq']) ? 1 : 2 ;
				if(!isset($_GET['action'])){
					$html .= '<a class="sh_'.$numetar2.'" href="'.add_query_arg(array('tab'=>'post'), get_author_posts_url($current_user->ID)).'" >'.__('Already released','cx-udy').' <span>'.$posts_count.'</span></a>';
					if(is_user_logged_in())
					$html .= '<a class="sh_'.$numetar.'" href="'.add_query_arg(array('tab'=>'post','sh'=>'all'), get_author_posts_url($current_user->ID)).'" > '.__('Unaudited','cx-udy').' </a>';
					if($cat_count){
						if( is_user_logged_in() && current_user_can('edit_posts') ){
							$html .= '<div class="tougao_author">';			
							$html .= '<a href="'.( is_user_logged_in() ? add_query_arg(array('tab'=>'post','action'=>'new'), get_author_posts_url($current_user->ID)) : wp_login_url() ).'">'.__('Post Post','cx-udy').'</a>';
							$html .= '</div>';
						}
					}
				}else{
					$html .= '<a class="sh_1" > '.__('Writing articles','cx-udy').' </a>';
				}
				break;
			case 'comment':
				$html .= '<a class="sh_1" > '.__('Comment list','cx-udy').' </a>';
				break;
			case 'credit':
				$html .= '<a class="sh_1" > '.__('My points','cx-udy').' </a>';
				break;
			case 'profile':
				$numetar = isset($_GET['sh']) ? 1 : 2 ;
				$numetar2 = !isset($_GET['sh'])&&!isset($_GET['wq']) ? 1 : 2 ;
				$numetar3 = isset($_GET['wq']) ? 1 : 2 ;
				$html .= '<a class="sh_'.$numetar2.'" href="'.add_query_arg(array('tab'=>'profile'), get_author_posts_url($current_user->ID)).'" > '.__('Edit data','cx-udy').' </a>';
				if(is_user_logged_in()){
					if($qq || $weibo)
					$html .= '<a class="sh_'.$numetar3.'" href="'.add_query_arg(array('tab'=>'profile','wq'=>'login'), get_author_posts_url($current_user->ID)).'" > '.__('Bind on Account','cx-udy').' </a>';
					$html .= '<a class="sh_'.$numetar.'" href="'.add_query_arg(array('tab'=>'profile','sh'=>'pwd'), get_author_posts_url($current_user->ID)).'" > '.__('Modify password','cx-udy').' </a>';
				}
				break;
			case 'membership':	
				$numetar = isset($_GET['sh']) ? 1 : 2 ;
				$numetar2 = !isset($_GET['sh'])&&!isset($_GET['wq']) ? 1 : 2 ;
				$html .= '<a class="sh_'.$numetar2.'" href="'.add_query_arg(array('tab'=>'membership'), get_author_posts_url($current_user->ID)).'" > '.__('Buy VIP','cx-udy').' </a>';
				if(current_user_can('edit_users'))
					$html .= '<a class="sh_'.$numetar.'" href="'.add_query_arg(array('tab'=>'membership','sh'=>'user'), get_author_posts_url($current_user->ID)).'" > '.__('All member','cx-udy').' </a>';
				break;
			case 'collect':
				$html .= '<a class="sh_1" > '.__('Exclusive collection','cx-udy').' </a>';
				break;
			case 'message':
				$html .= '<a class="sh_1" > '.__('My message','cx-udy').' </a>';
				break;
			case 'orders':
				$numetar = isset($_GET['sh']) ? 1 : 2 ;
				$numetar2 = !isset($_GET['sh'])&&!isset($_GET['wq']) ? 1 : 2 ;
				$html .= '<a class="sh_'.$numetar2.'" href="'.add_query_arg(array('tab'=>'orders'), get_author_posts_url($current_user->ID)).'" > '.__('My order','cx-udy').' </a>';
				if(current_user_can('edit_users'))
					$html .= '<a class="sh_'.$numetar.'" href="'.add_query_arg(array('tab'=>'orders','sh'=>'all'), get_author_posts_url($current_user->ID)).'" > '.__('All order','cx-udy').' </a>';
				break;
			case 'promote':
				$numetar4 = (isset($_GET['pl'])&&$_GET['pl']=='all') ? 1 : 2 ;
				$numetar5 = (!isset($_GET['pl'])|| ($_GET['pl']!='all' && $_GET['pl']!='cha')) ? 1 : 2 ;
				$numetar6 = (isset($_GET['pl'])&&$_GET['pl']=='cha') ? 1 : 2 ;
				$html .= '<a class="sh_'.$numetar5.'" href="'.add_query_arg(array('tab'=>'promote'), get_author_posts_url($current_user->ID)).'" > '.__('Rechargeable card','cx-udy').' </a>';
				$html .= '<a class="sh_'.$numetar4.'" href="'.add_query_arg(array('tab'=>'promote','pl'=>'all'), get_author_posts_url($current_user->ID)).'" > '.__('Batch generation','cx-udy').' </a>';
				$html .= '<a class="sh_'.$numetar6.'" href="'.add_query_arg(array('tab'=>'promote','pl'=>'cha'), get_author_posts_url($current_user->ID)).'" > '.__('Chaca','cx-udy').' </a>';
				break;
			case 'down':
				$numetar = isset($_GET['sh']) ? 1 : 2 ;
				$numetar2 = !isset($_GET['sh'])&&!isset($_GET['cx']) ? 1 : 2 ;
				$html .= '<a class="sh_'.$numetar2.'" href="'.add_query_arg(array('tab'=>'down'), get_author_posts_url($current_user->ID)).'" > '.__('Download log','cx-udy').' </a>';
				$html .= '<a class="sh_'.$numetar.'" href="'.add_query_arg(array('tab'=>'down','sh'=>'cx'), get_author_posts_url($current_user->ID)).'" > '.__('Record query','cx-udy').' </a>';
				break;
		}
		echo apply_filters( 'user_tab_title',$html,$current_user->ID,$get_tab);
	}

	public function chenxing_tougao_post(){
		$P = $_POST;
		//print_r($P);
		$post_meta = explode('&',$P['post_meta']);
		$posta = array();
		foreach ($post_meta as $key => $value) {
			$post_v = explode('=',$value);
			$posta[$post_v[0]] = urldecode($post_v[1]);
		}
		$P_M = $posta;
		$success = 0;
		$message = '';
		$post_id = 0;
		//print_r($P_M);
	    if( isset($P_M['wpaction']) && trim($P_M['wpaction'])=='update' && wp_verify_nonce( trim($P_M['_wpnonce']), 'check-nonce' ) ) {
	    	$title = sanitize_text_field($P_M['post_title']);
	    	//$content = $P['content'];
	    	$auto_page = ($P_M['auto-page'])?intval($P_M['auto-page']):'0';
	    	$content = $this->post_pages($P['content'],$auto_page);
	    	$id = $P_M['post_id']?$P_M['post_id']:'';
	    	if( $title && $content ){
	    		if(mb_strlen($content,'utf8')<140){
	    			$message = __('Submission failed, the content of the article at least 140 words.','cx-udy');
	    		}else{
	    			if(current_user_can('edit_users') && $P_M['post_status'] =='publish' ){
	    				$statr = 'publish';
	    			}elseif($P_M['post_status']==='pending' || (!current_user_can('edit_users') && $P_M['post_status'] =='publish')){
	    				$statr = 'pending';
	    			}else{
	    				$statr = 'draft';
	    			}
	    			//Post Meta
	    			$meta_input = array(
						'_post_txt' => $P_M['post_copyright'], 
						'_id_radio' => $P['tuijian'],
						'_cx_post_down'=> $P_M['_cx_post_down'],
						'_cx_post_down_meta' => $P['down_name'],
						'_cx_post_down_txt' =>$P['down_url'],
						'_cx_post_down_huiyuan_txt' => $P_M['down_vip']
						);  

	    			$meta_input = apply_filters( 'web_post_meta',$meta_input,$P_M,$P);

	    			if($id){
	    				$new_post = wp_update_post( array(
							'ID' => intval($id),
							'post_title'    => $title,
							'post_content'  => $content,
							'post_status'   => $statr,
							'post_author'   => get_current_user_id(),
							'post_excerpt'  => $P_M['post_copyright'],
							'_thumbnail_id' => $P_M['_cx_post_images'],
							'tags_input'    => $P['post_tag'],
							'post_category' => array($P['post_cat']),
							'meta_input' =>$meta_input
						) );
	    			}else{
	    				$new_post = wp_insert_post( array(
							'post_title'    => $title,
							'post_content'  => $content,
							'post_status'   => $statr,
							'post_author'   => get_current_user_id(),
							'post_excerpt'  => $P_M['post_copyright'],
							'tags_input'    => $P['post_tag'],
							'_thumbnail_id' => $P_M['_cx_post_images'],
							'post_category' => array($P['post_cat']),
							'meta_input' =>$meta_input
							) );

	    			}
	    			if( is_wp_error( $new_post ) ){
						$message = __('The operation failed, please try again or contact the administrator.','cx-udy');
					}else{
						$formats = $P_M['post-formats']?$P_M['post-formats']:0;
						set_post_format($new_post, $formats );
						$P_url = add_query_arg(array('tab'=>'post','action'=>'edit','id'=>$new_post), get_author_posts_url(get_current_user_id()));
						$post_id = array(
							'title' => __('Your submission of articles has been submitted to current status:','cx-udy').$this->post_status(get_post_status($new_post)),
							'cont' => sprintf(__('You can <a href= "%1$s" to view this article </a> or <a href= "%2$s" > modify the content of the </a> thank you for your support for this site!','cx-udy'),get_permalink($new_post), $P_url),
							'bottom' => __('I have known','cx-udy'),
							 );
						$message = __('Content update success.','cx-udy');
						$success = 1;
					}
	    		}

	    	}else{
	    		$message = __('The title and content cannot be blank.','cx-udy');
	    	}
	    }
	    $return = array('success'=>$success,'msg'=>$message,'post_id'=>$post_id);
		echo json_encode($return);
		exit;    
	}
	function create_order(){
		global $wpdb;
		$success = 0;
		$msg = '';
		$code = $_POST['creditrechargeNum'];
		$prefix = $wpdb->prefix;
		$table = $prefix.'chenxing_dianka';
		$row=$wpdb->get_row("select * from ".$table." where promote_code='".$code."'",'ARRAY_A');
		if(!$row){
			$msg = __('Recharge card does not exist','cx-udy');
		}elseif($row['promote_status']!=1||strtotime($row['expire_date'])<=time()){
			$msg = __('Prepaid card has been used or expired','cx-udy');
		}else{
			if($row['discount_value']>1){
				$success = 1;
				$msg = sprintf(__('Prepaid card value%1$s (integral) state: effective','cx-udy'),$row['discount_value']);
			}else{
				$msg = __('Recharge card invalid','cx-udy');
			}
		}
		$return = array('success'=>$success,'msg'=>$msg,'order_id'=>$code);
		echo json_encode($return);
		exit;
	}
	function create_dianka_order(){
		global $wpdb;
		$success = 0;
		$msg = '';
		$user = '';
		$user_name ='';
		$tab ='';
		$code_all = array();
		$code = isset($_POST['kahao'])?trim($_POST['kahao']):'';
		$user_id = isset($_POST['id'])?trim($_POST['id']):'';
		$prefix = $wpdb->prefix;
		$table = $prefix.'chenxing_dianka';
		if($code == 'ka'){
			$row=$wpdb->get_row("select * from ".$table." where promote_code='".$user_id."'",'ARRAY_A');		
			if(!$row){
				$msg = __('No search to meet the conditions of the prepaid card!','cx-udy');
			}else{
				if(isset($row['user_id']) && $row['user_id']>0){
					$users = get_user_by( 'id', $row['user_id']);
					$user = $users->ID;
					$user_name = $users->user_login;
				}
				$success = 1;
				$msg = sprintf(__('Recharge card:%1$s details are as follows:','cx-udy'),$row['promote_code']);
				$code_all = array(
					'sunc'=>$row['promote_status'],
					'id'=>$user,
					'name'=>$user_name,
					'code'=>$row['promote_code'],
					'pay'=>(int)$row['discount_value'],
					'date'=>$row['user_date'],
					'time'=>$row['expire_date']
					);
			}
		}elseif($code == 'id' || $code == 'login'){
			if($code == 'login'){
				$users = get_user_by( 'login',$user_id);
				$user_id = $users->ID;
			}
			$row=$wpdb->get_results("select * from ".$table." where user_id=$user_id",'ARRAY_A');
			if(!$row){
				$msg = __('No search to meet the conditions of the prepaid card!','cx-udy');
			}else{
				$success = 2;
				$msg = __('The user recharge card use history:','cx-udy');
				foreach ($row as $key => $value) {
					$tab .= '<tr><th>'.$value['promote_code'].'</th><th>'.$value['discount_value'].'</th><th>'.$value['user_date'].'</th></tr>';
				}
				

				$code_all = array(
					'num'=>count($row),
					'html'=>$tab,
					);
			}
		}

		$return = array('success'=>$success,'msg'=>$msg,'code'=>$code_all);
		echo json_encode($return);
		exit;
	}
	function create_chongzhi(){
		global $wpdb;
		$success = 0;
		$order_id = '';
		$msg = '';
		$code = $_POST['credit_kahao'];
		$product_id = $_POST['product_id'];
		$credit_mima = $_POST['credit_mima'];

		$order_note = json_encode(array('promote_code'=>$code));
		$prefix = $wpdb->prefix;
		$table = $prefix.'chenxing_dianka';
		$row=$wpdb->get_row("select * from ".$table." where promote_type='".$credit_mima."' and promote_status=1 and promote_code='".$code."'",'ARRAY_A');
		if(!$row || strtotime($row['expire_date'])<=time()){
			$msg = __('Recharge card anomaly, please check and then submit','cx-udy');
		}else{
			if($row['discount_value']>1){
				if(!is_user_logged_in()){
					$msg=__('Please login first','cx-udy');
				}else{
					$user_info = wp_get_current_user();
					$uid = $user_info->ID;
					$user_name=$user_info->display_name;
					$user_email = $user_info->user_email;
					$time = date("Y-m-d H:i:s");
					if($product_id!=-4){
						$msg=__('System error, please try again','cx-udy');
					}else{
						$wpdb->query( "UPDATE $table SET promote_status=0,user_id=$uid,user_date='$time' WHERE promote_code='$code'" );
						$credits = (int)$row['discount_value'];
						$order_name = sprintf(__('Recharge %1$s integral','cx-udy'),$credits);
						$order_price = (int)$credits;
						$insert = insert_order($product_id,$order_name,$order_price,1,$order_price,4,$order_note,$uid,$user_name,$user_email,'','','','','');
						if($insert){
							$success = 1;
							$msg = sprintf(__('Prepaid card recharge has been successfully used %1$s points!','cx-udy'),$credits);
							$order_id = $insert;
							add_user_credits_by_order($credits,$uid,$user_name,'','');
						}else{
							$msg = __('Failed to create the order, please try again','cx-udy');
						}
					}	
				}
			}else{
				$msg = __('Recharge card invalid','cx-udy');
			}
		}
		$return = array('success'=>$success,'msg'=>$msg,'order_id'=>$order_id);
		echo json_encode($return);
		exit;
	}
	function piliang_dianka(){
		$time = time();
		$num = (int)$_POST['num'];
		$p_discount =  intval($_POST['count']);
		$p_expire_date =  sanitize_text_field($_POST['date']);
		$html  = '';
		$html .= __('<h2> you generated this recharge card is as follows: </h2>','cx-udy');
		$html .= sprintf(__('Total value of generating %1$s integral card %2$s <br><br>','cx-udy'),$p_discount,$num);
		for ($i=1; $i<=$num; $i++) {
			$pid = $time.$i.rand(111,999);
			$mima = substr(MD5(wp_create_nonce($pid)),5,16);
			add_chenxing_promotecode($pid,$mima,$p_discount,$p_expire_date);
			$html .= $pid.' '.$mima.'<br />';
		}
		$html .= __('<br><p> generate again please refresh the page! </p>','cx-udy');
		echo $html;
		exit;
	}

	function Author_nav(){
		global $current_user, $curauth, $get_tab;
		$user = $current_user->ID;
		$uid = $curauth->ID;
		$tabs = array();
		if ( $user==$uid) {
			$tabs['post'] = __('My post','cx-udy');
			$tabs['comment'] = __('Comment list','cx-udy');
			$tabs['collect'] = __('My collection','cx-udy');
			$unread = intval(get_chenxing_message($uid, 'count', "msg_type='unread' OR msg_type='unrepm'"));
			if($unread){
				$message_tx = '<em style="color: rgb(247, 78, 11);margin-left: 5px;">'.__('new','cx-udy').'</em>';
				$tabs['message'] = __('Private letter','cx-udy').$message_tx;
			}else{
				$tabs['message'] = __('My private letters','cx-udy');
			}

			if($user==$uid || current_user_can('edit_users'))
			$tabs['profile'] = __('personal data','cx-udy');
		}else{
			$tabs = array(
				'post' => __('Post','cx-udy'),
				'comment' => __('comment','cx-udy'),
				'collect' => __('Collection','cx-udy'),
				'message' => __('Send private messages','cx-udy'),
			);	
		}
		foreach( $tabs as $tab_key=>$tab_value ){
			if( $tab_key ) $tab_array[] = $tab_key;
		}
		$tab_output = '<ul class="usermenu">';
		foreach( $tab_array as $tab_term ){
			$class = $get_tab==$tab_term ? ' class="active" ' : '';
			$tab_output .= sprintf('<li%s><a href="%s">%s</a></li>', $class, add_query_arg('tab', $tab_term, esc_url( get_author_posts_url( $curauth->ID ) )), $tabs[$tab_term]);
		}
		$tab_output .= '</ul>';
		echo $tab_output;
	}

	function Author_nav_class($array){
		$array2 = array('post','comment','collect','message','profile');
		$result = array_merge($array2, $array);
		return $result;
	}

	function Author_Nav_ad(){
		global $current_user, $curauth, $get_tab, $oneself,$admin;
		if($oneself){
			$tab2s['credit']=__('Integral management','cx-udy');
			$tab2s['membership']=__('Member service','cx-udy');
			$tab2s['orders']=__('Station order','cx-udy');
		}
		if($admin){
			$tab2s['down']=__('Download record','cx-udy');
			$tab2s['promote']=__('Rechargeable card','cx-udy');
		}		
		$tab_output = '';
		$tab_output .= '<ul class="usermenu">';
		if($oneself){
			foreach( $tab2s as $tab2_key=>$tab2_value ){
				if( $tab2_key ) $tab2s_array[] = $tab2_key;
			}
			foreach( $tab2s_array as $tab_term ){
				$class = $get_tab==$tab_term ? ' class="active" ' : '';
				$tab_output .= sprintf('<li%s><a href="%s">%s</a></li>', $class, add_query_arg('tab', $tab_term, esc_url( get_author_posts_url( $curauth->ID ) )), $tab2s[$tab_term]);
			}
			$tab_output .='<li><a href="'.wp_logout_url('/').'">'.__('Sign out','cx-udy').'</a></li>';				
		}elseif(is_user_logged_in()){
			$tab_output .='<li><a href="'.get_author_posts_url( $current_user->ID ).'">'.__('Return oneself','cx-udy').'</a></li>';
		}else{
			$tab_output .='<li><a href="'.home_url().'">'.__('Return home','cx-udy').'</a></li>';
		}
		$tab_output .= '</ul>';
		echo $tab_output;
	}

	function Author_nav_ad_class($array){
		$array2 = array('credit','membership','orders','down','promote');
		$result = array_merge($array2, $array);
		return $result;
	}	

}
$chen_author = new Author_Web(););