<?php
/**
 * Created by PhpStorm.
 * User: XiaoLin
 * Date: 2018-11-03
 * Time: 5:55 PM
 */

if (!isset($_GET['s']))
    die('非法操作');

if (!is_dir(__DIR__ . '/vendor') || !file_exists(__DIR__ . '.env'))
    require_once __DIR__ . '/core/start.php';
else
    die('请先完成安装.');