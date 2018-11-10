<p align="center">
<img src="https://i.imgur.com/NZpRScX.png" alt="RSSHub" width="100">
</p>
<h1 align="center">RSSHub PHP Ver.</h1>

> 🍰 万物皆可 RSS

RSSHub 是一个轻量、易于扩展的 RSS 生成器, 可以给任何奇奇怪怪的内容生成 RSS 订阅源

# 列表

一个十分寒酸的支持列表

若无符合请求路由, 请求将会返回一个奇奇怪怪的 RSS 错误页.

## 社交媒体

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