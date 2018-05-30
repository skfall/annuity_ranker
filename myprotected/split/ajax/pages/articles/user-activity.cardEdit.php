<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardEditHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getText($item_id);

	$rootPath = ROOT_PATH;
	
	$cardTmp = array(
		'Name'				=>	array( 'type'=>'input', 		'field'=>'name', 'params'=>array( 'size'=>100, 'hold'=>'Name', 'readonly' => true) ),
		'clear-1'				=>	array( 'type'=>'clear' ),
		'Value'				=>	array( 'type'=>'input', 		'field'=>'value', 'params'=>array( 'size'=>100, 'hold'=>'Value') ),		
		'Link'				=>	array( 'type'=>'input', 		'field'=>'link', 'params'=>array( 'size'=>100, 'hold'=>'If filled - text will be a link') ),		
	);

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"editStaticText", 'ajaxFolder'=>'edit', 'appTable'=>$appTable );
	
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