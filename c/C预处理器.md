# C预处理器

### 宏替换

```c
#define 名字 替换文本
#define max(A, B) ((A) > (B) ? (A) : (B)) // 使用参数必须在括号
#define square(x) x * x  // 错误写法，没有括号

// #表示吧宏的参数替换成字符串常量
#define  message_for(a, b)  \
    printf(#a " and " #b ": We love you!\n")
// message_for(Carole, Debra); result: Carole and Debra: We love you!

// ## 可以把两个标记合并为一个标记 result: 输出token34的值
#define tokenpaster(n) printf ("token" #n " = %d", token##n)
int token34 = 40;
tokenpaster(34);
```

出现名字标记的地方都会被替换成文本，如果有多行需要在待续的行末尾加上\。

为什么要加上括号，如果使用square(a+1)，会被替换成 x+1 * a + 1，所以加上括号保证运算正确性。

------

### 条件包含

```c
#ifndef HDR
#define HDR

// .h文件

#endif
```