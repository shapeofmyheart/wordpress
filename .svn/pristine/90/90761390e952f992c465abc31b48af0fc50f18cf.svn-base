<?php
$files = isset($_FILES['extendzip'])?$_FILES['extendzip']:'';
if($files){	
	$referer = $_POST['http_referer'];
	$plugins_dir = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))).'/theme_kz';
	if(strpos($files['name'],'.zip') && @move_uploaded_file($files["tmp_name"],  $_SERVER['DOCUMENT_ROOT'].'/wp-content/uploads/'.$files['name'])){
		$zip_dir = $_SERVER['DOCUMENT_ROOT'].'/wp-content/uploads/'.$files['name'];
		$zip = new ZipArchive;
		if ($zip->open($zip_dir) === TRUE){  
			$zip->extractTo($plugins_dir); 
			$zip->close();
			@unlink ($zip_dir);
			header("location: $referer");
		}else{
			echo '文件上传发生错误！错误代码：X000-2';
		}
	}else{
		echo '未找到符合条件的扩展包！';
	}
}else{
	echo '请选择好扩展包后再上传！';
}