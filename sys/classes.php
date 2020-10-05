<?php
function file_get_contents_utf8() {
     $content = file_get_contents("php://input");     
	 return $content;
}

function CastObject($className, $object)
{
    if (!class_exists($className))
        SendErrorMessage("No class name: ".$className);

    $new = new $className();
	if(!is_object($object))
		return $new;

    foreach($object as $property => $value)
    {
		if(isset($new->$property)){
			$new->$property = $value;
		}
    }
    return $new;
}

function ToJson($obj){
	$res = json_encode($obj,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
	if(json_last_error() != JSON_ERROR_NONE){
		SendErrorMessage("Json parse error: ".json_last_error());		
	}	
	return $res;
}
function FromJson($s){
	global $request,$response;
	if($s == "")
		return "";
	$obj = json_decode($s);	
	if(json_last_error() != JSON_ERROR_NONE){
		SendErrorMessage("Json parse error: ".json_last_error());		
	}
	return $obj;
}



function myLog($data, $m = ''){
    ob_start();
    var_dump($data);
    $d = ob_get_clean();

	file_put_contents ( "mylog.txt" , $m.' '.$d, FILE_APPEND );

}

class Request{ 
    public $id = '';
    public $command = ''; 
    public $params = ''; 

} 
class Response{ 
    public $id = '';
    public $success = '';
    public $data = '';  
    public $message = ''; 
} 

 	
class Advertisement{ 
    public $id = '';
    public $name = '';  
    public $descr = ''; 
    public $price = ''; 
    public $photos = '';
	public $creation = '';
} 
