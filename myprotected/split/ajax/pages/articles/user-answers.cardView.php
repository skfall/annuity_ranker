<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable, 'type' => 'user_answer' );
	
	$data['headContent'] = $zh->getCardViewHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getUserAnswer($item_id);

	$rootPath = ROOT_PATH;

	$cardTmp = array(
		'ID'						=>	array( 'type'=>'text', 		'field'=>'id', 				'params'=>array() ),
		'Question'					=>	array( 'type'=>'text', 		'field'=>'question', 		'params'=>array() ),
		'Selected answer'					=>	array( 'type'=>'text', 		'field'=>'answer', 			'params'=>array() ),
		'Question annuity'					=>	array( 'type'=>'text', 		'field'=>'annuity_name', 			'params'=>array() ),		
		'User IP'					=>	array( 'type'=>'text', 		'field'=>'ip', 			'params'=>array() ),		
		'Created'		=>	array( 'type'=>'date', 		'field'=>'created', 		'params'=>array() ),
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