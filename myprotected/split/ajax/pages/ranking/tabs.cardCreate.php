<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardCreateHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getTab($item_id);
	$companies = $zh->getCompaniesList();
	array_unshift($companies, ['id' => 0, 'name' => 'Select company...']);

	$rootPath = ROOT_PATH;
	
	$cardTmp = array(
		'Name'				=>	array( 'type'=>'input', 		'field'=>'name', 'params'=>array( 'size'=>100, 'hold'=>'Name', 'onchange'=>"change_alias();" ) ),
		'Company'	=>	array( 'type'=>'select', 	'field'=>'company_id', 			'params'=>array( 'list'=>$companies, 
			'fieldValue'=>'id', 
			'fieldTitle'=>'name', 
			'currValue'=>0, 
			'onChange'=>"" 
		)),
		'clear-1'				=>	array( 'type'=>'clear' ),
		'Publish'			=>	array( 'type'=>'block', 	'field'=>'block', 			'params'=>array( 'reverse'=>true ) ),
		'Display order'				=>	array( 'type'=>'number', 		'field'=>'pos', 		'params'=>array( 'size'=>100, 'hold'=>'Display order' ) ),

		'clear-2'				=>	array( 'type'=>'clear' ),

		'Content'				=>	array( 'type'=>'summernote', 		'field'=>'content', 		'params'=>array( 'size'=>100, 'hold'=>'Content' ) ),
		
		
		
	);

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"createTab", 'ajaxFolder'=>'create', 'appTable'=>$appTable );
	
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