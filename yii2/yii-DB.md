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
$model->updateCounters(['view_count' => 1]);
```


#### 批量插入
```php
<?php
   
   \Yii::$app->db->createCommand()
   ->batchInsert('table',['name','key1','key2',],[
       ['name'=>'joker','key1'=>'mykey1','key2'=>'mykey2'],
       ['name'=>'ban','key1'=>'mykey1','key2'=>'mykey2'],
   ])->execute();

```

### 乐观锁
```php
<?php

//AR类中重写
public function optimisticLock()
{
    return 'vesion';
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








