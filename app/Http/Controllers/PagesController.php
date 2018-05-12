<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Config;
use \App\Models\Project;
use \App\Models\Nav;
use \App\Models\HomeSection1;
use \App\Models\HomeSection2;
use \App\Models\HomeSection3;
use \App\Models\HomeSection4;
use \App\Models\Service;

class PagesController extends AppController {
    
    public function __construct(){
        parent::__construct();
    }

    public function home(){
    	return view('pages.home');
    }

}
