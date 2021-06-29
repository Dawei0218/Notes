# socket读写函数

### 发送数据

```c
// <unistd.h>
ssize_t write (int socketfd, const void *buffer, size_t size);
// 可以发送外带数据
ssize_t send (int socketfd, const void *buffer, size_t size, int flags);
// 指定多重缓冲区
ssize_t sendmsg(int sockfd, const struct msghdr *msg, int flags)
```

在非阻塞I/O的情况下，并且发送缓冲区不够存放全部数据，会直接返回能够放入的大小，所以需要应用程序执行控制。

------

### 读取数据

```c
// 返回实际读取大小
// 返回0表示EOF(enf-of-file)，表示对端发送了fin包，需要处理断连
// -1表示出错，非阻塞I/O，情况会不同
ssize_t read(int socketfd, void *buffer, size_t size);
```

从文件描述符中最多读取size个字节，并将结果存储到buffer中，返回结果为实际读取的大小。



