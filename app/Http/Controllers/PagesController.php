<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Config;

use App\Models\Annuity;


class PagesController extends AppController {
    
    public function __construct(){
        parent::__construct();
    }

    public function home(){
        $view_model = [];
        $annuities = Annuity::where('block', 0)->orderBy('id')->get();

        if ($annuities) {
            $view_model['annuities'] = $annuities;
        }

    	return view('pages.home', $view_model);
    }

}
