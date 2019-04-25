# 招协评分api

## 获取评分 

### 基本信息

BaseURL `score_in.php`

#### GET`{json}`

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

| table_name | 场次       | 选手1         | 选手2         | 选手3         | 选手4         | 选手5         |
| ---------- | ---------- | ------------- | ------------- | ------------- | ------------- | ------------- |
| score      | stage(int) | role1(double) | role2(double) | role3(double) | role4(double) | role5(double) |

### 错误对照

| HttpStatusCode | Error | Msg             | Meaning                |
| -------------- | ----- | --------------- | ---------------------- |
| 403            | 40300 | json is not set | {json}关键字没有       |
| 403            | 40301 | json is null    | json空                 |
| 403            | 40302 | insert is faile | 插入失败(已经关闭报错) |
| 500            | 50000 | database error  | 数据库连接失败         |

## 展示评分 

### 基本信息

BaseURL `show.php`

#### GET:`stage`

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

## 获取队名

### 基本信息

BaseURL `team.php`

#### GET:`stage`

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

