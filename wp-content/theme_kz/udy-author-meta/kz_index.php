<?php
/**
* Name：关注vs私信功能
* Dir:udy-author-meta
* Link: http://www.chenxingweb.com/store/1910.html
* Author: 晨星博客
* Description: 使用该扩展可以在前台添加关注功能，和私信作者的功能.
* Version: 1.0.0
*/

Class Kz_Author_Meta{

	/** 构造函数 **/
	function __construct($chen_author){
		$this->kz = get_option('ashu_extend');
		add_filter('themes_options', array($this, 'kz_options_value'));
		if($this->kz['kz_author_meta_off'] == 'off' && @$this->wp_users()){
			require_once 'class_author_widgets.php';
			$this->URL  = CX_PLUGINS_URL.'udy-author-meta/';
			add_action( 'wp_ajax_kz_author_gz', array($this,'kz_author_gz') );
			add_action( 'wp_ajax_kz_author_gz_move', array($this,'kz_author_gz_move') );
			remove_action('Author-menu', array($chen_author,'Author_nav'),10,1);
			add_action( 'Author-menu', array($this, 'author_nav'),1);
			add_action( 'Author-menu-class', array($this, 'Author_nav_class'));
			add_filter('user_tab_title',array($this,'author_nav_title'),10,3);
			add_action( 'chen_author', array($this,'get_user_guanzhu'));
		}	
	}

	public function Author_nav_class($array){
		$array2 = array('guanzhu');
		$result = array_merge($array2, $array);
		return $result;
	}

	public function get_user_guanzhu($get_tab){
		if($get_tab == 'guanzhu'){
            include CX_PLUGINS.'udy-author-meta/web_user_guanzhu.php';	
		}
	}

	public function author_nav_title($html,$current_id,$get_tab){
		if($get_tab == 'guanzhu'){
			$numetar = isset($_GET['sh']) ? 1 : 2 ;
			$numetar2 = !isset($_GET['sh'])&&!isset($_GET['wq']) ? 1 : 2 ;
			$guanzhu = (empty(get_user_meta( $current_id, 'author_guanzhu', true)))?0:count(get_user_meta( $current_id, 'author_guanzhu', true));
			$fensi = (empty(get_user_meta( $current_id, 'user_guanzhu', true)))?0:count(get_user_meta( $current_id, 'user_guanzhu', true));
			$html .= '<a class="sh_'.$numetar2.'" href="'.add_query_arg(array('tab'=>'guanzhu'), get_author_posts_url($current_id)).'" > 我的关注<span>('.$guanzhu.')</span> </a>';
			$html .= '<a class="sh_'.$numetar.'" href="'.add_query_arg(array('tab'=>'guanzhu','sh'=>'fs'), get_author_posts_url($current_id)).'" > 我的粉丝<span>('.$fensi.')</span> </a>';
		}
		return $html;
	}

	public function Author_nav(){
		global $current_user, $curauth, $get_tab;
		$user = $current_user->ID;
		$uid = $curauth->ID;
		$tabs = array();
		if ( $user==$uid) {
			$tabs['post'] = __('My post','cx-udy');
			$tabs['comment'] = __('Comment list','cx-udy');
			$tabs['collect'] = __('My collection','cx-udy');
			$tabs['guanzhu'] = __('我的关注','cx-udy');
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

	public function kz_author_gz(){
		$user = wp_get_current_user();
		$user_id = $user->ID;
		$success = 0;
		$msg = '非法请求！';
		$author_id = !empty($_POST['author_id'])?intval($_POST['author_id']):0;
		if($author_id && $user_id){
			if($author_id == $user_id){
				$msg = '自己不可以关注自己！';
				$success = 1;
			}else{
				$user_gz = get_user_meta( $user_id, 'author_guanzhu', true );
				$author_gz = get_user_meta( $author_id, 'user_guanzhu', true );
				//用户关注的列表
				if(!empty($user_gz) && is_array($user_gz)){
					if(!in_array($author_id, $user_gz)){
						$user_gz[] = $author_id;
					}					
				}else{
					$user_gz = array($author_id);
				}

				// 被关注的列表
				if(!empty($author_gz) && is_array($author_gz)){
					if(!in_array($user_id, $author_gz)){
						$author_gz[] = $user_id;
					}					
				}else{
					$author_gz = array($user_id);
				}

				if(update_user_meta( $user_id, 'author_guanzhu', $user_gz) &&
				   update_user_meta( $author_id, 'user_guanzhu', $author_gz)){
					$success = 2;
					$msg = '您已成功关注该作者！';
				}

			}
		}
		$return = array('success'=>$success,'msg'=>$msg);
		echo json_encode($return);
		exit;
	}

	public function kz_author_gz_move(){
		$user = wp_get_current_user();
		$user_id = $user->ID;
		$success = 0;
		$msg = '非法请求！';
		$succ = false;
		$author_id = !empty($_POST['author_id'])?intval($_POST['author_id']):0;
		if($author_id && $user_id){
			$user_gz = get_user_meta( $user_id, 'author_guanzhu', true );
			$author_gz = get_user_meta( $author_id, 'user_guanzhu', true );
			//用户关注的列表
			if(!empty($user_gz) && is_array($user_gz) && in_array($author_id, $user_gz)){
				foreach ($user_gz as $key => $value) {
					if($value == $author_id){
						array_splice($user_gz,0,1);
						$succ = true;
					}
				}					
			}

			// 被关注的列表
			if(!empty($author_gz) && is_array($author_gz) && in_array($user_id, $author_gz)){
				foreach ($author_gz as $key => $value) {
					if($value == $user_id){
						array_splice($author_gz,0,1);
						$succ = true;
					}
				}						
			}

			if($succ && update_user_meta( $user_id, 'author_guanzhu', $user_gz) &&
				update_user_meta( $author_id, 'user_guanzhu', $author_gz)){
				$success = 2;
				$msg = '您已取消对该作者的关注！';
			}
		}
		$return = array('success'=>$success,'msg'=>$msg);
		echo json_encode($return);
		exit;
	}

	private function wp_users(){
		if(@Themes_Kzcode::wp_usre()){
			return true;
		}else{
			return false;
		}
	}

	/**
	 * 添加后台控制字段
	 */
	public function kz_options_value($array){
		array_pop($array);
		$array[] = array(
		  'name'    => '关注vs私信功能',
		  'desc'    => '开启该扩展会新增一个小工具以及添加用户中心页面！',
		  'dir'    => 'udy-author-meta',
		  'vion'    => 0.1,
		  'type' => 'title'
		); 
		$array[] = array(
		  'name'    => '开启该扩展',
		  'id'      => 'kz_author_meta_off',
		  'desc'    => '开启该扩展会新增一个小工具以及添加用户中心页面！',
		  'std'     => 'no',
		  'subtype' => array(
		    'no'  => '关闭',
		    'off' => '开启',
		  ),
		  'type' => 'select'
		); 

		$array[] = array('desc' => '', 'type' => 'close');
		return $array;
	}

}

//初始化定制类
$Kz_Author_Meta = new Kz_Author_Meta($chen_author);