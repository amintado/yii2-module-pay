<?php
/**
 * Created by PhpStorm.
 * User: amin__000
 * Date: 10/14/2017
 * Time: 12:07 PM
 */

namespace amintado\pay\assets;


use yii\web\AssetBundle;

class PayAsset extends AssetBundle
{
    public $sourcePath = '@vendor/amintado/yii2-module-pay/assets';
    public $js =
        [

        ];
    public $css =
        [
            'css/pay-style.css'
        ];
}