<?php
/**
 * Created by PhpStorm.
 * User: XiaoLin
 * Date: 2018-11-03
 * Time: 10:11 PM
 */

namespace RSSHub\Lib;

class Config
{
    public static function getConfig()
    {
        $data = parse_ini_file(__DIR__ . '/../../.env.example');

        return $data;
    }
}