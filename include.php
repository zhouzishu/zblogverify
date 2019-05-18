<?php
require ZBP_PATH . 'zb_users/plugin/zblogverify/table_data.php';
require ZBP_PATH . 'zb_users/plugin/zblogverify/decode_data.php';
#注册插件
RegisterPlugin("zblogverify","ActivePlugin_zblogverify");

function ActivePlugin_zblogverify() {
    Add_Filter_Plugin('Filter_Plugin_Admin_TopMenu', 'zblogverify_Add_TopMenu');
}
function InstallPlugin_zblogverify() {
    zblogverify_CreateTable();
}
function UninstallPlugin_zblogverify() {
    zblogverify_DelTable();
}
function zblogverify_TimeAgo( $ptime ) {
    $ptime = strtotime($ptime);
    $etime = time() - $ptime;
    if($etime < 1) return '刚刚';
    $interval = array (
        12 * 30 * 24 * 60 * 60  =>  '年前 ('.date('Y-m-d', $ptime).')',
        30 * 24 * 60 * 60       =>  '个月前 ('.date('m-d', $ptime).')',
        7 * 24 * 60 * 60        =>  '周前 ('.date('m-d', $ptime).')',
        24 * 60 * 60            =>  '天前',
        60 * 60                 =>  '小时前',
        60                      =>  '分钟前',
        1                       =>  '秒前'
    );
    foreach ($interval as $secs => $str) {
        $d = $etime / $secs;
        if ($d >= 1) {
            $r = round($d);
            return $r . $str;
        }
    };
}
function zblogverify_Add_TopMenu(&$m) {
	global $zbp;
	$a = MakeTopMenu("root", '应用验证列表', $zbp->host . "zb_users/plugin/zblogverify/main.php", "", "topmenu_zblogverify");
	array_unshift($m, $a);
}