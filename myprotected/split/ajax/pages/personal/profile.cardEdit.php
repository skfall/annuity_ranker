<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable, 'type'=>'profile' );
	
	$data['headContent'] = $zh->getCardEditHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getUserInfo($item_id);
	
	
	$usersTypes = $zh->getUsersTypes();
	
	$efGroups = $zh->getExtraFieldsGroups();

	$rootPath = "../../../../..";
	
	$cardTmp = array(
					 'Name'					=>	array( 'type'=>'input', 	'field'=>'first_name', 			'params'=>array( 'size'=>25, 'hold'=>'Name', 'onchange'=>"change_alias();" ) ),
					 
					 'Surname'				=>	array( 'type'=>'input', 	'field'=>'last_name', 			'params'=>array( 'size'=>25, 'hold'=>'Surname' ) ),
					 
					 'Login'				=>	array( 'type'=>'input', 	'field'=>'login', 			'params'=>array( 'size'=>25, 'hold'=>'Login' ) ),
					 
					 'Phone'				=>	array( 'type'=>'input', 	'field'=>'phone', 			'params'=>array( 'size'=>25, 'hold'=>'Phone' ) ),
					 
					 'Birthday'		=>	array( 'type'=>'date', 		'field'=>'birthday', 		'params'=>array( ) ),
					 
					 'clear-1'				=>	array( 'type'=>'clear' ),
					 
					 'User group'	=>	array( 'type'=>'hidden', 	'field'=>'type' ),
					 
					 /*
					 'Група пользователей'	=>	array( 'type'=>'select', 	'field'=>'type', 			'params'=>array( 'list'=>$usersTypes, 
					 																									 'fieldValue'=>'id', 
																														 'fieldTitle'=>'name', 
																														 'currValue'=>$cardItem['type'], 
																														 'onChange'=>"reload_users_extra_fields($(this).val(),$item_id);" 
																														 ) ),
					 */
					 'Publishing'			=>	array( 'type'=>'hidden', 	'field'=>'block' ), // 'params'=>array( 'reverse'=>true )
					 
					 'Active'			=>	array( 'type'=>'hidden', 	'field'=>'active' ), // 'params'=>array( 'reverse'=>false )
					 
					 'Gender'					=>	array( 'type'=>'block', 	'field'=>'gender', 			'params'=>array( 'reverse'=>true, 'yes'=>"М", 'no'=>"Ж", 'replace'=>array('0'=>'1', '1'=>'0') ) ),
					 
					 
					 'Extra fields'			=>	array( 'type'=>'usersExtraFields',	'field'=>'ef_groups'),
					 
					 
					 'Images'			=>	array( 'type'=>'header'),
					 
					 'User avatar'	=>	array( 'type'=>'image_mono','field'=>'avatar', 	'params'=>array( 'path'=>"/split/files/users/", 'appTable'=>$appTable, 'id'=>$item_id ) ),
					 
					 'Change password'				=>	array( 'type'=>'header'),
					 
					 'Old password'			=>	array( 'type'=>'input', 	'field'=>'old-pass', 			'params'=>array( 'size'=>25, 'hold'=>'Old password', 'type'=>'password' ) ),
					 
					 'New password'				=>	array( 'type'=>'input', 	'field'=>'new-pass', 			'params'=>array( 'size'=>25, 'hold'=>'New password', 'type'=>'password' ) ),
					 
					 'Repeat new password'	=>	array( 'type'=>'input', 	'field'=>'new-pass-r', 			'params'=>array( 'size'=>25, 'hold'=>'Repeat new password', 'type'=>'password' ) ),
					 
					 'clear-2'				=>	array( 'type'=>'clear' )
					 
					 );

	$cardEditFormParams = array( 'cardItem'=>$cardItem, 'cardTmp'=>$cardTmp, 'rootPath'=>$rootPath, 'actionName'=>"editUserCard", 'ajaxFolder'=>'edit', 'appTable'=>$appTable );
	
	$cardEditFormStr = $zh->getCardEditForm($cardEditFormParams);
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3 class='new-line'>Форма редактирования профиля</h3>";
	
	$data['bodyContent'] .= $cardEditFormStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>