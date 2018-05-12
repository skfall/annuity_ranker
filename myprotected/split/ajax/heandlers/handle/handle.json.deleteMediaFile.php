<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	$appTable = $_POST['appTable'];
	
	$id = $_POST['id'];
	
	$field = $_POST['field'];
	
	$path = $_POST['path'];
	
	$filename = $_POST['filename'];
	
	$root_path = "../../../";
	
	$filepath = $root_path.$path.$filename;
	
	if(file_exists($filepath))
	{
		unlink($filepath);
	}
	
	$pre = $ah->dbh->prefix;
	
	$sql_pre = (str_replace($pre,"",$appTable)==$appTable ? "[pre]" : "");

	if($appTable == 'projects'){
		if($field == "s1_protocol" || $field == "s2_protocol" || $field == "s3_protocol") {$field = "protocol_link"; $appTable = 'stages';}
	}
	
	$query = "UPDATE ".$sql_pre.$appTable." set `$field`='' WHERE `id`='$id' LIMIT 1";

	$ah->rs($query);
	
	$data['message'] = "Success file delete";
	