<?php
	/*	KLYCHA WEB TECHNOLOGIES	*/
	/*	***************************	*/
	/*	Author: Sivkovich Maxim		*/
	/*	***************************	*/
	/*	Developed: from 2013		*/
	/*	***************************	*/
	
	// Settings class
	
require("BasicHelp.php");
class Ranker extends BasicHelp {
   		public $dbh;
		
		public $table;
		public $id;
		public $item;
		
		public function __construct($dbh) {
			parent::__construct($dbh);
			$this->dbh = $dbh;
		} 

		public function setSeen($item_id = 0, $table = ""){
			if($item_id > 0 && $table != ""){
				$item_id = (int)$item_id;
				try	{
					$q = "UPDATE $table SET seen = 1 WHERE id = ".$item_id;
					$this->rs($q);
				} catch (Exception $e){
					return "";
				}
			}
		}

		public function getAnnuity($id) {
			$query = "
				SELECT M.* 
				FROM [pre]annuities as M 
				WHERE `id`='$id' 
				LIMIT 1
			";
			$resultMassive = $this->rs($query);
			$result = ($resultMassive ? $resultMassive[0] : array());
			return $result;
		}

		public function getAnnuities($params=array(),$typeCount=false) {
			$filter_and = "";
			if(isset($params['filtr']['massive'])) {
				foreach($params['filtr']['massive'] as $f_name => $f_value) {
					if($f_value < 0) continue;
					$filter_and .= " AND ($f_name='$f_value') ";
				}
			}
			if(isset($params['filtr']['filtr_search_key']) && isset($params['filtr']['filtr_search_field']) && trim($params['filtr']['filtr_search_key']) != "") {
				$search_field = $params['filtr']['filtr_search_field'];
				$search_key = $params['filtr']['filtr_search_key'];
				$filter_and .= " AND ($search_field LIKE '%$search_key%') ";
			}
			$sort_field		= (isset($params['filtr']['sort_filtr']) ? $params['filtr']['sort_filtr'] : "M.id");
			$sort_vector	= (isset($params['filtr']['order_filtr']) ? $params['filtr']['order_filtr'] : "");
			$limit = (isset($_COOKIE['global_on_page']) ? (int)$_COOKIE['global_on_page'] : GLOBAL_ON_PAGE);
			if($limit <= 0) $limit = GLOBAL_ON_PAGE;
			$start = (isset($params['start']) ? ($params['start']-1)*$limit : 0);
			if(!$typeCount) {
				$query = "SELECT M.* 
						FROM [pre]annuities as M  
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
				return $this->rs($query);
			}else{
				$query = "SELECT COUNT(*)  
						FROM [pre]annuities as M  
						WHERE 1 $filter_and 
						LIMIT 100000";	
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}

		public function getCompany($id) {
			$query = "
				SELECT M.* 
				FROM [pre]companies as M 
				WHERE `id`='$id' 
				LIMIT 1
			";
			$resultMassive = $this->rs($query);
			$result = ($resultMassive ? $resultMassive[0] : array());
			return $result;
		}

		public function getCompanies($params=array(),$typeCount=false) {
			$filter_and = "";
			if(isset($params['filtr']['massive'])) {
				foreach($params['filtr']['massive'] as $f_name => $f_value) {
					if($f_value < 0) continue;
					$filter_and .= " AND ($f_name='$f_value') ";
				}
			}
			if(isset($params['filtr']['filtr_search_key']) && isset($params['filtr']['filtr_search_field']) && trim($params['filtr']['filtr_search_key']) != "") {
				$search_field = $params['filtr']['filtr_search_field'];
				$search_key = $params['filtr']['filtr_search_key'];
				$filter_and .= " AND ($search_field LIKE '%$search_key%') ";
			}
			$sort_field		= (isset($params['filtr']['sort_filtr']) ? $params['filtr']['sort_filtr'] : "M.id");
			$sort_vector	= (isset($params['filtr']['order_filtr']) ? $params['filtr']['order_filtr'] : "");
			$limit = (isset($_COOKIE['global_on_page']) ? (int)$_COOKIE['global_on_page'] : GLOBAL_ON_PAGE);
			if($limit <= 0) $limit = GLOBAL_ON_PAGE;
			$start = (isset($params['start']) ? ($params['start']-1)*$limit : 0);
			if(!$typeCount) {
				$query = "SELECT M.* 
						FROM [pre]companies as M  
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector DESC  
						LIMIT $start,$limit";
				return $this->rs($query);
			}else{
				$query = "SELECT COUNT(*)  
						FROM [pre]companies as M  
						WHERE 1 $filter_and 
						LIMIT 100000";	
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}

		public function getAnnuitiesList(){
			$q = "SELECT M.* FROM `osc_annuities` AS M";
			return $this->rs($q);
		}

		public function getCompaniesList(){
			$q = "SELECT M.id, M.name FROM `osc_companies` AS M";
			return $this->rs($q);
		}

		

		public function getCompanyRates($company_id){
			$c_id = (int)$company_id;

			$q = "SELECT DISTINCT M.annuity_id FROM `osc_rates`AS M WHERE M.company_id = $c_id";
			$annuity_ids = $this->rs($q);
			$rates = [];
			foreach ($annuity_ids as $ai => $av) {
				$aid = $av['annuity_id'];
				$q = "SELECT M.* FROM `osc_annuities` AS M WHERE M.id = $aid LIMIT 1";
				$annuity = $this->rs($q);
				$curr_annuity_id = $annuity[0]['id'];
				
				$q = "SELECT M.age as Age, M.rate1 as Growth_Rate , M.special_rate1 as Growth_Rate_SPECIAL, M.rate2 as Withdrawal_Rate , M.special_rate2 as Withdrawal_Rate_SPECIAL, M.modified as Updated FROM `osc_rates` AS M WHERE M.company_id = $c_id AND M.annuity_id = $curr_annuity_id";


				$rates[$annuity[0]['name']] = $this->rs($q);

			}
			
			return $rates;
		}

		public function getTab($id) {
			$query = "
				SELECT M.*,  
				(SELECT `name` FROM `osc_companies` WHERE `id` = M.company_id LIMIT 1) as company_name  
				FROM [pre]tabs as M 
				WHERE `id`='$id' 
				LIMIT 1
			";
			$resultMassive = $this->rs($query);
			$result = ($resultMassive ? $resultMassive[0] : array());
			return $result;
		}

		public function getTabs($params=array(),$typeCount=false) {
			$filter_and = "";
			if(isset($params['filtr']['massive'])) {
				foreach($params['filtr']['massive'] as $f_name => $f_value) {
					if($f_value < 0) continue;
					$filter_and .= " AND ($f_name='$f_value') ";
				}
			}
			if(isset($params['filtr']['filtr_search_key']) && isset($params['filtr']['filtr_search_field']) && trim($params['filtr']['filtr_search_key']) != "") {
				$search_field = $params['filtr']['filtr_search_field'];
				$search_key = $params['filtr']['filtr_search_key'];
				$filter_and .= " AND ($search_field LIKE '%$search_key%') ";
			}
			$sort_field		= (isset($params['filtr']['sort_filtr']) ? $params['filtr']['sort_filtr'] : "M.id");
			$sort_vector	= (isset($params['filtr']['order_filtr']) ? $params['filtr']['order_filtr'] : "");
			$limit = (isset($_COOKIE['global_on_page']) ? (int)$_COOKIE['global_on_page'] : GLOBAL_ON_PAGE);
			if($limit <= 0) $limit = GLOBAL_ON_PAGE;
			$start = (isset($params['start']) ? ($params['start']-1)*$limit : 0);
			if(!$typeCount) {
				$query = "SELECT M.*, 
						(SELECT `name` FROM `osc_companies` WHERE `id` = M.company_id LIMIT 1) as company_name
						FROM [pre]tabs as M  
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector DESC 
						LIMIT $start,$limit";
				return $this->rs($query);
			}else{
				$query = "SELECT COUNT(*)  
						FROM [pre]tabs as M  
						WHERE 1 $filter_and 
						LIMIT 100000";	
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}

		public function getQuestion($id) {
			$query = "
				SELECT M.*,  
				(SELECT `name` FROM `osc_annuities` WHERE `id` = M.annuity_id LIMIT 1) as annuity_name  
				FROM `osc_questions` as M 
				WHERE `id`='$id' 
				LIMIT 1
			";
			$resultMassive = $this->rs($query);
			$result = ($resultMassive ? $resultMassive[0] : array());
			return $result;
		}

		public function getQuestions($params=array(),$typeCount=false) {
			$filter_and = "";
			if(isset($params['filtr']['massive'])) {
				foreach($params['filtr']['massive'] as $f_name => $f_value) {
					if($f_value < 0) continue;
					$filter_and .= " AND ($f_name='$f_value') ";
				}
			}
			if(isset($params['filtr']['filtr_search_key']) && isset($params['filtr']['filtr_search_field']) && trim($params['filtr']['filtr_search_key']) != "") {
				$search_field = $params['filtr']['filtr_search_field'];
				$search_key = $params['filtr']['filtr_search_key'];
				$filter_and .= " AND ($search_field LIKE '%$search_key%') ";
			}
			$sort_field		= (isset($params['filtr']['sort_filtr']) ? $params['filtr']['sort_filtr'] : "M.id");
			$sort_vector	= (isset($params['filtr']['order_filtr']) ? $params['filtr']['order_filtr'] : "");
			$limit = (isset($_COOKIE['global_on_page']) ? (int)$_COOKIE['global_on_page'] : GLOBAL_ON_PAGE);
			if($limit <= 0) $limit = GLOBAL_ON_PAGE;
			$start = (isset($params['start']) ? ($params['start']-1)*$limit : 0);
			if(!$typeCount) {
				$query = "SELECT M.*, 
						(SELECT `name` FROM `osc_annuities` WHERE `id` = M.annuity_id LIMIT 1) as annuity_name
						FROM `osc_questions` as M  
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector DESC 
						LIMIT $start,$limit";
				return $this->rs($query);
			}else{
				$query = "SELECT COUNT(*)  
						FROM `osc_questions` as M  
						WHERE 1 $filter_and 
						LIMIT 100000";	
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}
		
    	public function __destruct(){}
}
