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

        $curl = new Curl();
        $curl->setReferrer("https://www.huya.com/{$id}/");
        $curl->setOpt(CURLOPT_SSL_VERIFYPEER,0);
        $curl->setOpt(CURLOPT_SSL_VERIFYHOST,0);
        $html = $curl->get("https://www.huya.com/{$id}");

        preg_match("/<title>(.*?)<\/title>/", $html, $title);
        preg_match("/\"startTime\":\"(.*?)\"/", $html, $date);
        preg_match("/\"isOn\":(.*?),/", $html, $isOn);
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
