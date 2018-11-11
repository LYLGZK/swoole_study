# 这是个人学习swoole的一个总结，用于记录

## 一、为什么会出现swoole这个技术？
    对于java语言来说，网络编程是一个很重要的环节，有了网络编程就不仅仅局限于http协议这样只能和浏览器进行交互了。但是php天生就是为了做web的，当时就没有考虑到其他的网络编程支持。但是现实生活中，尤其是在物联网快速发展的今天，和硬件的互联是必要的，php也得跟上节奏。
## 二、swoole到底能干什么？
    swoole是基于php不能进行网络编程进行的。
    1 他可以做为一个基于Tcp和UDP的异步服务器。
    2 也可以做一个毫秒的定时器。
    3 也可以做一个web服务器（但是目前支持的还不如nginx这些老牌）
    4 
## 三、初步写一个基于swoole的TCP同步服务器程序

~~~php
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
            $connection-> send();
        }
    });
    //创建一个自定义的进程
    $result = $server -> addProcess($process);

    /**------------------开启服务器-------------------- */
    $server -> start();

    //服务器的启动包括：1、主进程启动（mannage进程）；2、worker进程组启动；3、tasker进程组启动


  
~~~

