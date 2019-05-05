<?php
    header("Access-Control-Allow-Origin:*");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Request-Methods:GET, POST, PUT, DELETE, OPTIONS");
    header('Access-Control-Allow-Headers:content-type');
    ini_set("display_errors", "off");
    include "conn.php";
    /**重写isset() */
    function is_set($param,$method='get'){
        if ($method === 'post') {
            if (isset($_POST["$param"]) and $_POST["$param"] !== '')
                return true;
            else return false;
        }
        else{
            if (isset($_GET["$param"]) and $_GET["$param"] !== '')
                return true;
            else return false;
        }
    }
    /**获取学号，姓名 */
    function get_stu($authorization,$url="https://api.hduhelp.com/base/person/info"){
    $headers = array("authorization:token $authorization");
    // 初始化
    $curl = curl_init();
    // 设置抓取的url
    curl_setopt($curl, CURLOPT_URL, $url);
    // 设置获取的信息以文件流的形式返回，而不是直接输出。
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    // 设置请求头
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    // 不验证证书
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); 
    // 不验证证书
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); 
    // 执行命令
    return json_decode(curl_exec($curl),true);
    // 关闭URL请求
    curl_close($curl);
    //显示获得的数据
    }
    /**判断是否有权限 */
    function judge($id){
        include "conn.php";//不加的话无法加载conn.php页面
        $stmt = $pdo->prepare("select * from admin where id = ?");
        $stmt->execute(array($id));
        $datarow = $stmt->rowCount();
        if ($datarow === 0) {
            return false;       //数据库没有此学号
        }else{
            return true;
        }
    }
    /**获取token */
    if (isset($_SERVER['HTTP_AUTHORIZATION']) and $_SERVER['HTTP_AUTHORIZATION'] !== '') {
        $token = $_SERVER['HTTP_AUTHORIZATION'];
    }else{
        http_response_code(403);
        $str = array('error' => '40301', 'msg' =>'token error');
        echo json_encode($str);
        exit;
    }

    if (is_set('stage','post') and is_set('operate','post')) {
        /**操作方式 */
        $operate = $_POST['operate'];
        /**时间 */
        date_default_timezone_set('PRC');  //设置默认时区 PRC(中华人民共和国)
        if ($operate === 'open') {
            $time=date("Y-m-d H:i:s");
        }elseif($operate === 'close'){
            $time = date("Y-m-d H:i:s",time() - 120);
        }else{
            $str = array('error'=>'40303', 'msg'=>'operate error');
            http_response_code(403);
            echo json_encode($str);
            exit;
        }
        /**场次 */
        $stage = $_POST['stage'];
        $arr = get_stu($token);
        /**学号 */
        $id = $arr['data']['STAFFID'];
        if (!judge($id)) {
            http_response_code(403);
            $str = array('error'=>'40302', 'msg'=>'No authority');
            echo json_encode($str);
            exit;
        }
        /**姓名 */
        $name = $arr['data']['STAFFNAME'];
        /**预处理，两条语句中间用;隔开 */
        $stmt = $pdo->prepare( "insert into logs (time,id,name,operate) values (:time,:id,:name,:operate);
                                update team set enable_time = :time where stage = :stage");
        /**执行 */
        $stmt->execute(array(':time'=>$time, ':id'=>$id, ':name'=>$name, ':operate'=>$operate, 
                                    ':time'=>$time, ':stage'=>$stage));
        
        $str = array('error'=> '0', 'msg'=>'add logs');
    }
    else{
        http_response_code(403);
        $str = array('error' => '40300', 'msg' =>'parameter error');
    }
    echo json_encode($str);
?>