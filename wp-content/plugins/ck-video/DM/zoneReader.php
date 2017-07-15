<?php
$fp = fopen ("parameter.csv","r"); 
while ($data = fgetcsv ($fp, 100, "."))
{
	$para=substr ($data[0],1,2);//returns para ID
	$IDZone=stristr($data[0],"=");
	$length=strlen($IDZone);		
	$ID = substr ($IDZone,1,$length); // returns  zone ID	
	switch($para)
	{
		Case "z1":
			$pcid= $ID;//The text zone for PC mode
			break;
		Case "z2":
			$pcid2= $ID;//The on-Screen zone for PC mode
			break;
		Case "m1":
			$ztid= $ID; //The mobile zone id for Android type
			break;
		Case "m2":
			$mtzid1= $ID;// The text Zone id for mobile type
			break;
		Case "m3":
			$mtzid2= $ID;// The image Zone id for mobile type
			break;
		Case "m4":
			$osid= $ID;//The on-Screen zone for mobile mode
			break;
		default:
			break;
	}
}
?>