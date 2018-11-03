<?php
/**
 * Created by PhpStorm.
 * User: XiaoLin
 * Date: 2018-11-03
 * Time: 6:18 PM
 */

namespace RSSHub\Plugins\bilibili;

use Curl\Curl;
use RSSHub\Lib\Exception;
use RSSHub\Lib\XML;

class user
{
    public $_info = [
        'routes' => [
            'user/video/:uid' => 'video',
            'user/article/:uid' => 'article',
            'user/dynamic/:uid' => 'dynamic',
            'user/coin/:uid' => 'coin',
        ],
    ];

    protected function getUserData($uid)
    {
        $curl = new Curl();
        $curl->setReferrer("https://space.bilibili.com/{$uid}/");
        $curl->setHeader('Content-Type','application/x-www-form-urlencoded');
        $curl->setOpt(CURLOPT_SSL_VERIFYPEER,0);
        $curl->setOpt(CURLOPT_SSL_VERIFYHOST,0);
        $data = $curl->post("https://space.bilibili.com/ajax/member/GetInfo",[
            'mid' => $uid,
        ]);

        if ($data->status == true)
        {
            return json_decode(json_encode($data),true)['data'];
        } else
            throw new Exception("[BiliBili] UID:{$uid} 个人信息获取失败.",'error');
    }

    public static function video($uid)
    {
        $curl = new Curl();
        $curl->setReferrer("https://space.bilibili.com/{$uid}/");
        $curl->setOpt(CURLOPT_SSL_VERIFYPEER,0);
        $curl->setOpt(CURLOPT_SSL_VERIFYHOST,0);

        $data = json_decode(json_encode($curl->get("https://space.bilibili.com/ajax/member/getSubmitVideos?mid={$uid}")),true);

        if (is_array($data) && $data['status'] == true)
        {
            $user = (new user)->getUserData($uid);

            $list = [
                'title' => $user['name'] . ' 的哔哩哔哩投稿',
                'link' => "https://space.bilibili.com/{$uid}/#/video",
                'description' => "签名: {$user['sign']}",
                'image' => [
                    'url' => $user['face'],
                    'title' => 'face',
                    'src' => $user['face'],
                ],
                'items' => [],
            ];

            foreach ($data['data']['vlist'] as $video)
            {
                $list['items'][] = [
                    'title' => $video['title'],
                    'link' => "https://www.bilibili.com/video/av{$video['aid']}",
                    'date' => $video['created'],
                    'description' => $video['description'] . "<br><img referrerpolicy=\"no-referrer\" src=\"{$video['pic']}\">",
                ];
            }

            return XML::toRSS($list);
        } else
            throw new Exception("[BiliBili] UID: {$uid} 个人投稿获取失败",'error');

        //var_dump($data);
    }

    public static function article($uid)
    {

    }

    public static function dynamic($uid)
    {

    }

    public static function coin($uid)
    {
        return $uid;
    }
}