# 文件I/O

> 不带缓冲的I/O

### 标准输入输出

```c
#include <unistd.h>

STDIN_FILENO;
STDOUT_FILENO;
STDERR_FILENO;
```

------

### open和openat

```c
#include <unistd.h>

// O_RDONLY O_WRONLY O_RDWR O_EXEC O_SEARCH 必须指定一个并且只能指定一个
// 如果使用O_CREAT必须指定第四个参数，标识文件的访问权限位
// O_SYNC 每次write等待物理I/O完成，包括write操作引起的文件属性更新
int open(const char *path, int oflags, ...);
int openat(int fd, const char *path, int oflag, ...);

```

------

### creat

```c
#include <fcntl.h>

// 只写的方式打开创建文件
int creat(const char *path, mode_t mode);
```

------

### close

```c
#include <unistd.h>

// 当进程关闭时，内核自动关闭它所有的打开文件
int close(int fd);
```

------

### lseek

```c
#include <unistd.h>

// whence = SEEK_SET 偏移设置为据文件开始处的offset个字节
// whence = SEEK_CUR 偏移设置为其当前值加offset，offset可正可负
// whence = SEEK_END 偏移设置为文件长度加offset，offset可正可负

// 成功返回新的文件偏移量
off_t lseek(int fd, off_t offset, int whence);

// 可以知道打开文件的当前偏移量
off_t currpos = lseek(fd, 0, SEEK_CUR);
```

------

### read

```c
#include <unistd.h>

// 返回读到的字节数，读到文件末尾为0
// 从网络中读时，缓存机制可能造成返回值小于所要求读的字节数
ssize_t read(int fd, void *buf, size_t nbytes);
```

------

### write

```c
#include <unistd.h>

ssize_t write(int fd, const void *buff, size_t nbytes);
```

------

### dup和dup2

```c
#include <unistd.h>

// 复制一个现有的文件描述符

// dup返回当前可用描述符的最小值

// dup2 可以指定新描述符的值。
// 如果fd2已经打开，则先将其关闭。
// 如果fd等于fd2，则返回fd2，而不关闭
int dup(int fd);
int dup2(int fd, int fd2);
```

------

### sync、fsync和fdatasync

```c
#include <unistd.h>

// fsync同时会更新文件属性
// fdatasync只影响文件的数据部分
int fsync(int fd);
int fdatasync(int fd);

// 将所修改过的块缓冲区排入写队列，然后就返回，并不等待实际写磁盘操作结束
void sync(void);
```

------

### fcntl

```c
#include <fcntl.h>

// F_DUPFD 复制一个文件描述符，新描述符作为函数值返回。尚未打开的各描述符中大于或等于第3个参数的最小值
// F_DUPFD_CLOEXEC 复制文件描述符，设置与新描述符关联的FD_CLOEXEC文件描述符值，返回新文件描述符
// F_SETEL 将文件状态标志设置为第3个参数的值。O_APPEND O_NONBLOCK O_SYNC O_DSYNC O_RSYNC O_FSYNC O_ASYNC
int fcntl(int fd, int cmd, ...);
```



















