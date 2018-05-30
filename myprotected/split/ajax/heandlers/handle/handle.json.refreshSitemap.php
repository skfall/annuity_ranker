<?php 
	require_once "../../../../require.base.php";
	require_once "../../../library/AjaxHelp.php";
	$ah = new ajaxHelp($dbh);
	$data = array('status' => 'failed', 'message' => '');
	
	$root = 'https://'.$_SERVER['SERVER_NAME'].'/';
	$news = $ah->getNewsUrls();
	foreach ($news as $key => &$value) {
		$value['url'] = $root.'news/'.$value['url'];
	}
	
	$flats = array(
		array(
			'url' => $root.'flats/lion/r1/',
			'name' => 'Дом Лион | 1-к квартира'
		),
		array(
			'url' => $root.'flats/lion/r2/',
			'name' => 'Дом Лион | 2-к квартира'
		),
		array(
			'url' => $root.'flats/lion/r3/',
			'name' => 'Дом Лион | 3-к квартира'
		),
		array(
			'url' => $root.'flats/lion/rn/',
			'name' => 'Дом Лион | 2-х яр. квартира'
		),
		array(
			'url' => $root.'flats/shatel/r1/',
			'name' => 'Дом Шатель | 1-к квартира'
		),
		array(
			'url' => $root.'flats/shatel/r2/',
			'name' => 'Дом Шатель | 2-к квартира'
		),
		array(
			'url' => $root.'flats/finished/r1/',
			'name' => 'Готовые квартиры | 1-к квартира'
		),
		array(
			'url' => $root.'flats/finished/r2/',
			'name' => 'Готовые квартиры | 2-к квартира'
		)
	);
	
	$urls = array(
		array(
			'url' => $root,
			'name' => 'Главная',
			'children' => ''
		),
		array(
			'url' => $root.'about/',
			'name' => $ah->getMenuNameByTable('osc_menu', 1)['name'],
			'children' => ''
		),
		array(
			'url' => $root.'documents/',
			'name' => $ah->getMenuNameByTable('osc_menu', 2)['name'],
			'children' => ''
		),
		array(
			'url' => $root.'building-progress/',
			'name' => $ah->getMenuNameByTable('osc_menu', 3)['name'],
			'children' => ''
		),
		array(
			'url' => $root.'news/',
			'name' => $ah->getMenuNameByTable('osc_menu', 4)['name'],
			'children' => $news
		),
		array(
			'url' => $root.'contacts/',
			'name' => $ah->getMenuNameByTable('osc_menu', 5)['name'],
			'children' => ''
		),
		array(
			'url' => $root.'flats/',
			'name' => $ah->getMenuNameByTable('osc_menu', 6)['name'],
			'children' => $flats
		),
		array(
			'url' => $root.'townhouses/',
			'name' => $ah->getMenuNameByTable('osc_menu', 7)['name'],
			'children' => ''
		),
		array(
			'url' => $root.'cottages/',
			'name' => $ah->getMenuNameByTable('osc_menu', 8)['name'],
			'children' => ''
		),
		array(
			'url' => $root.'event/car/',
			'name' => $ah->getEventNameByType(8)['name'],
			'children' => ''
		),
		array(
			'url' => $root.'event/flat/',
			'name' => $ah->getEventNameByType(7)['name'],
			'children' => ''
		)
	);


	
	$xml = '<?xml version="1.0" encoding="UTF-8"?>
	<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
		foreach ($urls as $key => $value) {
			$loc = $value['url'];
			$xml .= '
				<url>
			      <loc>'.$loc.'</loc>
			   </url>
			';

			if (isset($value['children']) && $value['children']) {
				foreach ($value['children'] as $c_key => $c_value) {
					$c_loc = $c_value['url'];
					$xml .= '
						<url>
					      <loc>'.$c_loc.'</loc>
					   </url>
					';
				}
			}
		}
	   

	$xml .= '</urlset>';

	$sitemap = fopen("../../../../../sitemap.xml", "w") or die("Unable to open sitemap!");
	if (fwrite($sitemap, $xml)) {
		$data['status'] = 'success';
		$data['message'] = 'Sitemap обновлен!';
	}

	fclose($sitemap);


	echo json_encode($data);