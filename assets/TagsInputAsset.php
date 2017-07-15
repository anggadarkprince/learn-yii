<?php
/**
 * Created by PhpStorm.
 * User: angga
 * Date: 29/06/17
 * Time: 14:57
 */

namespace app\assets;

use yii\web\AssetBundle;

class TagsInputAsset extends AssetBundle
{
    public $sourcePath = '@npm/bootstrap-tagsinput/dist';
    public $css = [
        'bootstrap-tagsinput-typeahead.css',
    ];
    public $js = [
        'bootstrap-tagsinput.js',
    ];
}