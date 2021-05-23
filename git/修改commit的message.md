# 修改commit的message

### 修改最近的message

```shell
$ git commit --amend
```

------

### 修改老旧message

```shell
git rebase -i hash # 要修改的commit的父级
```

会出来一个页面

```shell
r hash xxx # 之后会弹出一个交互，直接修改就可以
```

------

### 把多个commit整理成一个

```shell
$ git rebase -i hash # 要合并的commit的，最下面的父级
```

pick一个要合并到上面的commit

并且剩下的加上s，有一个不需要