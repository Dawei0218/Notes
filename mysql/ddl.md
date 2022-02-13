# DDL

### 数据库基本操作

```sql
# SHOW VARIABLES LIKE 'datadir'; 查看数据目录

# 数据库操作
SHOW DATABASE;
CREATE DATABASE test;
CREATE DATABASE IF NOT EXISTS test;
USE test;
DROP DATABASE test;

# 表操作
SHOW TABLES FROM test;
SHOW TABLES;

CREATE TABLE test (
	id INT UNSIGNED NOT NULL DEFAULT 0 AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255),
  # PRIMARY KEY(id)
  UNIQUE KEY uk_id1(id1)
) COMMENT '表注释';

ALTER TABLE test ADD COLUMN id2 INT;
ALTER TABLE test ADD COLUMN id2 INT FIRST;
ALTER TABLE test ADD COLUMN id2 INT AFTER id;

ALTER TABLE test DROP COLUMN id2;
ALTER TABLE test MODIFY id2 CHAR(20);

# 还可以转移到db1库下并改名
ALTER TABLE test RENAME TO db1.test1;
RENAME TABLE test TO test1, test01 TO test02;

DROP TABLE test;

DESC test;
SHOW CREATE TABLE test\G;
```

------

### 备份与恢复

```sql
mysqldump -uroot -hlocalhost -p db1 test > test.sql
mysqldump -uroot -hlocalhost -p --database db1 db2 > test.sql
mysqldump -uroot -hlocalhost -p --all-database > test.sql

source test.sql
```

------

### 用户与权限

```sql
# 用户1 只能localhost登录（默认值为%） 密码88888
CREATE USER 'user1'@'locahost' IDENTIFIED BY '88888';
CREATE USER 'user1' IDENTIFIED BY '88888';

# 修改密码
ALTER USER 'user1'@'locahost' IDENTIFIED BY '8888888';

DROP USER 'user1'@'localhost';

# 权限
GRANT 权限名称 ON 应用级别 TO 'user1'@'localhost';
```



