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
		'Alias'					=>	array( 'type'=>'text', 		'field'=>'alias', 			'params'=>array() ),
		'Published'			=>	array( 'type'=>'text', 		'field'=>'block', 			'params'=>array( 'replace'=>array('0'=>'Yes', '1'=>'No') ) ),
		'Display order'			=>	array( 'type'=>'text', 		'field'=>'pos'),
		'Modified'		=>	array( 'type'=>'date', 		'field'=>'modified', 		'params'=>array() ),
		'Created'		=>	array( 'type'=>'date', 		'field'=>'created', 		'params'=>array() ),
		'Preview image'		=>	array( 'type'=>'image',		'field'=>'preview',			'params'=>array( 'path'=>RSF.'/split/files/annuities/' ) ),
	);

	if($cardItem['is_video_bg']){
		$cardTmp['Background image'] = array( 'type'=>'video',		'field'=>'background',			'params'=>array( 'path'=>RSF.'/split/files/annuities/' ) );
	}else{
		$cardTmp['Background image'] = array( 'type'=>'image',		'field'=>'background',			'params'=>array( 'path'=>RSF.'/split/files/annuities/' ) );
	}



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