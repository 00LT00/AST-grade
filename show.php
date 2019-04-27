<?php
    include "conn.php";
    header("Access-Control-Allow-Origin:*");
    ini_set("display_errors", "off");
    if (isset($_GET['stage']) and $_GET['stage'] !== '') {
        $stage = $_GET['stage'];
        $sql="select * from score where stage = ?";                             //写sql语句
        $stmt=$pdo->prepare($sql);                                              //预处理
        $stmt->execute(array($stage));
        $datarow = $stmt->rowCount();
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
        foreach ($stmt->fetchall(PDO::FETCH_ASSOC) as $sql_arr) {
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