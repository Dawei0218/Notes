# 初次运行git配置

```shell
# local 对某个仓库有效
# golbal 对当前用户所有仓库有效
# system 对系统所有登录的用户有效
git config --global user.name 'your_name'
git config --global user.email 'your_email'

# 查看已经配置的配置项 可以查看global local system下的
# 执行local只能在一个仓库里面
git config --list --global
```