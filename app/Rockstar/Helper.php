<?php 
namespace App\Rockstar;
use Request;
use Config;

class Helper {
    function __construct() {
        $this->now = date("Y-m-d H:i:s", time());
    }

    protected $now;

    protected function check_phone($phone, $iso='ua'){
        $reg_exp = "//";
        switch($iso) {
            case 'ua':{
                $reg_exp = '/[+380]\s\([0-9]{2}\)\s[0-9]{3}-[0-9]{2}-[0-9]{2}/';
                break;
                }
            default:{
                break;
                }
        }
        return preg_match($reg_exp, $phone);
    }

    protected function check_email_valid($email = ''){
        $is_valid = false;
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) $is_valid = true;
        return $is_valid;
    }

    protected function r2($to,$ntype='e',$msg=''){
        if($msg==''){
            header("HTTP/1.1 301 Moved Permanently");
            header("location: $to"); exit;
        }
        $_SESSION['ntype']=$ntype ; $_SESSION['notify']=$msg ;
        header("HTTP/1.1 301 Moved Permanently");
        header("location: $to"); exit;
    }

    protected function post($param,$defvalue = '') {
        if(!isset($_POST[$param])) return $defvalue;
        else return $this->safedata($_POST[$param]);
    }

    private function safedata($value){
        if(!isset($value)) return '';   
        if (is_string($value)) {
            $value = trim($value);
            $value = htmlentities($value, ENT_QUOTES, 'utf-8');
        }    
        return $value;
    }

    protected function get_months($lang = '', $format = 0){
        $months = [
            'ua' => [
                ['Січня', 'Лютого', 'Березня', 'Квітня', 'Травня', 'Червеня', 'Липня', 'Серпня', 'Вересня', 'Жовтня','Листопада', 'Грудня'],
                ['Cіч.', 'Лют.', 'Бер.', 'Кві.', 'Тра.', 'Чер.', 'Лип.', 'Сер.', 'Вер.', 'Жов.', 'Лис.', 'Гру.'],
                ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'],
            ],
            'ru' => [
                ['Января', 'Февраля', 'Март', 'Апреля', 'Мая', 'Июля', 'Июня', 'Августа', 'Сентября', 'Октября','Ноября', 'Декабря'],
                ['Янв.', 'Фев.', 'Мар.', 'Апр.', 'Мая', 'Июл.', 'Июн.', 'Авг.', 'Сен.', 'Окт.', 'Ноя.', 'Дек.'],
                ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'],
            ],
            'en' => [
                ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October','November', 'December'],
                ['Jan.', 'Feb.', 'Mar.', 'Apr.', 'May', 'Jun.', 'Jul.', 'Aug.', 'Sep.', 'Oct.', 'Nov.', 'Dec.'],
                ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'],
            ],
        ];

        if ($lang == '') $lang = Config::get('app.locale');
        $lang = strtolower(trim($lang));
        if((int)$format > count($months)) $format = (count($months) - 1); 
        return array_key_exists($lang, $months) ? $months[$lang][(int)$format] : [];
    }

    public function getPagination($instance, $per_pag){
        $instance = $instance::all();
        $per_page = $per_pag;
        $cur_page = (int)request()->query('page');
        if(!$cur_page) $cur_page = 1;

        $start = ($cur_page - 1) * $per_page;
        $count_items = $instance->where('block' , 0)->count();
        $num_pages = ceil($count_items / $per_page);

        return collect(['num_pages'=>$num_pages, 'cur_page'=>$cur_page, 'start'=>$start, 'per_page'=>$per_page]);
    }

    public static function to_object($array = array()) {
        $o = new \stdClass;
        foreach ($array as $k => $v) {
            if (strlen($k)) {
               if (is_array($v)) {
                    $o->{$k} = self::to_object($v);
               }else{
                    $o->{$k} = $v;
               }
            }
        }
        return $o;
    }

    public function check_block($instance, $key){
        if (gettype($key) == "integer") {
            $field = 'id';
        }else{
            $field = 'alias';
        }
        return $instance::where([$field => $key])->first()->block;
    }
}