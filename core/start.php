<?php
/**
 * Created by PhpStorm.
 * User: XiaoLin
 * Date: 2018-11-03
 * Time: 5:55 PM
 */

require_once __DIR__ . '/autoload.php';

error_reporting(0);

/*
 * Parse Query String Start
 */

$query = explode('/',$_GET['s']);

if (isset($query[1]) && is_array(RH_ROUTES[$query[1]])) //TODO: Change `is_array` to `isset` because of PHPStorm's bug.
{
    $group = RH_ROUTES[$query[1]];
    $count = 0;

    foreach ($group as $route => $info)
    {
        $count = 2;
        while ($count <= (count($query) - 1))
        {
            $str = '';
            for ($i = 2;$i <= $count;$i++)
                $str .= $query[$i] . '/';
            $str = substr($str,0,-1);

            if (!is_bool(stripos($route,$str)))
                if ($route == $str)
                {
                    $data = $group[$route];
                    if ((count($query) - $count) > 0)
                    {
                        for ($i = 0;$i < count($data['param']);$i++)
                        {
                            $data['data'][$data['param'][$i]] = $query[$i + $count + 1];
                        }
                    }
                    break 2;
                } else
                    $count++;
            else
                break;
        }
    }
}

if (isset($data))
{
    if (count($data['param']) > count($data['data']))
        die(\RSSHub\Lib\XML::toRSS([
            'title' => 'RSSHub Error',
            'description' => '[' . strtoupper("ERROR") . '] ' . '参数错误',
            'link' => \RSSHub\Lib\Config::getConfig()['general']['siteURL'],
            'items' => [],
        ]));

    define('RH_ROUTE',$data);

    try
    {
        $result = call_user_func_array($data['handler'],$data['data']);
    } catch (Exception $exception)
    {
        die(\RSSHub\Lib\XML::toRSS([
            'title' => 'RSSHub Error',
            'description' => '[' . strtoupper("ERROR") . '] ' . $exception->getTraceAsString(),
            'link' => \RSSHub\Lib\Config::getConfig()['general']['siteURL'],
            'items' => [],
        ]));
    }
    header('Content-Type: text/xml; charset=utf-8');
    echo $result;
} else
    die(\RSSHub\Lib\XML::toRSS([
        'title' => 'RSSHub Error',
        'description' => '[' . strtoupper("ERROR") . '] ' . '路由错误',
        'link' => \RSSHub\Lib\Config::getConfig()['general']['siteURL'],
        'items' => [],
    ]));

/*
 * Parse Query String Start
 */