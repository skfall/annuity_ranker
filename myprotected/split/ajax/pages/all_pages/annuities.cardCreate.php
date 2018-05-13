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
		
		//'Контент'				=>	array( 'type'=>'summernote', 		'field'=>'section_content', 		'params'=>array( 'size'=>100, 'hold'=>'Подзаголовок' ) ),
		'clear-2'				=>	array( 'type'=>'clear' ),
		'Preview image'		=>	array( 'type'=>'image_mono','field'=>'preview', 		'params'=>array( 'path'=>RSF."/split/files/annuities/", 'appTable'=>$appTable, 'id'=>$item_id ) ),
		'Background image'		=>	array( 'type'=>'image_mono','field'=>'background', 		'params'=>array( 'path'=>RSF."/split/files/annuities/", 'appTable'=>$appTable, 'id'=>$item_id ) ),
		'Is video background?'			=>	array( 'type'=>'block', 	'field'=>'is_video_bg', 'params'=>array( ) ),
	);

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"createAnnuity", 'ajaxFolder'=>'create', 'appTable'=>$appTable );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Форма создания слайда</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>