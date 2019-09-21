<?php namespace RSSHub\Plugins\live;
use Curl\Curl;
use RSSHub\Lib\Cache;
use RSSHub\Lib\Exception;
use RSSHub\Lib\XML;
class huya
{
    public $_info = [
        'routes' => [
            'huya/:id' => 'huya',
        ],
    ];

    public static function huya($id) {
        
        if ($id==null) {
            throw new Exception('id不能为空','error');
        }
        $md5=md5("https://www.huya.com/{$id}/");
        $html=Cache::getCache($md5,function () use ($id)
        {
            $curl = new Curl();
        $curl->setReferrer("https://www.huya.com/{$id}/");
        $curl->setOpt(CURLOPT_SSL_VERIFYPEER,0);
        $curl->setOpt(CURLOPT_SSL_VERIFYHOST,0);
        $data = $curl->get("https://www.huya.com/{$id}");
        return $data;
        });
        
        $html=json_decode($html,true);
        preg_match("/<title>(.*?)<\/title>/", $html, $title);
        preg_match("/\"startTime\":\"(.*?)\"/", $html, $date);
        if($date==null){
            preg_match("/\"startTime\":(.*?),/", $html, $date);
        }
        preg_match("/\"isOn\":(.*?),/", $html, $isOn);
        
        if ($date==null) {
            throw new Exception('直播间不存在','error');
        }
        
        $list = [
            'title' => $title[1],
            'description' => $title[1],
            'link' => "https://www.huya.com/{$id}/",
        ];
        if ($isOn[1] == 'true') {
            $list['items'] = [
                [
                    'title' => '正在直播: '.$title[1],
                    'link' => "https://www.huya.com/{$id}",
                    'date' => $date[1],
                    'description' => '正在直播: '.$title[1],
                ],
            ];
        }
        return XML::toRSS($list);
    }
}