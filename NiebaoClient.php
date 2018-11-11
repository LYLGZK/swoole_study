<?php
    $client = new swoole_client(SWOOLE_SOCK_TCP,SWOOLE_SOCK_SYNC);

    $client -> connect('127.0.0.1',11804) || exit("连接失败");
    $msg = "123456789";
    $data =  pack('N4',"","","",strlen($msg)) . $msg;
   for($i = 0;$i<1;$i++){
        $client -> send($data);
    }