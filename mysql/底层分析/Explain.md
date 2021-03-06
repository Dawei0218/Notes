# Explain

| 列名          | 描述                                                         |
| ------------- | ------------------------------------------------------------ |
| id            | 在一个大的查询语句中，每个 SELECT 关键字都对应一个唯一的 id  |
| select_type   | SELECT 关键字对应的查询的类型                                |
| table         | 表名                                                         |
| partitions    | 匹配的分区信息                                               |
| type          | 针对单表的访问方法                                           |
| possible_keys | 可能用到的索引                                               |
| key           | 实际使用的索引                                               |
| key_len       | 实际使用的索引长度                                           |
| ref           | 当使用索引列等值查询时，与索引列进行等值匹配的对象信息       |
| rows          | 预估的需要读取的记录条数                                     |
| filtered      | 针对预估的需要读取的记录，经过搜索条件过滤后剩余记录条数的百分比 |
| Extra         | 一些额外的信息                                               |

------

### id

- 查询语句中每出现一个 `SELECT` 关键字，就会为它分配一个唯一的id。
- 在连接查询时，每个表都会对应一条记录，这些记录的id列的值是相同的。出现在前面的表是驱动表，后面的是被驱动表。
- 优化器可能会对子查询重写，如果id列相同就是转换成连接查询。

------

### select_type

| 名称         | 描述                                                         |
| ------------ | ------------------------------------------------------------ |
| SIMPLE       | 查询语句中不包含UNION或者自查询的查询                        |
| PRIMARY      | UNION、UNION ALL或者子查询，最左边的那个查询的select_type就是PRIMARY |
| UNION        | UNION、UNION ALL或者子查询，除了最左边那个查询，其余都是UNION |
| UNION RESULT | MySQL使用临时表完成UNION查询的去重                           |
| SUBQUERY     | 包含子查询的查询语句不能够转为对应的半连接形式               |

------

### type

| 名称        | 描述                                                         |
| ----------- | ------------------------------------------------------------ |
| system      | 表中只有一条数据并且该表使用的存储引擎的统计数据是精确的（MyISAM、MEMORY） |
| const       | 通过主键或者唯一二级索引列与常数进行等值匹配                 |
| eq_ref      | 执行连接查询时，被驱动表是通过主键或者不允许存储NULL值的唯一二级索引列等值进行匹配（联合索引所有列都必须进行等值比较） |
| ref         | 通过普通的二级索引列与常量进行等值匹配的方式来查询某个表时，连接时被驱动表是普通二级索引，也有可能是ref |
| ref_or_null | 普通二级索引进行等值匹配且该索引列的值也可以是NULL值时       |
| range       | 使用索引获取某些单点扫描区间或者范围扫描区间                 |
| index       | 可以使用索引覆盖，但需要扫描全部的所有记录时                 |
| all         | 全表扫描                                                     |

------

### Extra

| 名称                    | 描述                                                     |
| ----------------------- | -------------------------------------------------------- |
| No tables used          | 没有from子句时                                           |
| lmpossible WHERE        | where子句永远为false时，比如 1 != 1                      |
| No matching min/max row | 查询列表处有min/max函数，但是没有满足where子句的搜索条件 |
| Using Index             | 使用覆盖索引执行查询                                     |
| Using index condition   | 使用了索引下推                                           |
| Using where             | 需要在server层进行判断                                   |
| all                     | 全表扫描                                                 |
