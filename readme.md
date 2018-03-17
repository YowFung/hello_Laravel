## 项目概述

- 项目名称： 简易微博
- 项目代号： yowfung/microBlog
- 开发人员： [yowfung](https://github.com/YowFung/)
- 开发框架： Laravel 5.5/BootStrap v3
- 当前版本： 1.1.0

yowfung/microBlog 是一个简洁的微博应用网站，使用 Laravel 5.5 后端框架及 BootStrap v3 前端框架编写而成。该项目为本人(yowfung)学习 Laravel 开发框架的一个实战项目。

## 应用功能

- 用户认证——注册、登录、退出；
- 个人中心——个人资料、修改资料、修改密码、微博动态列表、关注人列表、粉丝列表、消息中心、留言板等；
- 首页动态——关注人的最新微博动态、最新推荐动态、搜索用户等；
- 表单验证——Request
- 访问权限——Middleware
- 授权策略——Policy

## 测试上线

- 测试环境： Ubuntu 16.04/Nginx 1.11/MySQL 5.7
- 数据库迁移和填充：
```shell
    php artisan migrate --seed
```

## 项目约定

- 数据长度：
    - 用户昵称： min:3|max:50
    - 邮箱地址： min:1|max:255
    - 登录密码： min:6|max:16
    - 用户资料-社团：nullable|max:200
    - 用户资料-院系：nullable|max:200
    - 用户资料-籍贯：nullable|max:200
    - 微博动态内容：min:3|max:200
    - 动态评论内容：min:1|max:140
    - 留言内容： min:3|max:1000
    - 留言回复： min:1|max:140
    - 消息内容： min:10|max:500
    
- 数据唯一：
    - 用户昵称： unique: users
    - 邮箱地址: unique: users
    
- 数据限制：
    - 用户性别： in: male, female
    - 消息类别： in: system, attach, letter, letter_reply, comment, comment_reply
    
- 路由设计：
    遵循RESTFul规范
    
- 代码风格：
    遵循PSR规范
    