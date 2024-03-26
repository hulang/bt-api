#### 宝塔面板API 插件扩展包

#### 环境

- php >=7.0.0

#### 安装
```php
composer require hulang/bt-api
```

#### 使用说明

```php
$bt = new System('http://127.0.0.1:8888', 'Key', 'cookie保存目录设置');
$bt->getSystemTotal();
```
