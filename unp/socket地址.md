# socket地址

### 地址族宏定义

```c
#include <sys/socket.h>
    
// AF(Address Family)
// PE(Protocol Family)
// AF初始化socket地址，在下面地址格式结构体时使用
#define AF_UNSPEC PF_UNSPEC
#define AF_LOCAL  PF_LOCAL
#define AF_UNIX   PF_UNIX
#define AF_FILE   PF_FILE
#define AF_INET   PF_INET
#define AF_AX25   PF_AX25
#define AF_IPX    PF_IPX
#define AF_APPLETALK  PF_APPLETALK
#define AF_NETROM PF_NETROM
#define AF_BRIDGE PF_BRIDGE
#define AF_ATMPVC PF_ATMPVC
#define AF_X25    PF_X25
#define AF_INET6  PF_INET6
```

------

### 通用地址

```c
#include <sys/socket.h>

// POSIX.1g 规范规定了地址族为2字节的值.
// AF_LOCAL 本地地址
// AF_INET  IPv4 
// AF_INET6 IPv6
typedef unsigned short int sa_family_t;

/* 描述通用套接字地址  */
struct sockaddr {
    sa_family_t sa_family;  /* 地址族.  16-bit*/
    char sa_data[14];   /* 具体的地址值 112-bit */
}; 
```

------

### IPv4地址结构

```c
#include <netinet/in.h>

/* IPV4套接字地址，32bit值.  */
typedef uint32_t in_addr_t;
struct in_addr {
    in_addr_t s_addr;
};
  
/* 描述IPV4的套接字地址格式  */
struct sockaddr_in {
    sa_family_t sin_family; /* 16-bit */
    in_port_t sin_port;     /* 端口号  16-bit*/
    struct in_addr sin_addr;    /* Internet address. 32-bit */

    /* 这里仅仅用作占位符，不做实际用处  */
    unsigned char sin_zero[8];
};
```

### IPv6地址格式

```c
#include <netinet/in.h>

struct sockaddr_in6 {
    sa_family_t sin6_family; /* 16-bit */
    in_port_t sin6_port;  /* 传输端口号 # 16-bit */
    uint32_t sin6_flowinfo; /* IPv6流控信息 32-bit*/
    struct in6_addr sin6_addr;  /* IPv6地址128-bit */
    uint32_t sin6_scope_id; /* IPv6域ID 32-bit */
};
```

------

### 本地套接字格式

```c
struct sockaddr_un {
    unsigned short sun_family; /* 固定为 AF_LOCAL */
    char sun_path[108];   /* 路径名 */
};
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



