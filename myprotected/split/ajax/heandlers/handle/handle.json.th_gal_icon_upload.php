<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$id	= (isset($_POST['id']) ? (int)$_POST['id'] : 0);
	$file = (isset($_POST['file']) ? $_POST['file'] : 0);
	$file_name = (isset($_POST['filename']) ? $_POST['filename'] : 0);


	if ($id > 0 && $file && $file_name) {
			$ext = explode(';', $file);
			$ext = explode('/', $ext[0]);

			$ext = $ext[1];
			


			if ($ext == 'png' || $ext == 'PNG') {
				$file = str_replace('data:image/png;base64,', '', $file);
				$file = str_replace(' ', '+', $file);

				$blob = base64_decode($file);
				$saved = file_put_contents('../../../../split/files/townhouses/'.$file_name, $blob);

				if ($saved) {
					$query = "UPDATE `osc_th_gal` SET `icon`='$file_name' WHERE `id`=$id LIMIT 1";
					$ah->rs($query);
					$data['status'] = "success";
					$data['message'] = "Иконка обновлена.";
				}
			}else{
				$data['status'] = "success";
				$data['message'] = "Ожидаемый формат - PNG.";
			}

		
		
	}


	
	
	
	