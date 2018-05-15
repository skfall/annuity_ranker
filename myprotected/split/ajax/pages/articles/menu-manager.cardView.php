<?php 
	// Start header content
	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardViewHeader($headParams, $lpx);
	$pref = ($lpx ? $lpx.'_' : '');
	
	// Start body content
	
	$cardItem = $zh->getMenuItem($item_id, $lpx);
	$langs = $zh->getAvailableLangs();
	$rootPath = ROOT_PATH;
	
	$cardTmp = array(
					 'ID'						=>	array( 'type'=>'text', 		'field'=>'id', 				'params'=>array() ),
					 'Name '.$lpx			=>	array( 'type'=>'text', 		'field'=>$pref.'name', 			'params'=>array() ),
					 'Alias'					=>	array( 'type'=>'text', 		'field'=>'alias', 			'params'=>array() ),
					 'Parent'					=>	array( 'type'=>'text', 		'field'=>'parent_name', 			'params'=>array() ),
					 
					 'Display position'					=>	array( 'type'=>'text', 		'field'=>'pos', 			'params'=>array() ),
					
					 'Publishing'				=>	array( 'type'=>'text', 		'field'=>'block', 			'params'=>array( 'replace'=>array('0'=>'Да', '1'=>'Нет') ) ),
					 'Created'			=>	array( 'type'=>'date', 		'field'=>'created', 		'params'=>array() ),
					 'Modified'		=>	array( 'type'=>'date', 		'field'=>'modified', 		'params'=>array() ),
					 'Meta-title'					=>	array( 'type'=>'text', 		'field'=>'meta_title', 			'params'=>array() ),
					 'Meta-keys'					=>	array( 'type'=>'text', 		'field'=>'meta_keys', 			'params'=>array() ),
					 'Meta-desc'					=>	array( 'type'=>'text', 		'field'=>'meta_desc', 			'params'=>array() ),
					 );
	$cardViewTableParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'lpx'=>$lpx, 'headParams'=>$headParams, 'langs'=>$langs );
	
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