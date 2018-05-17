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

    public function ranks(Request $request, $alias){
        
        $annuity = Annuity::where([['block', 0], ['alias', $alias]])->first();
        $annuities = Annuity::where('block', 0)->get();
        $texts = StaticText::all()->toArray();

        $url_amount = $request->input('amount');
        $url_spousal_rate = $request->input('spousal_rate');
        $url_age = $request->input('age');
        $url_spousal_age = $request->input('spousal_age');

        if ($url_amount) $annuity->default_amount = $url_amount;
        if ($url_spousal_rate) $annuity->special_active = $url_spousal_rate;
        if ($url_age) $annuity->age = $url_age;
        if ($url_spousal_age) $annuity->special_age = $url_spousal_age;

        
        $companies_result = $this->core->getCompanies('default', $annuity, compact(
            'url_amount', 'url_spousal_rate', 'url_age', 'url_spousal_age'
        ));
        $companies = $companies_result['companies'];
        $count_left = $companies_result['count_left'];

        $t = [];
        foreach($texts as $key){
            $t[$key['id']] = array('l' => ($key['link'] ? $key['link'] : false), 'v' => $key['value']);
        }

        $view_model = [
            'annuity' => $annuity,
            'annuities' => $annuities,
            'texts' => $t,
            'companies' => $companies,
            'count_left' => $count_left
        ];
 
    	return view('pages.ranks', $view_model);
    }

    public function manual($alias){

        $view_model = [
            'page' => $this->nav->where('alias', $alias)->first()
        ];
        return view('pages.manual', $view_model);
    }

}
