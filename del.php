<?php
require '../../../zb_system/function/c_system_base.php';
require '../../../zb_system/function/c_system_admin.php';
$zbp->Load();
$action='root';
if (!$zbp->CheckRights($action)) {$zbp->ShowError(6);die();}
if (!$zbp->CheckPlugin('zblogverify')) {$zbp->ShowError(48);die();}
CheckIsRefererValid();
$verify = new zblogverify_Data;
$verify->LoadInfoByID((int) GetVars('id','GET'));
$verify->del();

$zbp->SetHint('good');
Redirect(GetVars('HTTP_REFERER','SERVER'));
