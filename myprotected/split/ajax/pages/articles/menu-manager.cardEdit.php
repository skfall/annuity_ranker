<?php 
	// Start header content
	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable, 'type'=>'menuEditHeader' );
	
	$data['headContent'] = $zh->getCardEditHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getMenuItem($item_id, $lpx);
	
	// Get formats List
	
	$parents = $zh->getMenuParents($item_id);
	$langs = $zh->getAvailableLangs();
	$lpx_name = ($lpx ? $lpx : 'en');
	
	$rootPath = ROOT_PATH;
	$cardTmp = array();
	$cardTmp = array(
		'Name'	=>	array( 'type'=>'input', 	'field'=>'name', 			'params'=>array( 'size'=>50, 'hold'=>'Name', 'onchange'=>"change_alias();" ) ));
		
		
		$part2 = array(
			'Alias (URL)'			=>	array( 'type'=>'input', 	'field'=>'alias', 			'params'=>array( 'size'=>50, 'hold'=>'Alias' ) ),
		
	   
			'clear-2'				=>	array( 'type'=>'clear' ),
	
		'Bind nav item to another'			=>	array( 'type'=>'select', 	'field'=>'parent', 			'params'=>array( 'list'=>$parents,
																											'first'=>array( 'name'=>'Not selected', 'id'=>0 ), 
																											 'fieldValue'=>'id', 
																											'fieldTitle'=>'name',
																											'currValue'=>$cardItem['parent'], 
																											) ));
		if($cardItem['type'] != 1){
			$cardTmp = array_merge($cardTmp, $part2);
		}
		
		
		$part3 = array(
		
		'clear-3'				=>	array( 'type'=>'clear' ),
		
		
		'Display order'				=>	array( 'type'=>'number', 	'field'=>'pos', 		'params'=>array( 'size'=>25, 'hold'=>'Display order' ) ),
		
		'Publish'			=>	array( 'type'=>'block', 	'field'=>'block', 			'params'=>array( 'reverse'=>true ) ),
		
		'clear-4'				=>	array( 'type'=>'clear' ),
		'Meta data'	=>	array( 'type'=>'header'),
		'Meta title'				=>	array( 'type'=>'input', 		'field'=>'meta_title', 		'params'=>array( 'size'=>50, 'hold'=>'Meta title' ) ),
		'Meta keys'				=>	array( 'type'=>'input', 		'field'=>'meta_keys', 		'params'=>array( 'size'=>50, 'hold'=>'Meta keys' ) ),
		'Meta description'				=>	array( 'type'=>'area', 		'field'=>'meta_desc', 		'params'=>array( 'size'=>50, 'hold'=>'Meta description' ) ),
					 
	);

	$cardTmp = array_merge($cardTmp, $part3);

	
	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"editMenuItem", 'ajaxFolder'=>'edit', 'appTable'=>$appTable, 'lpx'=>$lpx, 'headParams'=>$headParams, 'langs'=>$langs );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Item edit form #$item_id</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";
?>