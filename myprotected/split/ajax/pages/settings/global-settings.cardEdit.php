<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable, 'type'=>'global-settings' );
	
	$data['headContent'] = $zh->getCardEditHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getSiteConfigs($item_id, $lpx);

	$langs = $zh->getAvailableLangs();
	$lpx_name = ($lpx ? $lpx : 'en');

	$cardTmp = array(


					 'Site management'	=>	array( 'type'=>'header'),
					 'Site name'		=>	array( 'type'=>'input', 	'field'=>'sitename', 			'params'=>array( 'size'=>35, 'hold'=>'Site name') ),

					 'Indexing'			=>	array( 'type'=>'block', 	'field'=>'site_index', 				'params'=>array( 'reverse'=>false ) ),

					 'clear-0'				=>	array( 'type'=>'clear' ),

					 'Copyright'		=>	array( 'type'=>'input', 	'field'=>'copyright', 			'params'=>array( 'size'=>50, 'hold'=>'Copyright') ),

					'Contact information' => array('type' =>  'header'),
					'Email'		=>	array( 'type'=>'input', 	'field'=>'email', 			'params'=>array( 'size'=>35, 'hold'=>'') ),
					'Phone numbers'		=>	array( 'type'=>'area', 	'field'=>'phone', 			'params'=>array( 'size'=>35, 'hold'=>'') ),
					'Address'		=>	array( 'type'=>'area', 	'field'=>'address', 			'params'=>array( 'size'=>35, 'hold'=>'') ),

					'clear-1'				=>	array( 'type'=>'clear' ),

					 'JavaScript code'	=>	array( 'type'=>'header'),
					 'Before HEAD-close tag'				=>	array( 'type'=>'area', 	'field'=>'top_script', 			'params'=>array( 'size'=>100, 'hold'=>'<script>some code...</script>', 'onchange'=>"" ) ),
					 'Before BODY-close tag'				=>	array( 'type'=>'area', 	'field'=>'bot_script', 			'params'=>array( 'size'=>100, 'hold'=>'<script>some code...</script>', 'onchange'=>"" ) )

					 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"editSiteConfig", 'ajaxFolder'=>'edit', 'appTable'=>$appTable, 'lpx'=>$lpx, 'headParams'=>$headParams, 'langs'=>$langs );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Global site settings (edit mode)</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>