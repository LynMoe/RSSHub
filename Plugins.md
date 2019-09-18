<p align="center">
<img src="https://i.imgur.com/NZpRScX.png" alt="RSSHub" width="100">
</p>
<h1 align="center">RSSHub PHP Ver.</h1>

> 🍰 万物皆可 RSS

RSSHub 是一个轻量、易于扩展的 RSS 生成器, 可以给任何奇奇怪怪的内容生成 RSS 订阅源

# 列表

一个十分寒酸的支持列表

若无符合请求路由, 请求将会返回一个奇奇怪怪的 RSS 错误页.

## 小说·文学·阅读

### 笔趣阁

#### 小说更新

- 作者: iLay1678
- 路径: `/novel/biquge/:id`
  - 示例: `/novel/biquge/79_79883`
- 参数说明:
  - id:
    - 小说 id, 可在对应小说页 URL 中找到

::: tip 提示

由于笔趣阁网站有多个, 各站点小说对应的小说 id 不同. 此 feed 只对应在[`www.biquge5200.com`](https://www.biquge5200.com/)中的小说 id.

:::

## 社交媒体

### 开播提醒

#### 斗鱼直播

- 作者: iLay1678
- 路径: `/live/douyu/:id`
  - 示例: `/live/douyu/1126960`
- 参数说明:
  - id:
    - 直播间 id, 可从直播间 URL 中获取

### 哔哩哔哩

#### 番剧

- 作者: LoliLin
- 路径: `/bilibili/bangumi/:sessionID`
  - 示例: `/bilibili/bangumi/2267573`
- 参数说明:
  - sessionID:
    - 番剧 id, 番剧主页打开控制台执行 `window.__INITIAL_STATE__.ssId` 或 `window.__INITIAL_STATE__.mediaInfo.param.season_id` 获取

#### 投稿

- 作者: LoliLin
- 路径: `/bilibili/user/video/:uid`
  - 示例: `/bilibili/user/video/2267573`
- 参数说明:
  - uid:
    - 用户 id, UP 主空间 URL 中获取

#### 动态

- 作者: LoliLin
- 路径: `/bilibili/user/dynamic/:uid`
  - 示例: `/bilibili/user/dynamic/2267573`
- 参数说明:
  - uid:
    - 用户 id, UP 主空间 URL 中获取
