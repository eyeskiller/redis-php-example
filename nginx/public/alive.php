<?php
 require_once '/var/www/html/vendor/predis/predis/autoload.php';

 $redis = new Predis\Client(['host' => 'redis']);
 $redisStatus = redisConnect($redis);

 // check redis I/O
 if ($redisStatus == "OK") {
    if(isset($_GET['sess']) && strlen($_GET['sess']) > 10) {
        $sess = $_GET['sess'];

        $key = "alive_".$_GET['sess'];
        $redis->set($key, date('Y-m-d H:i:s'));

        echo date('Y-m-d H:i:s');
    }
 }else{
     echo "Fucked up Redis!";
 }

 function redisConnect($mem) {
    try {
        $mem->connect();
        $mem->select(0);
        $status = "OK";
    }

    catch (Exception $exception) {
        $status = "Redis failed to connect";
    }
    return $status;
  }

?>