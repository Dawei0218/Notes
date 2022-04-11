# socket函数

### 基本函数

```c
#include <sys/socket.h>

// domain 1. PF_INET 2. PF_INET6 3. PF_LOCAL
// type 1. SOCK_STREAM 2. SOCK_DGRAM 3. SOCK_RAW(原始套接字)
// protocol 设置成0即可

// 成功返回非负描述符，失败返回-1
int socket(int domain, int type, int protocol);
```

TCP，又被叫做字节流套接字（Stream Socket）。

UDP，又被叫做数据报套接字（demoDatagram Socket）。

***

### IPv4地址结构

```c
#include <netinet/in.h>

#define AF_INET   PF_INET
#define AF_UNIX   PF_UNIX
#define AF_LOCAL  PF_LOCAL
#define AF_INET6  PF_INET6

// 通配地址
// servaddr.sin_addr.s_addr = htonl(INADDR_ANY)

/* 描述IPV4的套接字地址格式  */
struct sockaddr_in {
    sa_family_t sin_family; /* 16-bit */
    in_port_t sin_port;     /* 端口号  16-bit*/
    struct in_addr sin_addr;    /* Internet address. 32-bit */

    /* 这里仅仅用作占位符，不做实际用处  */
    unsigned char sin_zero[8];
};

/* IPV4套接字地址，32bit值.  */
typedef uint32_t in_addr_t;
struct in_addr {
    in_addr_t s_addr;
};
```

***

### connect

```c
#include <sys/socket.h>

// Note: 需要转成通用地址格式
// 可以使用bind()固定ip、端口
int connect(int sockfd, const struct sockaddr *servaddr, socklen_t addrlen);
```

***

### bind

```c
#include <sys/socket.h>

// Note: 需要转成通用地址格式

// 错误返回-1
int bind(int sockfd, const struct sockaddr *myaddr, socklen_t addrlen);
```

***

### listen

```c
#include <sys/socket.h>

// 错误返回-1
int listen(int sockfd, int backlog);
```

***

### accept

```c
#include <sys/socket.h>

// 成功返回非负描述符，错误返回-1
int accept(int sockfd, struct sockaddr *cliaddr, socklen_t *addrlen);
```

***

### 字节排序

```c
#include <netinet/in.h>

// 网络字节序是大端字节序

// 本地转换
// host to network short/long
uint_16_t htons(uint16_t host16bitvalue);
uint_16_t htonl(uint32_t host32bitvalue);

uint_16_t ntohs(uint16_t host16bitvalue);
uint_16_t ntohl(uint32_t host16bitvalue);
```

***

### 地址转换函数

```c
#include <arpa/inet.h>

// 将字符串转成32为的网络字节序二进制，存储在addrptr中
// 有效返回1，否则0
int inet_aton(const char *strptr, struct in_addr *addrptr);

// 返回32为的网络字节序二进制
in_addr_t inet_addr(const char *strptr);

// 返回ip地址
char *inet_ntoa(struct in_addr inaddr);

// family可以是AF_INET也可以是AF_INET6
int inet_pton(int family, const char *strptr, void *addrptr);
const char *inet_ntop(int family, const void *addrptr, char *strptr, size_t len);
```

***

### 读写数据

只是放到发送缓冲区里，就直接返回了。

read返回0表示对端发送了FIN包。

像关闭的连接写会发送rst分节，在像rst分节写数据会触发 SIGPIPE 信号。



接收缓冲区没有数据可读/或write发送缓冲区不够时，在非阻塞情况下 read 调用会立即返回，一般返回 EWOULDBLOCK 或 EAGAIN 出错信息。



在监听套接字上有可读事件发生时，并没有马上调用 accept。由于客户端发生了 RST 分节，该连接被接收端内核从自己的已完成队列中删除了，此时再调用 accept，由于没有已完成连接（假设没有其他已完成连接），accept 一直阻塞，更为严重的是，该线程再也没有机会对其他 I/O 事件进行分发，相当于该服务器无法对其他 I/O 进行服务。

accept也需要设置非阻塞。忽略 EWOULDBLOCK、EAGAIN



```c
fcntl(fd, F_SETFL, O_NONBLOCK);
```

------

### 异常情况

##### 1. 网络中断对端无FIN包

	1. 对端路由器发出ICMP报文，read/write会返回Unreachable异常
	1. 没有ICMP会一直阻塞在read上，可以通过设置超时解决
	1. 如果先调用write经过重传9次，协议栈会标识此连接异常，read会返回TIMEOUT，如果还写入返回SIGPIPE信号

##### 2. 系统崩溃对端无FIN包

1. 无ICMP情况下只能通过read/write获取异常
2. 系统重启后返回RST分节，重传tcp分组到达重启后的系统，如果是阻塞的 read 调用错误信息为连接重置（Connection Reset），write返回SIGPIPE

##### 3. 对端有FIN包

1. 收到FIN等于在接受缓冲区放置了一个EOF符号，之前已经在缓冲区的数据不受影响，如果不通过write/read是无法感知的
