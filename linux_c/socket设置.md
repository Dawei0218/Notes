# socket设置

### 端口复用

```c
int on = 1;
setsockopt(listenfd, SOL_SOCKET, SO_REUSEADDR, &on, sizeof(on));
```

- 在服务端连接断开时，重新重新连接时如果四元组相同就会报错，地址被使用
- 解决服务端time_wait状态带来的端口占用问题以及同一个port对应多个ip
- 创建 socket 和 bind 之间使用REUSEADDR
- 可以在不同地址上使用相同的端口提供服务，否则第二个绑定会失败
  - 第一个地址通配 80
  - 第二个地址192.168.101通配80


***

### 超时

```c

struct timeval tv;
tv.tv_sec = 5;
tv.tv_usec = 0;
setsockopt(connfd, SOL_SOCKET, SO_RCVTIMEO, (const char *) &tv, sizeof tv);

while (1) {
    int nBytes = recv(connfd, buffer, sizeof(buffer), 0);
    if (nBytes == -1) {
        if (errno == EAGAIN || errno == EWOULDBLOCK) {
            printf("read timeout\n");
            onClientTimeout(connfd);
        } else {
            error(1, errno, "error read message");
        }
    } else if (nBytes == 0) {
        error(1, 0, "client closed \n");
    }
    ...
}

// errno = EAGAIN || errno = EWOULDBLOCK
```

