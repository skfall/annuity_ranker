<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardCreateHeader($headParams);
	
	// Start body content
	$user_id = 0;
	if(isset($_COOKIE["user_id"]) && $_COOKIE["user_id"]){
		$user_id = $_COOKIE["user_id"];
	}

	$cardItem = $zh->getCommentsItem($item_id);
	$users = $zh->getUsers();
	foreach($users as &$user){
		$user['name'] = $user['first_name'].' '.$user['last_name'];
	}

	$stages = $zh->getStages();
	foreach($stages as &$stage){
		$stage['name'] = $stage['project_name'].' / '.$stage['caption'];
	}

	$cardItem['stage'] = $cardItem['project_name'].' / '.$cardItem['stage_caption'];
	$cardItem['user'] = $cardItem['first_name'].' '.$cardItem['last_name'];		

	$rootPath = ROOT_PATH;
	
	$cardTmp = array(
		'Пользователь'					=>	array( 'type'=>'select', 		'field'=>'user_id', 'params'=>array( 'list'=>$users, 
		'fieldValue'=>'id', 
		'fieldTitle'=>'name', 
		'currValue'=>$user_id, 
		'onChange'=>"" 
		) ),
		'Этап'					=>	array( 'type'=>'select', 		'field'=>'stage_id', 'params'=>array( 'list'=>$stages, 
			'fieldValue'=>'id', 
			'fieldTitle'=>'name', 
			'currValue'=>$cardItem['stage_id'], 
			'onChange'=>"" 
			) ),
		'Комментарий'				=>	array( 'type'=>'area', 		'field'=>'content', 		'params'=>array( 'size'=>100, 'hold'=>'Комментарий' ) ),
		
		'Публикация'			=>	array( 'type'=>'block', 	'field'=>'block', 			'params'=>array( 'reverse'=>true ) ),
		'clear-4'				=>	array( 'type'=>'clear' ),


		'Анонимный комментарий' =>	array( 'type'=>'header' ),
		'ENABLE'	=>	array( 'type'=>'block', 	'field'=>'is_fake'),
		'Имя пользователя'		=>	array( 'type'=>'input', 		'field'=>'author_name', 		'params'=>array( 'size'=>25, 'hold'=>'Имя пользователя' ) ),
		'Аватар'			=>	array( 'type'=>'image_mono','field'=>'author_avatar', 		'params'=>array( 'path'=>RSF."/split/files/projects/", 'appTable'=>$appTable, 'id'=>$item_id ) ),
	);

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"createComment", 'ajaxFolder'=>'create', 'appTable'=>$appTable );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Форма создания комментария</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>