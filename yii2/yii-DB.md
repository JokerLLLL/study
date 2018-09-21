### 原生sql
```text
$command = Yii::$app ->db->createCommand($sql);
$command ->getRowSql();
$command ->bindParam(':id',$id); //引用
$command ->bindValues([':id'=>$id]); //绑定

$num = $rows ->count();               //条数
$data = $rows ->readAll();            //数据

$rows = $command ->queryAll();        //直接去取出数据
```

#### 批量插入
```php
<?php
   
   \Yii::$app->db->createCommand()
   ->batchInsert('table',['name','key1','key2',],[
       ['joker','mykey1','mykey2'],
       ['ban','mykey1','mykey2'],
   ])->execute();

```

#### 自增字段

```php
<?php
//sql 层
Topic::updateAllCounters(['view_count' => 1], ['id' => $id]);

//Expression 表示表达式 如sum()
Topic::updateAll(
    ['view_count' => new Expression('`view_count` + 1'), 'updated_at' => time()],
    ['id' => $id]
);

//模型层
$model = Post::findOne($id);
$model->updateCounters(['view_count' => 1]); //该方法并不通过模型层更新 但能更新模型层数据
```




### 乐观锁
```php
<?php

//AR类中重写
public function optimisticLock()
{
    return 'version';
}
```

### 相同AR类中 关联别名
```php
<?php

public function getOne()
{
    return $this->hasOne(AR::className(),['uid'=>'uid'])->from('table as u');
}

```








