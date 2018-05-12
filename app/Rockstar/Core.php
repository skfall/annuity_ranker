<?php 
namespace App\Rockstar;
use App\Rockstar\Helper as Helper;
use App;
use Config;
use Session;

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


		// test
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

	public function getProjects($filter, $start = 0, $per_page = 9){
		$projects = \App\Models\Project::where($filter)->orderBy('pos', 'desc')->skip($start)->take($per_page)->get();
		return $projects;
	}

	public function getProject($id = 0){
		$id = (int)$id;
		$project = \App\Models\Project::where(['block' => 0, 'id' => $id])->first();
		return $project;
	}

	public function getSameProjects($project = null){
		$response = collect(array());
		if($project != null){
			$response = \App\Models\Project::where([['block', '!=', '1'], ['id', '!=', $project->id], ['type', $project->type]])->orderBy('pos', 'desc')->skip(0)->take(9)->get();
		}
		return $response;
	}

	public function getHomePageSections($instances){
		return [
			$instances['1']::get() ?: [],
			$instances['2']::get() ?: [],
			$instances['3']::get() ?: [],
			$instances['4']::get() ?: [],
		];
	}

	public function getServices($filter = [], ...$params){
		// $filter ~ ['id' => 2] || [['id', '>', 1], ['id', '<=', 5]]
		$instance = \App\Models\Service::where($filter);
		if ($params && $params[0] == 'home_services') {
			$instance = $instance->orderBy('id', 'desc')->skip(0)->take(6);
		}
		return $instance->get() ?: [];
	}

}