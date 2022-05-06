<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
use Bitrix\Main\Application;
global $USER;

$request = Application::getInstance()->getContext()->getRequest();
$data = $request->getPostList()->toArray();
$arErrors = [];
/* Ошибки */
if (empty($data['USER_NAME'])) {
    $arErrors[] = '"Name" field is required';
}
if (empty($data['PERSONAL_PHONE'])) {
    $arErrors[] = '"Phone" field is required';
}
if(checkUserByEmail($data['EMAIL']) != false) // если пользователь зарегистрирован
    $arErrors[] = 'User with email ('.$data['EMAIL'].') already exists';

$default_group = COption::GetOptionString("main", "new_user_registration_def_group","");
if($default_group!="") {
    $arrGroups = explode(",", $default_group);
    $arPolicy = $USER->GetGroupPolicy($arrGroups);
}
else{
    $arPolicy = $USER->GetGroupPolicy(array());
}

$passwordMinLength = (int)$arPolicy['PASSWORD_LENGTH']>0?(int)$arPolicy['PASSWORD_LENGTH']:6;

if(strlen($data['PASSWORD']) < $passwordMinLength)
    $arErrors[] = 'Password must be at least '.$passwordMinLength.' characters long.';

if (empty($arErrors)) {
	if(!$USER->IsAuthorized()){
        $res = $USER->Register($data["EMAIL"], $data['USER_NAME'], "", $data['PASSWORD'], $data['PASSWORD'], $data["EMAIL"]);
        $result['res'] = $res; // ID нового пользователя

		if($res['TYPE'] == "OK"){ // если все ОК
            $user = new CUser;
            $fields = Array(
                'PERSONAL_PHONE' => $data['PERSONAL_PHONE'],
            );
            $user->Update($USER->GetID(), $fields);
            $result['id'] = $USER->GetID(); // ID нового пользователя
            /* отправка письма на почту*/
            CEvent::Send("BIKE_NEW_USER", SITE_ID, $data);

			$result['status'] = 'success';
			$result['message'] = strip_tags($res['MESSAGE']);
		}
		else{
			$result['status'] = 'error';
			$result['message'] = strip_tags($res['MESSAGE']);
		}
	}
}
else{
    $result['status'] = 'error';
    $result['message'] = implode("<br>", $arErrors);
}
echo json_encode($result);
?>