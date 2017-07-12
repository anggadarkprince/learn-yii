<?php
/**
 * Created by PhpStorm.
 * User: angga
 * Date: 29/06/17
 * Time: 14:57
 */

namespace app\assets;

use yii\web\AssetBundle;

class AxiosAsset extends AssetBundle
{
    public $sourcePath = '@bower/axios/dist';
    public $js = [
        'axios.js',
    ];
}