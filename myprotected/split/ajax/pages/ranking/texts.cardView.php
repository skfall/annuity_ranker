<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable);
	
	$data['headContent'] = $zh->getCardViewHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getText($item_id);

	$rootPath = ROOT_PATH;

	$cardTmp = array(
		'ID'						=>	array( 'type'=>'text', 		'field'=>'id', 				'params'=>array() ),
		'Name'					=>	array( 'type'=>'text', 		'field'=>'name', 		'params'=>array() ),
		'Text'					=>	array( 'type'=>'text', 		'field'=>'value', 			'params'=>array() ),
		'Link'					=>	array( 'type'=>'text', 		'field'=>'link', 			'params'=>array() ),		
		'Modified'		=>	array( 'type'=>'date', 		'field'=>'modified', 		'params'=>array() ),
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