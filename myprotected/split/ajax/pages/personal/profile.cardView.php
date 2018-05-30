<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable, 'type'=>'profile' );
	
	$data['headContent'] = $zh->getCardViewHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getUserInfo($item_id);

	$rootPath = "../../../../..";
	
	$cardTmp = array(
					 'Name'					=>	array( 'type'=>'text', 		'field'=>'name', 			'params'=>array() ),
					 'Surname'				=>	array( 'type'=>'text', 		'field'=>'fname', 			'params'=>array() ),
					 'ID'					=>	array( 'type'=>'text', 		'field'=>'id', 				'params'=>array() ),
					 'Avatar'			=>	array( 'type'=>'image',		'field'=>'avatar',			'params'=>array( 'path'=>'/split/files/users/' ) ),
					 'Email'				=>	array( 'type'=>'text', 		'field'=>'login', 			'params'=>array() ),
					 'Phone'				=>	array( 'type'=>'text', 		'field'=>'phone', 			'params'=>array() ),
					 'Publishing'			=>	array( 'type'=>'text', 		'field'=>'block', 			'params'=>array( 'replace'=>array('0'=>'Да', '1'=>'Нет') ) ),
					 'Active status'			=>	array( 'type'=>'text', 		'field'=>'active', 			'params'=>array( 'replace'=>array('0'=>'Not active', '1'=>'Active') ) ),
					 'Пол'					=>	array( 'type'=>'text', 		'field'=>'male', 			'params'=>array( 'replace'=>array('М'=>'Male', 'Ж'=>'Female') ) ),
					 //'Дочерние элементы'	=>	array( 'type'=>'arr_mult',	'field'=>'childs', 			'params'=>array( 'field'=>'name','link'=>array('parent'=>$parent,'alias'=>$alias,'id'=>$id,'item_id'=>1,'params'=>'{}') ) ),
					 'User group'	=>	array( 'type'=>'arr_mono', 	'field'=>'typeInfo', 		'params'=>array( 'field'=>'name' ) ),
					 'Birthday'		=>	array( 'type'=>'date', 		'field'=>'birthday', 		'params'=>array( ) ),
					 
					 'Extra fields'=>	array( 'type'=>'usersExtraFields', 'field'=>'ef_groups','params'=>array( 'data'=>$cardItem['ef_groups'] ) ),
					 
					 'Registered'		=>	array( 'type'=>'date', 		'field'=>'dateCreate', 		'params'=>array( ) ),
					 'Modified'	=>	array( 'type'=>'date', 		'field'=>'dateModify', 		'params'=>array( ) )
					 );

	$cardViewTableParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath );
	
	$cardViewTableStr = $zh->getCardViewTable($cardViewTableParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3>Детальный просмотр профиля</h3>";
	
	$data['bodyContent'] .= $cardViewTableStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>