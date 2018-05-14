<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post

	

	$appTable = $_POST['appTable'];

	
	$item_id = (isset($_POST['item_id']) ? $_POST['item_id'] : 0);
	$now = date("Y-m-d H:i:s", time());

	$cardUpd = array(
		'name'			=> $_POST['name'],
		'alias'			=> $_POST['alias'],
		'block'			=> $_POST['block'][0],
		'percent'		=> (double)$_POST['percent'],

		'td_field_27_plus'			=> $_POST['td_field_27_plus'][0],
		'percent_plus'			=> $_POST['percent_plus'][0],
		'td_field_29_plus'			=> $_POST['td_field_29_plus'][0],

		'td_field_31'			=> $_POST['td_field_31'],
		'td_field_16'			=> $_POST['td_field_16'],

		'td_field_15_r1'			=> $_POST['td_field_15_r1'],
		'td_field_15_r2'			=> $_POST['td_field_15_r2'],
		'td_field_15_r3'			=> $_POST['td_field_15_r3'],
		'td_field_15_r4'			=> $_POST['td_field_15_r4'],
		'td_field_14'			=> $_POST['td_field_14'],
		'td_field_11'			=> $_POST['td_field_11'],
		'td_field_30'			=> $_POST['td_field_30'],
		'td_field_10_r1'			=> $_POST['td_field_10_r1'],
		'td_field_10_r2'			=> $_POST['td_field_10_r2'],
		'td_field_10_r3'			=> $_POST['td_field_10_r3'],
		'td_field_10_r4'			=> $_POST['td_field_10_r4'],
		'td_field_9_r1'			=> $_POST['td_field_9_r1'],
		'td_field_9_r2'			=> $_POST['td_field_9_r2'],
		'td_field_8_r1'			=> $_POST['td_field_8_r1'],
		'td_field_8_r2'			=> $_POST['td_field_8_r2'],
		'td_field_8_r3'			=> $_POST['td_field_8_r3'],
		'td_field_8_r4'			=> $_POST['td_field_8_r4'],
		'td_field_7_r1'			=> $_POST['td_field_7_r1'],
		'td_field_7_r2'			=> $_POST['td_field_7_r2'],
		'td_field_7_r3'			=> $_POST['td_field_7_r3'],
		'td_field_7_r4'			=> $_POST['td_field_7_r4'],

		'modified'	=> $now,
		'created' 	=> $now
	);

	$file_path = "../../../../split/files/companies/";
	$im_1_filename = "logo";
	$im_1 		= false;
	$im_1_name 	= 5;
	$im_1_pre 	= "logo_";
	
	if(isset($_FILES[$im_1_filename]) && $_FILES[$im_1_filename]['size'] > 0){
		$im_1 		= true;
	}
	if($im_1){
		$file_update = false;
		$file_update = $ah->mtvc_add_files_file(array(
				'path'			=>$file_path,
				'name'			=>$im_1_name,
				'pre'			=>$im_1_pre,
				'size'			=>10,
				'rule'			=>0,
				'max_w'			=>2500,
				'max_h'			=>2500,
				'files'			=>$im_1_filename,
				'resize_path'	=>$file_path."crop/",
				'resize_w'		=>300,
				'resize_h'		=>300,
				'resize_path_2'	=>"0",
				'resize_w_2'	=>0,
				'resize_h_2'	=>0
			  ));
		
		if($file_update){
			$cardUpd[$im_1_filename] = $file_update;
		}
	}

	$file_path = "../../../../split/files/rates/";
	$im_1_filename = "upload_rate";
	$im_1 		= false;
	$im_1_name 	= 5;
	$im_1_pre 	= "rates";
	
	if(isset($_FILES[$im_1_filename]) && $_FILES[$im_1_filename]['size'] > 0){
		$im_1 = true;
	}

	$rate_excel = false;
	if($im_1){
		$rate_excel = $ah->mtvc_add_files_file(array(
			'path'			=>$file_path,
			'name'			=>$im_1_name,
			'pre'			=>$im_1_pre,
			'size'			=>10,
			'rule'			=>0,
			'max_w'			=>2500,
			'max_h'			=>2500,
			'files'			=>$im_1_filename
			));

		if(file_exists($file_path.$rate_excel)){
			chmod($file_path.$rate_excel, 0777);

		}

	}

	$alias = $_POST['alias'];
	$q = "SELECT M.id FROM `osc_companies` AS M WHERE M.alias = '$alias' LIMIT 1";
	$check_alias = $ah->rs($q);

	if(!$check_alias){
		$name_len = mb_strlen($_POST['name']);
		if ($name_len > 0) {
			$query = "INSERT INTO `osc_companies` ";
			$fieldsStr = " ( ";
			$valuesStr = " ( ";
			$cntUpd = 0;
			foreach($cardUpd as $field => $itemUpd) {
				$cntUpd++;
				$fieldsStr .= ($cntUpd==1 ? "`$field`" : ", `$field`");
				$valuesStr .= ($cntUpd==1 ? "'$itemUpd'" : ", '$itemUpd'");
			}
			$fieldsStr .= " ) ";
			$valuesStr .= " ) ";
			$query .= $fieldsStr." VALUES ".$valuesStr;
			$item_id = $ah->rs($query, 0, 1, 1);
			
			if($item_id){
				$data['message'] = "Company was successfully saved. ID: ".$item_id;
				$data['item_id'] = $item_id;
				$data['status'] = "success";

				// RATES
				$annuity_id = (int)$_POST['annuity_id'];
				
				if ($rate_excel && $annuity_id > 0) {
					$q = "SELECT id FROM `osc_annuities` WHERE id = $annuity_id";
					$annuity = $ah->rs($q);
					

					if(file_exists($file_path.$rate_excel) && $annuity){
						require_once "../../library/excel_reader/PHPExcel.php";
			
						$real_path = realpath($file_path.$rate_excel);
			
						$objPHPExcel = PHPExcel_IOFactory::load($real_path);
						$excel_data = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
			
						if(count($excel_data) > 0){

							$new_rates_q = "";
							$cnt = 0;
							$now = date("Y-m-d H:i:s", time());
							$excel_data = array_values($excel_data);
							foreach ($excel_data as $row) {
								$row = array_values($row);

								if(array_key_exists(0, $row) && $row[0])
									$age = $row[0];
								else continue;
			
								if(array_key_exists(1, $row) && $row[1])
									$gr = $row[1];
								else continue;
			
								if(array_key_exists(2, $row) && $row[2])
									$grs = $row[2];
								else continue;
			
								if(array_key_exists(3, $row) && $row[3])
									$wr = $row[3];
								else continue;
			
								if(array_key_exists(4, $row) && $row[4])
									$wrs = $row[4];
								else continue;

								$age = (int)$age;
								$gr = (double)$gr;
								$grs = (double)$grs;
								$wr = (double)$wr;
								$wrs = (double)$wrs;
			
								if($age > 0 && $gr > 0 && $grs > 0 && $wr > 0 && $wrs > 0){
									if($cnt == 0){
										$q = "DELETE FROM `osc_rates` WHERE `company_id` = $item_id AND `annuity_id` = $annuity_id";
										$deleted = $ah->rs($q);

										$new_rates_q .= " ($annuity_id, $item_id, $age, $gr, $grs, $wr, $wrs, '$now', '$now') ";
									}else{
										$new_rates_q .= ", ($annuity_id, $item_id, $age, $gr, $grs, $wr, $wrs, '$now', '$now') ";
									}
									$cnt++;
								}
							}

							if ($new_rates_q) {
								$q = "INSERT INTO `osc_rates` (`annuity_id`, `company_id`, `age`, `rate1`, `special_rate1`, `rate2`, `special_rate2`, `created`, `modified`) VALUES ".$new_rates_q;
								$res = $ah->rs($q, 0, 1, 1);
							}
						}
					}
				}	
				// RATES END		
			}
		}else{
			$data['message'] = "Failed to save. Name is too short.";	
		}
	}else{
		$data['message'] = "Failed to save. Company with this alias is already exists.";
	}

	
	