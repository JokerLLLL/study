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


## yii的事物锁 ##
```php
<?php
$tr = Yii::$app->db->beginTrancation();
// 只支持innodb引擎
Yii::$app->db->createCommand("SELECT * FORM user_data WHERE uid={$uid} FOR UPDATE")->qureyOne();
//查询表 user_data
$model = UserData::findOne(['uid'=>$uid]);
$model->save();

$tr->commit();

```


```php
<?php
//查询构建

1 . asArray() ；
2 . 要只查主表字段 circle.* ；
3 . 相同表要 from('表明 as 别名区分')；

$sql = 
<<<sql
SELECT `circle`.*
FROM `circle`
LEFT JOIN `user_data`
	ON `circle`.`uid` = `user_data`.`uid`
LEFT JOIN `circle_comment` `cir_com_1`
	ON `circle`.`id` = `cir_com_1`.`cir_id`
LEFT JOIN `user_data` `u1`
	ON `cir_com_1`.`uid` = `u1`.`uid`
LEFT JOIN `circle_comment`
	ON `cir_com_1`.`to_comment_id` = `circle_comment`.`id`
LEFT JOIN `user_data` `u2`
	ON `circle_comment`.`uid` = `u2`.`uid`
ORDER BY  `circle`.`create_time` DESC LIMIT 10
sql;

 return $circles = Circle::find()->asArray()->select('circle.*')
             ->joinWith(['author'=>function($query) {
                 return $query->select(['uid','nickname','head_url','phone']);
             }])
             ->joinWith([
                 'comments'=>function($query){
                    return $query->from('circle_comment as cir_com_1');
                 },
                 'comments.u'=>function($query) {
                    return $query->select(['uid','nickname','head_url','phone'])->from('user_data as u1');
                  },
                  'comments.toComment.u'=>function($query) {
                     return $query->select(['uid','nickname','head_url','phone'])->from('user_data as u2');
                  }
              ])
             ->orderBy(['circle.create_time'=>SORT_DESC])
             ->limit($this->limit)->offset($this->limit*$this->page)
//             ->createCommand()->getRawSql();
//           var_dump($circles);
            ->all();

```






