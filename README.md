# Lens
A light weight PHP framework, start at the moment of the audition of Meitu Corp.



## 框架目录结构

- app
  - controller	控制器：上层控制器以及基础控制器类（Controller）
  - model		模型：上层模型以及基础模型类（Model、SQL）
  - view		视图：上层视图以及基础视图类（View）
- framework	框架核心
  - Lens.php	实例化框架
  - Core.php	框架核心，自动加载以及路由
- public	资源
- runtime	运行临时区
- app.php	框架配置文件
- index.php	唯一入口



## 数据库表设计

### Users

- id: 用户ID 唯一 自增
- name: 用户名 唯一
- password: 用户密码
- avatar: 用户头像
- token: API 认证 token