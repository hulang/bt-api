## 宝塔面板API 插件扩展包

### 环境

- php >=7.0.0

## 安装
```php
composer require hulang/bt-api
```

#### 介绍
宝塔面板API

#### 使用说明

```php
<?php
    $bt = new System('http://127.0.0.1:8888', 'Key');
    $bt->getSystemTotal();

```