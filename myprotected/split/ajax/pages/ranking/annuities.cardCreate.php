<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardCreateHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getAnnuity($item_id);

	$rootPath = ROOT_PATH;
	
	$cardTmp = array(
		'Name'				=>	array( 'type'=>'input', 		'field'=>'name', 'params'=>array( 'size'=>100, 'hold'=>'Name', 'onchange'=>"change_alias();" ) ),
		'Alias'				=>	array( 'type'=>'input', 		'field'=>'alias', 		'params'=>array( 'size'=>100, 'hold'=>'Alias' ) ),
		'clear-1'				=>	array( 'type'=>'clear' ),
		'Publish'			=>	array( 'type'=>'block', 	'field'=>'block', 			'params'=>array( 'reverse'=>true ) ),
		'Display order'				=>	array( 'type'=>'number', 		'field'=>'pos', 		'params'=>array( 'size'=>100, 'hold'=>'Display order' ) ),

		'clear-2'				=>	array( 'type'=>'clear' ),		
		'Default value for age'	=>	array( 'type'=>'number', 		'field'=>'age', 		'params'=>array( 'size'=>3, 'hold'=>'Default value for age' ) ),
		'Default value for spouse age'	=>	array( 'type'=>'number', 		'field'=>'special_age', 		'params'=>array( 'size'=>3, 'hold'=>'Default value for spouse age' ) ),
		'Special rate default value'			=>	array( 'type'=>'block', 	'field'=>'special_active', 			'params'=>array() ),

		
		//'Контент'				=>	array( 'type'=>'summernote', 		'field'=>'section_content', 		'params'=>array( 'size'=>100, 'hold'=>'Подзаголовок' ) ),
		'clear-3'				=>	array( 'type'=>'clear' ),
		'Preview image'		=>	array( 'type'=>'image_mono','field'=>'preview', 		'params'=>array( 'path'=>RSF."/split/files/annuities/", 'appTable'=>$appTable, 'id'=>$item_id ) ),
		'Background image'		=>	array( 'type'=>'image_mono','field'=>'background', 		'params'=>array( 'path'=>RSF."/split/files/annuities/", 'appTable'=>$appTable, 'id'=>$item_id ) ),
		'Is video background?'			=>	array( 'type'=>'block', 	'field'=>'is_video_bg', 'params'=>array( ) ),

		'Table headers'				=>	array( 'type'=>'header' ),
		'Col 1'				=>	array( 'type'=>'input', 		'field'=>'col_1', 		'params'=>array( 'size'=>40, 'hold'=>'Col 1' ) ),
		'Col 2'				=>	array( 'type'=>'input', 		'field'=>'col_2', 		'params'=>array( 'size'=>40, 'hold'=>'Col 2' ) ),
		'Col 3'				=>	array( 'type'=>'input', 		'field'=>'col_3', 		'params'=>array( 'size'=>40, 'hold'=>'Col 3' ) ),
		'Col 4'				=>	array( 'type'=>'input', 		'field'=>'col_4', 		'params'=>array( 'size'=>40, 'hold'=>'Col 4' ) ),
		'Col 5'				=>	array( 'type'=>'input', 		'field'=>'col_5', 		'params'=>array( 'size'=>40, 'hold'=>'Col 5' ) ),
		'Col 6'				=>	array( 'type'=>'input', 		'field'=>'col_6', 		'params'=>array( 'size'=>40, 'hold'=>'Col 6' ) ),
		'Col 7'				=>	array( 'type'=>'input', 		'field'=>'col_7', 		'params'=>array( 'size'=>40, 'hold'=>'Col 7' ) ),
		
	);

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"createAnnuity", 'ajaxFolder'=>'create', 'appTable'=>$appTable );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Item create form</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>