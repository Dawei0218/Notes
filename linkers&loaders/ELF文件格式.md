# ELF文件格式

### 目标文件的格式

```
// file命令可查看
1. 可重定位文件，Linux的.o文件
2. 可执行文件
3. 共享目标文件，Linux .so以及Windows .ddl都是动态链接库
4. 核心转储文件，Linux下的core dump
```

`PE`和`ELF`都是`COFF(Common file format)`格式的变种。

动态链接库以及静态链接库`(Linux下的.a以及Windows下的.lib)`都按照可执行文件格式存储。

静态链接库是把很多目标文件捆绑在一起形成的文件，加上了一些索引，可以简单理解为包含很多目标文件的文件包。

------

### ELF文件结构

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

.data保存已经初始化的全局变量以及局部静态变量，.bss保存未初始化的全局变量以及局部静态变量。

.bss只是为未初始化的全局变量和局部静态变量预留位置，并没有内容，所以在文件中不占据空间 。

------

### ELF Header

```c
#define EI_NIDENT (16)
typedef struct
{
    // 第1个字节 0x7F ELF标识 
    // 第2-4字节 0x45 0x4c 0x46(ELF的ASCII码) 
    // 第5个字节 0x01 32bit 0x02 64bit
    // 第6个字节 表示字节序是大端还是小端
    // 第7个字节 规定ELF主版本号，一般是1，ELF标准1.2之后就再也没有更新过
    // 后面的9个字节 ELF标准没有定义，有些平台作为扩展
    unsigned char e_ident[EI_NIDENT];
    
    // ET_REL 1 可重定位文件，一般是.o文件
    // ET_EXEC 2 可执行文件
    // ET_DYN 3 共享目标文件，一般为.so
    Elf32_Half    e_type;         /* ELF文件类型 */
    
    Elf32_Half    e_machine;      /* CPU平台属性 */
    Elf32_Word    e_version;      /* ELF版本号 */
    Elf32_Addr    e_entry;        /* 入口地址，规定ELF入口的虚拟地址 */
    Elf32_Off e_phoff;        /* 程序头入口  */
    Elf32_Off e_shoff;        /* 段表的在文件中的偏移 */
    Elf32_Word    e_flags;        /* 标志位 */
    Elf32_Half    e_ehsize;       /* ELF文件头本身长度 */
    Elf32_Half    e_phentsize;        /* 程序头长度 */
    Elf32_Half    e_phnum;        /* 程序头数量 */
    Elf32_Half    e_shentsize;        /* 段表描述符长度 */
    Elf32_Half    e_shnum;        /* 段表描述符数量 */
    Elf32_Half    e_shstrndx;     /* 段表字符串表在段表中的下标 */
} Elf32_Ehdr;
```

------

### 常见的段

```c
// 除了.text、.data以及.bss之外常见的段。
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

------

### 段描述符结构

```c
typedef struct
{
	Elf32_Word    sh_name;        /* 段名，位于.shstrtab，sh_name的值是.shstrtab的偏移 */
 
    // SHT_NULL 0 无效段
    // SHT_PROGBITS 1 程序段、代码段、数据段都是这个类型
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
	Elf32_Word    sh_flags;       /* 段标志位 */
    
	Elf32_Addr    sh_addr;        /* 段虚拟地址，如果可以被加载就是被加载后的进程地址空间中的虚拟地址，否则为0 */
	Elf32_Off sh_offset;      	 /* 如果该段存在文件中，则表示该段在文件的偏移。对于.bss无意义 */
	Elf32_Word    sh_size;        /* 段的长度 */
    
    // sh_type = SHT_DYNAMIC sh_link 表示该段使用的字符串表在段表的下标 sh_info = 0
    // sh_type = SHT_HASH sh_link 表示该段使用的符号表在段表的下标 sh_info = 0
    // sh_type = SHT_RELA || SHT_RELA sh_link 表示该段相应的符号表在段表的下标 sh_info 该重定位表所作用的段表的下标
    // sh_type = SHT_SYMTAB || SHT_DYNSYM sh_link 操作系统相关的 sh_info 操作系统相关
    // sh_type = other sh_link = SHN_UNDEF sh_info = 0
	Elf32_Word    sh_link;        /* 段链接信息 */
	Elf32_Word    sh_info;        /* 段链接信息 */
    
	Elf32_Word    sh_addralign;   /* 段地址对齐 */
	Elf32_Word    sh_entsize;     /* 项的长度*/
} Elf32_Shdr;
```

段表这个数组的第一个元素是无效的段描述符，类型为NULL。

------

### 字符串表

把字符串集中起来存放到一个表里，引用字符串只需要给出下标（偏移）即可。

`.strtab`是字符串表，保存普通的字符串，比如符号的名字。

`.shstrtab`是段表字符串表，保存段表中用到的字符串，最常见的就是段名`(sh_name)`。

------

### 符号表

```c
typedef struct
{
    Elf32_Word    st_name;        /* 符号名，在字符串表的下标 */
	Elf32_Addr    st_value;       /* 符号在段内的偏移，可能是一个绝对值，也可能是个地址 */
	Elf32_Word    st_size;        /* 符号大小，比如double类型是8 */
    
    // st_info 高4位表示符号绑定信息
    // STB_LOCAL 0 局部符号，对于目标文件的外部不可见
    // STB_GLOBAL 1 全局符号，外部可见
    // STB_WEAK 2 弱引用
    
    // st_info 低四位表示符号的类型 
    // STT_NOTYPE 0 未知类型符号
    // STT_OBJECT 1 该符号是个数据对象，比如变量和数组等
    // STT_FUNCC 2 该符号是个函数或其它可执行代码
    // STT_SECTION 3 该符号表示一个段，这种符号必须是STB_LOCAL
    // STT_FILE 4 该符号表示文件名，一般对应源文件名，它一定是STB_LOCAL类型，并且st_shndx是SHN_ABS
	unsigned char st_info;        /* 符号类型和绑定信息 */
	unsigned char st_other;       /* 该成员目前为0，暂无用处 */
    
    // 如果符号定义在本目标文件中，那么这个成员表示所在的段在段表的下标
    // 如果符号不是定义在本目标文件，或者对于有些特殊符号，sh_shndx的值有些特殊，如下所示
    // SHN_ABS 0xfff1 表示该符号包含了一个绝对的值，比如表示文件名的符号就属于这种类型
    // SHN_COMMON 0xfff2 表示该符号是一个common块类型的符号，一般来说，未初始化的全局符号定义就是这种类型
    // SHN_UNDEF 0 表示该段未定义，这个符号表示该符号在本目标文件被引用到，但是定义在其它文件
	Elf32_Section st_shndx;       /* 符号所在段 */
} Elf32_Sym;
```

链接过程中很关键的一部分就是符号的管理，每一个目标文件都会有***一个***相应的符号表。这个表里面记录了目标文件中所用到的所有符号，每个定义的符号有一个相应的值，叫做符号值。对于变量和函数来说，符号值就是它们的地址。

符号的分类：

- 定义在本目标文件的全局符号，可以被其它目标文件引用。
- 在本目标文件中引用的全局符号，却没有定义在本目标文件中，这一般叫做外部符号。比如printf
- 段名，这种符号由编译器产生，它的值就是该段的起始地址。
- 局部符号，这类符号只在编译单元内部可见。比如局部静态变量

链接过程只关心全局符号的相互粘合，也就是上面的第一类合第二类。

------

### 强符号与弱符号

在编程中碰到一种情况叫符号重新定义，多个目标文件中含有相同名字的全局符号定义，那么在这些目标文件链接的的时候将会出现符号重复定义的错误。

初始化的全局变量可以称为强符号，未初始化的全局变量为弱符号。

```c
// weak weak2是弱符号
// strong main是强符号
// ext即非强符号也非弱符号，因为它是一个外部变量得引用
extern int ext;

int weak;
int strong = 1;
__attribute__((weak)) weak2 = 2;

int main(void) {
    return 0;
}
```

针对强弱符号的概念，链接器就会按如下规则处理与选择被多次定义的全局符号：

- 不允许强符号被多次定义（不同文件不能有同名的强符号），编译器会报错
- 如果一个符号在某个目标文件中是强符号，在其它文件都是弱符号，那么选择强符号
- 如果一个符号在所有目标文件都中都是弱符号，那么选择其中占用空间最大的一个

------

### 可重定位表

链接器在处理目标文件时，需要对目标文件中某些部位进行重定位，这些重定位信息就记录在重定位表。

对于每个需要重定位的代码段或数据段，都会产生一个相应的重定位表。

`.rel.text`段是针对.text段的重定位表，`sh_type`为`SHT_REL`，这个就是重定位表。

```c
typedef struct {
    ELF32_Adrr r_offset; // 重定位入口偏移，是需要修正位置的第一个字节相对于段起始偏移
    ELF32_Word r_info; // 低8位表示重定位类型，高28位表示重定位入口的符号在符号表的下标
}
```

------

### 链接器的历史

为什么单独介绍链接器？因为链接器的历史比编译器要早，在纸带编程的时候，就有链接。

在纸带编程的年代，如果有一条跳转指令人工确定了跳转位置，我们在这个跳转指令之后添加了几条指令，就需要重新修改跳转地址，这个过程也叫***重定位***。如果在多个纸带之间跨纸带跳转，就变得复杂和繁琐。

所以有了汇编语言，使用各种符号和标记来帮助记忆，用符号来标记位置。不管插入了多少条语句，汇编器每次都会重新计算符号地址。

### 

