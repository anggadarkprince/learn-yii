<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '//fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700',
        'css/site.css',
        'css/admin.css',
    ];
    public $js = [
        'js/app.js',
        'js/follow.js',
        'js/slugger.js',
        'js/recipe.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'app\assets\FontAwesomeAsset',
        'app\assets\AxiosAsset',
        'app\assets\Select2Asset',
        'app\assets\Select2BootstrapAsset',
        'app\assets\TagsInputAsset',
        'app\assets\MomentAsset',
        'app\assets\DateTimePickerAsset',
    ];
}
