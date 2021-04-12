# socket函数

### socket

```c
// <sys/socket.h>
// domain 1. PF_INET 2. PF_INET6 3. PF_LOCAL
// type 1. SOCK_STREAM 2. SOCK_DGRAM 3. SOCK_RAW
// protocol 设置成0即可
int socket(int domain, int type, int protocol);
```

------

### bind

```c
// fd socket()返回的文件描述符
bind(int fd, sockaddr * addr, socklen_t len);

// IPv4通配
// <netinet/in.h>
struct sockaddr_in name;
name.sin_addr.s_addr = htonl (INADDR_ANY);

// 参考
struct sockaddr_in name;
bind (sock, (struct sockaddr *) &name, sizeof (name) // sucess 0 failure -1
```

addr可能传入的IPv4、IPv6或本地套接字，最后转换成sockaddr结构。

bind会根据传入的len决定怎么解析，因为当时设计时还没有void *结构，所以设计了通用地址格式。

INADDR_ANY不知道布置到哪一台机器上，就需要通配，表示目标地址是这个机器的地址就行。

------

### listen

```c
int listen (int socketfd, int backlog) // sucess 0 failure -1
```

backlog表示已完成 (ESTABLISHED) 且未 accept 的队列大小

------

### accept

```c
// listensockfd是socket()返回的文件描述符
// cliaddr是客户端的地址
// addrlen是地址大小
// 返回全新的描述符用于 read write
int accept(int listensockfd, struct sockaddr *cliaddr, socklen_t *addrlen)
```

------

### connect

```c
int connect(int sockfd, const struct sockaddr *servaddr, socklen_t addrlen)
```

