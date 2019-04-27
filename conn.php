<?php
    $dsn="mysql:host=localhost;dbname=score";
    $username="root";
    $passwd="123456";
    $options = array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES UTF8");
    $pdo= new PDO($dsn, $username, $passwd, $options);try{
        $options = array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES UTF8");
        $pdo= new PDO($dsn, $username, $passwd, $options);
    }catch(Exception $e){
        http_response_code(500);
        $str = array('error' => '50000', 'msg' => 'database error');
        echo json_encode($str);
        exit;
    } 
?>