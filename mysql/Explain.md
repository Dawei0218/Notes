# Explain

| 列名          | 描述                                                      |
| ------------- | --------------------------------------------------------- |
| id            | 在一个大的查询语句中每个 SELECT 关键字都对应一个唯一的 id |
| select_type   | SELECT 关键字对应的那个查询的类型                         |
| table         | 表名                                                      |
| partitions    | 匹配的分区信息                                            |
| type          | 针对单表的访问方法                                        |
| possible_keys | 可能用到的索引                                            |
| key           | 实际上使用的索引                                          |
| key_len       | 实际使用到的索引长度                                      |
| ref           | 当使用索引列等值查询时，与索引列进行等值匹配的对象信息    |
| rows          | 预估的需要读取的记录条数                                  |
| filtered      | 某个表经过搜索条件过滤后剩余记录条数的百分比              |
| Extra         | 一些额外的信息                                            |

------

### id

每个语句有一个值，连接时两个表的id一样

------

### type

const。通过主键列、唯一二级索引列定位一条记录

ref。普通的二级索引列与常数进行等值比较

ref_or_null  二级索引列的值等于某个常数的记录，还想把该列的值为 NULL 的记录也找出 来

range   利用索引进行范围匹配

index。遍历整个二级索引

all  全表

eq_ref 被驱动表使用主键 值或者唯一二级索引列的值

------

### Extra

Using index    当我们的查询列表以及搜索条件中只包含属于某个索引的列，也就是在可以使用索引覆盖的情况下，在 Extra 列将会提示该额外信息。



Using index condition     使用了索引下推



Using where。  

​	当我们使用全表扫描来执行对某个表的查询，并且该语句的 WHERE 子句中有针对该表的搜索条件时

​	当使用索引访问来执行对某个表的查询，并且该语句的 WHERE 子句中有除了该索引包含的列之外的其他搜索 条件时，



 Using join buffer 



Using filesort   内存中或者磁盘上进行排序的方式统称为文件排序



 Using temporary    MySQL 可能会借助临时表来完成一些功能，比如去重、排序之类的，比如我们在 执行许多包含 DISTINCT 、 GROUP BY 、 UNION 等子句的查询过程中，如果不能有效利用索引来完成查询，

MySQL 很有可能寻求通过建立内部的临时表来执行查询。如果查询中使用到了内部的临时表，在执行计划 的 Extra 列将会显示 Using temporary 提示

```

```