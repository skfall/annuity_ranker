<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardViewHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getCompany($item_id);

	$company_rates = $zh->getCompanyRates($item_id);

	$rootPath = ROOT_PATH;
	
	$cardTmp = array(
		'ID'						=>	array( 'type'=>'text', 		'field'=>'id', 				'params'=>array() ),
		'Name'					=>	array( 'type'=>'text', 		'field'=>'name', 		'params'=>array() ),
		'Alias'					=>	array( 'type'=>'text', 		'field'=>'alias', 		'params'=>array() ),
		'Published'			=>	array( 'type'=>'text', 		'field'=>'block', 			'params'=>array( 'replace'=>array('0'=>'Yes', '1'=>'No') ) ),
		'Percent'					=>	array( 'type'=>'text', 		'field'=>'percent', 		'params'=>array() ),
		'Dropdown near growth rate'			=>	array( 'type'=>'text', 		'field'=>'td_field_27_plus', 			'params'=>array( 'replace'=>array('1'=>'Yes', '0'=>'No') ) ),
		'Dropdown near percent'			=>	array( 'type'=>'text', 		'field'=>'percent_plus', 			'params'=>array( 'replace'=>array('1'=>'Yes', '0'=>'No') ) ),
		'Dropdown near withdrawal rate'			=>	array( 'type'=>'text', 		'field'=>'td_field_29_plus', 			'params'=>array( 'replace'=>array('1'=>'Yes', '0'=>'No') ) ),
		'Logo'		=>	array( 'type'=>'image',		'field'=>'logo',			'params'=>array( 'path'=>RSF.'/split/files/companies/' ) ),
		'Text fields'					=>	array( 'type'=>'header'),
		'Tech doc field 15 (row 1)'					=>	array( 'type'=>'text', 		'field'=>'td_field_15_r1', 		'params'=>array() ),
		'Tech doc field 15 (row 2)'					=>	array( 'type'=>'text', 		'field'=>'td_field_15_r2', 		'params'=>array() ),
		'Tech doc field 15 (row 3)'					=>	array( 'type'=>'text', 		'field'=>'td_field_15_r3', 		'params'=>array() ),
		'Tech doc field 15 (row 4)'					=>	array( 'type'=>'text', 		'field'=>'td_field_15_r4', 		'params'=>array() ),
		'Tech doc field 14'					=>	array( 'type'=>'text', 		'field'=>'td_field_14', 		'params'=>array() ),
		'Tech doc field 11'					=>	array( 'type'=>'text', 		'field'=>'td_field_11', 		'params'=>array() ),
		'Tech doc field 30'					=>	array( 'type'=>'text', 		'field'=>'td_field_30', 		'params'=>array() ),
		'Tech doc field 10 (row 1)'					=>	array( 'type'=>'text', 		'field'=>'td_field_10_r1', 		'params'=>array() ),
		'Tech doc field 10 (row 2)'					=>	array( 'type'=>'text', 		'field'=>'td_field_10_r2', 		'params'=>array() ),
		'Tech doc field 10 (row 3)'					=>	array( 'type'=>'text', 		'field'=>'td_field_10_r3', 		'params'=>array() ),
		'Tech doc field 10 (row 4)'					=>	array( 'type'=>'text', 		'field'=>'td_field_10_r4', 		'params'=>array() ),
		'Tech doc field 9 (row 1)'					=>	array( 'type'=>'text', 		'field'=>'td_field_9_r1', 		'params'=>array() ),
		'Tech doc field 9 (row 2)'					=>	array( 'type'=>'text', 		'field'=>'td_field_9_r2', 		'params'=>array() ),
		'Tech doc field 8 (row 1)'					=>	array( 'type'=>'text', 		'field'=>'td_field_8_r1', 		'params'=>array() ),
		'Tech doc field 8 (row 2)'					=>	array( 'type'=>'text', 		'field'=>'td_field_8_r2', 		'params'=>array() ),
		'Tech doc field 8 (row 3)'					=>	array( 'type'=>'text', 		'field'=>'td_field_8_r3', 		'params'=>array() ),
		'Tech doc field 8 (row 4)'					=>	array( 'type'=>'text', 		'field'=>'td_field_8_r4', 		'params'=>array() ),
		'Tech doc field 7 (row 1)'					=>	array( 'type'=>'text', 		'field'=>'td_field_7_r1', 		'params'=>array() ),
		'Tech doc field 7 (row 2)'					=>	array( 'type'=>'text', 		'field'=>'td_field_7_r2', 		'params'=>array() ),
		'Tech doc field 7 (row 3)'					=>	array( 'type'=>'text', 		'field'=>'td_field_7_r3', 		'params'=>array() ),
		'Tech doc field 7 (row 4)'					=>	array( 'type'=>'text', 		'field'=>'td_field_7_r4', 		'params'=>array() ),
		
		'Company rates'					=>	array( 'type'=>'pre_text', 	'params'=>array('value' => $company_rates) ),
	);



	$cardViewTableParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath );
	
	$cardViewTableStr = $zh->getCardViewTable($cardViewTableParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3>Detailed item view #$item_id</h3>";
	
	$data['bodyContent'] .= $cardViewTableStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>