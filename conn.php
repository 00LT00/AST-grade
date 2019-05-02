<?php
    $dsn="mysql:host=hduhelp0820.mysql.rds.aliyuncs.com;dbname=vote";
    $username="vote";
    $passwd="duhwd3oifjoe38u9oj8wi!";
    $options = array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES UTF8");
    try{
        $pdo= new PDO($dsn, $username, $passwd, $options);
    }catch(Exception $e){
        http_response_code(500);
        $str = array('error' => '50000', 'msg' => 'database error');
        echo json_encode($str);
        exit;
    } 
?>