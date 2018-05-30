<?php 
	
	$appTable = $_POST['appTable'];
	$item_id = $_POST['item_id'];
	
	$cardUpd = array(
					'first_name'	=> $_POST['first_name'],
					'last_name'		=> $_POST['last_name'],
					'login'			=> $_POST['login'],
					//'phone'			=> $_POST['phone'],
					//'block'			=> $_POST['block'][0],
					//'active'		=> $_POST['active'][0],
					//'male'			=> $_POST['male'][0],
					//'birthday'		=> date("Y-m-d H:i:s", strtotime($_POST['birthday'])),
					
					'modified'	=> date("Y-m-d H:i:s", time())
					);

	if ($_POST['type']) {
		$cardUpd["type"] =  (int)$_POST['type'];
	}

	if ($_POST['block'][0]) {
		$cardUpd["block"] =  (int)$_POST['block'][0];
	}


	//echo "<pre>"; print_r(__DIR__); echo "</pre>"; exit();
	$filename = "avatar";
	$file_update = false;
	if(isset($_FILES[$filename]) && $_FILES[$filename]['size'] > 0) {

		$file_path = "../../../../split/files/users/";
		$file_update = $ah->mtvc_add_files_file(array(
				'path'			=>$file_path,
				'name'			=>5,
				'pre'			=>"zen_",
				'size'			=>10,
				'rule'			=>0,
				'max_w'			=>2500,
				'max_h'			=>2500,
				'files'			=>$filename,
				'resize_path'	=>"0", //$file_path."crop/",
				'resize_w'		=>0, //150,
				'resize_h'		=>0, //150,
				'resize_path_2'	=>"0", 
				'resize_w_2'	=>0,
				'resize_h_2'	=>0
			  ));
		if($file_update) {
			$cardUpd[$filename] = $file_update;
		}
	}
	
	// Update main table
	$query = "UPDATE [pre]$appTable SET ";
	
	$cntUpd = 0; 
	foreach($cardUpd as $field => $itemUpd){
		$cntUpd++;
		$query .= ($cntUpd==1 ? "`$field`='$itemUpd'" : ", `$field`='$itemUpd'");
	}
	
	$query .= " WHERE `id`=$item_id LIMIT 1";
	//echo "<pre>"; print_r($query); echo "</pre>"; exit();
		
	$data['block'] = $cardUpd['block'];
	$data['query'] = $query;
	$ah->rs($query);

	//echo "<pre>"; print_r(); echo "</pre>"; exit();

	$ef = array();
	
	$data['message'] = "Success user save. ";

	$q = "SELECT M.id FROM [pre]user_cards AS M WHERE M.user_id = $item_id";
	$user_card = $ah->rs($q);
	if ($user_card) {
		$q = "UPDATE [pre]user_cards SET phone = ".($_POST['phone'] ?: '""').", gender = ".($_POST['gender'][0] == '1' ? 1 : 0).", birthday = '".date("Y-m-d H:i:s", strtotime($_POST['birthday'])). "' LIMIT 1";
		//echo "<pre>"; print_r($q); echo "</pre>"; exit();
		$ah->rs($q);
	}
	
	// Change password
	
	if(isset($_POST['old-pass']))
	{
		$oldPass	= $_POST['old-pass'];
		$newPass	= $_POST['new-pass'];
		$newPassR	= $_POST['new-pass-r'];
		
		$query = "SELECT password FROM [pre]users WHERE `id`='$item_id' LIMIT 1";
		$userData = $ah->rs($query);
		
		if($userData)
		{
			$userPass = $userData[0]['pass'];
			
			if( (md5($oldPass)==$userPass || ADMIN_TYPE==1) && trim($newPass) != "")
			{
				if($newPass===$newPassR)
				{
					$query = "UPDATE [pre]users SET `password`='".md5($newPass)."' WHERE `id`='$item_id' LIMIT 1";
					$ah->rs($query);
					
					$letter = "<p>Здравствуйте, ".$cardUpd['name']." ".$cardUpd['fname']."!</p>";
					
					$letter .= "<p>Уведомляем Вас о том, что Ваш пароль для аккаунта <b>".$cardUpd['login']."</b> на сайте <u>http://".$_SERVER['HTTP_HOST']."</u> был изменен!</p>";
					
					$letter .= "<h4>Новые параметры для входа:</h4>";
					
					$letter .= "<table border='1'>
									<tr>
										<td style='padding:5px;'>Логин</td>
										<td style='padding:5px;'>".$cardUpd['login']."</td>
									</tr>
									<tr>
										<td style='padding:5px;'>Пароль</td>
										<td style='padding:5px;'>".$newPass."</td>
									</tr>
								</table>";
								
					$letter .= "<p>Если Вы не являетесь владельцем данного аккаунта - просто удалите это письмо.</p>";
					
					$ah->wp_send_letter($cardUpd['login'],"support@".$_SERVER['HTTP_HOST'],"Ваш пароль был изменен.",$letter);
					
					$data['message'] .= "Пароль успешно обновлен.";
				}else{
					$data['message'] .= "Пароли не совпадают!";
					}
			}else{
					if(trim($newPass) != "")
					{
						$data['message'] .= "Старый пароль введен неверно!";
					}
				}
		}
	}
	