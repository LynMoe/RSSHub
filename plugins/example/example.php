<?php
/**
 * Created by PhpStorm.
 * User: XiaoLin
 * Date: 2018-11-04
 * Time: 11:13 AM
 */

namespace RSSHub\Plugins\example;

use RSSHub\Lib\XML;

class example
{
    public $_info = [
        'routes' => [
            'test/:input1/:input2' => 'input',
        ],
    ];

    public static function input($input1,$input2)
    {
        $list = [
            'title' => "Example Plugin.",
            'description' => "Just an example.",
            'image' => [
                'url' => "https://i.loli.net/2018/11/04/5bde64c88071d.png",
                'title' => 'cover',
                'src' => "https://i.loli.net/2018/11/04/5bde64c88071d.png",
            ],
            'items' => [
                [
                    'title' => "input1",
                    'link' => "https://www.google.com/search?&q={$input1}",
                    'date' => time(),
                    'description' => "The first input.",
                ],
                [
                    'title' => "input2",
                    'link' => "https://www.google.com/search?&q={$input2}",
                    'date' => time(),
                    'description' => "The second input.",
                ],
            ],
        ];

        return XML::toRSS($list);
    }
}