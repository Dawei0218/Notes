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
// 每次处理完select都会修改传入的只，需要重新设置
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

// events macro 可以掩码操作
// POLLIN包括了OOB等带外数据的检测，POLLRDNORM则不包括这部分。
#define POLLIN     0x0001    /* any readable data available */
#define POLLPRI    0x0002    /* OOB/Urgent readable data */
#define POLLRDNORM 0x0040    /* non-OOB/URG data available */
#define POLLRDBAND 0x0080    /* OOB/Urgent readable data */

#define POLLOUT    0x0004    /* file descriptor is writeable */
#define POLLWRNORM POLLOUT   /* no write type differentiation */
#define POLLWRBAND 0x0100    /* OOB/Urgent data can be written */

#define POLLERR    0x0008    /* 一些错误发送 */
#define POLLHUP    0x0010    /* 描述符挂起*/
#define POLLNVAL   0x0020    /* 请求的事件无效*/

// poll不会修改传入的只，而是保存在revents中
struct pollfd {
    int    fd;       /* file descriptor */
    short  events;   /* events to look for */
    short  revents;  /* events returned */
 };

// 返回准备就绪的描述符，超时返回0，出错返回-1
// time < 0 有事件之前永远等待  time = 0 不阻塞进程立马返回   time > 0 等待指定的毫秒数
int poll(struct pollfd fdarray[], nfds_t nfds, int timeout);
```



