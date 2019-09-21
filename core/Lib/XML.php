<?php
/**
 * Created by PhpStorm.
 * User: XiaoLin
 * Date: 2018-11-03
 * Time: 7:30 PM
 */

namespace RSSHub\Lib;

use FeedWriter\RSS2;

class XML
{
    public static function toRSS($data) {
        $feed = new RSS2();

        $feed->setTitle($data['title']);
        $feed->setLink(Config::getConfig()['general']['siteURL'] . $_GET['s']);
        if (isset($data['link']))
            $feed->setLink($data['link']);
        if (isset($data['description']))
            $feed->setDescription($data['description']);
        if (isset($data['image']))
            $feed->setImage($data['image']['url'],$data['image']['title'],$data['image']['src']);
        $feed->setDate(date(DATE_RSS,time()));
        if (isset($data['date']))
            $feed->setDate(date(DATE_RSS,$data['date']));
        foreach ($data['items'] as $item) {
            $new = $feed->createNewItem();

            $new->setTitle($item['title']);
            $new->setLink($item['link']);
            if (isset($item['date']))
            $new->setDate(date(DATE_RSS,$item['date']));
            $new->setDescription($item['description']);

            $feed->addItem($new);
        }

        return $feed->generateFeed();
    }
}
