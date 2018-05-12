<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Rockstar\Core as Core;

class AjaxController extends BaseController {
    public function reception(Request $request){
        $action = $request->input('action');
    	$core = new Core();
    	$response = array('status' => 'failed');
    	switch ($action) {
    		case 'change_lang':
    			$response = $core->changeLang();
    			break;
            case 'register':
                $response = $core->register();
                break;
            case 'login':
                $response = $core->login();
                break;
            case 'contact_form':
                $response = $core->contact_form();
                break;
    		default:
    			break;
    	}
    	return collect($response)->toJson();
    }
}