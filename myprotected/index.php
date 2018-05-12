<?php
/*	KAM STUDIO WEB TECHNOLOGIES	*/
/*	---------------------------	*/
require 'boot/boot.php';
$db = new DBManager($config);
require 'helpers/functions.php';
require 'helpers/helper.php';
$helper = new Helper($db);
$udata = $helper->checkAdminLogin();

define("WP_LOGIN", $udata['wp_login']);
define("UIDs", $udata['uid']);
$path = str_replace('\\', '/', realpath(__DIR__ . '/..'));

$exploded = explode('/', $path);
$root = $exploded[count($exploded) - 1];
$root = str_replace('public_html/', '', $root);
if ($root) {
  define('RS', '/'.$root.'/');
}else{
  define('RS', '/');
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"	/>
<meta content="KAM STUDIO" name="author"	/>
<meta content="noindex,nofollow" name="robots"	/>
<link href="favicon.png" rel="shortcut icon" />
<title>Админ-панель | Volterra</title>
<link rel="stylesheet" type="text/css" href="webroot/css/reset.css" />
<link rel="stylesheet" type="text/css" href="webroot/css/style.css" />
<link rel="stylesheet" type="text/css" href="webroot/css/animate.css" />
<link rel="stylesheet" type="text/css" href="webroot/css/remodal.css" />
<link rel="stylesheet" type="text/css" href="webroot/css/jquery_ui_1.8.css" />

<!--[if IE]>
    <link rel="stylesheet" type="text/css" href="webroot/css/styleIE.css" />
<![endif]-->
    
<script type="text/javascript" language="javascript" src="webroot/js/jquery.min.js" ></script>
<script type="text/javascript" src="webroot/js/jquery.autocomplete.js"></script>
<script type="text/javascript" src="webroot/js/jquery.inputmask.js"></script>
<script type="text/javascript" language="javascript" src="webroot/js/jquery.easing.1.3.js" ></script>
<script type="text/javascript" language="javascript" src="webroot/js/jquery.form.js" ></script>
<script type="text/javascript" language="javascript" src="webroot/js/jquery.cookie.js" ></script>
<script type="text/javascript" language="javascript" src="webroot/js/jquery-ui.js"></script>
<script type="text/javascript" language="javascript" src="webroot/js/notifications.js"></script>
<link type="text/css" rel="stylesheet" href="redactor/redactor/redactor.css" />
<script type="text/javascript" language="javascript" src="redactor/redactor/redactor.min.js"></script>

<link type="text/css" href="summernote/summernote.css" rel="stylesheet">
<script type="text/javascript" src="summernote/summernote.min.js"></script>
</head>
<body>
<script>
  var RS = "<?php echo RS ?>";
</script>
<?php
    require_once(WP_FOLDER."view.php");
?>
<div class="ajax" id="ajax-getter">&nbsp;</div>
<audio src="click_one.wav" id="sound"></audio>
<link href="webroot/bootstrap/css/global-style.css" rel="stylesheet" type="text/css" media="screen" />
<script src="webroot/bootstrap/assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="webroot/bootstrap/assets/mixitup/jquery.mixitup.js" type="text/javascript"></script>
<script src="webroot/bootstrap/assets/fancybox/jquery.fancybox.pack.js?v=2.1.5" type="text/javascript"></script>
<script type="text/javascript" src="webroot/bootstrap/js/jquery.wp.custom.js"></script>
<script type="text/javascript" src="webroot/js/remodal.js"></script>


<div class="remodal selectEventType" data-remodal-id="selectEventType">
  <p class="remodalHeader">Создание новой акции</p>
  <div class="clear"></div>
  <form action="#">
  	<select name="event_type" class="eventSelectChoose" onchange="selectEventType(this);">
  		<option class="default" value="0">Выберите тип акции</option>
  		<option value="2">Вывод баннера с привязкой к комнате</option>
  		<option value="3">Вывод таймера с привязкой к планировке квартиры</option>
  		<option value="4">Вывод инфо-блока с привязкой к планировке коттеджа</option>
  		<option value="5">Вывод таймера с привязкой к планировке таунхауза</option>
  		<option value="6">Вывод секции с привязкой к блоку таунхауза</option>
  	</select>
  </form>
</div>

<div class="remodal cottageStatusEdit" data-remodal-id="cottageStatusEdit">
  <p class="remodalHeader">Редактирование генплана коттеджей</p>
  <div class="clear"></div>
  <form action="#" method="POST" id="ct_status_form">
    <select name="ct_status" class="ct_status">
      <option class="default" value="0">Выберите статус коттеджа</option>
      <option value="1">Участок под застройку</option>
      <option value="2">В наличии</option>
      <option value="3">Продано</option>
    </select>

    <input type="hidden" name="ct_id" value="0" />

    <textarea class="ct_status_area" name="ct_text"></textarea>

    <button type="button" onclick="cottageStatusEdit();">Применить</button>
  </form>
</div>

</body>
</html>