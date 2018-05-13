<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardEditHeader($headParams);
	
	// Start body content
	
	$annuities = $zh->getAnnuitiesList();
	array_push($annuities, ['id' => 0, 'name' => 'Select annuity...']);
	
	$cardItem = $zh->getCompany($item_id);

	$rootPath = ROOT_PATH;
	
	$cardTmp = array(
		'Company name'				=>	array( 'type'=>'input', 		'field'=>'name', 'params'=>array( 'size'=>100, 'hold'=>'Name', 'onchange'=>"change_alias();" ) ),
		'Alias'				=>	array( 'type'=>'input', 		'field'=>'alias', 		'params'=>array( 'size'=>100, 'hold'=>'Alias' ) ),
		'clear-0'				=>	array( 'type'=>'clear' ),
		'Publish'			=>	array( 'type'=>'block', 	'field'=>'block', 			'params'=>array( 'reverse'=>true ) ),
		'Percent'			=>	array( 'type'=>'number', 		'field'=>'percent', 		'params'=>array( 'size'=>100, 'hold'=>'Percent' ) ),
		'Dropdown near growth rate'		=>	array( 'type'=>'block', 	'field'=>'td_field_27_plus', 			'params'=>array( ) ),
		'Dropdown near percent'		=>	array( 'type'=>'block', 	'field'=>'percent_plus', 			'params'=>array( ) ),
		'Dropdown near withdrawal rate'		=>	array( 'type'=>'block', 	'field'=>'td_field_29_plus', 			'params'=>array( ) ),

		'clear-1'				=>	array( 'type'=>'clear' ),		
		
		'Link'			=>	array( 'type'=>'input', 		'field'=>'td_field_31', 		'params'=>array( 'size'=>100, 'hold'=>'Link' ) ),
		'Dropdown button name'				=>	array( 'type'=>'input', 		'field'=>'td_field_16', 		'params'=>array( 'size'=>100, 'hold'=>'Dropdown button name' ) ),

		'clear-2'				=>	array( 'type'=>'clear' ),		
		'Logo'		=>	array( 'type'=>'image_mono','field'=>'logo', 		'params'=>array( 'path'=>RSF."/split/files/companies/", 'appTable'=>$appTable, 'id'=>$item_id ) ),

		'Text fields'				=>	array( 'type'=>'header' ),

		'Tech doc field 15 (row 1)'				=>	array( 'type'=>'input', 		'field'=>'td_field_15_r1', 		'params'=>array( 'size'=>100, 'hold'=>'Tech doc field 15 (row 1)' ) ),
		'Tech doc field 15 (row 2)'				=>	array( 'type'=>'input', 		'field'=>'td_field_15_r2', 		'params'=>array( 'size'=>100, 'hold'=>'Tech doc field 15 (row 2)' ) ),
		'Tech doc field 15 (row 3)'				=>	array( 'type'=>'input', 		'field'=>'td_field_15_r3', 		'params'=>array( 'size'=>100, 'hold'=>'Tech doc field 15 (row 3)' ) ),
		'Tech doc field 15 (row 4)'				=>	array( 'type'=>'input', 		'field'=>'td_field_15_r4', 		'params'=>array( 'size'=>100, 'hold'=>'Tech doc field 15 (row 4)' ) ),

		'clear-3'				=>	array( 'type'=>'clear' ),		
		'Tech doc field 14'				=>	array( 'type'=>'input', 		'field'=>'td_field_14', 		'params'=>array( 'size'=>40, 'hold'=>'Tech doc field 14' ) ),
		'Tech doc field 11'				=>	array( 'type'=>'input', 		'field'=>'td_field_11', 		'params'=>array( 'size'=>40, 'hold'=>'Tech doc field 11' ) ),
		'Tech doc field 30'				=>	array( 'type'=>'input', 		'field'=>'td_field_30', 		'params'=>array( 'size'=>40, 'hold'=>'Tech doc field 14' ) ),

		'clear-4'				=>	array( 'type'=>'clear' ),	
		'Tech doc field 10 (row 1)'				=>	array( 'type'=>'input', 		'field'=>'td_field_10_r1', 		'params'=>array( 'size'=>40, 'hold'=>'Tech doc field 10 (row 1)' ) ),
		'Tech doc field 10 (row 2)'				=>	array( 'type'=>'input', 		'field'=>'td_field_10_r2', 		'params'=>array( 'size'=>40, 'hold'=>'Tech doc field 10 (row 2)' ) ),
		'Tech doc field 10 (row 3)'				=>	array( 'type'=>'input', 		'field'=>'td_field_10_r3', 		'params'=>array( 'size'=>40, 'hold'=>'Tech doc field 10 (row 3)' ) ),
		'Tech doc field 10 (row 4)'				=>	array( 'type'=>'input', 		'field'=>'td_field_10_r4', 		'params'=>array( 'size'=>40, 'hold'=>'Tech doc field 10 (row 4)' ) ),

		'clear-5'				=>	array( 'type'=>'clear' ),	
		'Tech doc field 9 (row 1)'				=>	array( 'type'=>'input', 		'field'=>'td_field_9_r1', 		'params'=>array( 'size'=>40, 'hold'=>'Tech doc field 9 (row 1)' ) ),
		'Tech doc field 9 (row 2)'				=>	array( 'type'=>'input', 		'field'=>'td_field_9_r2', 		'params'=>array( 'size'=>40, 'hold'=>'Tech doc field 9 (row 2)' ) ),

		'clear-6'				=>	array( 'type'=>'clear' ),	
		'Tech doc field 8 (row 1)'				=>	array( 'type'=>'input', 		'field'=>'td_field_8_r1', 		'params'=>array( 'size'=>40, 'hold'=>'Tech doc field 8 (row 1)' ) ),
		'Tech doc field 8 (row 2)'				=>	array( 'type'=>'input', 		'field'=>'td_field_8_r2', 		'params'=>array( 'size'=>40, 'hold'=>'Tech doc field 8 (row 2)' ) ),
		'Tech doc field 8 (row 3)'				=>	array( 'type'=>'input', 		'field'=>'td_field_8_r3', 		'params'=>array( 'size'=>40, 'hold'=>'Tech doc field 8 (row 3)' ) ),
		'Tech doc field 8 (row 4)'				=>	array( 'type'=>'input', 		'field'=>'td_field_8_r4', 		'params'=>array( 'size'=>40, 'hold'=>'Tech doc field 8 (row 4)' ) ),

		'clear-7'				=>	array( 'type'=>'clear' ),	
		'Tech doc field 7 (row 1)'				=>	array( 'type'=>'input', 		'field'=>'td_field_7_r1', 		'params'=>array( 'size'=>40, 'hold'=>'Tech doc field 7 (row 1)' ) ),
		'Tech doc field 7 (row 2)'				=>	array( 'type'=>'input', 		'field'=>'td_field_7_r2', 		'params'=>array( 'size'=>40, 'hold'=>'Tech doc field 7 (row 2)' ) ),
		'Tech doc field 7 (row 3)'				=>	array( 'type'=>'input', 		'field'=>'td_field_7_r3', 		'params'=>array( 'size'=>40, 'hold'=>'Tech doc field 7 (row 3)' ) ),
		'Tech doc field 7 (row 4)'				=>	array( 'type'=>'input', 		'field'=>'td_field_7_r4', 		'params'=>array( 'size'=>40, 'hold'=>'Tech doc field 7 (row 4)' ) ),

		'Upload rates'				=>	array( 'type'=>'header' ),
		
		'Rules'		=>	array( 'type'=>'text', 	'field'=>'rules', 			'params'=>array( 'value' => '
<pre>
Excel file format:

All values must be > 0

Column 1 -> Age [Only integer]

Column 2 -> Growth rate [Only integer or decimal]
Column 3 -> Growth rate (SPECIAL) [Only integer or decimal]

Column 4 -> Withdrawal rate [Only integer or decimal]
Column 5 -> Withdrawal rate (SPECIAL) [Only integer or decimal]

W A R N I N G: Upload will ERASE all previous rates by selected annuity and current company!
</pre>
		' ) ),

		
		'Select annuity from list below'	=>	array( 'type'=>'select', 	'field'=>'annuity_id', 			'params'=>array( 'list'=>$annuities, 
			'fieldValue'=>'id', 
			'fieldTitle'=>'name', 
			'currValue'=>0, 
			'onChange'=>"" 
		)),

		'Excel'		=>	array( 'type'=>'image_mono','field'=>'upload_rate', 		'params'=>array( 'path'=>RSF."/split/files/rates/", 'appTable'=>$appTable, 'id'=>$item_id ) ),
		
	);

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"editCompany", 'ajaxFolder'=>'edit', 'appTable'=>$appTable );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Item edit form #$item_id</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>