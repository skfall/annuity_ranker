<?php 
namespace App\Rockstar;
use App\Rockstar\Helper as Helper;
use App;
use Config;
use Session;
use DB;
use App\Models;
use View;

class Core extends Helper {
	public function __construct(){
		parent::__construct();
		$this->pag_size = 30;
	}

	public function changeLang(){
		$response = array('status' => 'failed', 'new_destination' => '');
		
		$locales = array_keys(Config::get('app.locales'));
		$def_locale = Config::get('app.fallback_locale');
		$new_locale = $this->post('lang');
		$curr_page = $this->post('curr_page');
		$new_location = "";
		$exploded_uri = explode('/', $curr_page);
		$prefix = '/'.$new_locale;
		if ($new_locale == $def_locale) {
			$prefix = '';
		};

		if (in_array($exploded_uri[0], $locales)) {
			if ($exploded_uri[0] == $def_locale) {
				$new_location = '/';
			}else{
				$exploded_uri[0] = $prefix;
				$new_location = implode('/', $exploded_uri);
			}
		}else{
			$new_location = $prefix.($curr_page != '/' ? '/'.$curr_page : '');
		}

		if ($new_location == "") $new_location = "/";
		if ($new_location != "/") $new_location .= "/";

		App::setLocale($new_locale);
		$response['status'] = "success";
		$response['new_destination'] = $new_location;

		return $response;
	}

	public function register(){
		$response = array('status' => 'failed', 'reason' => '', 'message' => '');

		$email = $this->post('email');
		$phone = $this->post('phone');
		$password = $this->post('password');
		$confirm_password = $this->post('confirm_password');
		$first_name = $this->post('first_name');
		$last_name = $this->post('last_name');
		if ($this->check_email_valid($email)) {
			$check_user = App\Models\User::where('login', $email)->first();
			if (!$check_user) {
				if (function_exists('mb_strlen') ? mb_strlen($password) > 5 : strlen($password) > 5) {
					if ($password == $confirm_password) {
						if (function_exists('mb_strlen') ? mb_strlen($first_name) > 1 : strlen($first_name) > 1) {
							if (function_exists('mb_strlen') ? mb_strlen($last_name) > 1 : strlen($last_name) > 1) {
								
								$md5_password = md5($password);
								$user = new App\Models\User();
								$user->login = $email;
								$user->password = $md5_password;
								$user->first_name = $first_name;
								$user->last_name = $last_name;

								if ($user->save()) {
									$card = $user->card()->first();
									$card->email = $email;
									$card->phone = $phone;
									$card->reg_ip = $_SERVER["REMOTE_ADDR"];
									$card->last_visit_ip = $_SERVER["REMOTE_ADDR"];
									$card->last_visit_date = $this->now;
									$card->save(); 

									session()->put('online', $user->id);
									$response["status"] = "success";
								}


							}else{
								$response["reason"] = 'last_name';
								$response["message"] = 'Enter correct last name.';
							}
						}else{
							$response["reason"] = 'first_name';
							$response["message"] = 'Enter correct first name.';
						}
					}else{
						$response["reason"] = 'confirm_password';
						$response["message"] = 'Passwords are not equal.';
					}					
				}else{
					$response["reason"] = 'password';
					$response["message"] = 'Enter correct password. Min length: 6.';
				}
			}else{
				$response["reason"] = 'user_exists';
				$response["message"] = 'User with this email is already exists.';
			}
		}else{
			$response["reason"] = 'email';
			$response["message"] = 'Email is not valid.';
		}

		return $response;
	}

	public function login(){
		$response = array('status' => 'failed', 'reason' => '', 'message' => '');

		$email = $this->post('email');
		$password = $this->post('password');

		
		
		if ($this->check_email_valid($email)) {
			$user = App\Models\User::where('login', $email)->first();
			if ($user) {
				if ($user->password == md5($password)) {
					$card = $user->card()->first();
					$card->last_visit_ip = $_SERVER["REMOTE_ADDR"];
					$card->last_visit_date = $this->now;
					$card->save();

					session()->put('online', $user->id);
					$response["status"] = "success";
				}else{
					$response["reason"] = 'password';
					$response["message"] = 'Wrong password.';
				}	
			}else{
				$response["reason"] = 'user_not_found';
				$response["message"] = 'User with this email was not found.';
			}
		}else{
			$response["reason"] = 'email';
			$response["message"] = 'Email is not valid.';
		}

		return $response;
	}

	public function contact_form(){
		$response = array('status' => 'failed', 'reason' => '', 'message' => '');
		$email = $this->post('email');
		$name = $this->post('name');
		$phone = $this->post('phone');
		$message = $this->post('message');

		if (mb_strlen($name) >= 2) {
			if ($this->check_email_valid($email)) {
				if ($this->check_phone($phone)) {
					if ($message && mb_strlen($message) > 10) {
						$contact_item = new App\Models\ContactForm();
						$contact_item->name = $name;
						$contact_item->email = $email;
						$contact_item->phone = $phone;
						$contact_item->message = $message;

						if ($contact_item->save()) {
							$response['status'] = "success";
							$response['message'] = "Message have been sent.";
						}

					}else{
						$response["reason"] = 'message';
						$response["message"] = 'Message is too short.';
					}
				}else{
					$response["reason"] = 'phone';
					$response["message"] = 'Enter correct phone.';
				}
			}else{
				$response["reason"] = 'email';
				$response["message"] = 'Enter correct email.';
			}
		}else{
			$response["reason"] = 'name';
			$response["message"] = 'Enter correct name.';
		}
		

		return $response;
	}

	public function answer_entry(){
		$response = array('status' => 'failed', 'html' => '', 'message' => '');
		$question_id = (int)$this->post("question_id");
		$answer_id = (int)$this->post("answer_id");
		$ip = $_SERVER["REMOTE_ADDR"];

		$user_answer = new Models\UserAnswers();
		$user_answer->ip = $ip;
		$user_answer->question_id = $question_id;
		$user_answer->answer_id = $answer_id;
		$success = $user_answer->save();
		if($success) $response['status'] = "success";

		return $response;
	}

	public function getCompanies($mode, $annuity, $params = []){
		if (gettype($annuity) == "object") {
			$annuity_id = $annuity->id;
		}else{
			$annuity_id = 0;
		}
		if ($mode == "default") {
			
			$age = $params['url_age'] ?: $annuity->age;
			$spouse_age = $params['url_spousal_age'] ?: $annuity->special_age;
			$special_active = $params['url_spousal_rate'] ?: $annuity->special_active;
			$default_amount = $params['url_amount'] ?: $annuity->default_amount;

			$companies = Models\Company::where('block', 0)
			->whereHas('rates', function($q) use ($annuity_id, $special_active, $age, $spouse_age){
				$q->where('annuity_id', $annuity_id);
				if ($special_active == 1) {
					$min_age = min($age, $spouse_age);
					$q->where('age', $min_age);
				}else{
					$q->where('age', $age);
				}
			})
			->where('min_amount', '<=', $default_amount)
			->where('max_amount', '>=', $default_amount)
			->orderBy('name')
			->skip(0)
			->take($this->pag_size);
			$total_count = $companies->count();
			$companies = $companies
			->get();

			$count_left = $total_count - $companies->count();


			foreach ($companies as $key => &$c) {
				if ($special_active == 1) {
					$min_age = min($age, $spouse_age);
					$c{'growth_rate'} = $c->rates()->where('age', $min_age)->first()->special_rate1;
					$c{'withdrawal_rate'} = $c->rates()->where('age', $min_age)->first()->special_rate2;
				}else{
					$c{'growth_rate'} = $c->rates()->where('age', $age)->first()->rate1;
					$c{'withdrawal_rate'} = $c->rates()->where('age', $age)->first()->rate2;
				}
			}

			return [
				'companies' => $companies,
				'count_left' => $count_left
			];
		}elseif($mode == "filter"){
			$response = array('status' => 'failed', 'html' => '', 'message' => '');

			$curr_count = (int)$_POST["curr_count"];			
			$key_index = (int)$_POST["key_index"];			
			$annuity_id = (int)$_POST["annuity_id"];
			$amount = (int)$_POST["amount"];
			$spouse_rates = (int)$_POST["spouse_rate"];
			$age = (int)$_POST["age"];
			$spouse_age = (int)$_POST["spouse_age"];
			$old_url = $_POST['old_url'];

			$annuity = Models\Annuity::where([['block', 0], ['id', $annuity_id]])->first();
			if ($annuity) {
				if ($amount > 0) {
					if ($age > 0) {
						if ($spouse_rates == 1) {
							if($spouse_age <= 0){
								$response['reason'] = "bad_spouse_age";
								$response['message'] = "Enter spouse age.";
								return $response;
							}
						}

						$sort_by = 'name';
						switch ($key_index) {
							case '3':
								$sort_by = "growth_rate";
							case '4':
								$sort_by = "percent";
							case '5':
								$sort_by = "withdrawal_rate";
							case '6':
								$sort_by = "td_field_30";
							default:
								$sort_by = 'name';
								break;
						}

						if ($key_index != 0) {
							$skip = 0;
							$take = $curr_count;
						}else{
							$skip = $curr_count;
							$take = $this->pag_size;
						}
						

						$companies = Models\Company::where('block', 0)
						->whereHas('rates', function($q) use ($annuity_id, $spouse_rates, $age, $spouse_age){
							$q->where('annuity_id', $annuity_id);
							if ($spouse_rates == 1) {
								$min_age = min($age, $spouse_age);
								$q->where('age', $min_age);
							}else{
								$q->where('age', $age);
							}
						})
						->where('min_amount', '<=', $amount)
						->where('max_amount', '>=', $amount)
						->orderBy('name')
						->skip($skip)
						->take($take);
						$total_count = $companies->count();
						$companies = $companies						
						->get();

						$count_left = $total_count - $companies->count();
						
						foreach ($companies as $key => &$c) {
							if ($spouse_rates == 1) {
								$min_age = min($age, $spouse_age);
								$c{'growth_rate'} = $c->rates()->where('age', $min_age)->first()->special_rate1;
								$c{'withdrawal_rate'} = $c->rates()->where('age', $min_age)->first()->special_rate2;
							}else{
								$c{'growth_rate'} = $c->rates()->where('age', $age)->first()->rate1;
								$c{'withdrawal_rate'} = $c->rates()->where('age', $age)->first()->rate2;
							}
						}

						if (session()->has('sort_desc')) {
							$companies = $companies->sortByDesc($sort_by);
							session()->forget('sort_desc');
						}else{
							$companies = $companies->sortBy($sort_by);
							session()->put('sort_desc', 1);
						}


						

						$response['html'] = $this->getCompaniesHtml($annuity, $companies, $curr_count, $count_left);
						$response['status'] = "success";
						$response['count_left'] = $count_left;
						

						$exploded = explode('/', $old_url);
						$last = $exploded[count($exploded) - 1];
						if ($last == "") {
							$last = $exploded[count($exploded) - 2];
						}
						$last_key = array_search($last, $exploded);
							
						$exploded[$last_key] = $annuity->alias;
						$new_url = implode('/', $exploded);
						$new_url .= "?amount=".$amount."&spousal_rate=".$spouse_rates."&age=".$age."&spouse_age=".$spouse_age;
						$response['new_url'] = $new_url;

						$user_activity = new Models\UserActivity();
						$user_activity->ip = $_SERVER['REMOTE_ADDR'];
						$user_activity->type = 1;
						$user_activity->activity_state = json_encode([
							'annuity' => $annuity->name,
							'amount' => $amount,
							'spouse_rates' => $spouse_rates == 1 ? "yes" : "no",
							'age' => $age,
							'spouse_age' => $spouse_age,
						]);
						$user_activity->created = $this->now;
						$user_activity->modified = $this->now;
						$user_activity->save();

					}else{
						$response['reason'] = "bad_age";
						$response['message'] = "Enter your age.";	
					}
				}else{
					$response['reason'] = "bad_ammount";
					$response['message'] = "Enter amount.";
				}

			}else{
				$response['reason'] = "bad_annuity";
				$response['message'] = "Annuity type is not selected.";
			}

			return $response;
		}
		return false;
	}

	public function getCompaniesHtml($annuity, $companies, $curr_count, $count_left){
		$html = "";
		if ($companies->count() > 0) {
			define('RS', Config::get('app.RS'));
			define('UPLOADS', RS.'split/files/');
			$html = view('elements.companies', [
				'companies' => $companies,
				'annuity' => $annuity,
				'curr_count' => $curr_count,
				'count_left' => $count_left
			])->render();
		}else{
			if (!$curr_count) {
				$html = "
				<div class=\"r-header-holder\">
					<table class=\"r-header\">
						<tbody>
							<tr>
								<td class=\"r-cell cell-1\">
									<span class=\"text\">$annuity->col_1</span>
								</td>
								<td class=\"r-cell cell-2\">
									<span class=\"text\">$annuity->col_2</span>
								</td>
								<td class=\"r-cell cell-3\">
									<span class=\"text\">$annuity->col_3</span>
								</td>
								<td class=\"r-cell cell-4\">
									<span class=\"text\">$annuity->col_4</span>
								</td>
								<td class=\"r-cell cell-5\">
									<span class=\"text\">$annuity->col_5</span>
								</td>
								<td class=\"r-cell cell-bonus\">
									<span class=\"text\">$annuity->col_6</span>
								</td>
								<td class=\"r-cell cell-btn\">
									<span class=\"text\">$annuity->col_7</span>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<table class=\"r-main-table\">
				<tbody>
				<tr>
				<td class=\"r-cell cell-company-name\" colspan=\"7\" style=\"width: 100%;\">
				<div class=\"content\">
				<div class=\"space10\"></div>
				<h4 class=\"company-name tac\">No results</h4>
				</div>
				</td>
				</tr>
				</tbody>
				</table>
				";
			}
		}
		return $html;
	}

	private $pag_size;

}