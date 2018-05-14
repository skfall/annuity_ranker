<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardViewHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getTab($item_id);

	$rootPath = ROOT_PATH;
	
	$cardTmp = array(
		'ID'						=>	array( 'type'=>'text', 		'field'=>'id', 				'params'=>array() ),
		'Tab name'					=>	array( 'type'=>'text', 		'field'=>'name', 		'params'=>array() ),
		'Company name'					=>	array( 'type'=>'text', 		'field'=>'company_name', 			'params'=>array() ),
		'Content'					=>	array( 'type'=>'text', 		'field'=>'content', 			'params'=>array() ),
		'Published'			=>	array( 'type'=>'text', 		'field'=>'block', 			'params'=>array( 'replace'=>array('0'=>'Yes', '1'=>'No') ) ),
		'Display order'			=>	array( 'type'=>'text', 		'field'=>'pos'),
		'Created'		=>	array( 'type'=>'date', 		'field'=>'created', 		'params'=>array() ),
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