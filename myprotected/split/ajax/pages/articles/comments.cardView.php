<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardViewHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getCommentsItem($item_id);
	$zh->setSeen($item_id, 'osc_comments');
	
	$cardItem['stage'] = $cardItem['project_name'].' / '.$cardItem['stage_caption'];
	$cardItem['user'] = $cardItem['first_name'].' '.$cardItem['last_name'];		
	


	$rootPath = ROOT_PATH;
	
	$cardTmp = array(
					 'ID'						=>	array( 'type'=>'text', 		'field'=>'id', 				'params'=>array() ),
					 'ID пользователя'				=>	array( 'type'=>'text', 		'field'=>'user_id', 		'params'=>array() ),
					 'Пользователь'				=>	array( 'type'=>'text', 		'field'=>'user', 		'params'=>array() ),
					 'Проект / этап'			=>	array( 'type'=>'text', 		'field'=>'stage', 			'params'=>array() ),
					 'Комментарий'				=>	array( 'type'=>'text', 		'field'=>'content', 		'params'=>array() ),
					 'Анонимный комментарий'					=>	array( 'type'=>'text', 		'field'=>'block', 			'params'=>array( 'replace'=>array('1'=>'Да', '0'=>'Нет') ) ),
					 'Публикация'				=>	array( 'type'=>'text', 		'field'=>'block', 			'params'=>array( 'replace'=>array('0'=>'Да', '1'=>'Нет') ) ),
					 'Дата создания'			=>	array( 'type'=>'date', 		'field'=>'created', 		'params'=>array() ),
					 'Дата редактирования'		=>	array( 'type'=>'date', 		'field'=>'modified', 		'params'=>array() ),
	 );



	$cardViewTableParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath );
	
	$cardViewTableStr = $zh->getCardViewTable($cardViewTableParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3>Детальный просмотр комментария #$item_id</h3>";
	
	$data['bodyContent'] .= $cardViewTableStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>