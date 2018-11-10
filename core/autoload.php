<?php
/**
 * Created by PhpStorm.
 * User: XiaoLin
 * Date: 2018-11-03
 * Time: 6:03 PM
 */

require_once __DIR__ . '/../vendor/autoload.php';

/*
 * Load Models Start
 */

$models = [
    'Cache',
    'Exception',
    'XML',
    'Config',
];

foreach ($models as $model)
{
    if (file_exists($path = __DIR__ . '/Lib/' . $model . '.php'))
        require_once $path;
    else
        die('请检查代码完整性.');
}

/*
 * Load Models End
 */


/*
 * Load Plugins Start
 */

function getPlugins($path,&$plugins)
{
    if (is_dir($path))
    {
        $dp = dir($path);
        while ($file = $dp ->read())
        {
            if($file !== "." && $file !== "..")
            {
                getPlugins($path . "/" . $file,$plugins);
            }
        }
        $dp ->close();
    }
    if (is_file($path))
    {
        $plugins[] =  $path;
    }
}

$plugins = [];
getPlugins(__DIR__ . '/../plugins',$plugins);

$routes = [];
foreach ($plugins as $plugin)
{
    if (substr($plugin,-4) == '.php')
        require_once $plugin;
    else
        continue;

    $pluginGroup = explode('/',$plugin)[count(explode('/',$plugin)) - 2];

    $pluginName = 'RSSHub\\Plugins\\' . $pluginGroup . '\\' . substr(explode('/',$plugin)[count(explode('/',$plugin)) - 1],0,-4);
    $tmpClass = new $pluginName();
    if (isset($tmpClass->_info))
        $tmpInfo = $tmpClass->_info;
    else
        continue;

    foreach ($tmpInfo['routes'] as $routeName => $routeValue)
    {
        $param = [];
        foreach (explode('/',$routeName) as $item)
        {
            if (substr($item,0,1) == ':')
            {
                $param[] = substr($item,1);
                $routeName = str_replace('/' . $item,'',$routeName);
            }
        }

        $routes[$pluginGroup][$routeName] = [
            'handler' => $pluginName . '::' . $routeValue,
            'param' => $param,
        ];

        unset($param);
    }
}
define('RH_ROUTES',$routes);

/*
 * Load Plugins End
 */

// Clean
foreach (get_defined_vars() as $var => $value)
    if ($var != '_GET' && $var != '_POST' && $var != '_REQUEST'
        && $var != '_SERVER' && $var != '_GLOBALS') unset($$var);
unset($var,$value);