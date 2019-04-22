## 展示评分 

BaseURL `show.php`

### GET:`stage`

Param

- `stage` :场次(`int`)

Response

- data(string)~~用int会因为json_encode的bug出现精度问题~~

```json
{
    "data": {
        "score1": "49.58",
        "score2": "86.92",
        "score3": "73.25",
        "score4": "90.75",
        "score5": "61.17"
    },
    "error": "0",
    "msg": "succes"
}
```

### 错误对照

| HttpStatusCode | Error | Msg              | Meaning                      |
| -------------- | ----- | ---------------- | ---------------------------- |
| 403            | 40300 | stage is not set | stage关键字没有              |
| 403            | 40301 | stage is null    | stage空                      |
| 403            | 40302 | don't have data  | 没有获取到数据               |
| 500            | 50000 | database error   | 数据库连接失败(已经关闭报错) |