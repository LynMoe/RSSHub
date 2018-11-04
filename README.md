<p align="center">
<img src="https://i.imgur.com/NZpRScX.png" alt="RSSHub" width="100">
</p>
<h1 align="center">RSSHub<small> PHP Ver.</small></h1>

> 🍰 万物皆可 RSS

## 介绍

RSSHub 是一个轻量、易于扩展的 RSS 生成器，可以给任何奇奇怪怪的内容生成 RSS 订阅源

这里是[她](https://github.com/DIYgod/RSSHub)的 PHP 版本，开坑就是因为 DIY 太会咕了 (x

明知道开了坑也没生态但还要开的是不是应该叫傻子呢 (小声

## 参与我们

如果有任何想法或需求，可以在 [issue](https://github.com/LoliLin/RSSHub/issues) 中告诉我们，同时我们欢迎各种 pull requests

### 提交新的 RSS 内容

1.  在 [/plugins/](https://github.com/LoliLin/RSSHub/blob/master/plugins) 里添加对应分类 (若不存在)

2.  在 [/plugins/分类名](https://github.com/LoliLin/RSSHub/blob/master/plugins) 中添加获取 RSS 内容的脚本

3.  更新文档: [/README.md](https://github.com/LoliLin/RSSHub/blob/master/README.md)

### 插件格式

### 基本

请查看 ```/plugins/example/example.php``` 文件

每个类的命名空间为 `RSSHub\Plugins\分类名`

#### 属性

每个类都需要定义公开属性 `$_info` ， 其中包括 `routes` 路由表， 如下
```php
public $_info = [
        'routes' => [
            'test/:input1/:input2' => 'input',
        ],
    ];
```
  - 键 `test/:input1/:input2` 代表在该插件分类中(example)， 定义名为 `test` 的路由， 输入参数为 `input1` 与 `input2`
  - 值 `input` 代表处理该条请求的函数方法为 `input` **注意：该方法必须为静态方法且在该类中**

#### 内置方法

```XML::toRSS($list)``` 是内置的函数方法，用于生成标准化的 RSS 内容，本质是 [mibe/FeedWriter](https://github.com/mibe/FeedWriter) ，开发者亦可直接使用该类库
  - 输入参数数组包含 `title` `description` `image` 以及 `items`
    - `image` 又包含 `url` `src` 以及 `title` ， 该参数若不需要可直接忽略
    - `items` 是内容数组 ， 格式如下
      - `title` 标题
      - `link` URL 链接
      - `date` 时间戳
      - `description` 内容

### 错误处理

若在处理过程中遇到错误，直接抛出 `RSSHub\Lib\Exception` 异常即可，第一位输入参数为消息，第二位为等级(可选 `warning` 以及 `error`)

输出时会自动添加 RSS header， 请勿重复添加

## 部署

1.  `git clone https://github.com/LoliLin/RSSHub.git`
2.  `composer install`
3.  配置伪静态规则 (nginx 规则如下)
```nginx
rewrite ^(.*)$ /index.php?s=$1 last;
```