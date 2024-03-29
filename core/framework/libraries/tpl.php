<?php

class Tpl
{
    /**
     * 单件对象
     */
    private static $instance = null;
    /**
     * 输出模板内容的数组，其他的变量不允许从程序中直接输出到模板
     */
    private static $output_value = array();
    /**
     * 模板路径设置
     */
    private static $tpl_dir = '';


    public static $tpl_val = array();


    /**
     * 默认layout
     */
    private static $layout_file = 'layout';

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (self::$instance === null || !(self::$instance instanceof Tpl)) {
            self::$instance = new Tpl();
        }
        return self::$instance;
    }


    /**
     * 设置模板目录
     *
     * @param string $dir
     * @return bool
     */
    public static function setDir($dir)
    {
        self::$tpl_dir = $dir;
        return true;
    }

    /**
     * @desc 设置页面布局文件
     * @date 2018-05-21
     * @author fzt
     * @param $layout
     * @return bool
     */
    public static function setLayout($layout)
    {
        self::$layout_file = $layout;
        return true;
    }


    public static function output($output, $input = '')
    {
        self::getInstance();
        self::$output_value[$output] = $input;
    }


    public static function assign($var, $value)
    {
        self::getInstance();
        self::$tpl_val[$var] = $value;
    }



    /**
     * @desc 输出模板页面
     * @date 2018-05-21
     * @author fzt
     * @param string $page_name 模板名
     * @param string $layout 布局文件
     * @param int $time
     * @param $tpl_dir string 模板文件目录
     */
    public static function showpage($page_name = '', $layout = '', $time = 2000,$tpl_dir='')
    {
        if(!defined('TPL_NAME')) {
            define('TPL_NAME', 'default');
        }
        self::getInstance();
        if (!empty(self::$tpl_dir)) {
            $tpl_dir = self::$tpl_dir . DS;
        }
        //获取布局文件  模板文件
        if (empty($layout)) {
            $layout = 'layout' . DS . self::$layout_file . '.php';
        } else {
            $layout = 'layout' . DS . $layout . '.php';
        }
        $layout_file = BASE_PATH . '/templates/' . TPL_NAME . DS . $layout;
        $tpl_file = BASE_PATH . '/templates/' . TPL_NAME . DS . $tpl_dir . $page_name . '.php';

        //模板文件是否存在
        if (file_exists($tpl_file)) {
            //对模板变量进行赋值
            $output = self::$output_value;
            //页头
            $output['html_title'] = $output['html_title'] != '' ? $output['html_title'] : $GLOBALS['setting_config']['site_name'];
            $output['seo_keywords'] = $output['seo_keywords'] != '' ? $output['seo_keywords'] : $GLOBALS['setting_config']['site_name'];
            $output['seo_description'] = $output['seo_description'] != '' ? $output['seo_description'] : $GLOBALS['setting_config']['site_name'];
            $output['ref_url'] = getReferer();
            Language::read('common');
            $lang = Language::getLangContent();
            //写入模板变量
            $output['_lang'] = $lang;
            header("Content-type: text/html; charset=" . CHARSET);
            //判断是否使用布局方式输出模板，如果是，那么包含布局文件，并且在布局文件中包含模板文件
            if ($layout != '') {
                if (file_exists($layout_file)) {
                    include($layout_file);
                } else {
                    $error = 'Tpl ERROR:' . 'templates' . DS . $layout . ' is not exists';
                    throw_exception($error);
                }
            } else {
                include_once($tpl_file);
            }
        } else {
            $error = 'Tpl ERROR:' . 'templates' . DS . $tpl_dir . $page_name . '.php' . ' is not exists';
            throw_exception($error);
        }
    }




    /**
     * 显示页面Trace信息
     *
     * @return array
     */
    public static function showTrace()
    {
        $trace = array();
        //当前页面
        $trace[Language::get('nc_debug_current_page')] = $_SERVER['REQUEST_URI'] . '<br>';
        //请求时间
        $trace[Language::get('nc_debug_request_time')] = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']) . '<br>';
        //系统运行时间
        $query_time = number_format((microtime(true) - StartTime), 3) . 's';
        $trace[Language::get('nc_debug_execution_time')] = $query_time . '<br>';
        //内存
        $trace[Language::get('nc_debug_memory_consumption')] = number_format(memory_get_usage() / 1024 / 1024, 2) . 'MB' . '<br>';
        //请求方法
        $trace[Language::get('nc_debug_request_method')] = $_SERVER['REQUEST_METHOD'] . '<br>';
        //通信协议
        $trace[Language::get('nc_debug_communication_protocol')] = $_SERVER['SERVER_PROTOCOL'] . '<br>';
        //用户代理
        $trace[Language::get('nc_debug_user_agent')] = $_SERVER['HTTP_USER_AGENT'] . '<br>';
        //会话ID
        $trace[Language::get('nc_debug_session_id')] = session_id() . '<br>';
        //执行日志
        $log = Log::read();
        $trace[Language::get('nc_debug_logging')] = count($log) ? count($log) . Language::get('nc_debug_logging_1') . '<br/>' . implode('<br/>', $log) : Language::get('nc_debug_logging_2');
        $trace[Language::get('nc_debug_logging')] = $trace[Language::get('nc_debug_logging')] . '<br>';
        //文件加载
        $files = get_included_files();
        $trace[Language::get('nc_debug_load_files')] = count($files) . str_replace("\n", '<br/>', substr(substr(print_r($files, true), 7), 0, -2)) . '<br>';
        return $trace;
    }

    public static function flexigridXML($flexigridXML)
    {//多频道
        $page = $flexigridXML['now_page'];
        $total = $flexigridXML['total_num'];

        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");
        header("Content-type: text/xml");
        $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
        $xml .= "<rows>";
        $xml .= "<page>$page</page>";
        $xml .= "<total>$total</total>";
        foreach ($flexigridXML['list'] as $k => $v) {
            $xml .= "<row id='" . $k . "'>";
            $xml .= "<cell><![CDATA[" . $v['operation'] . "]]></cell>";
            $xml .= "<cell><![CDATA[" . $v['channel_name'] . "]]></cell>";
            $xml .= "<cell><![CDATA[" . $v['channel_style'] . "]]></cell>";
            $xml .= "<cell><![CDATA[" . $v['gc_name'] . "]]></cell>";
            $xml .= "<cell><![CDATA[" . $v['channel_show'] . "]]></cell>";
            $xml .= "</row>";
        }

        $xml .= "</rows>";
        echo $xml;
    }

    public static function flexigridXMLfloor($flexigridXML)
    {//多频道
        $page = $flexigridXML['now_page'];
        $total = $flexigridXML['total_num'];

        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");
        header("Content-type: text/xml");
        $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
        $xml .= "<rows>";
        $xml .= "<page>$page</page>";
        $xml .= "<total>$total</total>";
        foreach ($flexigridXML['list'] as $k => $v) {
            $xml .= "<row id='" . $k . "'>";
            $xml .= "<cell><![CDATA[" . $v['operation'] . "]]></cell>";
            $xml .= "<cell><![CDATA[" . $v['web_name'] . "]]></cell>";
            $xml .= "<cell><![CDATA[" . $v['web_page'] . "]]></cell>";
            $xml .= "<cell><![CDATA[" . $v['update_time'] . "]]></cell>";
            $xml .= "<cell><![CDATA[" . $v['web_show'] . "]]></cell>";
            $xml .= "</row>";
        }

        $xml .= "</rows>";
        echo $xml;
    }
}
