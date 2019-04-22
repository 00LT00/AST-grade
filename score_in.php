<?php
include "conn.php";
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
    $mysqli = new mysqli(HOST,USER,PWD,DBNAME);
    if ($mysqli->connect_errno) {
        $str = array('error' => '50000', 'msg'=>'database error');
        http_response_code(500);
        echo json_encode($str);
        exit;
    }
    $sql = "insert into score (stage,role1,role2,role3,role4,role5) values ('$stage','$role1','$role2','$role3','$role4','$role5')";
    if ($mysqli->query($sql)) {
        $str = array('error' => '0', 'msg' =>'insert is success');
    }
    else {
        http_response_code(403);
        $str = array('error' => '40302', 'msg' =>'insert is faile');
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