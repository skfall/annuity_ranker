<?php 
	require_once "../../../../require.base.php";
	require_once "../../../library/AjaxHelp.php";
	require_once "../../../library/excel_writer/writer.php";


	
	
	error_reporting(1);
	$ah = new ajaxHelp($dbh);
	$data = array('status' => 'failed', 'message' => '');
	
	$activities = $ah->getActivity();

	$writer = new XLSXWriter();
	$folder =  realpath("../../../../../split/files/user_activity/");
	$filename = "ua_".time().".xls";
	$full_path = $folder.'\\'.$filename;

    $worksheet = [];
    $writer->setTempDir(realpath("../../../../../split/files/user_activity/"));
    $writer->setTitle('Activities');
    $writer->setSubject('Activities');
    $writer->setAuthor('Activities');
    $writer->setCompany('Activities');

	$worksheet[] = $row = [
		"#",
		"IP",
		"CREATED",
		"ANNUITY",
		"AMMOUNT",
		"SPOUSAL RATES",
		"AGE",
		"SPOUSE AGE"
	   ];
	$writer->writeSheetRow('Activities', $row);
	foreach($activities as $idx => $value):
		$act_state = json_decode($value['activity_state'], true);
		$ip = $value['ip'];
		$created = $value['created'];
		$annuity = $act_state['annuity'];
		$amount = $act_state['amount'];
		$spouse_rates = $act_state['spouse_rates'];
		$age = $act_state['age'];
		$spouse_age = $act_state['spouse_age'];


     $worksheet[] = $row = [
      $idx + 1,
      $ip,
      $created,
      $annuity,
      $amount,
	  $spouse_rates,
	  $age,
	  $spouse_age
     ];
     $writer->writeSheetRow('Activities', $row);
    endforeach;
    $writer->writeToFile($full_path);

     


	



	$data['download_link'] = 'https://'.$_SERVER['SERVER_NAME'].'/'."split/files/user_activity/".$filename;
	$data['status'] = "success";
	echo json_encode($data);