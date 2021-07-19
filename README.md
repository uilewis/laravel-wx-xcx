# laravel-wx-xcx for Laravel 5

###
laravel-wx-xcx

腾讯微信小程序composer包


###### ***************************

# laravel Installation
### Install via composer
Run the following command to pull in the latest version:
###### composer命令安装扩展包
```php
composer require uilewis/laravel-wx-xcx
```
#####  For laravel >=5.5 that's all. This package supports Laravel new Package Discovery.    
#####  If you are using Laravel < 5.5, you also need to add YueCode\Cos\QCloudCosServiceProvider::class to your ``` config/app.php ``` providers array:
###### 如果laravel版本小于5.5 需要添加YueCode\Cos\QCloudCosServiceProvider::class到 ``` config/app.php ``` 文件中如下：
```php
'providers' => [

        /*
         * Application Service Providers...
         */
         ......
        Uilewis\WxXcx\WxXcxServiceProvider::class,
    ],
```

### To publish the config settings in Laravel 5 use:
###### 执行命令复制COS配置文件到config目录
```php
php artisan vendor:publish --provider=" Uilewis\WxXcx\WxXcxServiceProvider"
```

### Configure config 
###### 配置config/cos.php 
```php
config/xcx_wx.php 
```

# Usage
######  使用
```php

......

    // 微信小程序
    $xcx = app('xcx');
    
    /**
     * 通过code获取用户信息
     * @param $code  小程序code
     * @return array  用户信息
     */
     $user_info_arr = $xcx->getLoginInfo($code);
    
 
  

```



###### ***************************





# Lumen Installation

### Install via composer
Run the following command to pull in the latest version:
```php
composer require uilewis/laravel-wx-xcx
```
Bootstrap file changes.
Add the following snippet to the bootstrap/app.php file under the providers section as follows:
###### 添加以下代码到```bootstrap/app``` 文件中 Register Service Providers 部分
```php
$app->register(UiLewis\WxXcx\WxXcxServiceProvider::class);
```
### Configure config 
###### 配置config/cos.php 
```php
config/xcx_wx.php 
```
