<?php
/**
 * Created by PhpStorm.
 * User: XiaoLin
 * Date: 2018-11-03
 * Time: 5:55 PM
 */

if (is_dir(__DIR__ . '/../vendor') && file_exists(__DIR__ . '/../.env'))
    if (!isset($_GET['s']))
        die(file_get_contents(__DIR__ . '/../view/homepage.html'));
    else
        require_once __DIR__ . '/../core/start.php';
else
    die(file_get_contents(__DIR__ . '/../view/notinstalled.html'));