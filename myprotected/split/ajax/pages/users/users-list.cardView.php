<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable );
	
	$data['headContent'] = $zh->getCardViewHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getUserInfo($item_id);

	$rootPath = "../../../../..";
	
	$cardTmp = array(
					 'Имя'					=>	array( 'type'=>'text', 		'field'=>'first_name', 			'params'=>array() ),
					 'Фамилия'				=>	array( 'type'=>'text', 		'field'=>'last_name', 			'params'=>array() ),
					 'ID'					=>	array( 'type'=>'text', 		'field'=>'id', 				'params'=>array() ),
					 'Изображение'			=>	array( 'type'=>'image',		'field'=>'avatar',			'params'=>array( 'path'=>RSF.'/split/files/users/' ) ),
					 'Email'				=>	array( 'type'=>'text', 		'field'=>'login', 			'params'=>array() ),
					 'Телефон'				=>	array( 'type'=>'text', 		'field'=>'phone', 			'params'=>array() ),
					 'Публикация'			=>	array( 'type'=>'text', 		'field'=>'block', 			'params'=>array( 'replace'=>array('0'=>'Да', '1'=>'Нет') ) ),

					 'Пол'					=>	array( 'type'=>'text', 		'field'=>'gender', 			'params'=>array( 'replace'=>array('1'=>'Мужской', '0'=>'Женский') ) ),
					 //'Дочерние элементы'	=>	array( 'type'=>'arr_mult',	'field'=>'childs', 			'params'=>array( 'field'=>'name','link'=>array('parent'=>$parent,'alias'=>$alias,'id'=>$id,'item_id'=>1,'params'=>'{}') ) ),
					 'Группа пользователей'	=>	array( 'type'=>'arr_mono', 	'field'=>'typeInfo', 		'params'=>array( 'field'=>'name' ) ),
					 'Дата рождения'		=>	array( 'type'=>'date', 		'field'=>'birthday', 		'params'=>array( ) ),
					 
					 
					 
					 'Дата регистрации'		=>	array( 'type'=>'date', 		'field'=>'created', 		'params'=>array( ) ),
					 'Дата редактирования'	=>	array( 'type'=>'date', 		'field'=>'modified', 		'params'=>array( ) )
					 );

	$cardViewTableParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath );
	
	$cardViewTableStr = $zh->getCardViewTable($cardViewTableParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3>Детальный просмотр карточки пользователя</h3>";
	
	$data['bodyContent'] .= $cardViewTableStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>