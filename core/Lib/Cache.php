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
        file_put_contents(__DIR__ . '/../../cache/' . $md5,json_encode($data));
    }

    public static function getCache($md5,$func)
    {
        if (file_exists(__DIR__ . '/../../cache/' . $md5))
        {
            if (time() - (filemtime(__DIR__ . '/../../cache' . $md5)) > 60*5)
                self::updateCache($md5,$func());
        } else
            self::updateCache($md5,$func());

        return file_get_contents(__DIR__ . '/../../cache/' . $md5);
    }
}