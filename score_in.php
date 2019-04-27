<?php
include "conn.php";
header("Access-Control-Allow-Origin:*");
ini_set("display_errors", "off");
if (isset($_GET['json']) and $_GET['json']!== '')
{
    $json_string = $_GET['json'];
    $obj = json_decode($json_string);
    $stage = $obj->stage;
    $role1 = $obj->role1;
    $role2 = $obj->role2;
    $role3 = $obj->role3;
    $role4 = $obj->role4;
    $role5 = $obj->role5;
    if (is_null($stage) or is_null($role1) or is_null($role2) or is_null($role3) or is_null($role4) or is_null($role5)){
        http_response_code(403);
        $str = array('error' => '40302', 'msg' =>'insert is faile');
    }
    else{
        $stmt = $pdo->prepare("insert into score (stage,role1,role2,role3,role4,role5) values (:stage,:role1,:role2,:role3,:role4,:role5)");
        $stmt->execute(array(':stage'=>$stage, ':role1'=> $role1, ':role2'=>$role2, ':role3'=>$role3, ':role4'=> $role4, ':role5'=> $role5));
        $str = array('error' => '0', 'msg' =>'insert is success');
    }
}
elseif (!isset($_GET['json'])) {
    http_response_code(403);
    $str = array('error' => '40300', 'msg' =>'json is not set');
}
elseif ($_GET['json'] === '') {
    http_response_code(403);
    $str = array('error' => '40301', 'msg' =>'json is null');
}
echo json_encode($str);
?>