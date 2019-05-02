<?php
    include "conn.php";
    header("Access-Control-Allow-Origin:*");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Request-Methods:GET, POST, PUT, DELETE, OPTIONS");
    header('Access-Control-Allow-Headers:content-type');
    ini_set("display_errors", "off");
    if (isset($_GET['stage']) and $_GET['stage']!== '') {
        $stage = $_GET['stage'];
        $sql = "select * from team where stage = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array($stage));
            $sql_arr = $stmt->fetch(PDO::FETCH_ASSOC);
            $str = array('data' => array('team1'=>$sql_arr['team1'],'team2'=>$sql_arr['team2'],'team3'=>$sql_arr['team3'],'team4'=>$sql_arr['team4'],'team5'=>$sql_arr['team5']),'error' => '0', 'msg' =>'select is success');
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