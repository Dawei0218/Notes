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


```

