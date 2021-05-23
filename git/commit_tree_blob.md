# commit tree blob关系

git commit命令就是一个commit对象，一个commit对象有tree和blob。

tree可以理解为目录，blob是文本。

git中不是按照文件名区分唯一，而是通过文件内容。

------

```
新建一个仓库，只有一个commit，仅包含/doc/readme，它的tree和blob的结构
```

commit里面有个tree，这个tree的内容是   tree  doc（就是仓库文件全部展示出来）

doc这个tree指向一个tree，内容是blob readme（展示doc下的内容）

blob指向文件内容