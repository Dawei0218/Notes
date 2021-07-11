# socket函数

### socket

```c
#include <sys/socket.h>

// domain 1. PF_INET 2. PF_INET6 3. PF_LOCAL
// type 1. SOCK_STREAM 2. SOCK_DGRAM 3. SOCK_RAW
// protocol 设置成0即可

// 成功返回非负描述符，失败返回-1
int socket(int domain, int type, int protocol);
```

------

### connect

```c
#include <sys/socket.h>

// 成功返回0，出错为-1
int connect(int sockfd, const struct sockaddr *servaddr, socklen_t addrlen);
```

------

### bind

```c
#include <sys/socket.h>

// 成功返回0，出错为-1
// 通配地址 servaddr.sin_addr.s_addr = htonl(INADDR_ANY)
// 如果是十进制点分地址要用inet_addr
int bind(int sockfd, const struct sockaddr *myaddr, socklen_t addrlen);
```

------

### listen

```c
#include <sys/socket.h>

// 成功返回0，错误为-1
int listen(int sockfd, int backlog);
```

------

### accept

```c
#include <sys/socket.h>

// 成功返回非负描述符，错误返回-1
// sockfd为监听套接字，accept返回的描述符为已连接套接字
// addrlen 调用者必须初始化它以包含地址指向的结构
int accept(int sockfd, struct sockaddr *cliaddr, socklen_t *addrlen);
```



