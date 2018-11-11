<?php
    //编写一个Swoole的UDP的server
    $udpServer = new swoole_server("0.0.0.0","10086",SWOOLE_BASE,SWOOLE_SOCK_UDP);

    

    //开启服务器
    $udpServer -> start();