<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable, 'type'=>'global-settings1' );
	$data['headContent'] = $zh->getCardViewHeader($headParams, $lpx);
	$pref = ($lpx ? $lpx.'_' : '');
	// Start body content
	
	$cardItem = $zh->getSiteConfigs($item_id, $lpx);

	$langs = $zh->getAvailableLangs();


	$rootPath = ROOT_PATH;
	
	$cardTmp = array(
					 'Site name'		=>	array( 'type'=>'text', 		'field'=>'sitename', 		'params'=>array() ),

					 'Email'		=>	array( 'type'=>'text', 		'field'=>'email', 		'params'=>array() ),
					 'Phones'		=>	array( 'type'=>'text', 		'field'=>'phone', 		'params'=>array() ),
					 'Address'		=>	array( 'type'=>'text', 		'field'=>'address', 		'params'=>array() ),
					 'Footer header'		=>	array( 'type'=>'text', 		'field'=>'footer_header', 		'params'=>array() ),
					 'Footer text'		=>	array( 'type'=>'text', 		'field'=>'footer_text', 		'params'=>array() ),

					 'Site indexing in search engines'		=>	array( 'type'=>'text', 		'field'=>'site_index', 		'params'=>array( 'replace'=>array('0'=>'Нет', '1'=>'Да') ) ),
					 
					 'Copyright'		=>	array( 'type'=>'text', 		'field'=>'copyright', 		'params'=>array() ),
					
					 'Modified'	=>	array( 'type'=>'date', 		'field'=>'modified', 		'params'=>array() ),


					 'JS code before HEAD-close tag'		=>	array( 'type'=>'text', 		'field'=>'top_script', 		'params'=>array() ),
					 'JS code before BODY-close tag'		=>	array( 'type'=>'text', 		'field'=>'bot_script', 		'params'=>array() ),
					 );

	$cardViewTableParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'lpx'=>$lpx, 'headParams'=>$headParams, 'langs'=>$langs );
	
	$cardViewTableStr = $zh->getCardViewTable($cardViewTableParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3>Global site settings (view mode)</h3>";
	
	$data['bodyContent'] .= $cardViewTableStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>