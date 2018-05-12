<?php 
	//********************
	//** WEB INSPECTOR
	//********************
	
	require_once "../../../require.base.php";
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Answer DELETE ITEMS</title>
</head>

<?php
	$items = $_POST['items'];
	$table = $_POST['table'];

?>

<body>
<?php 
	
	if ($table == 'site_languages') {
		if(sizeof($items) == 0){ echo "Ни одна запись для удаления не найдена."; }

		foreach($items as $item_id){
			$query = "
				SELECT M.*, L.name, L.alias, L.id as common_lang_id
				FROM `osc_site_languages` AS M
				LEFT JOIN `osc_languages` AS L ON L.id = M.lang_id
				WHERE M.id = ".$item_id."
				LIMIT 1
			";

			

			$data_stmt = $dbh->prepare($query);
			$data_arr = $data_stmt->execute();
			$data = $data_arr->fetchallAssoc();
				
			$info = $data[0];

			$pref = $info['alias']."_";
			$common_lang_id = $info['common_lang_id'];
			
			$is_continue = false;

			// DELETE FROM SITE LANGUAGES
			$delete_query = "DELETE FROM [pre]".$table." WHERE `id`='".$item_id."' LIMIT 1";
			$delete_stmt = $dbh->prepare($delete_query);
			$delete_arr = $delete_stmt->execute();

			// DELETE LANG FROM ARTICLES
			$delete_query = "
				ALTER TABLE `osc_articles` 
				DROP `".$pref."name`, 
				DROP `".$pref."content`
			";
			$delete_stmt = $dbh->prepare($delete_query);
			$delete_arr = $delete_stmt->execute();

			// DELETE LANG FROM MENU
			$delete_query = "
				ALTER TABLE `osc_menu` 
				DROP `".$pref."name`, 
				DROP `".$pref."details`, 
				DROP `".$pref."meta_title`, 
				DROP `".$pref."meta_desc`, 
				DROP `".$pref."meta_keys`
			";
			$delete_stmt = $dbh->prepare($delete_query);
			$delete_arr = $delete_stmt->execute();

			// DELETE LANG FROM BANNERS
			$delete_query = "
				ALTER TABLE `osc_banners` 
				DROP `".$pref."alt`, 
				DROP `".$pref."title`
			";
			$delete_stmt = $dbh->prepare($delete_query);
			$delete_arr = $delete_stmt->execute();

			// DELETE LANG FROM CONTACT CATS
			$delete_query = "ALTER TABLE `osc_contact_categories` DROP `".$pref."name`";
			$delete_stmt = $dbh->prepare($delete_query);
			$delete_arr = $delete_stmt->execute();

			// DELETE LANG FROM ALT-TITLE-META TABLE
			$delete_query = "ALTER TABLE `osc_article_images_alts` DROP `".$pref."data`";
			$delete_stmt = $dbh->prepare($delete_query);
			$delete_arr = $delete_stmt->execute();

			// DELETE LANG FROM PRIVACY TABLE
			$delete_query = "
				ALTER TABLE `osc_privacy` 
				DROP `".$pref."q`,
				DROP `".$pref."a`
			";
			$delete_stmt = $dbh->prepare($delete_query);
			$delete_arr = $delete_stmt->execute();

			// DELETE LANG FROM STATIC TRANSLATIONS TABLE
			$delete_query = "
				ALTER TABLE `osc_static_translations` 
				DROP `".$pref."text`
			";
			$delete_stmt = $dbh->prepare($delete_query);
			$delete_arr = $delete_stmt->execute();


			// DELETE LANG FROM TOTAL CONFIG
			$delete_query = "
				ALTER TABLE `osc_total_config` 
				DROP `".$pref."meta_title`,
				DROP `".$pref."meta_desc`,
				DROP `".$pref."meta_keys`,
				DROP `".$pref."copyright`,
				DROP `".$pref."alt`,
				DROP `".$pref."title`
			";
			$delete_stmt = $dbh->prepare($delete_query);
			$delete_arr = $delete_stmt->execute();

			// SET NOT-USED LANGUAGE STATUS
			$delete_query = "UPDATE `osc_languages` SET `used` = 0 WHERE `id`='".$common_lang_id."' LIMIT 1";
			$delete_stmt = $dbh->prepare($delete_query);
			$delete_arr = $delete_stmt->execute();
					
			$item_name = "[".$info['id']."]";
			
			if(isset($info['name'])) $item_name .= " ".$info['name'];
			
			?>
			<p>Запись <b><?php echo $item_name ?></b> успешно удалена из системы.</p>
			<?php

		}

		


	}else{
		if(sizeof($items) == 0){ echo "Ни одна запись для удаления не найдена."; }
	
		foreach($items as $item_id)
		{
			// Get info by item
			
			$query = "SELECT * FROM [pre]".$table." WHERE `id`='".$item_id."' LIMIT 1";
			

			
			$db->q($query);


			$info = $db->q($query);
			
			$is_continue = false;

			switch($table)
			{	
				case 'users_types':
				{
					$mQuery = "SELECT id FROM [pre]users WHERE `type`=$item_id LIMIT 1";
					$m_data = $db->q($query);
					
					if($m_data)
					{
						$is_continue = true;
						?>
							<p>Группа <b><?php echo $info['name'] ?></b> не может быть удалена, поскольку она не пустая.</p>
						<?php
					}
					break;
				}

				case 'projects':
					$q = "SELECT * FROM `osc_stages` WHERE `project_id`= $item_id";
					$stages = $db->q($q);
					if($stages){
						foreach($stages as $stage){
							$s_id = (int)$stage['id'];
							$q = "DELETE FROM `osc_stages` WHERE `id` = '$s_id'";
							$db->q($q,0,1);
							$q = "DELETE FROM `osc_stage_docs` WHERE `stage_id` = '$s_id'";
							$db->q($q,0,1);
							$q = "DELETE FROM `osc_stage_photos` WHERE `stage_id` = '$s_id'";
							$db->q($q,0,1);
						}
					}
					break;

				case 'articles':
				{
					// GET ARTICLES FILES
					$q = "
						SELECT M.fl_name_preview, M.fl_name_banner, M.fl_name_top_img, M.fl_name_bot_img, M.fl_name_modal
						FROM [pre]$table AS M
						WHERE M.id = '".$item_id."'
						LIMIT 1
					";

					$item = $db->q($query);;

					$file_path = "../../../../split/files/images/";
					$prev_name = $item['fl_name_preview'];
					$ban_name = $item['fl_name_banner'];
					$top_name = $item['fl_name_top_img'];
					$bot_name = $item['fl_name_bot_img'];
					$modal_name = $item['fl_name_modal'];

					// DELETE ARTICLES FILES
					if ($prev_name) {
						unlink($file_path.$prev_name);
						unlink($file_path.'crop/466x363_'.$prev_name);
					}
					if ($ban_name) {
						unlink($file_path.$ban_name);
						unlink($file_path.'crop/466x363_'.$ban_name);
					}
					if ($top_name) {
						unlink($file_path.$top_name);
						unlink($file_path.'crop/466x363_'.$top_name);
					}
					if ($bot_name) {
						unlink($file_path.$bot_name);
						unlink($file_path.'crop/466x363_'.$bot_name);
					}
					if ($modal_name) {
						unlink($file_path.$modal_name);
					}

					// DELETE ARTICLE ALTS AND TITLES
					$mQuery = "DELETE FROM [pre]article_images_alts WHERE `art_id`='".$item_id."' LIMIT 1";


					$db->q($mQuery,0,1);

					break;
				}


				default:
				{
					break;
				}
			}
			
			if($is_continue) continue;
			
			if($table == "users_dialogs")
			{
				$delete_query = "DELETE FROM [pre]".$table." WHERE (`from_id`='".$info['from_id']."' AND `to_id`='".$info['to_id']."') OR 
								(`to_id`='".$info['from_id']."' AND `from_id`='".$info['to_id']."') LIMIT 10000";
			}else
			{

				if($table == 'users'){
					$qqv = "DELETE FROM `osc_user_cards` WHERE `user_id`='".$item_id."' LIMIT 1";
					$db->q($qqv,0,1);
				}


				$delete_query = "DELETE FROM [pre]".$table." WHERE `id`='".$item_id."' LIMIT 1";

			}

			
			$db->q($delete_query,0,1);

					
					
			$item_name = "[".$info[0]['id']."]";
			
			if(isset($info['name'])) $item_name .= " ".$info['name'];
			
			?>
			<p>Запись <b><?php echo $item_name ?></b> успешно удалена из системы.</p>
			<?php
		}
	}
?>
</body>

<script type="text/javascript" language="javascript">
</script>

</html>