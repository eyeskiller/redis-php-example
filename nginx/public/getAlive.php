<?php
 require_once '/var/www/html/vendor/predis/predis/autoload.php';

 $redis = new Predis\Client(['host' => 'redis']);
 $redisStatus = redisConnect($redis);

 // check redis I/O
 if ($redisStatus == "OK") {
     // get all keys with prefix alive_
    $key = "alive_*";
    $alive = $redis->keys($key);
    $active = [];

    // loop over users and compare dates
    foreach($alive as $user) {
        //user == alive_PHPSESSID
        // get user key
        $lastActivity = $redis->get($user);

        //check last activity
        $diff = strtotime(date('Y-m-d H:i:s')) - strtotime($lastActivity);

        // if last activity was less than second ago, add to array as active
        // if last activity was more than second ago, remove from redis 
        // this interval should be changed - more than 1 second is recommended
        if ($diff > 1) {
            $redis->del($user);
        }else{
            $active[] = $user;
        }
    }


    // return as JSON
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