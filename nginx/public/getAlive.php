<?php
 require_once '/var/www/html/vendor/predis/predis/autoload.php';

 $redis = new Predis\Client(['host' => 'redis']);
 $redisStatus = redisConnect($redis);

 // check redis I/O
 if ($redisStatus == "OK") {
    $key = "alive_*";
    $alive = $redis->keys($key);
    $active = [];
    foreach($alive as $user) {
        $lastActivity = $redis->get($user);
        $diff = strtotime(date('Y-m-d H:i:s')) - strtotime($lastActivity);
        if ($diff > 1) {
            $redis->del($user);
        }else{
            $active[] = $user;
        }
    }

    echo json_encode($active);

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