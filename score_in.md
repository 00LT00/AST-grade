## 获取评分 

BaseURL `score_in.php`

### GET`{json}`

Param

- `stage` :场次(int)
- `role(a)`:得分 a(int)

example

```json
{
"stage": 2,
"role1": 100,
"role2": 95,
"role3": 80,
"role4": 99,
"role5": 59
}
```

Response

- (string)

```json
{
    "error": "0",
    "msg": "insert is success"
}
```

### 数据表字段名

| table_name | 场次       | 选手1      | 选手2      | 选手3      | 选手4      | 选手5      |
| ---------- | ---------- | ---------- | ---------- | ---------- | ---------- | ---------- |
| score      | stage(int) | role1(int) | role2(int) | role3(int) | role4(int) | role5(int) |

### 错误对照

| HttpStatusCode | Error | Msg             | Meaning                |
| -------------- | ----- | --------------- | ---------------------- |
| 403            | 40300 | json is not set | {json}关键字没有       |
| 403            | 40301 | json is null    | json空                 |
| 403            | 40302 | insert is faile | 插入失败(已经关闭报错) |
| 500            | 50000 | database error  | 数据库连接失败         |