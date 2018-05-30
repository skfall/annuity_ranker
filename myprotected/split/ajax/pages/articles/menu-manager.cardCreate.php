<?php 
	// Start header content
	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardCreateHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getMenuItem($item_id);
	
	// Get formats List
	
	$parents = $zh->getMenuParents();
	
	// Get Galleries List
	
	$galleriesList = $zh->getGalleriesList();
	
	$rootPath = ROOT_PATH;
	
	$cardTmp = array(
					 'Name'	=>	array( 'type'=>'input', 	'field'=>'name', 			'params'=>array( 'size'=>50, 'hold'=>'Name', 'onchange'=>"change_alias();" ) ),
					 'Alias (URL)'			=>	array( 'type'=>'input', 	'field'=>'alias', 			'params'=>array( 'size'=>50, 'hold'=>'Alias' ) ),
					 
					
					 'clear-2'				=>	array( 'type'=>'clear' ),
					 
					 'Bind nav item to another'			=>	array( 'type'=>'select', 	'field'=>'parent', 			'params'=>array( 'list'=>$parents,
					 																									'first'=>array( 'name'=>'Not selected', 'id'=>0 ), 
					 																									 'fieldValue'=>'id', 
																														 'fieldTitle'=>'name'
																														 
																														 ) ),
					 
					 'clear-3'				=>	array( 'type'=>'clear' ),

					 'Content'				=>	array( 'type'=>'summernote', 	'field'=>'content', 		'params'=>array( 'size'=>25, 'hold'=>'Page content' ) ),
					  
					 
					 
					 'Display order'				=>	array( 'type'=>'number', 	'field'=>'pos', 		'params'=>array( 'size'=>25, 'hold'=>'Display order' ) ),
					 
					 'Publish'			=>	array( 'type'=>'block', 	'field'=>'block', 			'params'=>array( 'reverse'=>true ) ),
					 'Display in header'			=>	array( 'type'=>'block', 	'field'=>'display_in_header', 			'params'=>array( ) ),
					 'Display in footer'			=>	array( 'type'=>'block', 	'field'=>'display_in_footer', 			'params'=>array( ) ),
					 
					 'clear-4'				=>	array( 'type'=>'clear' ),
					 'Meta data'	=>	array( 'type'=>'header'),
					 'Meta title'				=>	array( 'type'=>'input', 		'field'=>'meta_title', 		'params'=>array( 'size'=>50, 'hold'=>'Meta title' ) ),
					 'Meta keys'				=>	array( 'type'=>'input', 		'field'=>'meta_keys', 		'params'=>array( 'size'=>50, 'hold'=>'Meta keys' ) ),
					 'Meta description'				=>	array( 'type'=>'area', 		'field'=>'meta_desc', 		'params'=>array( 'size'=>50, 'hold'=>'Meta description' ))
					
					
					 );
	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"createMenuItem", 'ajaxFolder'=>'create', 'appTable'=>$appTable );
	
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