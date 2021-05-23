#  .git目录

```shell
-rw-r--r-- 1 wangmaolin 197121   3  5月  8 23:18 COMMIT_EDITMSG
-rw-r--r-- 1 wangmaolin 197121 130  5月  8 23:06 config
-rw-r--r-- 1 wangmaolin 197121  73  5月  8 23:06 description
-rw-r--r-- 1 wangmaolin 197121 132  5月 18 23:52 gitk.cache
-rw-r--r-- 1 wangmaolin 197121  23  5月  8 23:06 HEAD
drwxr-xr-x 1 wangmaolin 197121   0  5月  8 23:06 hooks/
-rw-r--r-- 1 wangmaolin 197121 209  5月  8 23:18 index
drwxr-xr-x 1 wangmaolin 197121   0  5月  8 23:06 info/
drwxr-xr-x 1 wangmaolin 197121   0  5月  8 23:09 logs/
drwxr-xr-x 1 wangmaolin 197121   0  5月  8 23:18 objects/
-rw-r--r-- 1 wangmaolin 197121  41  5月  8 23:10 ORIG_HEAD
drwxr-xr-x 1 wangmaolin 197121   0  5月  8 23:06 refs/
```

------

### HEAD

```shell
$ cat HEAD
ref: refs/heads/master
```

在master分支就会显示master，如果在tmp分支就是tmp，切换分支就会变。

------

### config

```shell
$  cat config
[core]
        repositoryformatversion = 0
        filemode = false
        bare = false
        logallrefupdates = true
        symlinks = false
        ignorecase = true
```

比如设置当前conifg --local也会记录在里面，记录当前目录的配置

------

### refs/

```shell
drwxr-xr-x 1 wangmaolin 197121 0  5月  8 23:18 heads/
drwxr-xr-x 1 wangmaolin 197121 0  5月  8 23:06 tags/

$ ll heads
-rw-r--r-- 1 wangmaolin 197121 41  5月  8 23:18 master

$ cat master
7eac9cccc70172c6298c69f2fa80fd1204916cce # 可以查看对象类型

### 查看对象类型
$ git cat-file -t 7eac9ccc # 如果短的时候识别，就可以使用短的类型，如果重现重复就需要使用长一点的
commit

$ git cat-file -p 7eac9ccc  # -p 查看内容
tree e3861fedd2c6b89f26992def045fed84a3843a73 # tree类型
parent e8551fb15d02345574bec61b77665ffb8f5b08f9
author wangmaolin <wangmaolin0218@gmail.com> 1620487103 +0800
committer wangmaolin <wangmaolin0218@gmail.com> 1620487103 +0800

2"

```

保存tags就是标签，heads就是分支

HEAD指向heads/分支，heads/分支 指向的具体的commit

------

### objects/

```shell
$ ll objects/
total 0
drwxr-xr-x 1 wangmaolin 197121 0  5月  8 23:09 1b/
drwxr-xr-x 1 wangmaolin 197121 0  5月  8 23:08 70/
drwxr-xr-x 1 wangmaolin 197121 0  5月  8 23:18 7e/
drwxr-xr-x 1 wangmaolin 197121 0  5月  8 23:07 9a/
drwxr-xr-x 1 wangmaolin 197121 0  5月  8 23:18 e3/
drwxr-xr-x 1 wangmaolin 197121 0  5月  8 23:09 e8/
drwxr-xr-x 1 wangmaolin 197121 0  5月  8 23:06 info/
drwxr-xr-x 1 wangmaolin 197121 0  5月  8 23:06 pack/ # 打包

$ ll 1b/
total 1
-r--r--r-- 1 wangmaolin 197121 54  5月  8 23:09 087ce30827746cbb2fd472bff2898ee1fb70de # 吧1b和文件名合并形成hash

```



