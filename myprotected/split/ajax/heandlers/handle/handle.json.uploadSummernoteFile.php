<?php 
error_reporting(0);
$uploaded_files = array_values($_FILES);
$response = array('status' => 'failed', 'message' => '', 'files' => array());
if ($uploaded_files) {
	$file_path = "../../../../../split/files/summernote/";
	foreach ($uploaded_files as $key => $file) {
		$real_name = $file['name'];
		$exploded = explode(".", $real_name);
		$ext = count($exploded) > 1 ? $exploded[1] : "";
		$size = $file['size'];
		if ($ext && ($ext == 'png' || $ext == 'PNG' || $ext == 'jpeg' ||  $ext == 'JPEG' || $ext == 'jpg' || $ext == 'JPG')) {
			$filename = md5(time()).'.'.$ext;
			if ($size <= 1024000) {
				move_uploaded_file($file['tmp_name'], $file_path.$filename);
				chmod($file_path.$filename, 0777);
				$response['message'] = 'File was successfully uploaded.';
				$response['status'] = 'success';
				array_push($response['files'], $filename);
			}else{
				$response['message'] = 'Max file size is 1MB.';
			}
		}else{
			$response['message'] = 'Allowed file extensions: .png, .jpg, .jpeg .';
		}	
	}
}else{
	$response['message'] = 'No uploaded files.';
}

echo json_encode($response); exit();