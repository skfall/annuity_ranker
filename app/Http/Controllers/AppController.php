<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models as Models;
use Config;
use Request;
use Session;

use App\Rockstar\Helper as Helper;
use \App\Rockstar\Core as Core;

class AppController extends BaseController {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $locale;
    public $config;
    public $nav;
    public $top_nav;
    public $prefix;
    public $body_class;
    public $page;

    protected $core;
    protected $helper;
    
    public function __construct(){
        $FA = trim(Request::segment(1));
        if (isset(config('app.locales')[$FA])) {
            $FA = trim(Request::segment(2));
        }
        $page = $FA;
        if ($FA == '') $page = 'home';


        $this->locale = Config::get('app.locale');
        $this->locale_array = config('app.locales')[$this->locale];
        $this->prefix = $this->locale_array['prefix'];      
        $this->config = Models\Config::first(['osc_settings.*', $this->prefix.'copyright as copyright']);
        $this->nav = Models\Nav::where('block', '!=', 1)->orderBy('pos')->get(['osc_nav.*', $this->prefix.'name as name']);
        $this->top_nav = $this->nav->where('type', 0);
        $this->core = new Core();
        $this->helper = new Helper();
        $this->page = $page;

        // Global variables
        define('RS', Config::get('app.RS'));
        define('FA', $FA);
        define('DEF_LANG', Config::get('app.fallback_locale'));
        define('PREFIX', $this->prefix);
        define('PAGE', $this->page);
        define('JS', RS.'public/js/');
        define('CSS', RS.'public/css/');
        define('IMG', RS.'public/img/');
        define('UPLOAD', RS.'split/files/');
        // test

        $lang_alias = Config::get('app.routeLang');
        if ($lang_alias == '') {
            define('LANG', Config::get('app.routeLang'));
        }else{
            define('LANG', Config::get('app.routeLang').'/');
        }

        if (session()->has('online')) {
            define('ONLINE', true);
            define('UID', session()->get('online'));
        }else{
            define('ONLINE', false);
            define('UID', 0);
        }


        $this->body_class = $page;
        
        // Meta data
        $meta = [];
        $curr_nav = $this->nav->where('alias', $page)->first();

        if ($curr_nav) {
            $meta = $curr_nav->meta()->first();
        }
        $meta_array = array(
            'meta_title' => '',
            'meta_keys' => '',
            'meta_desc' => ''
        );

        if ($meta) {
            $meta = $meta->toArray();
            $meta_array = array(
                'meta_title' => $meta[$this->prefix.'meta_title'],
                'meta_keys' => $meta[$this->prefix.'meta_keys'],
                'meta_desc' => $meta[$this->prefix.'meta_desc']
            );
        }

        // Set view model
    	$viewmodel = array(
    		'config' => $this->config,
    		'nav' => $this->nav,
            'top_nav' => $this->top_nav,
            'meta' => collect($meta_array),
            'body_class' => $this->body_class
    	);

    	if (Config::get('app.multilang')) {
    		$viewmodel['languages'] = array_keys(Config::get('app.locales'));
    	}

    	view()->share($viewmodel);
    }

    public function return404($additional_data = []){
        $data = [];
        if (is_array($additional_data)) $data = array_merge($data, $additional_data);
        return response()->view('errors.404', $data, 404);
    }
}
