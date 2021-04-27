# ELF文件格式

### 目标文件的格式

```
// file命令可查看
1. 可重定位文件，Linux的.o文件
2. 可执行文件
3. 共享目标文件，Linux .so以及Windows .ddl都是动态链接库
4. 核心转储文件，Linux下的core dump
```

从结构上讲，目标文件已经是可执行文件的格式，只是没有经过链接，地址没有调整。

PE和ELF都是COFF(Common file format)格式的变种。动态链接库以及静态链接库（Linux下的.a以及Windows下的.lib）都按照可执行文件格式存储。

静态链接库是把很多目标文件捆绑在一起形成的文件，加上了一些索引，可以简单理解为包含很多目标文件的文件包。

------

### ELF文件总体结构

```
1. ELF Header  
2. .text
3. .data
4. .bss
5. other sections
6. Section header table
7. String Tables, Symbol Tables
```

已经初始化的全局变量以及局部静态变量放在.data

未初始化的全局变量以及局部静态变量放在.bss，目标文件阶段不占用文件空间，链接时分配空间。

------

### ELF Header

```shell
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
  Size of program headers:           0 (bytes)                         # 程序头数量
  Number of program headers:         0                                 # 程序头长度
  Size of section headers:           64 (bytes)                        # 段表长度
  Number of section headers:         13                                # 段表数量
  Section header string table index: 12                                # 段表字符表在段表的下标
```

------

### 文件头的结构体

```c
#define EI_NIDENT (16)
typedef struct
{
    unsigned char e_ident[EI_NIDENT]; /* Magic number and other info */
    Elf32_Half    e_type;         /* Object file type */
    Elf32_Half    e_machine;      /* Architecture */
    Elf32_Word    e_version;      /* Object file version */
    Elf32_Addr    e_entry;        /* Entry point virtual address */
    Elf32_Off e_phoff;        /* Program header table file offset */
    Elf32_Off e_shoff;        /* Section header table file offset */
    Elf32_Word    e_flags;        /* Processor-specific flags */
    Elf32_Half    e_ehsize;       /* ELF header size in bytes */
    Elf32_Half    e_phentsize;        /* Program header table entry size */
    Elf32_Half    e_phnum;        /* Program header table entry count */
    Elf32_Half    e_shentsize;        /* Section header table entry size */
    Elf32_Half    e_shnum;        /* Section header table entry count */
    Elf32_Half    e_shstrndx;     /* Section header string table index */
} Elf32_Ehdr;
```

------

### 段表(Section Header Table)

```c
typedef struct
{
	Elf32_Word    sh_name;        /* Section name (string tbl index) 段名*/
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
	Elf32_Word    sh_type;        /* Section type 段类型 */
    // SHF_WRITE 1 表示该段在进程空间中可写
    // SHF_ALLOC 2 表示该段在进程空间中需要分配空间，代码段、数据段、.bss段都要这个表示
    // SHF_EXECINSTR 4 表示该段在进程空间中可以被执行，一般指代码段
	Elf32_Word    sh_flags;       /* Section flags 标志位 */
	Elf32_Addr    sh_addr;        /* 段虚拟地址，如果可以被加载就是被加载后的进程地址空间中的虚拟地址，否则为0 */
	Elf32_Off sh_offset;      	 /* Section file offset */
	Elf32_Word    sh_size;        /* Section size in bytes */
	Elf32_Word    sh_link;        /* Link to another section */
	Elf32_Word    sh_info;        /* Additional section information */
	Elf32_Word    sh_addralign;       /* Section alignment 段地址对齐 */
	Elf32_Word    sh_entsize;     /* Entry size if section holds table 项的长度*/
} Elf32_Shdr;
```

------

### 可重定位表

在段表里有一个`.rel.text`的段，`sh_type`为`SHT_REL`，这个就是重定位表。链接器在处理目标文件时，需要对目标文件中某些部位进行重定位，即代码段和数据段中那些对绝对地址的引用的位置。这些重定位信息都会记录在重定位表里面，每个需要重定位的代码段或者数据段都有一个相应的重定位表。比如`.rel.text`就是针对`.text`的重定位表，如果有引用才会有。有些数据段没有绝对地址的引用就没有

------

### 字符串表

ELF文件中用到了很多字符串比如段名、变量名等。因为字符串的长度往往是不定的，所以用固定的结构来表示比较困难。一般很常见的做法是把字符串集中起来存方到一个表，然后使用字符串在表中的偏移来引用字符串

------

### 链接的接口——符号





