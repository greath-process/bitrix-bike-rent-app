<? define("NO_KEEP_STATISTIC", true);?>
<? define("NOT_CHECK_PERMISSIONS", true);?>
<? define("NEED_AUTH", true);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
if(!empty($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=='xmlhttprequest'){
	if(!$USER->IsAuthorized()){
		$res = $USER->Login(strip_tags($_POST['USER_EMAIL']), strip_tags($_POST['USER_PASSWORD']), 'Y');
		if(empty($res['MESSAGE'])){
			$result['status'] = 'success';
		}
		else{
			$result['status'] = 'error';
			$result['message'] = strip_tags($res['MESSAGE']);
		}
		echo json_encode($result);
	}
}
?>