<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardEditHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getQuestion($item_id);
	$annuities = $zh->getAnnuitiesList();
	array_unshift($annuities, ['id' => 0, 'name' => 'Select annuity...']);

	$rootPath = ROOT_PATH;
	
	$cardTmp = array(
		'Question'				=>	array( 'type'=>'area', 		'field'=>'question', 'params'=>array( 'size'=>100, 'hold'=>'Question') ),
		'Annuity'	=>	array( 'type'=>'select', 	'field'=>'annuity_id', 			'params'=>array( 'list'=>$annuities, 
			'fieldValue'=>'id', 
			'fieldTitle'=>'name', 
			'currValue'=>$cardItem['annuity_id'], 
			'onChange'=>"" 
		)),
		'clear-1'				=>	array( 'type'=>'clear' ),
		'Publish'			=>	array( 'type'=>'block', 	'field'=>'block', 			'params'=>array( 'reverse'=>true ) ),
		'Display order'				=>	array( 'type'=>'number', 		'field'=>'pos', 		'params'=>array( 'size'=>100, 'hold'=>'Display order' ) ),

		'clear-2'				=>	array( 'type'=>'clear' ),
		
	);

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"editQuestion", 'ajaxFolder'=>'edit', 'appTable'=>$appTable );
	
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