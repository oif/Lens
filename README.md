# Lens

## 框架目录结构

- app
  - controller    控制器：上层控制器以及基础控制器类（Controller）
  - model    模型：上层模型以及基础模型类（Model、SQL）
  - view    视图：上层视图以及基础视图类（View）
- framework    框架核心
  - Lens.php    实例化框架
  - Core.php    框架核心，自动加载以及路由
  - Route.php    路由
- public    资源
- app.php    框架配置文件
- index.php    唯一入口




## 配置

- 将根目录下 meitu.sql 导入创建好的数据库
- 修改 app.php 中的数据库相关配置信息。
- 完成




## 数据库表设计

### Users

- id: 用户ID 自增、主键
- name: 用户名 唯一
- password: 用户密码
- avatar: 用户头像
- token: API 认证 token
- expire: token 过期时间


## 路由

### /user/register  [POST]

- 请求字段

  - name 用户名：3～10位的大小写字母数字（必须）
  - password 密码：6～18位的大小写字母数字（必须）
  - avatar 头像：URL（必须）

- 返回结果

  - 正确返回：

    {
    "token": "用户token",
    "expire": "过期时间"
    }

  - 错误返回：{"stat":"错误提示"}

### /user/login  [POST]

- 请求字段

  - name 用户名：3～10位的大小写字母数字（必须）
  - password 密码：6～18位的大小写字母数字（必须）

- 返回结果

  - 正确返回：

    {
    "token": "用户token",
    "expire": "过期时间"
    }

  - 错误返回：{"stat":"错误提示"}

### /user/info  [POST]

- 请求字段

  - token 标示码：128位的随机大小写字母数字（必须）

- 返回结果

  - 正确返回：

    {
      "id": "用户 ID",
      "name": "用户名",
      "avatar":"用户头像地址"
    }

  - 错误返回：{"stat":"错误提示"}

