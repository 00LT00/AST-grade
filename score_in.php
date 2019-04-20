<?php
include "conn.php";
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
    $sql = "insert into score (stage,role1,role2,role3,role4,role5) values ('$stage','$role1','$role2','$role3','$role4','$role5')";
    if ($mysqli->query($sql)) {
        $str = array('error' => '0', 'msg' =>'insert is success');
    }
    else {
        $str = array('error' => '40302', 'msg' =>'insert is faile');
    }
}
elseif (!isset($_GET['json'])) {
    $str = array('error' => '40300', 'msg' =>'json(post) is not set');
}
elseif ($_GET['json'] === '') {
    $str = array('error' => '40301', 'msg' =>'json(post) is null');
}
echo json_encode($str);
?>