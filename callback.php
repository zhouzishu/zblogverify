<?php
require '../../../zb_system/function/c_system_base.php';
$zbp->Load();
if (!$zbp->CheckPlugin('zblogverify')) {$zbp->ShowError(48);die();}
header('Content-Type: application/zblogverify');

$info = zblogverify_GetVerifyData(file_get_contents('php://input'));
$info_array = json_decode($info,true);

$where = array();
$where[] = array('=', 'Verify_appId', $info_array['appId']);
$where[] = array('=', 'Verify_host', $info_array['host']);
$selectsql = $zbp->db->sql->Select($table['zblogverify_Data'],'*',$where,null,null,null);
$array = $zbp->GetListType('zblogverify_Data', $selectsql);

if(count($array)>0){
	$sql = $zbp->db->sql->Update($table['zblogverify_Data'],$datainfo['zblogverify_Data'],$where);
	$zbp->db->Update($sql);
    die('ok');
}

$verify_data = new zblogverify_Data;
$verify_data->UniqidID = $info_array['id'];
$verify_data->from = $info_array['from'];
$verify_data->error_number = $info_array['error']['number'];
$verify_data->error_message = $info_array['error']['message'];
$verify_data->error_verified = $info_array['error']['verified'];
$verify_data->error_cracking = $info_array['error']['cracking'];
$verify_data->error_user_message = $info_array['error']['user']['message'];
$verify_data->appId = $info_array['appId'];
$verify_data->host = $info_array['host'];
$verify_data->user_id = $info_array['user']['id'];
$verify_data->user_name = $info_array['user']['username'];
$verify_data->modified = $info_array['modified'];
$verify_data->license_appId = $info_array['license']['appId'];
$verify_data->license_userId = $info_array['license']['userId'];
$verify_data->license_timestamp = $info_array['license']['timestamp'];
$verify_data->Time = time();
$verify_data->Save();

if ($info_array['error']['verified']) {
	echo 'ok';
}
