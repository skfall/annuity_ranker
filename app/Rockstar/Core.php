<?php 
namespace App\Rockstar;
use App\Rockstar\Helper as Helper;
use App;
use Config;
use Session;
use DB;
use App\Models;

class Core extends Helper {
	public function __construct(){
		parent::__construct();
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
		$annuity_id = $annuity->id;
		if ($mode == "default") {
			$age = $annuity->age;
			$spouse_age = $annuity->special_age;
			$special_active = $annuity->special_active;

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
			->where('min_amount', '<=', $annuity->default_amount)
			->where('max_amount', '>=', $annuity->default_amount)
			->orderBy('id')
			->skip(0)
			->take(30)
			->get();

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

			return $companies;
		}else{
			// 
		}
	}


}