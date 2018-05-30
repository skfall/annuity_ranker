<?php 
namespace App\Observers;

use App\Models\User;
use App\Models\UserCard;

class UserCardObserver {
	public function created(UserCard $user_card){
		$user = $user_card->user()->first();
		$user->user_card_id = $user_card->id;
		$user->save();
	}
}