<?php namespace RSSHub\Plugins\blog;
use Curl\Curl;
use RSSHub\Lib\Cache;
use RSSHub\Lib\Exception;
use RSSHub\Lib\XML;
use Symfony\Component\DomCrawler\Crawler;
class handsome
{
    public $_info = [
        'routes' => [
            'handsome/:url' => 'handsome',
        ],
    ];

    public static function handsome($url) {

        if ($url==null) {
            throw new Exception('url不能为空','error');
        }
        
        $curl = new Curl();
        $curl->setReferrer('http://'.$url);
        $curl->setOpt(CURLOPT_SSL_VERIFYPEER,0);
        $curl->setOpt(CURLOPT_SSL_VERIFYHOST,0);
        $curl->setopt(CURLOPT_FOLLOWLOCATION,1);
        $request = $curl->get('http://'.$url);
        //$request = mb_convert_encoding($request, 'UTF-8', 'UTF-8,GBK,GB2312,BIG5');


        $data = [];
        $crawler = new Crawler();
        $crawler->addHtmlContent($request);
        try {
            
            $data['title'] = $crawler->filterXPath('//html/head/title')->text();
            $data['description'] = $crawler->filterXPath('//html/head/title')->text();
            $data['link'] = 'http://'.$url;
            $crawler->filterXPath('//div[contains(@class, "blog-post")]/div')->each(function(Crawler $node, $i) use (&$data){
            $items = [
                 'title' => $node->filterXPath('//div[contains(@class, "post-meta wrapper-lg")]/h2/a')->text(),
                 'link' => $node->filterXPath('//div[contains(@class, "post-meta wrapper-lg")]/h2/a')->attr('href'),
                 'date' => self::cntime($node->filterXPath('//div[contains(@class, "post-meta wrapper-lg")]/div/span[2]')->text()),
                 'description' => $node->filterXPath('//div[contains(@class, "post-meta wrapper-lg")]/p')->text(),
             ];
            $data['items'][]=$items;
         });
            return XML::toRSS($data);
        } catch (\Exception $e) {
           throw new Exception("获取数据失败，请检查参数是否正确，并确保url采用的是typecho和handsome主题");
        }
        
    }
    private function cntime($time){
    $arr = date_parse_from_format('Y年m月d日',$time);
	return mktime(0,0,0,$arr['month'],$arr['day'],$arr['year']);
    }
}
