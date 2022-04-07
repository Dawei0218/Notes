# 标准I/O

> 带缓冲的IO，包括缓冲区分配、以优化的块长度执行I/O等。
>
> 标准I/O的操作时围绕流（stream）进行的。

### 标准输入输出

```c
#include <stdio.h>

stdin;
stdout;
stderr;
```

------

### 流和FILE对象

```c
#include <stdio.h>
#include <wchar.h>

// 若mode为负，试图使指定的流是字节定向的
// 若mode为正，试图使指定的流使宽定向的
// 若model为0，不设置流的定向，返回该流定向的值
int fwide(FILE *fp, int mode);
```

------

### 缓冲

- 全缓冲：填满标准I/O的缓冲区才进行实际的I/O操作。
- 行缓冲：在遇到换行符时，才进行I/O操作。
- 不带缓冲：标准I/O库不对字符进行缓冲存储。

------

### setbuf和setvbuf

```c
#include <stdio.h>

// 设置缓冲类型
void setbuf(FILE *restrict fp, char *restrict buf);
int setvbuf(FILE *restrict fp, char *restrict buf, int mode, size_t size);
```









