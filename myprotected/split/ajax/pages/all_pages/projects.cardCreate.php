<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardCreateHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getProjectItem($item_id);
	$projectTypes = $zh->getProjectTypes();
	$empty_type = array(
		"id" => 0,
		"name" => 'No type',
		"block" => 0,
		"icon" => ""
	);
	array_push($projectTypes, $empty_type);
	$rootPath = ROOT_PATH;
	
	$cardTmp = array(
					 'Карточка проекта'	=>	array( 'type'=>'header'),
					 'Название'				=>	array( 'type'=>'input', 		'field'=>'name', 		'params'=>array( 'size'=>50, 'hold'=>'Название', 'onchange' => 'change_alias();' ) ),
					 'Алиас'				=>	array( 'type'=>'input', 		'field'=>'alias', 		'params'=>array( 'size'=>50, 'hold'=>'Алиас' ) ),
					 'clear-1'				=>	array( 'type'=>'clear' ),
					 'Описание'				=>	array( 'type'=>'area', 		'field'=>'details', 		'params'=>array( 'size'=>100, 'hold'=>'Описание' ) ),
					 'clear-2'				=>	array( 'type'=>'clear' ),
					 'Позиция'				=>	array( 'type'=>'number', 		'field'=>'pos', 		'params'=>array( 'size'=>50, 'hold'=>'Позиция' ) ),
					 'Публикация'			=>	array( 'type'=>'block', 	'field'=>'block', 			'params'=>array( 'reverse'=>true ) ),
					 'clear-3'				=>	array( 'type'=>'clear' ),
					 'Местоположение'				=>	array( 'type'=>'input', 		'field'=>'location', 		'params'=>array( 'size'=>50, 'hold'=>'Местоположение' ) ),
					 'Площадь'				=>	array( 'type'=>'input', 		'field'=>'area', 		'params'=>array( 'size'=>50, 'hold'=>'Площадь' ) ),
					 'Мощность'				=>	array( 'type'=>'input', 		'field'=>'capacity', 		'params'=>array( 'size'=>50, 'hold'=>'Мощность' ) ),
					 'Тип'					=>	array( 'type'=>'select', 		'field'=>'type', 			'params'=>array( 'list'=>$projectTypes, 
					 																									 'fieldValue'=>'id', 
																														 'fieldTitle'=>'name', 
																														 'currValue'=>$cardItem['type_id'], 
																														 'onChange'=>"" 
																														 ) ),
					 
					 'clear-4'				=>	array( 'type'=>'clear' ),

					 'Контент'				=>	array( 'type'=>'summernote', 		'field'=>'content', 		'params'=>array( 'size'=>100, 'hold'=>'Контент' ) ),
					 'clear-6'				=>	array( 'type'=>'clear' ),

					 'Изображение превью'			=>	array( 'type'=>'image_mono','field'=>'preview', 		'params'=>array( 'path'=>RSF."/split/files/projects/", 'appTable'=>$appTable, 'id'=>$item_id ) ),
					 'Изображение карточки'			=>	array( 'type'=>'image_mono','field'=>'card_image', 		'params'=>array( 'path'=>RSF."/split/files/projects/", 'appTable'=>$appTable, 'id'=>$item_id ) ),


					 'Stage 1'	=>	array( 'type'=>'header'),
					 'Заголовок этапа'				=>	array( 'type'=>'input', 		'field'=>'s1_caption', 		'params'=>array( 'size'=>50, 'hold'=>'Заголовок' ) ),
					 'Публикация этапа'			=>	array( 'type'=>'block', 	'field'=>'s1_block', 			'params'=>array( 'reverse'=>true ) ),
					 'Очередность вывода этапа'				=>	array( 'type'=>'number', 		'field'=>'s1_pos', 		'params'=>array( 'size'=>50, 'hold'=>'Очередность вывода' ) ),

					 'Описание этапа'				=>	array( 'type'=>'summernote', 		'field'=>'s1_details', 		'params'=>array( 'size'=>100, 'hold'=>'Описание' ) ),
					 'Протокол'			=>	array( 'type'=>'image_mono','field'=>'s1_protocol', 		'params'=>array( 'path'=>RSF."/split/files/projects/", 'appTable'=>$appTable, 'id'=>$item_id ) ),

					 'Галерея этапа'	=>	array( 'type'=>'image_mult', 'field'=>'s1_photos', 		'params'=>array( 'path'=>RSF."/split/files/projects/", 'appTable'=>$appTable, 'id'=>$item_id, 'field'=>'filename' ) ),

					 'Координаты карты (lat)'					=>	array( 'type'=>'input', 		'field'=>'s1_lat', 		'params'=>array( 'size'=>50, 'hold'=>'Lat' ) ),
					 'Координаты карты (lng)'					=>	array( 'type'=>'input', 		'field'=>'s1_lng', 		'params'=>array( 'size'=>50, 'hold'=>'Lng' ) ),
					 'Видео (embed)'				=>	array( 'type'=>'area', 		'field'=>'s1_video', 		'params'=>array( 'size'=>100, 'hold'=>'Видео' ) ),
					 'Панорама (embed)'				=>	array( 'type'=>'area', 		'field'=>'s1_panorama', 		'params'=>array( 'size'=>100, 'hold'=>'Панорама' ) ),
					 'Заголовок (документы)'				=>	array( 'type'=>'input', 		'field'=>'s1_docs_caption', 		'params'=>array( 'size'=>50, 'hold'=>'Заголовок (документы)' ) ),
					 'Описание (документы)'				=>	array( 'type'=>'summernote', 		'field'=>'s1_docs_details', 		'params'=>array( 'size'=>100, 'hold'=>'Описание (документы)' ) ),
					 'Документы этапа'	=>	array( 'type'=>'image_mult', 'field'=>'s1_docs', 		'params'=>array( 'path'=>RSF."/split/files/documents/", 'appTable'=>$appTable, 'id'=>$item_id, 'field'=>'filename' ) ),


					 'Stage 2'	=>	array( 'type'=>'header'),
					 'Заголовок этапа '				=>	array( 'type'=>'input', 		'field'=>'s2_caption', 		'params'=>array( 'size'=>50, 'hold'=>'Заголовок' ) ),
					 'Публикация этапа '			=>	array( 'type'=>'block', 	'field'=>'s2_block', 			'params'=>array( 'reverse'=>true ) ),
					 'Очередность вывода этапа '				=>	array( 'type'=>'number', 		'field'=>'s2_pos', 		'params'=>array( 'size'=>50, 'hold'=>'Очередность вывода' ) ),

					 'Описание этапа '				=>	array( 'type'=>'summernote', 		'field'=>'s2_details', 		'params'=>array( 'size'=>100, 'hold'=>'Описание' ) ),
					 'Протокол '			=>	array( 'type'=>'image_mono','field'=>'s2_protocol', 		'params'=>array( 'path'=>RSF."/split/files/projects/", 'appTable'=>$appTable, 'id'=>$item_id ) ),

					 'Галерея этапа '	=>	array( 'type'=>'image_mult', 'field'=>'s2_photos', 		'params'=>array( 'path'=>RSF."/split/files/projects/", 'appTable'=>$appTable, 'id'=>$item_id, 'field'=>'filename' ) ),

					 'Координаты карты (lat) '					=>	array( 'type'=>'input', 		'field'=>'s2_lat', 		'params'=>array( 'size'=>50, 'hold'=>'Lat' ) ),
					 'Координаты карты (lng) '					=>	array( 'type'=>'input', 		'field'=>'s2_lng', 		'params'=>array( 'size'=>50, 'hold'=>'Lng' ) ),
					 'Видео (embed) '				=>	array( 'type'=>'area', 		'field'=>'s2_video', 		'params'=>array( 'size'=>100, 'hold'=>'Видео' ) ),
					 'Панорама (embed) '				=>	array( 'type'=>'area', 		'field'=>'s2_panorama', 		'params'=>array( 'size'=>100, 'hold'=>'Панорама' ) ),
					 'Заголовок (документы) '				=>	array( 'type'=>'input', 		'field'=>'s2_docs_caption', 		'params'=>array( 'size'=>50, 'hold'=>'Заголовок (документы)' ) ),
					 'Описание (документы) '				=>	array( 'type'=>'summernote', 		'field'=>'s2_docs_details', 		'params'=>array( 'size'=>100, 'hold'=>'Описание (документы)' ) ),
					 'Документы этапа '	=>	array( 'type'=>'image_mult', 'field'=>'s2_docs', 		'params'=>array( 'path'=>RSF."/split/files/documents/", 'appTable'=>$appTable, 'id'=>$item_id, 'field'=>'filename' ) ),



					 'Stage 3'	=>	array( 'type'=>'header'),
					 'Заголовок этапа  '				=>	array( 'type'=>'input', 		'field'=>'s3_caption', 		'params'=>array( 'size'=>50, 'hold'=>'Заголовок' ) ),
					 'Публикация этапа  '			=>	array( 'type'=>'block', 	'field'=>'s3_block', 			'params'=>array( 'reverse'=>true ) ),
					 'Очередность вывода этапа  '				=>	array( 'type'=>'number', 		'field'=>'s3_pos', 		'params'=>array( 'size'=>50, 'hold'=>'Очередность вывода' ) ),

					 'Описание этапа  '				=>	array( 'type'=>'summernote', 		'field'=>'s3_details', 		'params'=>array( 'size'=>100, 'hold'=>'Описание' ) ),
					 'Протокол  '			=>	array( 'type'=>'image_mono','field'=>'s3_protocol', 		'params'=>array( 'path'=>RSF."/split/files/projects/", 'appTable'=>$appTable, 'id'=>$item_id ) ),

					 'Галерея этапа  '	=>	array( 'type'=>'image_mult', 'field'=>'s3_photos', 		'params'=>array( 'path'=>RSF."/split/files/projects/", 'appTable'=>$appTable, 'id'=>$item_id, 'field'=>'filename' ) ),

					 'Координаты карты (lat)  '					=>	array( 'type'=>'input', 		'field'=>'s3_lat', 		'params'=>array( 'size'=>50, 'hold'=>'Lat' ) ),
					 'Координаты карты (lng)  '					=>	array( 'type'=>'input', 		'field'=>'s3_lng', 		'params'=>array( 'size'=>50, 'hold'=>'Lng' ) ),
					 'Видео (embed)  '				=>	array( 'type'=>'area', 		'field'=>'s3_video', 		'params'=>array( 'size'=>100, 'hold'=>'Видео' ) ),
					 'Панорама (embed)  '				=>	array( 'type'=>'area', 		'field'=>'s3_panorama', 		'params'=>array( 'size'=>100, 'hold'=>'Панорама' ) ),
					 'Заголовок (документы)  '				=>	array( 'type'=>'input', 		'field'=>'s3_docs_caption', 		'params'=>array( 'size'=>50, 'hold'=>'Заголовок (документы)' ) ),
					 'Описание (документы)  '				=>	array( 'type'=>'summernote', 		'field'=>'s3_docs_details', 		'params'=>array( 'size'=>100, 'hold'=>'Описание (документы)' ) ),
					 'Документы этапа  '	=>	array( 'type'=>'image_mult', 'field'=>'s3_docs', 		'params'=>array( 'path'=>RSF."/split/files/documents/", 'appTable'=>$appTable, 'id'=>$item_id, 'field'=>'filename' ) ),





					 'Meta data'	=>	array( 'type'=>'header'),
					 'Meta title'				=>	array( 'type'=>'input', 		'field'=>'meta_title', 		'params'=>array( 'size'=>50, 'hold'=>'Meta title' ) ),
					 'Meta keys'				=>	array( 'type'=>'input', 		'field'=>'meta_keys', 		'params'=>array( 'size'=>50, 'hold'=>'Meta keys' ) ),
					 'Meta description'				=>	array( 'type'=>'area', 		'field'=>'meta_desc', 		'params'=>array( 'size'=>50, 'hold'=>'Meta description' ) ),
					 
					 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"createProject", 'ajaxFolder'=>'create', 'appTable'=>$appTable );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Форма создания проекта</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>