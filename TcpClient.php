<?php
    $client = new swoole_client(SWOOLE_TCP,SWOOLE_SYNC);  //同步的tcp客户端

    //连接服务器
    $client -> connect('127.0.0.1',"9511");

    // $client -> on("receive",function($client,$data){
    //     echo "接受到了服务器传来的数据，数据是：";
    //     var_dump($data);
    //     echo "\n";
    // });

    $client -> send("这是客户端发来的数据");
    
    //接受数据
    $data = $client -> recv();