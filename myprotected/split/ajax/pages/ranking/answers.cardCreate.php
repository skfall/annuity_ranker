<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardCreateHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getAnswer($item_id);
	$questions = $zh->getQuestionsList();

	array_unshift($questions, ['id' => 0, 'question' => 'Select question...']);

	$rootPath = ROOT_PATH;
	
	$cardTmp = array(
		'Answer'				=>	array( 'type'=>'area', 		'field'=>'answer', 'params'=>array( 'size'=>100, 'hold'=>'Answer') ),
		'Annuity | Question'	=>	array( 'type'=>'select', 	'field'=>'question_id', 			'params'=>array( 'list'=>$questions, 
			'fieldValue'=>'id', 
			'fieldTitle'=>'question', 
			'currValue'=>0, 
			'onChange'=>"" 
		)),
		'clear-1'				=>	array( 'type'=>'clear' ),
		'Publish'			=>	array( 'type'=>'block', 	'field'=>'block', 			'params'=>array( 'reverse'=>true ) ),
		'Display order'				=>	array( 'type'=>'number', 		'field'=>'pos', 		'params'=>array( 'size'=>100, 'hold'=>'Display order' ) ),

		'clear-2'				=>	array( 'type'=>'clear' ),
		
	);

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"createAnswer", 'ajaxFolder'=>'create', 'appTable'=>$appTable );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Item create form</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>