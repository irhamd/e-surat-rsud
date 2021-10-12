<?php 
$ch=curl_init("https://fcm.googleapis.com/fcm/send");
$header=array("Content-Type:application/json","Authorization: key=AAAAT5eDlNo:APA91bE4lkOBzNvAsvEU8IGMDUn1RgjJkEkhTYA9h05nObBeFa2yamqsDv0I05J68tUxHPMeyHCDSVfR82yfP5pOvltfDXIEuC4QenC7OBF0VHVkfxABWuwGL2yqxrJTrdV9R0iOQYBx");
//to topic means am using all device
//$data=json_encode(array("to"=>"/topics/allDevices","notification"=>array("title"=>$_REQUEST['title'],"message"=>$_REQUEST['message'])));
//$data=json_encode(array("to"=>"fVHH4Dz_vKo:APA91bFFaxnUbX1U5IaDjJR4Hy3ewEX8QSjsCXHDTVLXPGToK0HU0dnItAUqHsPDkLTn6jGoiq5LK4mqiCyWtvrM_xPn2GwgTHbuc5rInJ0f2Us2iUmqIIwSBH_Fg1czVDPBbhJsgrnc","notification"=>array("title"=>$_REQUEST['title'],"message"=>$_REQUEST['message'])));


//now let's see data message
$data=json_encode(array("to"=>$_REQUEST['to'],"data"=>array("title"=>$_REQUEST['title'],"message"=>$_REQUEST['message'])));
curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($ch,CURLOPT_POST,1);
curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
curl_exec($ch);
