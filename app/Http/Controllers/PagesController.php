<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Config;


class PagesController extends AppController {
    
    public function __construct(){
        parent::__construct();
    }

    public function home(){
        
    	return view('pages.home');
    }

}
