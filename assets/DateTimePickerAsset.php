<?php
/**
 * Created by PhpStorm.
 * User: angga
 * Date: 29/06/17
 * Time: 14:57
 */

namespace app\assets;

use yii\web\AssetBundle;

class DateTimePickerAsset extends AssetBundle
{
    public $sourcePath = '@bower/eonasdan-bootstrap-datetimepicker/build';
    public $css = [
        'css/bootstrap-datetimepicker.css',
    ];
    public $js = [
        'js/bootstrap-datetimepicker.min.js',
    ];
}