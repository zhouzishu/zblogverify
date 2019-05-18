<?php
function zblogverify_GetVerifyData($data) {
	$publicKey = openssl_pkey_get_public('-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAoH4uiMZYWy1sOXuq4YAA
MtyrAtUcWHOXalSAmtDs1FA2H8fTBbEF+gnvg83Byp/mIvHMIaXc7RPIniwoMgDo
Xo3H0GquBEOH4YoufIqfRFGFwnBw7V1KNv9Iw4XpmBYEboD5HT4PLuoUvSP78iWK
7kMMsYsYOVi7EPn8DbPZbvxnrDXkJmkj3l8YhGWtAjbFU7XgyEKEKBTes9fcxWSW
GCdd1jV9oXcV9EQRkRr50wMvydgIWAAWvcVZ5zzK4sZelZDaGz7yEXG/Q1F1Xp3e
GcC057CQoaEzuTQILUCypiNeQpKdzGXxwyp+Q6DAYITjyFBjQ5WbQiSaZtCPV5D9
lwIDAQAB
-----END PUBLIC KEY-----');
	$rsaDecrypted = '';
	$explodeData = explode('.', $data);
	$rsaEncrypted = $explodeData[0];
	$aesEncrypted = $explodeData[1];
	openssl_public_decrypt(base64_decode($rsaEncrypted), $rsaDecrypted, $publicKey);
	$aesInfo = explode('.', $rsaDecrypted);
	$aesKey = base64_decode($aesInfo[0]);
	$aesIv = base64_decode($aesInfo[1]);
	$hash = $aesInfo[2];
	$data = openssl_decrypt(base64_decode($aesEncrypted), 'aes-256-cbc', $aesKey, OPENSSL_RAW_DATA, $aesIv);
	if (hash_hmac('sha256', $data, 'zblogverification') === $hash) {
		return $data;
	} else {
		throw new Exception('Hash error!');
	}
}
