<?php
/**
 * Created by PhpStorm.
 * User: amin__000
 * Date: 10/17/2017
 * Time: 6:43 AM
 */

namespace amintado\pay\classes;

use amintado\pay\Module;
use Yii;
use amintado\pay\models\Settings;

class Atpayfunctions
{
    public static function Option($key, $value = null)
    {
        $model = Settings::findOne(['setting_key' => $key]);
        if (empty($model)) {
            if (!empty($value)){
                $model=new Settings();
                $model->setting_key=$key;
                $model->setting_value=serialize($value);
                $model->save();
            }
            return '';
        }
        if (empty($value)) {
            return unserialize($model->setting_value);
        }
        $model->setting_value = serialize($value);
        $model->save();
    }
    public function RenderPDF($content){
        $pdf = new \kartik\mpdf\Pdf([
            'mode' => \kartik\mpdf\Pdf::MODE_UTF8,
            'format' => \kartik\mpdf\Pdf::FORMAT_A4,
            'orientation' => \kartik\mpdf\Pdf::ORIENT_PORTRAIT,
            'destination' => \kartik\mpdf\Pdf::DEST_BROWSER,
            'content' => $content,
            'cssFile' => '@vendor/amintado/yii2-module-pay/assets/css/at-mpdf-bootstrap.css',
            'defaultFont' => 'Samim',
        ]);
        define('_MPDF_TTFONTPATH',realpath(__DIR__ . '/../assets/fonts').'/');
        define('_MPDF_SYSTEM_TTFONTS_CONFIG',realpath(__DIR__ . '/../classes/config_fonts.php'));

        $pdf->configure(
            [

                'defaultCSS'=> require realpath(__DIR__.'/../classes/defaultCSS.php'),

            ]
        );
        return $pdf->render();
    }

    public static function Amount($amount){
      return number_format
        (
            intval
            (
                $amount
            )
            , 0
            , ','
            , ','
        ).' ' . Yii::t('atpay', 'RIAL');
    }

    public static function InitModule(){
        $moduleID = '';

        foreach (Yii::$app->modules as $key => $value) {
            if (!empty($value['class'])) {
                if ($value['class'] == 'amintado\pay\Module') {

                    $moduleID = $key;
                    break;
                }
            }

        }

        //---------------- init Module -------------------
        $module = (new Module($moduleID))->init();
    }
}