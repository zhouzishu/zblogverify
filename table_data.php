<?php
$table['zblogverify_Data']    = '%pre%zblogverify_Data';
$datainfo['zblogverify_Data'] = array(
	'ID' => array('Verify_ID', 'integer', '', 0),
	'UniqidID' => array('Verify_UniqidID', 'string', 255, ''),
	'from' => array('Verify_from', 'string', 50, ''),
	'error_number' => array('Verify_error_number', 'integer', '', 0),
	'error_message' => array('Verify_error_message', 'string', 255, ''),
	'error_verified' => array('Verify_error_verified', 'integer', '', 0),
	'error_cracking' => array('Verify_error_cracking', 'integer', '', 0),
	'error_user_message' => array('Verify_error_user_message', 'string', 255, ''),
	'appId' => array('Verify_appId', 'string', 255, ''),
	'host' => array('Verify_host', 'string', 255, ''),
	'user_id' => array('Verify_user_id', 'string', 255, ''),
	'user_name' => array('Verify_user_name', 'string', 255, ''),
	'modified' => array('Verify_modified', 'string', 255, ''),
	'license_appId' => array('Verify_license_appId', 'string', 255, ''),
	'license_userId' => array('Verify_license_userId', 'string', 255, ''),
	'license_timestamp' => array('Verify_license_timestamp', 'string', 255, ''),
	'Time' => array('Verify_Time', 'string', '', ''),
);

class zblogverify_Data extends Base {
	function __construct() {
		global $zbp;
		parent::__construct($zbp->table['zblogverify_Data'], $zbp->datainfo['zblogverify_Data']);
	}
	public function __set($name, $value) {
		global $zbp;
		parent::__set($name, $value);
	}
	public function __get($name) {
		global $zbp;
		return parent::__get($name);
	}
	public function VerifyStatus($verified){
	    global $bloghost;
	    $isverify = $bloghost.'zb_system/image/admin/tick.png';
	    $isnotverify = $bloghost.'zb_system/image/admin/exclamation.png';
	    if($verified){
	        echo $isverify;
	    }else{
	        echo $isnotverify;
	    }
	}
	function Save() {
		return parent::Save();
	}
	function Del() {
		return parent::Del();
	}

}

function zblogverify_CreateTable() {
	global $zbp;
	if ($zbp->db->ExistTable($GLOBALS['table']['zblogverify_Data']) == false) {
		$s = $zbp->db->sql->CreateTable($GLOBALS['table']['zblogverify_Data'], $GLOBALS['datainfo']['zblogverify_Data']);
		$zbp->db->QueryMulit($s);
	}
}

function zblogverify_DelTable() {
	global $zbp;
	if ($zbp->db->ExistTable($zbp->table['zblogverify_Data']) == true) {
		$s = $zbp->db->sql->DelTable($zbp->table['zblogverify_Data']);
		$zbp->db->QueryMulit($s);
	}
}
