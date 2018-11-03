<?php
/**
 * Created by PhpStorm.
 * User: XiaoLin
 * Date: 2018-11-04
 * Time: 12:48 AM
 */

namespace RSSHub\Plugins\bilibili;

use Curl\Curl;
use RSSHub\Lib\Cache;
use RSSHub\Lib\Exception;
use RSSHub\Lib\XML;

class bangumi
{
    public $_info = [
        'routes' => [
            'bangumi/:sessionID' => 'bangumi',
        ],
    ];

    public static function bangumi($sessionID)
    {
        $md5 = md5("https://bangumi.bilibili.com/jsonp/seasoninfo/{$sessionID}.ver?callback=seasonListCallback&jsonp=jsonp&_=233333");

        $data = Cache::getCache($md5,function () use ($sessionID)
        {
            $curl = new Curl();
            $curl->setReferrer("https://bangumi.bilibili.com/anime/{$sessionID}/");
            $curl->setOpt(CURLOPT_SSL_VERIFYPEER,0);
            $curl->setOpt(CURLOPT_SSL_VERIFYHOST,0);

            $data = json_decode(json_encode($curl->get("https://bangumi.bilibili.com/jsonp/seasoninfo/{$sessionID}.ver?callback=seasonListCallback&jsonp=jsonp&_=233333")),true);

            return $data;
        });

        $data = json_decode(json_decode(str_replace('seasonListCallback(','',str_replace('});','}',$data)),true),true);

        if (is_array($data) && $data['code'] == 0)
        {
            $list = [
                'title' => $data['result']['bangumi_title'],
                'link' => "https://bangumi.bilibili.com/anime/{$sessionID}/",
                'description' => $data['result']['evaluate'],
                'image' => [
                    'url' => $data['result']['cover'],
                    'title' => 'cover',
                    'src' => $data['result']['cover'],
                ],
                'items' => [],
            ];

            foreach ($data['result']['episodes'] as $episode)
            {
                $list['items'][] = [
                    'title' => $episode['index_title'],
                    'link' => $episode['webplay_url'],
                    'date' => strtotime($episode['update_time']),
                    'description' => "<img referrerpolicy=\"no-referrer\" src=\"{$episode['cover']}\"><br>",
                ];
            }

            return XML::toRSS($list);
        } else
            throw new Exception("[BiliBili] SID: {$sessionID} 番剧获取失败",'error');
    }
}