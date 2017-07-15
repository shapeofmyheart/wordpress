<?php
echo 'videoID = "'.$vid.'";'."\n";
switch ($wid) 
{
	case "420":
		echo 'vWidth="420";'."\n";
		echo 'vHeight="315";'."\n";
		break;
	case "480":
		echo 'vWidth="480";'."\n";
		echo 'vHeight="360";'."\n";
		break;
	case "560":
		echo 'vWidth="560";'."\n";
		echo 'vHeight="315";'."\n";
		break;
	case "640":
		echo 'vWidth="640";'."\n";
		echo 'vHeight="360";'."\n";
		break;
	case "727":
		echo 'vWidth="727";'."\n";
		echo 'vHeight="440";'."\n";
		break;	
	default:
		echo 'vWidth="640";'."\n";
		echo 'vHeight="360";'."\n";
		break;
}
?>