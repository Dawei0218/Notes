# optimizer_trace表

optimizer trace系统变量

```
SHOW VARIABLES LIKE 'optimizer_trace';

SET optimizer_trace="enabled=on";
```





1. 打开optimizer trace功能 (默认情况下它是关闭的):

```
    SET optimizer_trace="enabled=on";
```

2. 这里输入你自己的查询语句 SELECT ...;

3. 从OPTIMIZER_TRACE表中查看上一个查询的优化过程 SELECT * FROM information_schema.OPTIMIZER_TRACE;

4. 可能你还要观察其他语句执行的优化过程，重复上边的第2、3步 ...

5. 当你停止查看语句的优化过程时，把optimizer trace功能关闭 SET optimizer_trace="enabled=off";