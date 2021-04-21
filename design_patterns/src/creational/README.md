### 简单工厂

1. 解决类创建问题
2. 屏蔽底层创建类细节，可能创建过程很复杂
3. 但是不满足开闭原则

### 工厂方法

1. 满足开闭原则
2. 屏蔽底层创建细节
3. 随着需要创建的类变多，类的数量成对增加，增加了系统复杂度

### 抽象工厂

1. 一个产品族的类被设计在一起工作
2. 增加新的产品族容易，如果增加新的产品就会变得复杂

### 建造者

1. 一个类的属性很多，引入建造者