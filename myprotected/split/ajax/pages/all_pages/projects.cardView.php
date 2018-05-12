<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardViewHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getProjectItem($item_id);

	$stages = $zh->getStagesByProject($item_id);

	$stage_1_id = 0;
	$stage_2_id = 0;
	$stage_3_id = 0;
	

	if($stages){
		$stage_1_id = $stages[0]['id'];
		$stage_2_id = $stages[1]['id'];
		$stage_3_id = $stages[2]['id'];

		$scnt = 1;
		foreach($stages as $stage){
			
			$cardItem['s'.$scnt.'_caption'] = $stage['caption'];
			$cardItem['s'.$scnt.'_details'] = $stage['details'];
			$cardItem['s'.$scnt.'_pos'] = $stage['pos'];
			$cardItem['s'.$scnt.'_block'] = $stage['block'];
			$cardItem['s'.$scnt.'_lat'] = $stage['lat'];
			$cardItem['s'.$scnt.'_lng'] = $stage['lng'];
			$cardItem['s'.$scnt.'_video'] = $stage['video'];
			$cardItem['s'.$scnt.'_panorama'] = $stage['panorama'];
			$cardItem['s'.$scnt.'_docs_caption'] = $stage['docs_caption'];
			$cardItem['s'.$scnt.'_docs_details'] = $stage['docs_details'];
			$cardItem['s'.$scnt.'_block'] = $stage['block'];
			$cardItem['s'.$scnt.'_protocol'] = $stage['protocol_link'];

			$cardItem['s'.$scnt.'_photos'] = $stage['photos'];
			$cardItem['s'.$scnt.'_docs'] = $stage['docs'];

			$scnt++;
		}
	}
	

	$rootPath = ROOT_PATH;
	
	$cardTmp = array(
					 'Карточка проекта'					=>	array( 'type'=>'header'),
					 'ID'						=>	array( 'type'=>'text', 		'field'=>'id', 				'params'=>array() ),
					 'Название'					=>	array( 'type'=>'text', 		'field'=>'name', 		'params'=>array() ),
					 'Алиас'					=>	array( 'type'=>'text', 		'field'=>'alias', 			'params'=>array() ),
					 'Тип'						=>	array( 'type'=>'text', 		'field'=>'type', 			'params'=>array() ),
					 'Описание'					=>	array( 'type'=>'text', 		'field'=>'details', 		'params'=>array() ),
					 'Местоположение'			=>	array( 'type'=>'text', 		'field'=>'location', 			'params'=>array() ),
					 'Площадь'					=>	array( 'type'=>'text', 		'field'=>'area', 			'params'=>array() ),
					 'Мощность'					=>	array( 'type'=>'text', 		'field'=>'capacity', 			'params'=>array() ),
					 'Позиция'					=>	array( 'type'=>'text', 		'field'=>'pos', 			'params'=>array() ),
					 'Map LAT'					=>	array( 'type'=>'text', 		'field'=>'lat', 			'params'=>array() ),
					 'Map LNG'					=>	array( 'type'=>'text', 		'field'=>'lng', 			'params'=>array() ),
					 'Позиция'					=>	array( 'type'=>'text', 		'field'=>'pos', 			'params'=>array() ),
					 'Публикация'				=>	array( 'type'=>'text', 		'field'=>'block', 			'params'=>array( 'replace'=>array('0'=>'Да', '1'=>'Нет') ) ),
					 'Контент'					=>	array( 'type'=>'text', 		'field'=>'content', 		'params'=>array() ),
					 'Meta-title'				=>	array( 'type'=>'text', 		'field'=>'meta_title', 			'params'=>array() ),
					 'Meta-keys'				=>	array( 'type'=>'text', 		'field'=>'meta_keys', 			'params'=>array() ),
					 'Meta-desc'				=>	array( 'type'=>'text', 		'field'=>'meta_desc', 			'params'=>array() ),
					 'Дата создания'			=>	array( 'type'=>'date', 		'field'=>'created', 		'params'=>array() ),
					 'Дата редактирования'		=>	array( 'type'=>'date', 		'field'=>'modified', 		'params'=>array() ),
					 'Изображение превью'		=>	array( 'type'=>'image',		'field'=>'preview',			'params'=>array( 'path'=>RSF.'/split/files/projects/' ) ),
					 'Изображение карточки'		=>	array( 'type'=>'image',		'field'=>'card_image',			'params'=>array( 'path'=>RSF.'/split/files/projects/' ) ),

					 'Stage 1'					=>	array( 'type'=>'header'),
					 'Заголовок этапа'					=>	array( 'type'=>'text', 		'field'=>'s1_caption', 			'params'=>array() ),
					 'Публикация этапа'				=>	array( 'type'=>'text', 		'field'=>'s1_block', 			'params'=>array( 'replace'=>array('0'=>'Да', '1'=>'Нет') ) ),
					 'Очередность вывода этапа'					=>	array( 'type'=>'text', 		'field'=>'s1_pos', 			'params'=>array() ),
					 'Описание этапа'					=>	array( 'type'=>'text', 		'field'=>'s1_details', 			'params'=>array() ),
					 'Протокол'					=>	array( 'type'=>'text', 		'field'=>'s1_protocol', 			'params'=>array() ),
					 'Галерея этапа'			=>	array( 'type'=>'images',	'field'=>'s1_photos',			'params'=>array( 'path'=>RSF.'/split/files/projects/', 'field'=>'filename' ) ),
					 'Координаты карты (lat)'					=>	array( 'type'=>'text', 		'field'=>'s1_lat', 			'params'=>array() ),
					 'Координаты карты (lng)'					=>	array( 'type'=>'text', 		'field'=>'s1_lng', 			'params'=>array() ),
					 'Видео'					=>	array( 'type'=>'frame', 		'field'=>'s1_video', 			'params'=>array() ),
					 'Панорама'					=>	array( 'type'=>'frame', 		'field'=>'s1_panorama', 			'params'=>array() ),
					 'Заголовок (документы)'					=>	array( 'type'=>'text', 		'field'=>'s1_docs_caption', 			'params'=>array() ),
					 'Описание (документы)'					=>	array( 'type'=>'text', 		'field'=>'s1_docs_details', 			'params'=>array() ),
					 'Документы этапа'			=>	array( 'type'=>'images',	'field'=>'s1_docs',			'params'=>array( 'path'=>RSF.'/split/files/documents/', 'field'=>'filename' ) ),

					 'Stage 2 '					=>	array( 'type'=>'header'),
					 'Заголовок этапа '					=>	array( 'type'=>'text', 		'field'=>'s2_caption', 			'params'=>array() ),
					 'Публикация этапа '				=>	array( 'type'=>'text', 		'field'=>'s2_block', 			'params'=>array( 'replace'=>array('0'=>'Да', '1'=>'Нет') ) ),
					 'Очередность вывода этапа '					=>	array( 'type'=>'text', 		'field'=>'s2_pos', 			'params'=>array() ),
					 'Описание этапа '					=>	array( 'type'=>'text', 		'field'=>'s2_details', 			'params'=>array() ),
					 'Протокол '					=>	array( 'type'=>'text', 		'field'=>'s2_protocol', 			'params'=>array() ),
					 'Галерея этапа '			=>	array( 'type'=>'images',	'field'=>'s2_photos',			'params'=>array( 'path'=>RSF.'/split/files/projects/', 'field'=>'filename' ) ),
					 'Координаты карты (lat) '					=>	array( 'type'=>'text', 		'field'=>'s2_lat', 			'params'=>array() ),
					 'Координаты карты (lng) '					=>	array( 'type'=>'text', 		'field'=>'s2_lng', 			'params'=>array() ),
					 'Видео '					=>	array( 'type'=>'frame', 		'field'=>'s2_video', 			'params'=>array() ),
					 'Панорама '					=>	array( 'type'=>'frame', 		'field'=>'s2_panorama', 			'params'=>array() ),
					 'Заголовок (документы) '					=>	array( 'type'=>'text', 		'field'=>'s2_docs_caption', 			'params'=>array() ),
					 'Описание (документы) '					=>	array( 'type'=>'text', 		'field'=>'s2_docs_details', 			'params'=>array() ),
					 'Документы этапа '			=>	array( 'type'=>'images',	'field'=>'s2_docs',			'params'=>array( 'path'=>RSF.'/split/files/documents/', 'field'=>'filename' ) ),


					 'Stage 3  '					=>	array( 'type'=>'header'),
					 'Заголовок этапа  '					=>	array( 'type'=>'text', 		'field'=>'s3_caption', 			'params'=>array() ),
					 'Публикация этапа  '				=>	array( 'type'=>'text', 		'field'=>'s3_block', 			'params'=>array( 'replace'=>array('0'=>'Да', '1'=>'Нет') ) ),
					 'Очередность вывода этапа  '					=>	array( 'type'=>'text', 		'field'=>'s3_pos', 			'params'=>array() ),
					 'Описание этапа  '					=>	array( 'type'=>'text', 		'field'=>'s3_details', 			'params'=>array() ),
					 'Протокол  '					=>	array( 'type'=>'text', 		'field'=>'s3_protocol', 			'params'=>array() ),
					 'Галерея этапа  '			=>	array( 'type'=>'images',	'field'=>'s3_photos',			'params'=>array( 'path'=>RSF.'/split/files/projects/', 'field'=>'filename' ) ),
					 'Координаты карты (lat)  '					=>	array( 'type'=>'text', 		'field'=>'s3_lat', 			'params'=>array() ),
					 'Координаты карты (lng)  '					=>	array( 'type'=>'text', 		'field'=>'s3_lng', 			'params'=>array() ),
					 'Видео  '					=>	array( 'type'=>'frame', 		'field'=>'s3_video', 			'params'=>array() ),
					 'Панорама  '					=>	array( 'type'=>'frame', 		'field'=>'s3_panorama', 			'params'=>array() ),
					 'Заголовок (документы)  '					=>	array( 'type'=>'text', 		'field'=>'s3_docs_caption', 			'params'=>array() ),
					 'Описание (документы)  '					=>	array( 'type'=>'text', 		'field'=>'s3_docs_details', 			'params'=>array() ),
					 'Документы этапа  '			=>	array( 'type'=>'images',	'field'=>'s3_docs',			'params'=>array( 'path'=>RSF.'/split/files/documents/', 'field'=>'filename' ) ),
	 );



	$cardViewTableParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath );
	
	$cardViewTableStr = $zh->getCardViewTable($cardViewTableParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3>Детальный просмотр проекта #$item_id</h3>";
	
	$data['bodyContent'] .= $cardViewTableStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>