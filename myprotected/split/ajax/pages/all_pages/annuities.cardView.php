<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardViewHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getAnnuity($item_id);

	$rootPath = ROOT_PATH;
	
	$cardTmp = array(
		'ID'						=>	array( 'type'=>'text', 		'field'=>'id', 				'params'=>array() ),
		'Name'					=>	array( 'type'=>'text', 		'field'=>'name', 		'params'=>array() ),
		'Alias'					=>	array( 'type'=>'text', 		'field'=>'Alias', 			'params'=>array() ),
		'Edit date'		=>	array( 'type'=>'date', 		'field'=>'modified', 		'params'=>array() ),
		'Изображение'		=>	array( 'type'=>'image',		'field'=>'filename',			'params'=>array( 'path'=>RSF.'/split/files/home_slides/' ) ),
	);



	$cardViewTableParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath );
	
	$cardViewTableStr = $zh->getCardViewTable($cardViewTableParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3>Детальный просмотр слайда #$item_id</h3>";
	
	$data['bodyContent'] .= $cardViewTableStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>