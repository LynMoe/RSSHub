<?php
/**
 * Created by PhpStorm.
 * User: XiaoLin
 * Date: 2018-11-03
 * Time: 5:57 PM
 */

namespace RSSHub\Lib;

class Cache
{
    public static function updateCache($md5,$data)
    {
        file_put_contents(__DIR__ . '/../../cache/' . $md5 . '.json',json_encode($data));
    }

    public static function getCache($md5,$func)
    {
        clearstatcache(true,__DIR__ . '/../../cache/' . $md5 . '.json');
        if (file_exists(__DIR__ . '/../../cache/' . $md5 . '.json'))
        {
            if (time() - (filemtime(__DIR__ . '/../../cache/' . $md5 . '.json')) > 300)
                self::updateCache($md5,$func());
        } else
            self::updateCache($md5,$func());

        return file_get_contents(__DIR__ . '/../../cache/' . $md5 . '.json');
    }
}