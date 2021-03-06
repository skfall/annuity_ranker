<?php
	/*	KLYCHA WEB TECHNOLOGIES	*/
	/*	***************************	*/
	/*	Author: Sivkovich Maxim		*/
	/*	***************************	*/
	/*	Developed: from 2013		*/
	/*	***************************	*/
	
	// Settings class
	
require("BasicHelp.php");
class articlesHelp extends BasicHelp
{
   		public $dbh;
		
		public $table;
		public $id;
		public $item;
		
		public function __construct($dbh)
		{
			parent::__construct($dbh);
			$this->dbh = $dbh;
		} 
		
		///////////////////////////////////////////
		
		// CATEGORIES
		
		///////////////////////////////////////////
		
		// Get category item
		
		public function getArtCategoriesItem($id)
		{
			$query = "SELECT M.*, (SELECT COUNT(*) FROM [pre]articles WHERE `cat_id`=M.id LIMIT 1000) as arts_quant  FROM [pre]categories as M WHERE `id`='$id' LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			return $result;
		}
	
		// Get all categories
		
		public function getArtCategories($params=array(),$typeCount=false)
		{
			// Filter params
			
			$filter_and = "";
			
			if(isset($params['filtr']['massive']))
			{
				foreach($params['filtr']['massive'] as $f_name => $f_value)
				{
					if($f_value < 0) continue;
					$filter_and .= " AND ($f_name='$f_value') ";
				}
			}
			
			// Filter like
			
			if(isset($params['filtr']['filtr_search_key']) && isset($params['filtr']['filtr_search_field']) && trim($params['filtr']['filtr_search_key']) != "")
			{
				$search_field = $params['filtr']['filtr_search_field'];
				$search_key = $params['filtr']['filtr_search_key'];
				
				$filter_and .= " AND ($search_field LIKE '%$search_key%') ";
			}
			
			// Filter sort
			
			$sort_field		= (isset($params['filtr']['sort_filtr']) ? $params['filtr']['sort_filtr'] : "M.id");
			
			$sort_vector	= (isset($params['filtr']['order_filtr']) ? $params['filtr']['order_filtr'] : "");
			
			// Order limits
			
			$limit = (isset($_COOKIE['global_on_page']) ? (int)$_COOKIE['global_on_page'] : GLOBAL_ON_PAGE);
			
			if($limit <= 0) $limit = GLOBAL_ON_PAGE;
			
			$start = (isset($params['start']) ? ($params['start']-1)*$limit : 0);
			
			if(!$typeCount)
			{
			
				$query = "SELECT M.id, M.name, M.alias, M.block,  
			
						(SELECT COUNT(*) FROM [pre]articles WHERE `cat_id`=M.id LIMIT 1000) as arts_quant 
						
						FROM [pre]categories as M  
						
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]categories as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}
		
		///////////////////////////////////////////
		
		// ARTICLES
		
		///////////////////////////////////////////
		
		// Get article item
		
		public function getArticleItem($id, $lpx="")
		{
			$lpx = ($lpx ? $lpx."_" : "");
			$query = "SELECT M.*, M.".$lpx."name as name, M.".$lpx."content as content, (SELECT name FROM [pre]categories WHERE `id`=M.cat_id LIMIT 1) as cat_name  FROM [pre]articles as M WHERE `id`='$id' LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			// Вытягиваем данные о documents
				$result['docs'] = array();
				
				$query = "SELECT id,file,crop,path,title FROM [pre]docs_ref WHERE `ref_table`='articles' AND `ref_id`=$id LIMIT 1000";
				$docsMassive = $this->rs($query);
				
				if($docsMassive)
				{
					$result['docs'] = $docsMassive;
				}
			
			return $result;
		}
	
		// Get all articles
		
		public function getArticles($params=array(),$typeCount=false)
		{
			// Filter params
			
			$filter_and = "";
			
			if(isset($params['filtr']['massive']))
			{
				foreach($params['filtr']['massive'] as $f_name => $f_value)
				{
					if($f_value < 0) continue;
					$filter_and .= " AND ($f_name='$f_value') ";
				}
			}
			
			// Filter like
			
			if(isset($params['filtr']['filtr_search_key']) && isset($params['filtr']['filtr_search_field']) && trim($params['filtr']['filtr_search_key']) != "")
			{
				$search_field = $params['filtr']['filtr_search_field'];
				$search_key = $params['filtr']['filtr_search_key'];
				
				$filter_and .= " AND ($search_field LIKE '%$search_key%') ";
			}
			
			// Filter sort
			
			$sort_field		= (isset($params['filtr']['sort_filtr']) ? $params['filtr']['sort_filtr'] : "M.id");
			
			$sort_vector	= (isset($params['filtr']['order_filtr']) ? $params['filtr']['order_filtr'] : "");
			
			// Order limits
			
			$limit = (isset($_COOKIE['global_on_page']) ? (int)$_COOKIE['global_on_page'] : GLOBAL_ON_PAGE);
			
			if($limit <= 0) $limit = GLOBAL_ON_PAGE;
			
			$start = (isset($params['start']) ? ($params['start']-1)*$limit : 0);
			
			if(!$typeCount)
			{
			
				$query = "SELECT M.id, M.name, M.alias, M.block, M.cat_id, 
			
						(SELECT name FROM [pre]categories WHERE `id`=M.cat_id LIMIT 1) as cat_name 
						
						FROM [pre]articles as M  
						
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]articles as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}
		
		// Get cats List
		
		public function getCatsList()
		{
			$query = "SELECT id,name FROM [pre]categories WHERE 1 ORDER BY id LIMIT 1000";
			return $this->rs($query);
		}
		
		///////////////////////////////////////////
		
		// BANNERS
		
		///////////////////////////////////////////
		
		// Get banner item
		
		public function getBannerItem($id, $lpx="")
		{
			$lpx = ($lpx ? $lpx."_" : "");
			$query = "SELECT M.*, M.".$lpx."alt as alt, M.".$lpx."title as title,
			(SELECT name FROM [pre]site_positions WHERE `id`=M.pos_id LIMIT 1) as pos_name  FROM [pre]banners as M WHERE `id`='$id' LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			return $result;
		}
	
		// Get all articles
		
		public function getBanners($params=array(),$typeCount=false)
		{
			// Filter params
			
			$filter_and = "";
			
			if(isset($params['filtr']['massive']))
			{
				foreach($params['filtr']['massive'] as $f_name => $f_value)
				{
					if($f_value < 0) continue;
					$filter_and .= " AND ($f_name='$f_value') ";
				}
			}
			
			// Filter like
			
			if(isset($params['filtr']['filtr_search_key']) && isset($params['filtr']['filtr_search_field']) && trim($params['filtr']['filtr_search_key']) != "")
			{
				$search_field = $params['filtr']['filtr_search_field'];
				$search_key = $params['filtr']['filtr_search_key'];
				
				$filter_and .= " AND ($search_field LIKE '%$search_key%') ";
			}
			
			// Filter sort
			
			$sort_field		= (isset($params['filtr']['sort_filtr']) ? $params['filtr']['sort_filtr'] : "M.id");
			
			$sort_vector	= (isset($params['filtr']['order_filtr']) ? $params['filtr']['order_filtr'] : "");
			
			// Order limits
			
			$limit = (isset($_COOKIE['global_on_page']) ? (int)$_COOKIE['global_on_page'] : GLOBAL_ON_PAGE);
			
			if($limit <= 0) $limit = GLOBAL_ON_PAGE;
			
			$start = (isset($params['start']) ? ($params['start']-1)*$limit : 0);
			
			if(!$typeCount)
			{
			
				$query = "SELECT M.*, 
			
						(SELECT name FROM [pre]site_positions WHERE `id`=M.pos_id LIMIT 1) as pos_name 
						
						FROM [pre]banners as M  
						
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]banners as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}
		
		///////////////////////////////////////////
		
		// Galleries
		
		///////////////////////////////////////////
		
		// Get gallery item
		
		public function getGalleryItem($id)
		{
			$query = "SELECT M.*  FROM [pre]galleries as M WHERE `id`='$id' LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			// Вытягиваем данные о картинках
				$result['images'] = array();
				
				$query = "SELECT * FROM [pre]files_ref WHERE `ref_table`='galleries' AND `ref_id`=$id LIMIT 100";
				$imagesMassive = $this->rs($query);
				
				if($imagesMassive)
				{
					$result['images'] = $imagesMassive;
				}
			
			return $result;
		}
	
		// Get all articles
		
		public function getGalleries($params=array(),$typeCount=false)
		{
			// Filter params
			
			$filter_and = "";
			
			if(isset($params['filtr']['massive']))
			{
				foreach($params['filtr']['massive'] as $f_name => $f_value)
				{
					if($f_value < 0) continue;
					$filter_and .= " AND ($f_name='$f_value') ";
				}
			}
			
			// Filter like
			
			if(isset($params['filtr']['filtr_search_key']) && isset($params['filtr']['filtr_search_field']) && trim($params['filtr']['filtr_search_key']) != "")
			{
				$search_field = $params['filtr']['filtr_search_field'];
				$search_key = $params['filtr']['filtr_search_key'];
				
				$filter_and .= " AND ($search_field LIKE '%$search_key%') ";
			}
			
			// Filter sort
			
			$sort_field		= (isset($params['filtr']['sort_filtr']) ? $params['filtr']['sort_filtr'] : "M.id");
			
			$sort_vector	= (isset($params['filtr']['order_filtr']) ? $params['filtr']['order_filtr'] : "");
			
			// Order limits
			
			$limit = (isset($_COOKIE['global_on_page']) ? (int)$_COOKIE['global_on_page'] : GLOBAL_ON_PAGE);
			
			if($limit <= 0) $limit = GLOBAL_ON_PAGE;
			
			$start = (isset($params['start']) ? ($params['start']-1)*$limit : 0);
			
			if(!$typeCount)
			{
			
				$query = "SELECT M.id, M.name, M.caption, M.block, M.dateCreate, M.dateModify
				
						FROM [pre]galleries as M  
						
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]galleries as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}
		
		
		///////////////////////////////////////////
		
		// CONTENT BLOCKS
		
		///////////////////////////////////////////
		
		// Get content block item
		
		public function getContentBlockItem($id)
		{
			$query = "SELECT M.*, (SELECT name FROM [pre]site_positions WHERE `id`=M.pos_id LIMIT 1) as pos_name  FROM [pre]content_blocks as M WHERE `id`='$id' LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			return $result;
		}
	
		// Get all articles
		
		public function getContentBlocks($params=array(),$typeCount=false)
		{
			// Filter params
			
			$filter_and = "";
			
			if(isset($params['filtr']['massive']))
			{
				foreach($params['filtr']['massive'] as $f_name => $f_value)
				{
					if($f_value < 0) continue;
					$filter_and .= " AND ($f_name='$f_value') ";
				}
			}
			
			// Filter like
			
			if(isset($params['filtr']['filtr_search_key']) && isset($params['filtr']['filtr_search_field']) && trim($params['filtr']['filtr_search_key']) != "")
			{
				$search_field = $params['filtr']['filtr_search_field'];
				$search_key = $params['filtr']['filtr_search_key'];
				
				$filter_and .= " AND ($search_field LIKE '%$search_key%') ";
			}
			
			// Filter sort
			
			$sort_field		= (isset($params['filtr']['sort_filtr']) ? $params['filtr']['sort_filtr'] : "M.id");
			
			$sort_vector	= (isset($params['filtr']['order_filtr']) ? $params['filtr']['order_filtr'] : "");
			
			// Order limits
			
			$limit = (isset($_COOKIE['global_on_page']) ? (int)$_COOKIE['global_on_page'] : GLOBAL_ON_PAGE);
			
			if($limit <= 0) $limit = GLOBAL_ON_PAGE;
			
			$start = (isset($params['start']) ? ($params['start']-1)*$limit : 0);
			
			if(!$typeCount)
			{
			
				$query = "SELECT M.id, M.name, M.alias, M.block, M.pos_id, M.startPublish, M.finishPublish, 
			
						(SELECT name FROM [pre]site_positions WHERE `id`=M.pos_id LIMIT 1) as pos_name 
						
						FROM [pre]content_blocks as M  
						
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]content_blocks as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}
		
		// Get site Positions
		
		public function getPositions()
		{
			$query = "SELECT id,name FROM [pre]site_positions WHERE 1 ORDER BY id LIMIT 1000";
			return $this->rs($query);
		}
		
		// Get menuFormats
		
		public function getMenuFormats()
		{
			$query = "SELECT id,name FROM [pre]menu_formats WHERE 1 ORDER BY id LIMIT 100";
			return $this->rs($query);
		}
		
		// Get galleries list
		
		public function getGalleriesList()
		{
			$query = "SELECT id,name FROM [pre]galleries WHERE 1 ORDER BY id LIMIT 10000";
			return $this->rs($query);
		}
		
		public function getMenuParents($item_id=0)
		{
			$query = "SELECT id,name FROM [pre]nav WHERE `parent`=0 AND `id`!='$item_id' ORDER BY id LIMIT 10000";
			return $this->rs($query);
		}
		
		///////////////////////////////////////////
		
		// FAQ
		
		///////////////////////////////////////////
		
		// Get FAQ item
		
		public function getFaqItem($id)
		{
			$query = "SELECT M.* FROM [pre]faq as M WHERE `id`='$id' LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			return $result;
		}
	
		// Get all articles
		
		public function getFAQ($params=array(),$typeCount=false)
		{
			// Filter params
			
			$filter_and = "";
			
			if(isset($params['filtr']['massive']))
			{
				foreach($params['filtr']['massive'] as $f_name => $f_value)
				{
					if($f_value < 0) continue;
					$filter_and .= " AND ($f_name='$f_value') ";
				}
			}
			
			// Filter like
			
			if(isset($params['filtr']['filtr_search_key']) && isset($params['filtr']['filtr_search_field']) && trim($params['filtr']['filtr_search_key']) != "")
			{
				$search_field = $params['filtr']['filtr_search_field'];
				$search_key = $params['filtr']['filtr_search_key'];
				
				$filter_and .= " AND ($search_field LIKE '%$search_key%') ";
			}
			
			// Filter sort
			
			$sort_field		= (isset($params['filtr']['sort_filtr']) ? $params['filtr']['sort_filtr'] : "M.id");
			
			$sort_vector	= (isset($params['filtr']['order_filtr']) ? $params['filtr']['order_filtr'] : "");
			
			// Order limits
			
			$limit = (isset($_COOKIE['global_on_page']) ? (int)$_COOKIE['global_on_page'] : GLOBAL_ON_PAGE);
			
			if($limit <= 0) $limit = GLOBAL_ON_PAGE;
			
			$start = (isset($params['start']) ? ($params['start']-1)*$limit : 0);
			
			if(!$typeCount)
			{
			
				$query = "SELECT M.id, M.question, M.answer, M.block, M.order_id, M.dateCreate 
			
						FROM [pre]faq as M  
						
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]faq as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}
		
		///////////////////////////////////////////
		
		// HOME MENU SECTIONS
		
		///////////////////////////////////////////
		
		// Get HOME MENU SECTIONS item
		
		public function getMenuHomeSectionsItem($id)
		{
			$query = "SELECT M.* FROM [pre]menu_home as M WHERE `id`='$id' LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			return $result;
		}
	
		// Get all HOME MENU SECTIONS
		
		public function getMenuHomeSections($params=array(),$typeCount=false)
		{
			// Filter params
			
			$filter_and = "";
			
			if(isset($params['filtr']['massive']))
			{
				foreach($params['filtr']['massive'] as $f_name => $f_value)
				{
					if($f_value < 0) continue;
					$filter_and .= " AND ($f_name='$f_value') ";
				}
			}
			
			// Filter like
			
			if(isset($params['filtr']['filtr_search_key']) && isset($params['filtr']['filtr_search_field']) && trim($params['filtr']['filtr_search_key']) != "")
			{
				$search_field = $params['filtr']['filtr_search_field'];
				$search_key = $params['filtr']['filtr_search_key'];
				
				$filter_and .= " AND ($search_field LIKE '%$search_key%') ";
			}
			
			// Filter sort
			
			$sort_field		= (isset($params['filtr']['sort_filtr']) ? $params['filtr']['sort_filtr'] : "M.id");
			
			$sort_vector	= (isset($params['filtr']['order_filtr']) ? $params['filtr']['order_filtr'] : "");
			
			// Order limits
			
			$limit = (isset($_COOKIE['global_on_page']) ? (int)$_COOKIE['global_on_page'] : GLOBAL_ON_PAGE);
			
			if($limit <= 0) $limit = GLOBAL_ON_PAGE;
			
			$start = (isset($params['start']) ? ($params['start']-1)*$limit : 0);
			
			if(!$typeCount)
			{
			
				$query = "SELECT M.* 
			
						FROM [pre]menu_home as M  
						
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]menu_home as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}
		
		///////////////////////////////////////////
		
		// CONTENT BLOCKS
		
		///////////////////////////////////////////
		
		// Get content block item
		
		public function getMenuItem($id, $lpx="")
		{
			$lpx = ($lpx ? $lpx."_" : "");
			$query = "
				SELECT M.*, M.".$lpx."name as name, 
				IFNULL((SELECT `name` FROM `osc_nav` WHERE id = M.parent LIMIT 1), '&#9875;') as parent_name,
				(SELECT meta_title FROM `osc_meta` AS META WHERE META.alias = M.alias LIMIT 1) as meta_title, 
				(SELECT meta_keys FROM `osc_meta` AS META WHERE META.alias = M.alias LIMIT 1) as meta_keys, 
				(SELECT meta_desc FROM `osc_meta` AS META WHERE META.alias = M.alias LIMIT 1) as meta_desc
				FROM [pre]nav as M 
				WHERE 
					`id`='$id' 
				LIMIT 1
				";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			// Вытягиваем данные о картинках
				$result['docs'] = array();
				
				$query = "SELECT id,file,crop,path FROM [pre]docs_ref WHERE `ref_table`='menu' AND `ref_id`=$id LIMIT 1000";
				$docsMassive = $this->rs($query);
				
				if($docsMassive)
				{
					$result['docs'] = $docsMassive;
				}
			
			return $result;
		}
	
		// Get all articles
		
		public function getMenu($params=array(),$typeCount=false)
		{
			// Filter params
			
			$filter_and = "";
			
			if(isset($params['filtr']['massive']))
			{
				foreach($params['filtr']['massive'] as $f_name => $f_value)
				{
					if($f_value < 0) continue;
					$filter_and .= " AND ($f_name='$f_value') ";
				}
			}
			
			// Filter like
			
			if(isset($params['filtr']['filtr_search_key']) && isset($params['filtr']['filtr_search_field']) && trim($params['filtr']['filtr_search_key']) != "")
			{
				$search_field = $params['filtr']['filtr_search_field'];
				$search_key = $params['filtr']['filtr_search_key'];
				
				$filter_and .= " AND ($search_field LIKE '%$search_key%') ";
			}
			
			// Filter sort
			
			$sort_field		= (isset($params['filtr']['sort_filtr']) ? $params['filtr']['sort_filtr'] : "M.id");
			
			$sort_vector	= (isset($params['filtr']['order_filtr']) ? $params['filtr']['order_filtr'] : "");
			
			// Order limits
			
			$limit = (isset($_COOKIE['global_on_page']) ? (int)$_COOKIE['global_on_page'] : GLOBAL_ON_PAGE);
			
			if($limit <= 0) $limit = GLOBAL_ON_PAGE;
			
			$start = (isset($params['start']) ? ($params['start']-1)*$limit : 0);
			
			if(!$typeCount)
			{
			
				$query = "SELECT M.*, M.".$lpx."name as name, 
						IFNULL((SELECT `name` FROM `osc_nav` WHERE id = M.parent LIMIT 1), '&#9875;') as parent_name
						FROM [pre]nav as M  
						
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]menu as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}
		
		// ARTICLE COMMENTS
		
		public function getArticleComments($params=array(),$typeCount=false)
		{
			// Filter params
			
			$filter_and = "";
			
			if(isset($params['filtr']['massive']))
			{
				foreach($params['filtr']['massive'] as $f_name => $f_value)
				{
					if($f_value < 0) continue;
					$filter_and .= " AND ($f_name='$f_value') ";
				}
			}
			
			// Filter like
			
			if(isset($params['filtr']['filtr_search_key']) && isset($params['filtr']['filtr_search_field']) && trim($params['filtr']['filtr_search_key']) != "")
			{
				$search_field = $params['filtr']['filtr_search_field'];
				$search_key = $params['filtr']['filtr_search_key'];
				
				$filter_and .= " AND ($search_field LIKE '%$search_key%') ";
			}
			
			// Filter sort
			
			$sort_field		= (isset($params['filtr']['sort_filtr']) ? $params['filtr']['sort_filtr'] : "M.id, M.block");
			
			$sort_vector	= (isset($params['filtr']['order_filtr']) ? $params['filtr']['order_filtr'] : " DESC");
			
			// Order limits
			
			$limit = (isset($_COOKIE['global_on_page']) ? (int)$_COOKIE['global_on_page'] : GLOBAL_ON_PAGE);
			
			if($limit <= 0) $limit = GLOBAL_ON_PAGE;
			
			$start = (isset($params['start']) ? ($params['start']-1)*$limit : 0);
			
			if(!$typeCount)
			{
			
				$query = "SELECT M.*,   
			
						(SELECT name FROM [pre]users WHERE `id`=M.user_id) as user_name,
						(SELECT login FROM [pre]users WHERE `id`=M.user_id) as user_email,
						(SELECT name FROM [pre]articles WHERE `id`=M.art_id) as prod_name		
						
						FROM [pre]article_comments as M  
						
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]article_comments as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}
		
		public function getArticleCommentItem($id)
		{
			$query = "SELECT M.*, 
						(SELECT name FROM [pre]users WHERE `id`=M.user_id) as user_name,
						(SELECT login FROM [pre]users WHERE `id`=M.user_id) as user_email,
						(SELECT name FROM [pre]articles WHERE `id`=M.art_id) as prod_name 
						FROM [pre]article_comments as M 
						WHERE `id`=$id 
						LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			return $result;
		}
		// Get FAQ item
		
		public function getLangItem($id)
		{
			$query = "SELECT M.block, L.name, L.alias, M.id 
			FROM [pre]site_languages as M
			LEFT JOIN [pre]languages AS L ON L.id = M.lang_id
			WHERE M.id='$id' 
			LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			return $result;
		}
	
		// Get all articles
		
		public function getLanguages($params=array(),$typeCount=false)
		{
			// Filter params
			
			$filter_and = "";
			
			if(isset($params['filtr']['massive']))
			{
				foreach($params['filtr']['massive'] as $f_name => $f_value)
				{
					if($f_value < 0) continue;
					$filter_and .= " AND ($f_name='$f_value') ";
				}
			}
			
			// Filter like
			
			if(isset($params['filtr']['filtr_search_key']) && isset($params['filtr']['filtr_search_field']) && trim($params['filtr']['filtr_search_key']) != "")
			{
				$search_field = $params['filtr']['filtr_search_field'];
				$search_key = $params['filtr']['filtr_search_key'];
				
				$filter_and .= " AND ($search_field LIKE '%$search_key%') ";
			}
			
			// Filter sort
			
			$sort_field		= (isset($params['filtr']['sort_filtr']) ? $params['filtr']['sort_filtr'] : "M.id");
			
			$sort_vector	= (isset($params['filtr']['order_filtr']) ? $params['filtr']['order_filtr'] : "");
			
			// Order limits
			
			$limit = (isset($_COOKIE['global_on_page']) ? (int)$_COOKIE['global_on_page'] : GLOBAL_ON_PAGE);
			
			if($limit <= 0) $limit = GLOBAL_ON_PAGE;
			
			$start = (isset($params['start']) ? ($params['start']-1)*$limit : 0);
			
			if(!$typeCount)
			{
			
				$query = "SELECT L.name, L.alias, M.block, M.id 
			
						FROM [pre]site_languages AS M 
						LEFT JOIN [pre]languages AS L ON L.id = M.lang_id 
						
						WHERE 1 $filter_and AND L.alias != '".DEF_LANG."'
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]site_languages as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}
		public function getAllLangs(){
			$q = "
				SELECT * FROM [pre]languages WHERE `used` = 0 LIMIT 1000 
			";
			return $this->rs($q);
		}
		public function getAvailableLangs(){
				$query = "
					SELECT L.name, L.alias, M.block, M.id 
					FROM [pre]site_languages AS M 
					LEFT JOIN [pre]languages AS L ON L.id = M.lang_id 
					WHERE 1 $filter_and AND L.alias != '".DEF_LANG."'
					ORDER BY M.id
					LIMIT 1000
				";
						
				return $this->rs($query);
		}
		public function getImageAlts($item_id, $lpx=""){
			$lpx = ($lpx ? $lpx."_" : "");
			$q = "
				SELECT M.".$lpx."data AS data
				FROM [pre]article_images_alts AS M
				WHERE M.art_id = '$item_id'
				LIMIT 1
			";
			return $this->rs($q);
		}
		///////////////////////////////////////////
		
		// PRIVACY
		
		///////////////////////////////////////////
		
		// Get PRIVACY item
		
		public function getPrivacyItem($id, $lpx="")
		{
			$lpx = ($lpx ? $lpx."_" : "");
			$query = "SELECT M.*, M.".$lpx."q as q, M.".$lpx."a as a FROM [pre]privacy as M WHERE `id`='$id' LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			return $result;
		}
	
		// Get all articles
		
		public function getPrivacy($params=array(),$typeCount=false)
		{
			// Filter params
			
			$filter_and = "";
			
			if(isset($params['filtr']['massive']))
			{
				foreach($params['filtr']['massive'] as $f_name => $f_value)
				{
					if($f_value < 0) continue;
					$filter_and .= " AND ($f_name='$f_value') ";
				}
			}
			
			// Filter like
			
			if(isset($params['filtr']['filtr_search_key']) && isset($params['filtr']['filtr_search_field']) && trim($params['filtr']['filtr_search_key']) != "")
			{
				$search_field = $params['filtr']['filtr_search_field'];
				$search_key = $params['filtr']['filtr_search_key'];
				
				$filter_and .= " AND ($search_field LIKE '%$search_key%') ";
			}
			
			// Filter sort
			
			$sort_field		= (isset($params['filtr']['sort_filtr']) ? $params['filtr']['sort_filtr'] : "M.id");
			
			$sort_vector	= (isset($params['filtr']['order_filtr']) ? $params['filtr']['order_filtr'] : "");
			
			// Order limits
			
			$limit = (isset($_COOKIE['global_on_page']) ? (int)$_COOKIE['global_on_page'] : GLOBAL_ON_PAGE);
			
			if($limit <= 0) $limit = GLOBAL_ON_PAGE;
			
			$start = (isset($params['start']) ? ($params['start']-1)*$limit : 0);
			
			if(!$typeCount)
			{
			
				$query = "SELECT M.* 
			
						FROM [pre]privacy as M  
						
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]privacy as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}
		public function getFlatItem($id)
		{
			$query = "
				SELECT 
					M.*,
					(SELECT R.name FROM `osc_sys_flats_rooms` AS R WHERE R.id = M.room_id LIMIT 1) as room_name,
					(SELECT E.name FROM `osc_sys_events` AS E WHERE E.id = M.event_id LIMIT 1) as event_name,
					(SELECT H.name FROM `osc_sys_houses` AS H WHERE H.id = M.house_id LIMIT 1) as house_name,
					(SELECT H.alias FROM `osc_sys_houses` AS H WHERE H.id = M.house_id LIMIT 1) as house_alias
				FROM [pre]sys_flats_area as M 
				WHERE 
					M.id='$id' 
				LIMIT 1
			";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			$q = "
				SELECT M.* FROM `osc_sys_layouts` AS M WHERE M.ref = '$id' LIMIT 200
			";
			$layouts = $this->rs($q);
			$result['layouts'] = ($layouts ? $layouts : array());
			$result['parts_area'] = unserialize($result['parts_area']);
			return $result;
		}

		public function getEventsByType($type){
			$q = "SELECT M.id, M.name FROM `osc_sys_events` AS M WHERE M.type = '$type' LIMIT 300";
			return $layouts = $this->rs($q);
		}
	
		// Get all articles
		
		public function getFlats($params=array(),$typeCount=false)
		{
			// Filter params
			
			$filter_and = "";
			
			if(isset($params['filtr']['massive']))
			{
				foreach($params['filtr']['massive'] as $f_name => $f_value)
				{
					if($f_value < 0) continue;
					$filter_and .= " AND ($f_name='$f_value') ";
				}
			}
			
			// Filter like
			
			if(isset($params['filtr']['filtr_search_key']) && isset($params['filtr']['filtr_search_field']) && trim($params['filtr']['filtr_search_key']) != "")
			{
				$search_field = $params['filtr']['filtr_search_field'];
				$search_key = $params['filtr']['filtr_search_key'];
				
				$filter_and .= " AND ($search_field LIKE '%$search_key%') ";
			}
			
			// Filter sort
			
			$sort_field		= (isset($params['filtr']['sort_filtr']) ? $params['filtr']['sort_filtr'] : "M.id");
			
			$sort_vector	= (isset($params['filtr']['order_filtr']) ? $params['filtr']['order_filtr'] : "");
			
			// Order limits
			
			$limit = (isset($_COOKIE['global_on_page']) ? (int)$_COOKIE['global_on_page'] : GLOBAL_ON_PAGE);
			
			if($limit <= 0) $limit = GLOBAL_ON_PAGE;
			
			$start = (isset($params['start']) ? ($params['start']-1)*$limit : 0);
			
			if(!$typeCount)
			{
			
				$query = "
					SELECT 
						M.*,
						(SELECT `name` FROM `osc_sys_flats_rooms` WHERE `id` = M.room_id LIMIT 1) as room_name,
						(SELECT H.name FROM `osc_sys_houses` AS H WHERE H.id = M.house_id LIMIT 1) as house_name,
						(SELECT H.alias FROM `osc_sys_houses` AS H WHERE H.id = M.house_id LIMIT 1) as house_alias
					FROM [pre]sys_flats_area as M  	
					WHERE 
						1 
						$filter_and 
					ORDER BY $sort_field $sort_vector 
					LIMIT $start,$limit
				";
				
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]sys_flats_area as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}
		public function getHouses(){
			return $this->rs("SELECT M.* FROM `osc_sys_houses` AS M LIMIT 100");
		}
		public function getRooms(){
			return $this->rs("SELECT M.* FROM `osc_sys_flats_rooms` AS M LIMIT 100");
		}

		public function getEventItemInfo($id){
			$query = "SELECT M.type, M.name FROM [pre]sys_events as M WHERE `id`='$id' LIMIT 1";
			$resultMassive = $this->rs($query);
			$result = ($resultMassive ? $resultMassive[0] : array());
			return $result;
		}

		public function getEventTypeName($type){
			$query = "SELECT M.name FROM `osc_sys_event_types` AS M WHERE M.id = '$type' LIMIT 1";
			$resultMassive = $this->rs($query);
			$result = ($resultMassive ? $resultMassive[0] : array());
			return $result;
		}
		
		public function getSingleEvent($id, $type){
			$q = "SELECT M.* FROM `osc_sys_events` AS M WHERE M.id = '$id' AND M.type = '$type' LIMIT 1";
			$resultArray = $this->rs($q);
			$result = ($resultArray ? $resultArray[0] : array());
			return $result;
		}
		public function getRefEvent($id, $type){
			$q = "
				SELECT M.* 
				FROM `osc_sys_events` AS M 
				WHERE M.id = '$id' AND 
				M.type = '$type' 
				LIMIT 1
			";
			$resultArray = $this->rs($q);
			$event = ($resultArray ? $resultArray[0] : array());
			$event['benefits'] = unserialize($event['benefits']);
			$q = "
				SELECT M.* FROM `osc_sys_event_items` AS M WHERE M.ref = '$id' LIMIT 200
			";
			$resultArray = $this->rs($q);
			$items = ($resultArray ? $resultArray : array());
			$result = $event;
			$result['items'] = $items;


			return $result;
		}

		public function getFlatsLayoutsForEvent(){
			$q = "
				SELECT 
					M.id, M.total_area,
					(SELECT `name` FROM `osc_sys_flats_rooms` WHERE `id` = M.room_id LIMIT 1) as room_name,
					(SELECT `name` FROM `osc_sys_houses` WHERE `id` = M.house_id LIMIT 1) as house_name 
				FROM `osc_sys_flats_area` AS M
				WHERE M.block = 0 AND M.event_id = 0
				LIMIT 1000
			";
			$layouts = $this->rs($q);
			if ($layouts) {
				return $layouts;
			}else{
				return array();
			}
		}

		public function getExFlatsLayoutsForEvent($event_id){
			$q = "
				SELECT 
					M.id, M.total_area,
					(SELECT `name` FROM `osc_sys_flats_rooms` WHERE `id` = M.room_id LIMIT 1) as room_name,
					(SELECT `name` FROM `osc_sys_houses` WHERE `id` = M.house_id LIMIT 1) as house_name 
				FROM `osc_sys_flats_area` AS M
				WHERE M.block = 0 AND M.event_id = '$event_id'
				LIMIT 1000
			";
			$layouts = $this->rs($q);
			if ($layouts) {
				return $layouts;
			}else{
				return array();
			}
		}

		public function getTonwhousesLayoutsForEvent(){
			$q = "
				SELECT 
					M.id, M.total_area,
					(SELECT `name` FROM `osc_sys_townhouses` WHERE `id` = M.townhouse_id LIMIT 1) as townhouse_name 
				FROM `osc_sys_townhouses_layouts` AS M
				WHERE M.block = 0 AND M.event_id = 0
				LIMIT 1000
			";
			$layouts = $this->rs($q);
			if ($layouts) {
				return $layouts;
			}else{
				return array();
			}
		}

		public function getExTonwhousesLayoutsForEvent($event_id){
			$q = "
				SELECT 
					M.id, M.total_area,
					(SELECT `name` FROM `osc_sys_townhouses` WHERE `id` = M.townhouse_id LIMIT 1) as townhouse_name 
				FROM `osc_sys_townhouses_layouts` AS M
				WHERE M.block = 0 AND M.event_id = '$event_id'
				LIMIT 1000
			";
			$layouts = $this->rs($q);
			if ($layouts) {
				return $layouts;
			}else{
				return array();
			}
		}

		public function getCottagesLayoutsForEvent(){
			$q = "
				SELECT 
					M.*
				FROM `osc_sys_cottages_layouts` AS M
				WHERE M.block = 0 AND M.event_id = 0
				LIMIT 1000
			";
			$layouts = $this->rs($q);
			if ($layouts) {
				return $layouts;
			}else{
				return array();
			}
		}

		public function getExCottagesLayoutsForEvent($event_id){
			$q = "
				SELECT 
					M.*
				FROM `osc_sys_cottages_layouts` AS M
				WHERE M.block = 0 AND M.event_id = '$event_id'
				LIMIT 1000
			";
			$layouts = $this->rs($q);
			if ($layouts) {
				return $layouts;
			}else{
				return array();
			}
		}

		public function getFlatsRoomsForEvent(){
			$q = "
				SELECT M.* 
				FROM `osc_sys_flats_rooms` AS M
				WHERE M.event_id = 0
				LIMIT 1000
			";
			$rooms = $this->rs($q);
			if ($rooms) {
				return $rooms;
			}else{
				return array();
			}
		}

		public function getExFlatsRoomsForEvent($event_id){
			$q = "
				SELECT M.* 
				FROM `osc_sys_flats_rooms` AS M
				WHERE M.event_id = '$event_id'
				LIMIT 1000
			";
			$rooms = $this->rs($q);
			if ($rooms) {
				return $rooms;
			}else{
				return array();
			}
		}

		public function getTownhouseBlockForEvent(){
			$q = "
				SELECT M.* 
				FROM `osc_sys_townhouses` AS M
				WHERE M.event_id = 0
				LIMIT 1000
			";
			$townhouseBlock = $this->rs($q);
			if ($townhouseBlock) {
				return $townhouseBlock;
			}else{
				return array();
			}
		}

		public function getExTownhouseBlockForEvent($event_id){
			$q = "
				SELECT M.* 
				FROM `osc_sys_townhouses` AS M
				WHERE M.event_id = '$event_id'
				LIMIT 1000
			";
			$townhouseBlock = $this->rs($q);
			if ($townhouseBlock) {
				return $townhouseBlock;
			}else{
				return array();
			}
		}

		public function getEvParticipants($type, $event_id){
			switch ($type) {
				case '2':
					$q = "SELECT M.id, M.name FROM `osc_sys_flats_rooms` as M WHERE `event_id` = '$event_id' LIMIT 1000";
					$part = $this->rs($q);
					return $part;
					break;
				case '3':
					$q = "SELECT M.id, M.total_area,
						(SELECT `name` FROM `osc_sys_flats_rooms` WHERE `id` = M.room_id LIMIT 1) as room_name,
						(SELECT `name` FROM `osc_sys_houses` WHERE `id` = M.house_id LIMIT 1) as house_name
					 FROM `osc_sys_flats_area` as M WHERE M.event_id = '$event_id' LIMIT 1000";
					$part = $this->rs($q);

					foreach ($part as $key => &$value) {
						$value['link_name'] = $value['house_name'].', '.$value['room_name'].', '.$value['total_area'].' м(2)';
					}
					return $part;
					break;
				case '4':
					$q = "SELECT M.id, M.name FROM `osc_sys_cottages_layouts` as M WHERE `event_id` = '$event_id' LIMIT 1000";
					$part = $this->rs($q);
					return $part;
					break;	
				case '5':
					$q = "SELECT M.id, M.name FROM `osc_sys_townhouses_layouts` as M WHERE `event_id` = '$event_id' LIMIT 1000";
					$part = $this->rs($q);
					return $part;
					break;
				case '6':
					$q = "SELECT M.id, M.name FROM `osc_sys_townhouses` as M WHERE `event_id` = '$event_id' LIMIT 1000";
					$part = $this->rs($q);
					return $part;
					break;
				default:
					$count = array(array('count' => 'Глобальная акция'));
					break;
			}
		}

		public function getThLayoutsParticipants($id){
			$q = "SELECT M.id, M.name FROM `osc_sys_townhouses_layouts` as M WHERE `townhouse_id` = '$id' LIMIT 1000";
			$part = $this->rs($q);
			return $part;
		}

		public function gatEventParticipantsCount($type, $event_id){
			$table = "";
			switch ($type) {
				case '2':
					$q = "SELECT COUNT(`id`) as count FROM `osc_sys_flats_rooms` WHERE `event_id` = '$event_id' LIMIT 1";
					$count = $this->rs($q);
					break;
				case '3':
					$q = "SELECT COUNT(`id`) as count FROM `osc_sys_flats_area` WHERE `event_id` = '$event_id' LIMIT 1";
					$count = $this->rs($q);
					break;
				case '4':
					$q = "SELECT COUNT(`id`) as count FROM `osc_sys_cottages_layouts` WHERE `event_id` = '$event_id' LIMIT 1";
					$count = $this->rs($q);
					break;	
				case '5':
					$q = "SELECT COUNT(`id`) as count FROM `osc_sys_townhouses_layouts` WHERE `event_id` = '$event_id' LIMIT 1";
					$count = $this->rs($q);
					break;
				case '6':
					$q = "SELECT COUNT(`id`) as count FROM `osc_sys_townhouses` WHERE `event_id` = '$event_id' LIMIT 1";
					$count = $this->rs($q);
					break;
				default:
					$count = array(array('count' => 'Глобальная акция'));
					break;
			}
			if ($count) {
				return $count[0];
			}else{
				return array();
			}

		}

		public function getThLayoutsCount($id){
			$q = "SELECT COUNT(`id`) as count FROM `osc_sys_townhouses_layouts` WHERE `townhouse_id` = '$id' LIMIT 1";
				$count = $this->rs($q);
				return $count[0];
		}
				
		public function getEvents($params=array(),$typeCount=false)
		{
			// Filter params
			
			$filter_and = "";
			
			if(isset($params['filtr']['massive'])){
				foreach($params['filtr']['massive'] as $f_name => $f_value){
					if($f_value < 0) continue;
					$filter_and .= " AND ($f_name='$f_value') ";
				}
			}
			
			// Filter like
			
			if(isset($params['filtr']['filtr_search_key']) && isset($params['filtr']['filtr_search_field']) && trim($params['filtr']['filtr_search_key']) != "")
			{
				$search_field = $params['filtr']['filtr_search_field'];
				$search_key = $params['filtr']['filtr_search_key'];
				
				$filter_and .= " AND ($search_field LIKE '%$search_key%') ";
			}
			
			// Filter sort
			
			$sort_field		= (isset($params['filtr']['sort_filtr']) ? $params['filtr']['sort_filtr'] : "M.id");
			
			$sort_vector	= (isset($params['filtr']['order_filtr']) ? $params['filtr']['order_filtr'] : "");
			
			// Order limits
			
			$limit = (isset($_COOKIE['global_on_page']) ? (int)$_COOKIE['global_on_page'] : GLOBAL_ON_PAGE);
			
			if($limit <= 0) $limit = GLOBAL_ON_PAGE;
			
			$start = (isset($params['start']) ? ($params['start']-1)*$limit : 0);
			
			if(!$typeCount)
			{
			
				$query = "SELECT M.*,
						(SELECT `name` FROM `osc_sys_event_types` WHERE `id` = M.type LIMIT 1) AS event_type  
						FROM [pre]sys_events as M
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else{
				$query = "
					SELECT COUNT(*)  
					FROM [pre]sys_events as M  
					WHERE 1 $filter_and 
					LIMIT 100000
				";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}

		public function getFlatRoomsItem($id){
			$query = "
				SELECT M.* 
				FROM [pre]sys_flats_rooms as M 
				WHERE `id`='$id' 
				LIMIT 1
			";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			return $result;
		}
	
		// Get all articles
		
		public function getFlatRooms($params=array(),$typeCount=false)
		{
			// Filter params
			
			$filter_and = "";
			
			if(isset($params['filtr']['massive']))
			{
				foreach($params['filtr']['massive'] as $f_name => $f_value)
				{
					if($f_value < 0) continue;
					$filter_and .= " AND ($f_name='$f_value') ";
				}
			}
			
			// Filter like
			
			if(isset($params['filtr']['filtr_search_key']) && isset($params['filtr']['filtr_search_field']) && trim($params['filtr']['filtr_search_key']) != "")
			{
				$search_field = $params['filtr']['filtr_search_field'];
				$search_key = $params['filtr']['filtr_search_key'];
				
				$filter_and .= " AND ($search_field LIKE '%$search_key%') ";
			}
			
			// Filter sort
			
			$sort_field		= (isset($params['filtr']['sort_filtr']) ? $params['filtr']['sort_filtr'] : "M.id");
			
			$sort_vector	= (isset($params['filtr']['order_filtr']) ? $params['filtr']['order_filtr'] : "");
			
			// Order limits
			
			$limit = (isset($_COOKIE['global_on_page']) ? (int)$_COOKIE['global_on_page'] : GLOBAL_ON_PAGE);
			
			if($limit <= 0) $limit = GLOBAL_ON_PAGE;
			
			$start = (isset($params['start']) ? ($params['start']-1)*$limit : 0);
			
			if(!$typeCount){
				$query = "
					SELECT M.*			
					FROM [pre]sys_flats_rooms as M  
					WHERE 1 $filter_and 
					ORDER BY $sort_field $sort_vector 
					LIMIT $start,$limit
				";
						
				return $this->rs($query);
				
			}else{
				$query = "
					SELECT COUNT(*)  
					FROM [pre]sys_flats_rooms as M  
					WHERE 1 $filter_and 
					LIMIT 100000
				";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}

		public function getTownhousesItem($id)
		{
			$query = "SELECT M.* FROM [pre]sys_townhouses as M WHERE `id`='$id' LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			return $result;
		}
	
		// Get all articles
		
		public function getTownhouses($params=array(),$typeCount=false)
		{
			// Filter params
			
			$filter_and = "";
			
			if(isset($params['filtr']['massive']))
			{
				foreach($params['filtr']['massive'] as $f_name => $f_value)
				{
					if($f_value < 0) continue;
					$filter_and .= " AND ($f_name='$f_value') ";
				}
			}
			
			// Filter like
			
			if(isset($params['filtr']['filtr_search_key']) && isset($params['filtr']['filtr_search_field']) && trim($params['filtr']['filtr_search_key']) != "")
			{
				$search_field = $params['filtr']['filtr_search_field'];
				$search_key = $params['filtr']['filtr_search_key'];
				
				$filter_and .= " AND ($search_field LIKE '%$search_key%') ";
			}
			
			// Filter sort
			
			$sort_field		= (isset($params['filtr']['sort_filtr']) ? $params['filtr']['sort_filtr'] : "M.id");
			
			$sort_vector	= (isset($params['filtr']['order_filtr']) ? $params['filtr']['order_filtr'] : "");
			
			// Order limits
			
			$limit = (isset($_COOKIE['global_on_page']) ? (int)$_COOKIE['global_on_page'] : GLOBAL_ON_PAGE);
			
			if($limit <= 0) $limit = GLOBAL_ON_PAGE;
			
			$start = (isset($params['start']) ? ($params['start']-1)*$limit : 0);
			
			if(!$typeCount)
			{
			
				$query = "
					SELECT M.* 
					FROM [pre]sys_townhouses as M  
					WHERE 1 $filter_and 
					ORDER BY $sort_field $sort_vector 
					LIMIT $start,$limit
				";
						
				return $this->rs($query);
				
			}else{
				$query = "
					SELECT COUNT(*)  
					FROM [pre]sys_townhouses as M  
					WHERE 1 $filter_and 
					LIMIT 100000
				";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}

		public function getTownhousesLayoutsItem($id)
		{
			$query = "SELECT M.* FROM [pre]sys_townhouses_layouts as M WHERE `id`='$id' LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());

			$result['layouts'] = array();
			$q = "SELECT M.* FROM `osc_sys_townhouses_layouts_items` AS M WHERE M.ref = '$id' LIMIT 300";
			$layouts = $this->rs($q);
			$result['layouts'] = ($layouts ? $layouts : array());
			$result['parts1_area'] = unserialize($result['parts1_area']);
			$result['parts2_area'] = unserialize($result['parts2_area']);
			$result['parts3_area'] = unserialize($result['parts3_area']);
			
			return $result;
		}
	
		// Get all articles
		
		public function getTownhousesLayouts($params=array(),$typeCount=false){
			// Filter params
			
			$filter_and = "";
			
			if(isset($params['filtr']['massive'])){
				foreach($params['filtr']['massive'] as $f_name => $f_value){
					if($f_value < 0) continue;
					$filter_and .= " AND ($f_name='$f_value') ";
				}
			}
			
			// Filter like
			
			if(isset($params['filtr']['filtr_search_key']) && isset($params['filtr']['filtr_search_field']) && trim($params['filtr']['filtr_search_key']) != "")
			{
				$search_field = $params['filtr']['filtr_search_field'];
				$search_key = $params['filtr']['filtr_search_key'];
				
				$filter_and .= " AND ($search_field LIKE '%$search_key%') ";
			}
			
			// Filter sort
			
			$sort_field		= (isset($params['filtr']['sort_filtr']) ? $params['filtr']['sort_filtr'] : "M.id");
			
			$sort_vector	= (isset($params['filtr']['order_filtr']) ? $params['filtr']['order_filtr'] : "");
			
			// Order limits
			
			$limit = (isset($_COOKIE['global_on_page']) ? (int)$_COOKIE['global_on_page'] : GLOBAL_ON_PAGE);
			
			if($limit <= 0) $limit = GLOBAL_ON_PAGE;
			
			$start = (isset($params['start']) ? ($params['start']-1)*$limit : 0);
			
			if(!$typeCount){
			
				$query = "
					SELECT M.* 
					FROM [pre]sys_townhouses_layouts as M  
					WHERE 1 $filter_and 
					ORDER BY $sort_field $sort_vector 
					LIMIT $start,$limit
				";
						
				return $this->rs($query);
			}else{
				$query = "
					SELECT COUNT(*)  
					FROM [pre]sys_townhouses_layouts as M  
					WHERE 1 $filter_and 
					LIMIT 100000
				";	
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}

		public function getThLayoutsParents($id, $free = false){
			if ($free == false) {
				$q = "SELECT M.id, M.name FROM `osc_sys_townhouses` AS M WHERE M.id = '$id' LIMIT 1000";
			}else{
				$q = "SELECT M.id, M.name FROM `osc_sys_townhouses` AS M WHERE 1 LIMIT 1000";
			}

			$parents = $this->rs($q);
			return $parents;
		}


		public function getCottagesLayoutsItem($id)
		{
			$query = "SELECT M.* FROM [pre]sys_cottages_layouts as M WHERE `id`='$id' LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());

			$result['layouts'] = array();
			$q = "SELECT M.* FROM `osc_sys_cottages_layouts_items` AS M WHERE M.ref = '$id' LIMIT 300";
			$layouts = $this->rs($q);
			$result['layouts'] = ($layouts ? $layouts : array());
			$result['parts_area'] = unserialize($result['parts_area']);
			
			return $result;
		}
	
		// Get all articles
		
		public function getCottagesLayouts($params=array(),$typeCount=false){
			// Filter params
			
			$filter_and = "";
			
			if(isset($params['filtr']['massive'])){
				foreach($params['filtr']['massive'] as $f_name => $f_value){
					if($f_value < 0) continue;
					$filter_and .= " AND ($f_name='$f_value') ";
				}
			}
			
			// Filter like
			
			if(isset($params['filtr']['filtr_search_key']) && isset($params['filtr']['filtr_search_field']) && trim($params['filtr']['filtr_search_key']) != "")
			{
				$search_field = $params['filtr']['filtr_search_field'];
				$search_key = $params['filtr']['filtr_search_key'];
				
				$filter_and .= " AND ($search_field LIKE '%$search_key%') ";
			}
			
			// Filter sort
			
			$sort_field		= (isset($params['filtr']['sort_filtr']) ? $params['filtr']['sort_filtr'] : "M.id");
			
			$sort_vector	= (isset($params['filtr']['order_filtr']) ? $params['filtr']['order_filtr'] : "");
			
			// Order limits
			
			$limit = (isset($_COOKIE['global_on_page']) ? (int)$_COOKIE['global_on_page'] : GLOBAL_ON_PAGE);
			
			if($limit <= 0) $limit = GLOBAL_ON_PAGE;
			
			$start = (isset($params['start']) ? ($params['start']-1)*$limit : 0);
			
			if(!$typeCount){
			
				$query = "
					SELECT M.* 
					FROM [pre]sys_cottages_layouts as M  
					WHERE 1 $filter_and 
					ORDER BY $sort_field $sort_vector 
					LIMIT $start,$limit
				";
						
				return $this->rs($query);
			}else{
				$query = "
					SELECT COUNT(*)  
					FROM [pre]sys_cottages_layouts as M  
					WHERE 1 $filter_and 
					LIMIT 100000
				";	
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}

		public function getEventMeta($event_type){
			$alias = ($event_type == 8 ? 'car' : ($event_type == 7 ? 'flat' : ''));
			$q = "
				SELECT 
					M.meta_title,
					M.meta_keys,
					M.meta_desc
				FROM `osc_meta_table` AS M 
				WHERE M.alias = '$alias' 
				LIMIT 1
			";
			$result = $this->rs($q);
			return $result[0];
		}

		public function getThBoxItem($id)
		{
			$query = "SELECT M.* FROM [pre]sys_th_boxes as M WHERE `id`='$id' LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());

			$result['layouts'] = array();
			$q = "SELECT M.* FROM `osc_sys_th_boxes_items` AS M WHERE M.ref = '$id' AND M.type = 1 LIMIT 300";
			$layouts = $this->rs($q);
			$result['layouts'] = ($layouts ? $layouts : array());

			$result['photos'] = array();
			$q = "SELECT M.* FROM `osc_sys_th_boxes_items` AS M WHERE M.ref = '$id' AND M.type = 2 LIMIT 300";
			$photos = $this->rs($q);
			$result['photos'] = ($photos ? $photos : array());



			
			
			
			
			return $result;
		}
	
		// Get all articles
		
		public function getThBoxes($params=array(),$typeCount=false){
			// Filter params
			
			$filter_and = "";
			
			if(isset($params['filtr']['massive'])){
				foreach($params['filtr']['massive'] as $f_name => $f_value){
					if($f_value < 0) continue;
					$filter_and .= " AND ($f_name='$f_value') ";
				}
			}
			
			// Filter like
			
			if(isset($params['filtr']['filtr_search_key']) && isset($params['filtr']['filtr_search_field']) && trim($params['filtr']['filtr_search_key']) != "")
			{
				$search_field = $params['filtr']['filtr_search_field'];
				$search_key = $params['filtr']['filtr_search_key'];
				
				$filter_and .= " AND ($search_field LIKE '%$search_key%') ";
			}
			
			// Filter sort
			
			$sort_field		= (isset($params['filtr']['sort_filtr']) ? $params['filtr']['sort_filtr'] : "M.id");
			
			$sort_vector	= (isset($params['filtr']['order_filtr']) ? $params['filtr']['order_filtr'] : "");
			
			// Order limits
			
			$limit = (isset($_COOKIE['global_on_page']) ? (int)$_COOKIE['global_on_page'] : GLOBAL_ON_PAGE);
			
			if($limit <= 0) $limit = GLOBAL_ON_PAGE;
			
			$start = (isset($params['start']) ? ($params['start']-1)*$limit : 0);
			
			if(!$typeCount){
			
				$query = "
					SELECT M.* 
					FROM [pre]sys_th_boxes as M  
					WHERE 1 $filter_and 
					ORDER BY $sort_field $sort_vector 
					LIMIT $start,$limit
				";
						
				return $this->rs($query);
			}else{
				$query = "
					SELECT COUNT(*)  
					FROM [pre]sys_th_boxes as M  
					WHERE 1 $filter_and 
					LIMIT 100000
				";	
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}


		public function getThTabs($params=array(),$typeCount=false){
			// Filter params
			
			$filter_and = "";
			
			if(isset($params['filtr']['massive'])){
				foreach($params['filtr']['massive'] as $f_name => $f_value){
					if($f_value < 0) continue;
					$filter_and .= " AND ($f_name='$f_value') ";
				}
			}
			
			// Filter like
			
			if(isset($params['filtr']['filtr_search_key']) && isset($params['filtr']['filtr_search_field']) && trim($params['filtr']['filtr_search_key']) != "")
			{
				$search_field = $params['filtr']['filtr_search_field'];
				$search_key = $params['filtr']['filtr_search_key'];
				
				$filter_and .= " AND ($search_field LIKE '%$search_key%') ";
			}
			
			// Filter sort
			
			$sort_field		= (isset($params['filtr']['sort_filtr']) ? $params['filtr']['sort_filtr'] : "M.id");
			
			$sort_vector	= (isset($params['filtr']['order_filtr']) ? $params['filtr']['order_filtr'] : "");
			
			// Order limits
			
			$limit = (isset($_COOKIE['global_on_page']) ? (int)$_COOKIE['global_on_page'] : GLOBAL_ON_PAGE);
			
			if($limit <= 0) $limit = GLOBAL_ON_PAGE;
			
			$start = (isset($params['start']) ? ($params['start']-1)*$limit : 0);
			
			if(!$typeCount){
			
				$query = "
					SELECT M.* 
					FROM [pre]th_tabs as M  
					WHERE 1 $filter_and 
					ORDER BY $sort_field $sort_vector 
					LIMIT $start,$limit
				";
						
				return $this->rs($query);
			}else{
				$query = "
					SELECT COUNT(*)  
					FROM [pre]th_tabs as M  
					WHERE 1 $filter_and 
					LIMIT 100000
				";	
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}

		public function getThTabItem($id)
		{
			$query = "SELECT M.* FROM [pre]th_tabs as M WHERE `id`='$id' LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());


			
			return $result;
		}

    	public function __destruct(){}
}
