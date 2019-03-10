<?php
define('APP_ID', 'admin');
define('BASE_PATH',realpath(dirname(__FILE__)));
include(realpath(dirname(dirname(__FILE__))).'/global.php');
include(BASE_PATH.'/control/control.php');
include(BASE_CORE_PATH.'/app.php');

define('TPL_NAME',TPL_ADMIN_NAME);
define('ADMIN_TEMPLATES_URL',ADMIN_SITE_URL.'/templates/'.TPL_NAME);
define('BASE_TPL_PATH',BASE_PATH.'/templates/'.TPL_NAME);
Base::run();