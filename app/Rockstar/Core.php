<?php 
namespace App\Rockstar;
use App\Rockstar\Helper as Helper;
use App;
use Config;
use Session;
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

	public function get_questions(){
		$response = array('status' => 'failed', 'html' => '', 'message' => '');
		$annuity_id = $this->post('annuity_id');
		$id = 0;
		if ($annuity_id == "default") {
			$id = DEFAULT_ANNUITY_ID;
		}else{
			$id = (int)$annuity_id;
		}

		
		$annuity = Models\Annuity::find($id);
		if ($annuity) {
			$questions = $annuity->questions()->get();
			if (count($questions) > 0) {
				$html = "";
				ob_start();
				foreach ($questions as $qi => $question) { ?>
					<div class="question_item" style="background: #eee; padding: 10px; margin: 10px; float: left; border: 1px solid #333;">
						<p>Question: <?= $question->question ?></p>
						<ul style='list-style-type: circle;'><?php 
							foreach ($question->answers()->get() as $ai => $answer) { ?>
								<li onclick="network.sendAnswer('<?= $question->id ?>', '<?= $answer->id ?>', '<?= $annuity->id ?>')" style='padding: 5px; margin: 15px; border: 1px solid #333; cursor: pointer;'><?= $answer->answer ?></li>
							<?php }
						?></ul>
					</div>	
				<?php }
				$html = ob_get_clean();

				$response['status'] = "success";
				$response['reason'] = $annuity->name;
				$response['html'] = $html;

			}else{
				$response['status'] = "success";
				$response['reason'] = $annuity->name;
				$response['trigger'] = "get_form";
			}
		}else{
			$response['reason'] = "no_annuity";
			$response['message'] = "Annuity not found";
		}
		
		return $response;
	}

	public function get_annuity_form(){
		$response = array('status' => 'failed', 'html' => '', 'message' => '');
		$annuity_id = $this->post('annuity_id');
		$annuity = Models\Annuity::find((int)$annuity_id);
		$another_annuities = Models\Annuity::where('id', '!=', $annuity->id)->get();

		if ($annuity) {
			$html = "";
			ob_start(); ?>
				<div class="top_filter" style="background: #eee; padding: 10px; margin: 10px; border: 1px solid #333;">
					<div style="clear: both;"></div>
					<p>Filter place...</p>
					<div class="annuity" style="background: #ccc; padding: 10px; margin: 10px; float: left; border: 1px solid #333;">
						<?= $annuity->name ?>
					</div>

					<?php 
						foreach ($another_annuities as $ai => $an) {
							?>
								<div class="annuity" style="background: #eee; padding: 10px; margin: 10px; float: left; border: 1px solid #333; cursor: pointer;" onclick="network.get_questions('<?= $an->id ?>')">
									<?= $an->name ?>
								</div>
							<?php
						}
					?>

					<div style="clear: both;"></div>					
				</div>
				<div class="companies" style="background: #eee; padding: 10px; margin: 10px; border: 1px solid #333;">
					<?php 
						$companies = Models\Company::where('block', 0)->get();
					?>
					<table style="width: 100%;">
						<tbody>
						<?php 
							if($companies){
								?>
								<tr>
									<td style="background: #ccc; padding: 10px; border: 1px solid #333;"><?= $annuity->col_1 ?></td>
									<td style="background: #ccc; padding: 10px; border: 1px solid #333;"><?= $annuity->col_2 ?></td>
									<td style="background: #ccc; padding: 10px; border: 1px solid #333;"><?= $annuity->col_3 ?></td>
									<td style="background: #ccc; padding: 10px; border: 1px solid #333;"><?= $annuity->col_4 ?></td>
									<td style="background: #ccc; padding: 10px; border: 1px solid #333;"><?= $annuity->col_5 ?></td>
								</tr>
								<?php
								foreach ($companies as $ci => $cv) {
									$rate = $cv->rates()->where([['company_id', $cv->id], ['annuity_id', $annuity->id]])->first();
									if (!$rate) continue;

									?>
										<tr>
											<td style="background: #eee; padding: 10px; border: 1px solid #333;"><?= $cv->name ?></td>
											<td style="background: #eee; padding: 10px; border: 1px solid #333;"><?= $rate->rate1 ?>%</td>
											<td style="background: #eee; padding: 10px; border: 1px solid #333;"><?= $cv->percent ?>%</td>
											<td style="background: #eee; padding: 10px; border: 1px solid #333;"><?= $rate->rate2 ?>%</td>
											<td style="background: #eee; padding: 10px; border: 1px solid #333;"><?= $cv->created ?></td>
										</tr>
									<?php
								}
							}else{
								?>
									<tr><td colspan="5" style="background: #eee; padding: 10px; border: 1px solid #333;">There is no companies by this annuity.</td></tr>
								<?php
							}
						?>
						</tbody>
					</table>
				</div>
			<?php $html = ob_get_clean();
			$response['html'] = $html;			
			$response['status'] = "success";
			$response['message'] = $annuity->name;
		}else{
			$response['reason'] = "no_annuity";
			$response['message'] = "Annuity not found";
		}
		return $response;
	}

}