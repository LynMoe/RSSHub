<?php namespace RSSHub\Plugins\live;
use Curl\Curl;
use RSSHub\Lib\Cache;
use RSSHub\Lib\Exception;
use RSSHub\Lib\XML;
use Symfony\Component\DomCrawler\Crawler;
class douyu
{
    public $_info = [
        'routes' => [
            'douyu/:id' => 'douyu',
        ],
    ];
    
    public static function douyu($id)
   {
   		$md5 = md5("http://open.douyucdn.cn/api/RoomApi/room/{$id}");
   		$data = Cache::getCache($md5,function () use ($id)
        {
            $curl = new Curl();
            $curl->setReferrer("https://www.douyu.com/{$id}/");
            $curl->setOpt(CURLOPT_SSL_VERIFYPEER,0);
            $curl->setOpt(CURLOPT_SSL_VERIFYHOST,0);

            $data = json_decode(json_encode($curl->get("http://open.douyucdn.cn/api/RoomApi/room/{$id}")),true);

            return $data;
        });

        $data = json_decode($data,true);
        $list = [
            'title' => $data['data']['owner_name'].'的斗鱼直播间',
            'description' => $data['data']['owner_name'].'的斗鱼直播间',
        ];
		if($data['data']['online']!=0){
			            $list['items'] = [
                [
                    'title' =>  '开播: '.$data['data']['room_name'],
                    'link' => "https://www.douyu.com/{$id}",
                    'date' => strtotime(date($data['data']['start_time'])),
                    'description' => '开播: '.$data['data']['room_name'],
                ],
            ];
		}
        return XML::toRSS($list);
    }
}
