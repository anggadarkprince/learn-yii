<?php
/**
 * Created by PhpStorm.
 * User: angga
 * Date: 29/06/17
 * Time: 14:57
 */

namespace app\assets;

use yii\web\AssetBundle;

class MomentAsset extends AssetBundle
{
    public $sourcePath = '@bower/moment/min';
    public $js = [
        'moment.min.js',
    ];
}