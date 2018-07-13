#### 自增字段
```php
<?php

Topic::updateAllCounters(['view_count' => 1], ['id' => $id]);

//Expression 表示表达式 如sum()
Topic::updateAll(
    ['view_count' => new Expression('`view_count` + 1'), 'updated_at' => time()],
    ['id' => $id]
);

$model = Post::findOne($id);
$model->updateCounters(['view_count' => 1]);
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


