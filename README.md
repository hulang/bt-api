#### 宝塔面板`API`接口扩展包

<p align="center"> 
  您是第  <img src="https://profile-counter.glitch.me/github:hulang:bt-api/count.svg" />位访问者
</p>

#### 环境

- php >=8.0.0

#### 安装
```php
composer require hulang/bt-api
```

#### 使用说明

```php
// Database|File|Ftp|Plugin|Site|System
// 以上都基础了[Base]都可以调用以下示例
$bt = new System('http://127.0.0.1:8888', 'Key', 'cookie保存目录设置');
$bt->getSystemTotal();
```
