# ELF文件格式

### 目标文件的格式

```
// file命令可查看
1. 可重定位文件，Linux的.o文件
2. 可执行文件
3. 共享目标文件，Linux .so以及Windows .ddl都是动态链接库
4. 核心转储文件，Linux下的core dump
```

结构上目标文件已经是可执行文件的格式，只是没有经过链接，地址没有调整。

`PE`和`ELF`都是`COFF(Common file format)`格式的变种。

动态链接库以及静态链接库`(Linux下的.a以及Windows下的.lib)`都按照可执行文件格式存储。

静态链接库是把很多目标文件捆绑在一起形成的文件，加上了一些索引，可以简单理解为包含很多目标文件的文件包。

------

### ELF文件总体结构

```
// 比较重要的结构
1. ELF Header  
2. .text
3. .data
4. .bss
5. other sections
6. Section header table
7. String Tables, Symbol Tables
```

.data保存已经初始化的全局变量以及局部静态变量。

.bss保存未初始化的全局变量以及局部静态变量，只是记录大小总和，在运行时占用内存，在文件中不占用空间 。

------

### ELF Header

```c
ELF Header:
  Magic:   7f 45 4c 46 02 01 01 00 00 00 00 00 00 00 00 00             # ELF魔数
  Class:                             ELF64                             # 文件机器字节长度
  Data:                              2's complement, little endian     # 数据存储方式
  Version:                           1 (current)                       # 版本
  OS/ABI:                            UNIX - System V                   # 运行平台
  ABI Version:                       0                                 # ABI版本
  Type:                              REL (Relocatable file)            # ELF重定位类型
  Machine:                           Advanced Micro Devices X86-64     # 硬件平台
  Version:                           0x1                               # 硬件平台版本
  Entry point address:               0x0                               # 入口地址
  Start of program headers:          0 (bytes into file)               # 程序头入口
  Start of section headers:          824 (bytes into file)             # 段表的位置
  Flags:                             0x0                               # 标志位
  Size of this header:               64 (bytes)                        # ELF Header长度
  Size of program headers:           0 (bytes)                         # 程序头长度
  Number of program headers:         0                                 # 程序头数量
  Size of section headers:           64 (bytes)                        # 段表长度
  Number of section headers:         13                                # 段表数量
  Section header string table index: 12                                # 段表字符表在段表的下标
  
// 描述ELF Header的结构体，与上面解析的数据对应
#define EI_NIDENT (16)
typedef struct
{
    // 第1个字节 0x7F ELF标识 
    // 第2-4字节 0x45 0x4c 0x46(ELF的ASCII码) 
    // 第5个字节 0x01 32bit 0x02 64bit
    // 第6个字节 表示字节序是大端还是小端
    // 第7个字节 规定ELF主版本号，一般是1，ELF标准1.2之后就再也没有更新过
    // 后面的9个字节 ELF标准没有定义，有些平台作为扩展
    unsigned char e_ident[EI_NIDENT]; /* ELF魔数 文件机器字节长度 数据存储方式 版本 运行平台 ABI版本 */
    
    // ET_REL 1 可重定位文件，一般是.o文件
    // ET_EXEC 2 可执行文件
    // ET_DYN 3 共享目标问及那一般为.so
    Elf32_Half    e_type;         /* ELF重定位类型 */
    
    Elf32_Half    e_machine;      /* 硬件平台 */
    Elf32_Word    e_version;      /* 硬件平台版本 */
    Elf32_Addr    e_entry;        /* 入口地址，规定ELF入口的虚拟地址 */
    Elf32_Off e_phoff;        /* 程序头入口  */
    Elf32_Off e_shoff;        /* 段表的在文件中的偏移 */
    Elf32_Word    e_flags;        /* 标志位 */
    Elf32_Half    e_ehsize;       /* ELF Header长度 */
    Elf32_Half    e_phentsize;        /* 程序头长度 */
    Elf32_Half    e_phnum;        /* 程序头数量 */
    Elf32_Half    e_shentsize;        /* 段表长度 */
    Elf32_Half    e_shnum;        /* 段表数量 */
    Elf32_Half    e_shstrndx;     /* 段名表在段表中的下标 */
} Elf32_Ehdr;
```

------

### 常见的段

```c
// .rodata1 Read only data，这个段只存放只读数据
// .comment 存放编译器版本信息
// .debug 调试信息
// .dynamic 动态链接信息
// .hash 符号哈希表
// .line 调试时的行号表
// .note 额外的编译器信息
// .strtab 字符串表，用于存储ELF文件中的各种字符串
// .symtab 符号表
// .shstrtab 段名表，保存段表中用到的字符串，最常见的就是段名3w
// .plt .got 动态链接的跳转表和全局入口
// .init .fini 程序初始化与终结代码段
// .rel.text 重定位表，每个需要重定位的代码段和数据段都会有一个重定位表
```

除了`.text`、`.data`以及`.bss`之外常见的段。

------

### 段表结构(Section Header Table)

```c
typedef struct
{
	Elf32_Word    sh_name;        /* 段名，存在在段名表，sh_name的值是段名表的偏移 */
    
    // sh_type
    // SHT_NULL 0 无效段
    // SHT_PROGBITS 1 程序段。代码段、数据段都是这个类型
    // SHT_SYMTAB 2 表示该段内容为符号表
    // SHT_STRTAB 3 表示该段为字符串表
    // SHT_RELA 4 重定位表。该段包含了重定位信息
    // SHT_HASH 5 符号表的hash表
    // SHT_DYNAMIC 6 动态链接信息
    // SHT_NOTE 7 提示性信息
    // SHT_NOBITS 8 表示该段在文件中没有内容，比如.bss
    // SHT_REL 9 该段包含了重定位信息
    // SHT_SHLIB 10 保留
    // SHT_DNYSYM 11 动态链接符号表
	Elf32_Word    sh_type;        /* 段类型 */
    
    // SHF_WRITE 1 表示该段在进程空间中可写
    // SHF_ALLOC 2 表示该段在进程空间中需要分配空间，代码段、数据段、.bss段都要这个表示
    // SHF_EXECINSTR 4 表示该段在进程空间中可以被执行，一般指代码段
	Elf32_Word    sh_flags;       /* 标志位 */
    
	Elf32_Addr    sh_addr;        /* 段虚拟地址，如果可以被加载就是被加载后的进程地址空间中的虚拟地址，否则为0 */
	Elf32_Off sh_offset;      	 /* 如果该段存在文件中，则表示该段在文件的偏移。对于.bss无意义 */
	Elf32_Word    sh_size;        /* 段的长度 */
    
    // sh_type = SHT_DYNAMIC sh_link 表示该段使用的字符串表在段表的下标 sh_info = 0
    // sh_type = SHT_HASH sh_link 表示该段使用的符号表在段表的下标 sh_info = 0
    // sh_type = SHT_RELA || SHT_RELA sh_link 表示该段相应的符号表在段表的下标 sh_info 该重定位表所作用的段表下标
    // sh_type = SHT_SYMTAB || SHT_DYNSYM sh_link 操作系统相关的 sh_info 操作系统相关
    // sh_type = other sh_link = SHN_UNDEF sh_info = 0
	Elf32_Word    sh_link;        /* Link to another section */
	Elf32_Word    sh_info;        /* Additional section information */
    
	Elf32_Word    sh_addralign;   /* Section alignment 段地址对齐 */
	Elf32_Word    sh_entsize;     /* Entry size if section holds table 项的长度*/
} Elf32_Shdr;
```

------

### 可重定位表

`.rel.text`段，`sh_type`为`SHT_REL`，这个就是重定位表。

链接器在处理目标文件时，需要重定位代码段和数据段中那些对绝对地址的引用的位置，这些重定位信息就记录在可重定位表里面。

------

### 字符串表

ELF文件中用到了很多字符串比如段名、变量名等。因为字符串的长度往往是不定的，所以用固定的结构来表示比较困难。

一般很常见的做法是把字符串集中起来存方到一个表，然后使用字符串在表中的偏移来引用字符串。

`.strtab`是字符串表保存普通的字符串，`.shstrtab`保存段表中用到的字符串，最常见的就是段名。

只要分析ELF文件头，就可以得到段表和段表字符串表的位置，从而解析整个ELF文件。

------

### 链接的接口——符号

在链接中，目标文件之间相互拼合实际上是目标文件之间对地址的引用，即对函数和变量地址的引用。

在链接中，将函数和变量统称为符号，函数名和变量名就是符号名。

链接过程中很关键的一部分就是符号的管理，每一个目标文件都会有一个相应的符号表。这个表里面记录了目标文件中所用到的所有符号。每个定义的符号有一个相应的值，叫做符号值。

对于变量和函数来说，符号值就是它们的地址。

------





