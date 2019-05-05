<?php
header("Access-Control-Allow-Origin:*");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Request-Methods:GET, POST, PUT, DELETE, OPTIONS");
header('Access-Control-Allow-Headers:content-type');
ini_set("display_errors", "on");
if($_SERVER['REQUEST_METHOD']=='OPTIONS'){
    die();
}
function enable($stage){
    include "conn.php";
    date_default_timezone_set('PRC');  //设置默认时区 PRC(中华人民共和国)
    $time=strtotime(date("Y-m-d H:i:s"));
    $sql = "select enable_time from team where stage = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array($stage));
    $sql_arr = $stmt->fetch(PDO::FETCH_ASSOC);
    $opentime = strtotime($sql_arr['enable_time']);
    if ($time - $opentime < 120) {
        return true;
    }else{
        return false;
    }
}
include "conn.php";
ini_set("display_errors", "off");
$json_string = file_get_contents('php://input');
if($json_string !== ' '){
    $obj = json_decode($json_string, true);
    // Stage
    $stage = $obj['stage'];
    if (is_null($stage)){
        http_response_code(403);
        $str = array('error' => '40302', 'msg' =>'insert is faile');
        echo json_encode($str);
        exit;
    }
    /**判断投票是否开启 */
    if (!enable($stage)) {
        http_response_code(403);
        $str = array('error' => '40303', 'msg' =>'time limit');
        echo json_encode($str);
        exit;
    }
    unset($obj['stage']);
    foreach($obj as $key => $value){
        if(is_null($value) || !is_numeric($value) || $value < 8 || $value > 10 ){
            http_response_code(403);
            $str = array('error' => '40302', 'msg' =>'insert is faile');
            echo json_encode($str);
            exit;
        }
    }
    
    $role1 = $obj['role1'];
    $role2 = $obj['role2'];
    $role3 = $obj['role3'];
    $role4 = $obj['role4'];
    $role5 = $obj['role5'];

    $stmt = $pdo->prepare("insert into score (stage,role1,role2,role3,role4,role5) values (:stage,:role1,:role2,:role3,:role4,:role5)");
    $stmt->execute(array(':stage'=>$stage, ':role1'=> $role1, ':role2'=>$role2, ':role3'=>$role3, ':role4'=> $role4, ':role5'=> $role5));
    $str = array('error' => '0', 'msg' =>'insert is success');
}
else{
    http_response_code(403);
    $str = array('error' => '40301', 'msg' =>'json is null');
}
echo json_encode($str);
?>



