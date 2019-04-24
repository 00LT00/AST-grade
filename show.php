<?php
    include "conn.php";
    header("Access-Control-Allow-Origin:*");
    ini_set("display_errors", "off");
    if (isset($_GET['stage']) and $_GET['stage'] !== '') {
        $stage = $_GET['stage'];
        $mysqli = new mysqli(HOST,USER,PWD,DBNAME);
        if ($mysqli->connect_errno) {
            $str = array('error' => '50000', 'msg'=>'database error');
            http_response_code(500);
            echo json_encode($str);
            exit;
        }
        $sql = "select * from score where stage = '$stage'";
        $result = $mysqli->query($sql);
        $datarow = mysqli_num_rows($result);
        if ($datarow === 0) {
            http_response_code(403);
            $str = array('error' => '40302', 'msg'=> "don't have data");
            echo json_encode($str);
            exit;
        }
        $score1 = 0;
        $score2 = 0;
        $score3 = 0;
        $score4 = 0;
        $score5 = 0;
        for ($i=0; $i < $datarow; $i++) { 
            $sql_arr = mysqli_fetch_assoc($result);
            $score1+= $sql_arr['role1'];
            $score2+= $sql_arr['role2'];
            $score3+= $sql_arr['role3'];
            $score4+= $sql_arr['role4'];
            $score5+= $sql_arr['role5'];
        }
        $str = array('data'=>array('score1'=>(string)round($score1/$datarow,2), 'score2'=>(string)round($score2/$datarow,2), 'score3'=>(string)round($score3/$datarow,2), 'score4'=>(string)round($score4/$datarow,2), 'score5'=>(string)round($score5/$datarow,2)),'error' => '0', 'msg'=>'succes');
    }
    elseif (!isset($_GET['stage'])) {
        http_response_code(403);
        $str = array('error' => '40300', 'msg' => 'stage is not set');
    }
    elseif ($_GET['stage'] ==='') {
        http_response_code(403);
        $str = array('error' => '40301', 'msg' => 'stage is null');
    }
    echo json_encode($str);

?>