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
