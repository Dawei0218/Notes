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

### IPv4地址结构

```c
#include <netinet/in.h>

#define AF_INET   PF_INET
#define AF_UNIX   PF_UNIX
#define AF_LOCAL  PF_LOCAL
#define AF_INET6  PF_INET6

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

------

### connect

```c
#include <sys/socket.h>

// Note: 需要转成通用地址格式
int connect(int sockfd, const struct sockaddr *servaddr, socklen_t addrlen);
```

------

### bind

```c
#include <sys/socket.h>

// Note: 需要转成通用地址格式
int bind(int sockfd, const struct sockaddr *myaddr, socklen_t addrlen);
```

------

### listen

```c
#include <sys/socket.h>

int listen(int sockfd, int backlog);
```

------

### accept

```c
#include <sys/socket.h>

// 成功返回非负描述符，错误返回-1
int accept(int sockfd, struct sockaddr *cliaddr, socklen_t *addrlen);
```

------

### 字节排序

```c
#include <netinet/in.h>

// 网络字节序是大端字节序

uint_16_t htons(uint16_t host16bitvalue);
uint_16_t htonl(uint32_t host32bitvalue);

uint_16_t ntohs(uint16_t host16bitvalue);
uint_16_t ntohl(uint32_t host16bitvalue);
```

------

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



