<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardViewHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getServiceItem($item_id);
	

	$rootPath = ROOT_PATH;
	
	$cardTmp = array(
					 'ID'						=>	array( 'type'=>'text', 		'field'=>'id', 				'params'=>array() ),
					 'Иконка'		=>	array( 'type'=>'image',		'field'=>'icon',			'params'=>array( 'path'=>RSF.'/split/files/services/' ) ),
					 'Название'					=>	array( 'type'=>'text', 		'field'=>'name', 		'params'=>array() ),
					 'Алиас'					=>	array( 'type'=>'text', 		'field'=>'alias', 			'params'=>array() ),
					 'Описание'					=>	array( 'type'=>'text', 		'field'=>'description', 		'params'=>array() ),
					 'Позиция'					=>	array( 'type'=>'text', 		'field'=>'pos', 			'params'=>array() ),
					 'Публикация'				=>	array( 'type'=>'text', 		'field'=>'block', 			'params'=>array( 'replace'=>array('0'=>'Да', '1'=>'Нет') ) ),
					 'Дата создания'			=>	array( 'type'=>'date', 		'field'=>'created', 		'params'=>array() ),
					 'Дата редактирования'		=>	array( 'type'=>'date', 		'field'=>'modified', 		'params'=>array() ),
	 );



	$cardViewTableParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath );
	
	$cardViewTableStr = $zh->getCardViewTable($cardViewTableParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3>Детальный просмотр сервиса #$item_id</h3>";
	
	$data['bodyContent'] .= $cardViewTableStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>