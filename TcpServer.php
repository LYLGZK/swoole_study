<?php
    //创建一个同步的Tcp的server
    $server = new swoole_server("0.0.0.0","9511",SWOOLE_BASE,SWOOLE_SOCK_TCP);
    //设置进程数，一般是cpu核数的2倍
    $server -> set(
        [
            'worker_num' => 2,
            "daemonize" => false   //在后台运行服务器
        ]
    );
    /**---------------------设置监听事件-------------------*/
    $server -> on("connect",function($server,$fd){
        echo "设备{$fd}连接上了服务器\n";
    });

    //这里的from_id 是reactor_id，就是reactor线程id
    $server -> on("receive",function($server,$fd,$from_id,$data){
        echo "接受到了客户端{$fd}发来的数据,数据是：{$data}";
        echo "\n";
        $server -> send($fd,"这是服务端发来的数据");
    });

    $server -> on("close",function($server,$fd){
        echo "设备{$fd}退出了连接\n";
    });


    /**--------------------创建一个自定义进程，用于监控、上报和其他特殊任务------------------------ */
    //创建一个swoole的自定义进程,swoole_process是子进程的回调函数
    $process = new swoole_process(function($process) use ($server){
        foreach($server->connections as $key => $connection){
            
        }
    });
    //创建一个自定义的进程
    $result = $server -> addProcess($process);

    /**------------------开启服务器-------------------- */
    $server -> start();

    //服务器的启动包括：1、主进程启动（mannage进程）；2、worker进程组启动；3、tasker进程组启动


  