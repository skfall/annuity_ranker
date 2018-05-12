<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	switch ($_POST['table']) {
		case 'page_home':
			$appTable = 'osc_slides';
			break;
		default:
			break;
	}

	$table = $_POST['table'];

	$id = $_POST['id'];

	$path = $_POST['path'];
	
	$root_path = "../../../..";
	
	if($path=='/split/files/documents/') $appTable = 'docs_ref';
	if($table == 'projects' && $path=='../split/files/documents/') $appTable = 'osc_stage_docs';
	if($table == 'projects' && $path=='../split/files/projects/') $appTable = 'osc_stage_photos';

	
	$data = array();

	$query = "SELECT * FROM $appTable WHERE `id`='$id' LIMIT 1";

	$data = $ah->rs($query);
	$path = str_replace('..', '', $path);
	
	if($data){
		$data = $data[0];

		$filepath = $root_path.$path.$data['filename'];
		$croppath = glob($root_path.$path."crop/*".$data['filename']) ? glob($root_path.$path."crop/*".$data['filename'])[0] : "";
	
		if(file_exists($filepath)){
			unlink($filepath);
		}
		
		if(file_exists($croppath)){
			unlink($croppath);
		}
		
		$query = "DELETE FROM $appTable WHERE `id`='$id' LIMIT 1";
		
		$ah->rs($query);
		
		$data['message'] = "Success file delete";
	}else
	{
		$data['message'] = 'File not found';
	}
	