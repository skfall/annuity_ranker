<?php 
namespace App\Observers;

use App\Models\User;
use App\Models\UserCard;

class UserObserver {
	public function created(User $user){
		$card = new UserCard();
		$card->user_id = $user->id;
		$card->save();
	}
}