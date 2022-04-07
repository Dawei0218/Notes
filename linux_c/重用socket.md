# 重用socket

```c
int on = 1;
setsockopt(listenfd, SOL_SOCKET, SO_REUSEADDR, &on, sizeof(on));
```

- 在服务端连接断开时，重新重新连接时如果四元组相同就会报错，地址被使用
- 创建 socket 和 bind 之间使用REUSEADDR



