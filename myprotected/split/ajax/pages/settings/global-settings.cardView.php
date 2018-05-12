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
					 'Название сайта'		=>	array( 'type'=>'text', 		'field'=>'sitename', 		'params'=>array() ),

					 'Email'		=>	array( 'type'=>'text', 		'field'=>'email', 		'params'=>array() ),
					 'Телефоны'		=>	array( 'type'=>'text', 		'field'=>'phone', 		'params'=>array() ),
					 'Адрес'		=>	array( 'type'=>'text', 		'field'=>'address', 		'params'=>array() ),

					 'MAP LAT'		=>	array( 'type'=>'text', 		'field'=>'lat', 		'params'=>array() ),
					 'MAP LNG'		=>	array( 'type'=>'text', 		'field'=>'lng', 		'params'=>array() ),
					 
					 'Индексация сайта в поисковых системах'		=>	array( 'type'=>'text', 		'field'=>'site_index', 		'params'=>array( 'replace'=>array('0'=>'Нет', '1'=>'Да') ) ),
					 
					 'Copyright'		=>	array( 'type'=>'text', 		'field'=>'copyright', 		'params'=>array() ),
					
					 'Дата редактирования'	=>	array( 'type'=>'date', 		'field'=>'modified', 		'params'=>array() ),


					 'JS код перед закрытием тега </head>'		=>	array( 'type'=>'text', 		'field'=>'top_script', 		'params'=>array() ),
					 'JS код перед закрытием тега </body>'		=>	array( 'type'=>'text', 		'field'=>'bot_script', 		'params'=>array() ),
					 );

	$cardViewTableParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'lpx'=>$lpx, 'headParams'=>$headParams, 'langs'=>$langs );
	
	$cardViewTableStr = $zh->getCardViewTable($cardViewTableParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3>Глобальные настройки сайта (режим просмотра)</h3>";
	
	$data['bodyContent'] .= $cardViewTableStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>