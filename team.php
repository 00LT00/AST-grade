<?php
    include "conn.php";
    header("Access-Control-Allow-Origin:*");
    ini_set("display_errors", "off");
    if (isset($_GET['stage']) and $_GET['stage']!== '') {
        $stage = $_GET['stage'];
        $mysqli = new mysqli(HOST,USER,PWD,DBNAME);
        if ($mysqli->connect_errno) {
            $str = array('error' => '50000', 'msg'=>'database error');
            http_response_code(500);
            echo json_encode($str);
            exit;
        }
        $sql = "select * from team where stage = $stage";
        if ($result= $mysqli->query($sql)) {
            $sql_arr = mysqli_fetch_assoc($result);
            $str = array('data' => array('team1'=>$sql_arr['team1'],'team2'=>$sql_arr['team2'],'team3'=>$sql_arr['team3'],'team4'=>$sql_arr['team4'],'team5'=>$sql_arr['team5']),'error' => '0', 'msg' =>'select is success');
        }
        else {
            http_response_code(403);
            $str = array('error' => '40302', 'msg' =>'select is faile');
        }
    }
    elseif (!isset($_GET['stage'])) {
        http_response_code(403);
        $str = array('error' => '40300', 'msg' =>'stage is not set');
    }
    elseif ($_GET['stage'] === '') {
        http_response_code(403);
        $str = array('error' => '40301', 'msg' =>'stage is null');
    }
    echo json_encode($str);
?>