<?php
/**
 * 头像处理
 */
class Avatar_File{	

	public function proceess(){
		$current_user = wp_get_current_user();
		$uid = $current_user->ID;
		$this->edit_user_profile_update($uid);
		exit;
	}

	public function unique_filename_callback( $dir, $name, $ext ) {
		$user = get_user_by( 'id', (int) $this->user_id_being_edited ); 
		$name = $base_name = sanitize_file_name( $user->ID . '_avatar' );
		$number = 1;
 
		while ( file_exists( $dir . "/$name$ext" ) ) {
			$name = $base_name . '_' . $number;
			$number++;
		}
 
		return $name . $ext;
	}

	public function edit_user_profile_update($user_id){
 
		if ( ! empty( $_FILES['avatar_file']['name'] ) ) {
			$mimes = array(
				'jpg|jpeg|jpe' => 'image/jpeg',
				'gif' => 'image/gif',
				'png' => 'image/png'
			);
 
			// front end (theme my profile etc) support
			if ( ! function_exists( 'wp_handle_upload' ) )
				require_once( ABSPATH . 'wp-admin/includes/file.php' );
 
			//$this->avatar_delete( $user_id );
 			$this->avatar_delete($user_id);
			// 如果是php文件停止执行
			if ( strstr( $_FILES['simple-local-avatar']['name'], '.php' ) )
				wp_die('请上传合法文件.');
 
			$this->user_id_being_edited = $user_id;
			$avatar = wp_handle_upload( 
				$_FILES['avatar_file'],
				 array( 
				 	'mimes' => $mimes,
				 	'test_form' => false,
				 	'unique_filename_callback' => array( $this, 'unique_filename_callback' )
				 ),
				 'icon'
			);
 			

			if ( empty($avatar['file'])) return false;
			$upload_path = wp_upload_dir('icon');
			$old_avatar_path = str_replace('//','/',str_replace( $upload_path['url'], $upload_path['path'],$avatar['url']));
			$old_avatar_url = preg_replace("/(.jpg|.jpeg|.jpe|.gif|.png)/is", "-100$1", $avatar['url']);
			$o_avatar_url = parse_url($old_avatar_url);
			$old_avatar_url = $o_avatar_url['scheme'].'://'.$o_avatar_url['host'].str_replace('//','/',$o_avatar_url['path']);
			if ($old_avatar_path) {		
				$image = wp_get_image_editor($old_avatar_path);
				if(!is_wp_error( $image)){
					$image_data = json_decode(stripslashes($_POST['avatar_data']), true);
					if($image_data){
						$image->crop($image_data['x'],$image_data['y'], $image_data['width'],$image_data['height']);
					}
					$image->resize(300,300,true);
					$image->save(preg_replace("/(.jpg|.jpeg|.jpe|.gif|.png)/is", "-100$1", $old_avatar_path));
					@unlink($old_avatar_path);
				}
			}
			if(update_user_meta($user_id,'simple_local_avatar',$old_avatar_url)){
				$response = array(
				  'state'  => 200,
				  'message' => '上传成功',
				  'result' => $old_avatar_url
				);
				echo json_encode($response);
			}
		}
	}

	public function avatar_delete($user_id) {
		$old_avatars = get_user_meta( $user_id, 'simple_local_avatar', true );
		$upload_path = wp_upload_dir('icon');
 
		if ($old_avatars && strstr($old_avatars, get_option('home'))) {
			$old_avatar_path = str_replace('//','/',str_replace( $upload_path['url'], $upload_path['path'], $old_avatars));
			@unlink( $old_avatar_path );
		} 
		delete_user_meta( $user_id, 'simple_local_avatar' );
	}
}