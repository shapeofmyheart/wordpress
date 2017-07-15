<!--This Program control the zone parameters, brwoser type activities-
	Doublemax Technology Kash Chen 11/5/2012
-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>DoubleMax Video AD Plug-in</title>
	<?php
			include 'zoneReader.php';
			$wid=$_GET['w']; //width of the player
			if($wid >'728'){$wid='728';}
			elseif( '640'<$wid&&$wid <'728'){$wid='640';}
			elseif( '560'<$wid&&$wid <'640'){$wid='560';}
			elseif( '480'<$wid&&$wid <'560'){$wid='480';}
			elseif( '420'<$wid&&$wid <'480'){$wid='420';}
			elseif( $wid <'420'){$wid='420';}
			$bgid=$_GET['bg'];//Backgroud color of the player
			$vid= $_GET['v']; //video ID
			$mtid= $_GET['mt'];//mobile type AD
			$mode=$_GET['mode'];//video player type: dm: dailyumotion. yt:youTube
			
			//If the HTPP request is from iPhone
			echo '<script type="text/javascript">'."\n";		
			echo 'if(navigator.userAgent.match(/iPhone/i))'."\n";
	  		echo '	document.location.href="ADplayer_iphone.php?z1='.$mtzid1.'&z2='.$osid.'&v='.$vid.'&bg='.$bgid.'&w='.$wid.'&mode='.$mode.'";'."\n";
			//If the HTPP request is from iPad/Android/Window mobile
			echo 'else if( navigator.userAgent.match(/htc/i)||navigator.userAgent.match(/Android/i)||navigator.userAgent.match(/iPad/i)|| navigator.userAgent.match(/IEMobile/i))'."\n";
	  		echo '	document.location.href="ADplayer_html5.php?z1='.$ztid.'&z2='.$mtzid1.'&z3='.$mtzid2.'&z4='.$osid.'&mt='.$mtid.'&w='.$wid.'&v='.$vid.'&bg='.$bgid.'&mode='.$mode.'";'."\n";
            //If the HTPP request is from PC
			echo 'else document.location.href="ADplayer_PC.php?z1='.$pcid.'&z2='.$pcid2.'&w='.$wid.'&v='.$vid.'&bg='.$bgid.'&mode='.$mode.'";'."\n";
			echo '</script>'."\n";
	 ?>	
<body>
test test

</body>		 
</html>
