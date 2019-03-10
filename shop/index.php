<?php
define('APP_ID', 'shop');
define('BASE_PATH',realpath(dirname(__FILE__)));
include(realpath(dirname(dirname(__FILE__))).'/global.php');
include(BASE_PATH.'/control/control.php');
include(BASE_CORE_PATH.'/app.php');

$wapurl = WAP_SITE_URL;
$agent = $_SERVER['HTTP_USER_AGENT'];
if (strpos($agent, "comFront") || strpos($agent, "iPhone") || strpos($agent, "MIDP-2.0") || strpos($agent, "Opera Mini") || strpos($agent, "UCWEB") || strpos($agent, "Android") || strpos($agent, "Windows CE") || strpos($agent, "SymbianOS")) {
    global $config;
    if (!empty($config['wap_site_url'])) {
        $url = $config['wap_site_url'];
        switch ($_GET['act']) {
            case 'goods':
                $url .= '/tmpl/product_detail.html?goods_id=' . $_GET['goods_id'];
                break;
            case 'store_list':
                $url .= '/shop.html';
                break;
            case 'show_store':
                $url .= '/tmpl/product_store.html?store_id=' . $_GET['store_id'];
                break;
        }
    } else {
        header("Location:$wapurl");
    }
    header('Location:' . $url);
    exit();
}
define('APP_SITE_URL', SHOP_SITE_URL);
define('TPL_NAME', TPL_SHOP_NAME);
define('SHOP_RESOURCE_SITE_URL', SHOP_SITE_URL . DS . 'resource');
define('SHOP_TEMPLATES_URL', SHOP_SITE_URL . '/templates/' . TPL_NAME);
define('BASE_TPL_PATH', BASE_PATH . '/templates/' . TPL_NAME);

Base::run();