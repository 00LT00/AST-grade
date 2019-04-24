## 获取队名

BaseURL `team.php`

### GET:`stage`

Param

- `stage`:场次(`int`)

Response

```json
{
    "data": {
        "team1": "龙起玄渊团队",
        "team2": "HDU-YYSZ",
        "team3": "从感恩湖畔到月雅湖畔小队",
        "team4": "新纪元回访团",
        "team5": "杭电银川回访小分队"
    },
    "error": "0",
    "msg": "select is success"
}
```

### 错误对照

| HttpStatusCode | Error | Msg              | Meaning                      |
| -------------- | ----- | ---------------- | ---------------------------- |
| 403            | 40300 | stage is not set | stage关键字没有              |
| 403            | 40301 | stage is null    | stage空                      |
| 403            | 40302 | select is faile  | 查询失败                     |
| 500            | 50000 | database error   | 数据库连接失败(已经关闭报错) |