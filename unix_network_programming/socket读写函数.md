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

使用write写入的字节数有可能比请求的数量少

### 发送缓冲区

TCP三次握手成功，连接建立成功时内核会为每个连接创建基础设施，比如发送缓冲区。

发送缓冲区可以通过套接字选项来改变，当调用write时，实际上是吧数据从应用程序中拷贝到操作系统内核的发送缓冲区中，不一定是吧数据通过socket写出去。

1. 操作系统的发送缓冲区足够大，可以直接容纳这份数据，程序从write调用中退出，返回写入的字节数就是应用程序的数据大小。
2. 操作系统内核的发送缓冲区足够大，但是还有数据没有发送完，或者发送完了，但是操作系统内核的缓冲区不足以容纳应用程序数据，这时候操作系统内核不会返回，程序被阻塞。大部分unix系统的做法是一直等到可以把应用程序数据完全放到内核中，才从系统调用中返回。这个时候并没有全部发送出去，发送缓冲区里还有部分数据，这个数据会在稍后由操作系统内核通过网络发送出去

发送成功只是把数据拷贝到了发送缓冲区中，并不意味着对端已经接收到了所有的数据。成功的只是写到发送缓冲区的成功。

缓冲区固定大小放不下   就返回目前能装下的部分 剩下的部分要应用程序自己装（非阻塞情况下）

阻塞io如果缓冲区放不下就会阻塞等待全部放下，如果是非阻塞io会直接返回能装下的大小。所以要在程序里自己控制没发送完的在发送

------

### 读取数据

```c
ssize_t read(int socketfd, void *buffer, size_t size);
```

从socketfd中最多读取size个字节，并将结果存储到buffer中，返回值告诉我们实际读取的字节数据。

如果返回值为0，表示EOL(end-of-file)，表示对端发送了fin包，要处理断连。

-1表示出错，非阻塞I/O，情况会不同

需要考虑EOF等异常

```c
    bzero(&servaddr, sizeof(servaddr)); // 不处理会地址报错？？
    servaddr.sin_family = AF_INET;
    servaddr.sin_port = htons(12345);
    inet_pton(AF_INET, argv[1], &servaddr.sin_addr);
  
```

