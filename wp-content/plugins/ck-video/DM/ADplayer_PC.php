
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>DoubleMax Video AD Plug-in</title>
 </head>
   <script>
	  function closeAD(){document.getElementById('clickforce_ad').style.display='none';}
	  setTimeout(function(){
		  document.getElementById('clickforce_ad').style.display='none';
		},10000);
   </script>  
	<?php
		$wid=$_GET['w'];
		$vid= $_GET['v'];
		$zid= $_GET['z1'];
		$zid2= $_GET['z2'];
		$bgid=$_GET['bg'];
		$mode=$_GET['mode'];
		//To devlare the global variable for width, height and video ID
		switch($mode){
			case("yt"):
				echo '<script type="text/javascript">'."\n";
				include './view/ytJS.php';
				echo '</script>'."\n";
				break;
			case("dm"):
				echo '<script type="text/javascript">';
				include './view/dmVideoInit.php';
				include './view/dmJS.php';		
				echo '</script>'."\n";
				break;
			default:
				echo '<script type="text/javascript">'."\n";
				include './view/ytJS.php';
				echo '</script>'."\n";
				break;			
		}
		if($bgid=="")			
			echo '<body bgcolor="#000000" alink="#FFFFFF">'."\n";
		else
			echo '<body bgcolor="#'.$bgid.'" alink="#FFFFFF">'."\n";
		
		switch($wid){
			case("420"):
				echo ' <div style="position:absolute; left:30px; width:21px;">'."\n";
				echo '<iframe id="ad1" src="" allowtransparency="true" width="190" height="21"
				framespacing="0" frameborder="no" scrolling="no">'."\n".'</iframe>'."\n";
				echo ' </div>'."\n";
				echo '<div style="position:absolute; left:230px; width:21px;">'."\n";
				echo '<iframe id="ad2" src="" allowtransparency="true" width="190" height="21"
				framespacing="0" frameborder="no" scrolling="no">'."\n".'</iframe>'."\n";
				echo ' </div>'."\n";
				switch($mode){
					case("yt"):
						include './view/ytPlayerTag.php';
						break;	
					case("dm"):
						include './view/dmPlayerTag.php';
						break;
					default:
						include './view/ytPlayerTag.php';
						break;	
				}
				echo '<div id="clickforce_ad" style="position: absolute; top:70px; left:80px; height:265px; width:300px; display=block;">'."\n";
				break;
			case("480"):
				echo ' <div style="position:absolute; left:50px; width:21px;">'."\n";
				echo '<iframe id="ad1" src="" allowtransparency="true" width="190" height="21"
				framespacing="0" frameborder="no" scrolling="no">'."\n".'</iframe>'."\n";
				echo ' </div>'."\n";
				echo '<div style="position:absolute; left:280px; width:21px;">'."\n";
				echo '<iframe id="ad2" src="" allowtransparency="true" width="190" height="21"
				framespacing="0" frameborder="no" scrolling="no">'."\n".'</iframe>'."\n";
				echo ' </div>'."\n";
				switch($mode){
					case("yt"):
						include './view/ytPlayerTag.php';
						break;	
					case("dm"):
						include './view/dmPlayerTag.php';
						break;
					default:
						include './view/ytPlayerTag.php';
						break;	
				}
				echo '<div id="clickforce_ad" style="position: absolute; top:70px; left:100px; height:265px; width:300px; display=block;">'."\n";
				break;
			case("560"):
				echo ' <div style="position:absolute; left:70px; width:21px;">'."\n";
				echo '<iframe id="ad1" src="" allowtransparency="true" width="190" height="21"
				framespacing="0" frameborder="no" scrolling="no">'."\n".'</iframe>'."\n";
				echo ' </div>'."\n";
				echo '<div style="position:absolute; left:300px; width:21px;">'."\n";
				echo '<iframe id="ad2" src="" allowtransparency="true" width="190" height="21"
				framespacing="0" frameborder="no" scrolling="no">'."\n".'</iframe>'."\n";
				echo ' </div>'."\n";
				switch($mode){
					case("yt"):
						include './view/ytPlayerTag.php';
						break;	
					case("dm"):
						include './view/dmPlayerTag.php';
						break;
					default:
						include './view/ytPlayerTag.php';
						break;	
				}
				echo '<div id="clickforce_ad" style="position: absolute; top:70px; left:140px; height:265px; width:300px; display=block;">'."\n";
				break;
			case("640"):
				echo ' <div style="position:absolute; left:110px; width:21px;">'."\n";
				echo '<iframe id="ad1" src="" allowtransparency="true" width="190" height="21"
				framespacing="0" frameborder="no" scrolling="no">'."\n".'</iframe>'."\n";
				echo ' </div>'."\n";
				echo '<div style="position:absolute; left:340px; width:21px;">'."\n";
				echo '<iframe id="ad2" src="" allowtransparency="true" width="190" height="21"
				framespacing="0" frameborder="no" scrolling="no">'."\n".'</iframe>'."\n";
				echo ' </div>'."\n";
				switch($mode){
					case("yt"):
						include './view/ytPlayerTag.php';
						break;	
					case("dm"):
						include './view/dmPlayerTag.php';
						break;
					default:
						include './view/ytPlayerTag.php';
						break;	
				}
				echo '<div id="clickforce_ad" style="position: absolute; top:70px; left:180px; height:265px; width:300px; display=block;">'."\n";
				break;
			case("727"):
				echo ' <div style="position:absolute; left:130px; width:21px;">'."\n";
				echo '<iframe id="ad1" src="" allowtransparency="true" width="190" height="21"
				framespacing="0" frameborder="no" scrolling="no">'."\n".'</iframe>'."\n";
				echo ' </div>'."\n";
				echo '<div style="position:absolute; left:410px; width:21px;">'."\n";
				echo '<iframe id="ad2" src="" allowtransparency="true" width="190" height="21"
				framespacing="0" frameborder="no" scrolling="no">'."\n".'</iframe>'."\n";
				echo ' </div>'."\n";
				switch($mode){
					case("yt"):
						include './view/ytPlayerTag.php';
						break;	
					case("dm"):
						include './view/dmPlayerTag.php';
						break;
					default:
						include './view/ytPlayerTag.php';
						break;	
				}
				echo '<div id="clickforce_ad" style="position: absolute; top:110px; left:220px; height:265px; width:300px; display=block;">'."\n";
				break;	
			default:
				echo ' <div style="position:absolute; left:110px; width:21px;">'."\n";
				echo '<iframe id="ad1" src="" allowtransparency="true" width="190" height="21"
				framespacing="0" frameborder="no" scrolling="no">'."\n".'</iframe>'."\n";
				echo ' </div>'."\n";
				echo '<div style="position:absolute; left:380px; width:21px;">'."\n";
				echo '<iframe id="ad2" src="" allowtransparency="true" width="190" height="21"
				framespacing="0" frameborder="no" scrolling="no">'."\n".'</iframe>'."\n";
				echo ' </div>'."\n";
				switch($mode){
					case("yt"):
						include './view/ytPlayerTag.php';
						break;	
					case("dm"):
						include './view/dmPlayerTag.php';
						break;
					default:
						include './view/ytPlayerTag.php';
						break;	
				}
				echo '<div id="clickforce_ad" style="position: absolute; top:70px; left:180px; height:265px; width:300px; display=block;">'."\n";
				break;
		}
		echo '<div id="logo" style="position: absolute; text-align:right; opacity:0.8;background-color: white; color:white; height:15px; color: white; left:285px; width:15px; display=block;z-index:2"><a href="javascript:onclick=closeAD();"><img src="close.png"></a></div>'."\n";
		echo '<div id="ifrme_ad" style="position: absolute; top:0px; left:0px; height:250px; width:300px; display=block; z-index:1">'."\n";
		echo '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		      <!-- ck-video DM -->
			  <ins class="adsbygoogle"
			  style="display:inline-block;width:300px;height:250px"
			  data-ad-client="ca-pub-1495498038472167"
			  data-ad-slot="9820328338"></ins>
			  <script>
			  (adsbygoogle = window.adsbygoogle || []).push({});
			  </script>'."\n";
		echo ' </div>'."\n";
	?>
<script type="text/javascript">
var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F3c4fdf41004fd0d6e4a62e37c28a4fd1' type='text/javascript'%3E%3C/script%3E"));
</script>
	
  </body>
</html>
