<?php
/**
 * Created by PhpStorm.
 * User: amin__000
 * Date: 10/15/2017
 * Time: 9:30 AM
 */

namespace amintado\pay\classes;


use Yii;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\View;

class PayIR
{
    public $api, $amount, $redirect, $factornumber;


    public function send($api, $amount, $redirect, $factorNumber = '0')
    {
        $url="api=$api&amount=$amount&redirect=$redirect&factorNumber=$factorNumber";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://pay.ir/payment/send');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $res = curl_exec($ch);
        curl_close($ch);
        $result = Json::decode($res);
        
        if (empty($result)) {
            throw new BadRequestHttpException('متاسفانه ارتباط با درگاه پرداخت برقرار نشد، لطفا مجددا امتحان کنید.');
        }
        switch ($result['status']) {
            case 0:
                throw new BadRequestHttpException($result['errorMessage']);
                break;

            case 1:

               return Yii::$app->controller->redirect('https://pay.ir/payment/gateway/' . $result['transId']);
                break;
        }

    }

    function verify($api, $transId)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://pay.ir/payment/verify');
        curl_setopt($ch, CURLOPT_POSTFIELDS, "api=$api&transId=$transId");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
    }
}