<?php 
	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'appTable'=>$appTable );
	$data['headContent'] = $zh->getLandingHeader($headParams);

	$itemsList = $zh->getAnswers($params);
	$totalItems = $zh->getAnswers($params,true);

	
	$on_page = (isset($_COOKIE['global_on_page']) ? $_COOKIE['global_on_page'] : GLOBAL_ON_PAGE);
	$pages = ceil($totalItems/$on_page);
	$start_page = (isset($params['start']) ? $params['start'] : 1);
	
	$frst_page = 1;
	$prev_page = 1;
	$next_page = $pages;
	$last_page = $pages;
				
	if($start_page < $pages) $next_page = $start_page+1;
	if($start_page > 1) $prev_page = $start_page-1;

	if(isset($_COOKIE['filter-1']) && $_COOKIE['filter-1']) $data['filter']['f1'] = 1;
	if(isset($_COOKIE['filter-2']) && $_COOKIE['filter-2']) $data['filter']['f2'] = 1;
	if(isset($_COOKIE['filter-3']) && $_COOKIE['filter-3']) $data['filter']['f3'] = 1;

	$filter1_options = array( 'By ID'=>'M.id', 'By Answer'=>'M.answer', 'By Question'=>'Q.question', 'By Annuity'=>'A.name' );
	$filter2_options = array( 
								'Publish' => array( 'fieldName'=>'M.block', 'params' => array('Yes'=>'0', 'No'=>'1') )
							);
	$filter3_options = array( 
							'sort' => array( 'ID'=>'id', 'By Answer'=>'answer', 'By Question'=>'question', 'By Annuity'=>'annuity_name',),
							'order' => array( 'По возрастанию'=>'', 'По убыванию'=>' DESC' ) 
							);
	$filterFormParams = array(	'params'=>$params, 
								'headParams'=>$headParams, 
								'filter1_options'=>$filter1_options, 
								'filter2_options'=>$filter2_options, 
								'filter3_options'=>$filter3_options, 
								'on_page'=>$on_page 
							  );
	
	$filterFormStr = $zh->getLandingFilterForm($filterFormParams);

	$tableColumns = array(
						  'Checkbox'			=>	array('type'=>'checkbox',	'field'=>''),
						  'Answer'				=>	array('type'=>'text',		'field'=>'answer'),
						  'Question'				=>	array('type'=>'text',		'field'=>'question'),
						  'Annuity name'				=>	array('type'=>'text',		'field'=>'annuity_name'),
						  'Display order'				=>	array('type'=>'text',		'field'=>'pos'),
						  'Published'			=>	array('type'=>'block',		'field'=>'block'),
						  'View'			=>	array('type'=>'cardView',	'field'=>'Смотреть'),
						  'Edit'		=>	array('type'=>'cardEdit',	'field'=>'Редактировать'),
						  'ID'					=>	array('type'=>'text',		'field'=>'id')
						  );
	
	$tableParams = array( 'itemsList'=>$itemsList, 'tableColumns'=>$tableColumns, 'headParams'=>$headParams );
	
	$tableStr = $zh->getItemsTable($tableParams);
	
	// START PAGINATION
	
	$pagiParams = array( 'headParams'=>$headParams, 'start_page'=>$start_page, 'pages'=>$pages, 'on_page'=>$on_page );
	
	$pagiStr = $zh->getLandingPagination($pagiParams);
	
	// Join Content
	
	$data['bodyContent'] = $filterFormStr;
	
	$data['bodyContent'] .= $tableStr;
	
	$data['bodyContent'] .= $pagiStr;

?>