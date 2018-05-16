<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Config;

use App\Models\Annuity;
use App\Models\StaticText;
use App\Models\Question;


class PagesController extends AppController {
    
    public function __construct(){
        parent::__construct();
    }

    public function home(){
        $view_model = [];
        $annuities = Annuity::where('block', 0)->orderBy('pos')->get();

        $view_model['annuities'] = $annuities;
        $view_model['questions'] = Question::where([['block', 0]])->orderBy('pos')->get();

    	return view('pages.home', $view_model);
    }

    public function ranks($alias){
        
        $annuity = Annuity::where([['block', 0], ['alias', $alias]])->first();
        $annuities = Annuity::where('block', 0)->get();
        $texts = StaticText::all()->toArray();

        $companies = $this->core->getCompanies('default', $annuity);

        $t = [];
        foreach($texts as $key){
            $t[$key['id']] = array('l' => ($key['link'] ? $key['link'] : false), 'v' => $key['value']);
        }

        $view_model = [
            'annuity' => $annuity,
            'annuities' => $annuities,
            'texts' => $t,
            'companies' => $companies
        ];
 
    	return view('pages.ranks', $view_model);
    }

    public function manual($alias){
        echo "<pre>"; print_r($alias); echo "</pre>"; exit();
    }

}
