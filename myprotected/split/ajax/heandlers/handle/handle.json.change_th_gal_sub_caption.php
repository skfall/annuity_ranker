<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************

	
	$id	= (int)$_POST['id'];
	
	$val	= strip_tags(str_replace("'","",$_POST['val']));
	
	
	$query = "UPDATE `osc_th_gal` SET `sub_caption`='$val' WHERE `id`=$id LIMIT 1";
	
	$ah->rs($query);
	
	$data['status'] = "success";
	
	$data['message'] = "Подзаголовок успешно сохранен.";