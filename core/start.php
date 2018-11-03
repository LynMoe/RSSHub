<?php
/**
 * Created by PhpStorm.
 * User: XiaoLin
 * Date: 2018-11-03
 * Time: 5:55 PM
 */

require_once __DIR__ . '/autoload.php';

$_GET['s'] = '/bilibili/user/video/481169';

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
        die('参数错误');

    define('RH_ROUTE',$data);

    try
    {
        $result = call_user_func_array($data['handler'],$data['data']);
    } catch (\RSSHub\Lib\Exception $exception)
    {
        //var_dump($exception->getTrace());
    }

    var_dump($result);
    file_put_contents(__DIR__ . '/../data.xml',$result);
} else
    die('路由地址错误');

/*
 * Parse Query String Start
 */