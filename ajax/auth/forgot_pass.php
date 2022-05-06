<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if( isset($_POST['USER_EMAIL']) && !empty($_POST['USER_EMAIL']) ){

    global $USER;
    $res = $USER->SendPassword($_POST['USER_EMAIL'], $_POST['USER_EMAIL']);
    if($res["TYPE"] == "OK"){
        $result['status'] = 'success';
        $result['message'] = "The control string for changing the password has been sent to email.";
    }
    else{
        $result['status'] = 'error';
        $result['message'] = "The entered e-mail was not found.";
    }
    echo json_encode($result);

}else{
	echo json_encode(array('status' => 'error', 'message'=>'E-mail is incorrect.'));
}
