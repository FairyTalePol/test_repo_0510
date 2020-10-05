<?php
$content_url = "http://media.alfataxi.md/sys/core/files/0/content/playlists";
$device_id = ''; 

function Process(){
	global $request,$response,$device_id,$session;
	
	
	
	
	
	$http_body = file_get_contents_utf8(); 

	$obj = FromJson($http_body);

	$request = CastObject("Request",$obj);

	switch (strtolower ($request->command)) {
		case "add_adv":
			$item = CastObject("Advertisement",$request->params);
			myLog($item, "×òî ıòî çà ÷îğò?");
			$response->data = Add_Adv($item);
			$response->success = "0";
			break;
		case "get_adv":
			
			$response->data = Get_Adv($request->params);
			if ($response->data == [])
			{
				$response->success = "1";
				$response->message = "No data with such index";
			}
			else
				$response->success = "0";
		
			break;
		case "get_adv_list":
			$response->data = Get_Adv_List();
			$response->success=0;
			break;
		default:
			break;	
	}	
	
	
	die(ToJson($response));
}


function Add_Adv($sd){
	global $db;
	
	$d = $sd;
	if (strlen($d->name)>200)
		$d->name = substr($d->name,0,200);
	if (strlen($d->descr)>1000)
		$d->name = substr($d->name,0,1000);
	if (count(explode(",",$d->photos))>3)
		$d->photos=explode(",",$d->photos)[0].", ".explode(",",$d->photos)[1].", ".explode(",",$d->photos)[2];
	
	$sql = "INSERT INTO advertisements (name, descr, photos, price, creation) VALUES ('".$d->name."','".$d->descr."','".$d->photos."','".$d->price."','".time()."')";
	myLog($sql ,"Add_Descr: ");
	$result = $db->query($sql);
	if(!$result)
	{
		myLog("Database error" ,"Add_Descr: ");
		
	}
	
	$sd->id = $db->insert_id;
	myLog("Got id ".$sd->id  ,"Add_Descr: ");
	

	return $sd->id;
}

function Get_Adv($d){
	global $db;
	
	
	$sql = "SELECT * FROM advertisements WHERE id='".$d->id."'";
	myLog($sql ,"Get_Adv: ");
	$result = $db->query($sql);
	if(!$result)
	{
		myLog("Database error" ,"Get_Adv: ");
		
	}
	
	$res = Array();
	while ($row = $result->fetch_object()){
		$row = CastObject('Advertisement',$row);
		if ($d->all_photos ==0)
			$row->photos = explode(",", $row->photos)[0];
		if ($d->descr == 0)
			unset($row->descr);
		$res[] = $row;
	}
	$result->close();
	 
	return $res;
	

	
}

function Get_Adv_List(){
	global $db;
	
	
	$sql = "SELECT * FROM advertisements";
	myLog($sql ,"Get_Descr: ");
	$result = $db->query($sql);
	if(!$result)
	{
		myLog("Database error" ,"Get_Descr: ");
	}
	
	$res = Array();
	while ($row = $result->fetch_object()){
		$row = CastObject('Advertisement',$row);
		$row->photos = explode(",", $row->photos)[0];
		$res[] = $row;
	}
	$result->close();
	 
	return $res;
	

	return $sd->id;
}

