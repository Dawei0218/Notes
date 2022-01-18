# buff pool

在 MySQL 服务器启动的时候就向操作系统申请了一片连续的内存，他 们给这片内存起了个名，叫做 Buffer Pool 



默认情况下 Buffer Pool 只有 128M 大小。当然如果你嫌弃这个 128M 太大或者太小，可以在启 动服务器的时候配置 innodb_buffer_pool_size 参数的值

