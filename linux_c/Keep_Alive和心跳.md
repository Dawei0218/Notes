# Keep-Alive和心跳

### TCP Keep-Alive

```
保活时间、保活时间间隔和保活探测次数
每次间隔2小时开始第一次探测，共探测九次，每次探测间隔75秒
net.ipv4.tcp_keepalive_time、net.ipv4.tcp_keepalive_intvl、 net.ipv4.tcp_keepalve_probes默认设置是 7200 秒（2 小时）、75 秒和 9 次探测。
```

- 默认是关闭的
- 发现时间太长，最少要经过2小时 + 75*9才能知道

------

### 应用层探活

```c
// 简单的PING-PONG协议	
typedef struct {
    u_int32_t type;
    char data[1024];
} messageObject;

#define MSG_PING          1
#define MSG_PONG          2
#define MSG_TYPE1        11
#define MSG_TYPE2        21
```

- 设计PING-PONG的机制

- 使用IO复用自带的定时器，以及设计一个PING-PONG协议

  
