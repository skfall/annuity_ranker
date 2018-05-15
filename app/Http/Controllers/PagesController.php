<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Config;

use App\Models\Annuity;
use App\Models\Question;


class PagesController extends AppController {
    
    public function __construct(){
        parent::__construct();
    }

    public function home(){
        $view_model = [];
        $annuities = Annuity::where('block', 0)->orderBy('id')->get();

        $view_model['annuities'] = $annuities;
        $view_model['questions'] = Question::where([['block', 0]])->orderBy('pos')->get();

    	return view('pages.home', $view_model);
    }

    public function manual($alias){
        echo "<pre>"; print_r($alias); echo "</pre>"; exit();
    }

}
