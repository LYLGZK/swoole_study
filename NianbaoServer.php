<?php
    $tcpServr = new swoole_server('0.0.0.0',11804,SWOOLE_PROCESS,SWOOLE_SOCK_TCP);
    $tcpServr -> set([
        'worker_num' => 2,
        'open_length_check' => true,   //开启包头包体定长校验
        'package_length_type' => 'N',  //包中某一个位置存放了包的长度，N代表是4个字节,表示的是包头中用多少个字节来表示包体，4个字节就是32位，包体的长度最大为2的32次方
        'package_body_offset' => 10,    //从哪个位置开始计算包体，从侧面上也就反应出包头就是4个字节，这里可以变得大点
        'package_length_offset' => 3,    //第几位开始是包的长度
        'package_max_length' => 800000   

    ]);

    $tcpServr -> on("connect",function($server,$fd){
        echo "设备{$fd}接入了服务器\n";
    });

    $tcpServr -> on('receive',function($server,$fd,$from,$data){
        //这里如果使用了固定包头和包体解析协议，data就是没有解析的数据
       $length = unpack('N4',$data);   //解析出来的是长度
        var_dump($length);
//       $body = substr($data,-$length);
//        echo $body."\n";
    });

    $tcpServr -> on("close",function($server,$fd){
        echo "设备{$fd}退出了设备\n";
    });
    
    $tcpServr -> start ();
   