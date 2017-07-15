<?php
/**
 * Created by PhpStorm.
 * User: angga
 * Date: 29/06/17
 * Time: 14:57
 */

namespace app\assets;

use yii\web\AssetBundle;

class Select2BootstrapAsset extends AssetBundle
{
    public $sourcePath = '@npm/select2-bootstrap-theme/dist';
    public $css = [
        'select2-bootstrap.css',
    ];
}