# swoole 的工作进程的生命周期

swoole是基于php的多进程\线程的，在整个工作期间swoole的进程的生命周期是什么样子的呢？

## 一、 swoole服务器启动

* 首先创建了一个master进程（主进程）

* master进程接着创建一个manage进程和一些reactor线程



## 二、swoole名词介绍

* manage进程是主进程，他是一定存在的，如果主进程创建失败，就导致这个服务器启动失败。master进程还会创建manage进程和reactor线程。
* manage进程的作用是管理其他的进程。管理的进程包括task进程，worker进程。
* 真正和客户端进行交互的是reactor线程，因为在swoole中，reactor的作用就是epoll客户端数据，然后转给worker进程进行业务逻辑的处理。
* taskWork进程是为了处理异步而创建的进程，只有当调用$server->task()方法的时候才会创建一个taskWorker进程进行处理。
* ·

