# 高级I/O

### 非阻塞I/O

```c
// 调用open时，指定O_NONBLOCK
// 对于一个已经打开的描述符，可以调用fcntl，打开O_NONBLOCK标志
// 非阻塞描述符无数据可读，read返回-1，errno被设置为EAGAIN
```

------

### select和pselect

```c
#include <sys/select.h>

// 返回准备就绪的文件描述符数量，超时返回0，出错返回-1

// tvptr == NULL 永远等待。如果捕捉到一个信号则中断此无限期等待。如果捕捉到一个信号返回-1，errno设置为EINTR
// tvprt->tv_sec == 0 && tvptr->tv_usec != 0 等待指定的秒数和微秒数。如果超时还没有描述符准备好，返回0
// tvprt->tv_sec !=0 || tvptr->tv_usec !=0 等待指定的秒数和微秒数。如果超时到期还没有准备好返回0

// maxfdp1设置为最大的fd+1

// 超时了会把所有描述符集都会置为0，需要重新设置
// 每次处理完了都需要重新设置fds，都置为0
int select(int maxfdp1,
          fd_set *restrict readfds,
          fd_set *restrict writefds,
          fd_set *restrict exceptfds,
          struct timeval *restrict tvptr);

int FD_ISSET(int fd, fd_set *fdset); // 如果描述符在集合里，返回非0值。否则返回0
void FD_CLR(int fd, fd_set *fdset); // 开启一位
void FD_SET(int fd, fd_set *fdset); // 清除一位
void FD_ZERO(fd_set *fdset); // fdset所有位置设置为0。声明了一个fd_set之后必须用此函数置零
```

------

### poll

```c
#include <poll.h>

// 返回准备就绪的描述符，超时返回0，出错返回-1
int poll(struct pollfd fdarray[], nfds_t nfds, int timeout);
```



