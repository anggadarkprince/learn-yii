<?php
/**
 * Created by PhpStorm.
 * User: angga
 * Date: 29/06/17
 * Time: 14:57
 */

namespace app\assets;

use yii\web\AssetBundle;

class Select2Asset extends AssetBundle
{
    public $sourcePath = '@bower/select2/dist';
    public $css = [
        'css/select2.css',
    ];
    public $js = [
        'js/select2.js',
    ];
}