<?php
/**
 * Created by PhpStorm.
 * User: angga
 * Date: 29/06/17
 * Time: 14:57
 */

namespace app\assets;

use yii\web\AssetBundle;

class SimpleLineIconAsset extends AssetBundle
{
    public $sourcePath = '@bower/simple-line-icons';
    public $css = [
        'css/simple-line-icons.css',
    ];
    public $publishOptions = [
        'only' => [
            'fonts/',
            'css/',
        ]
    ];
}