<?php
namespace amintado\pay;

use amintado\pay\models\Transaction;

interface EventInterface{

    /**
     * this function runs when payment done
     * @param $model Transaction
     * @return mixed
     */
    public static function afterPay($model);

    /**
     * this function runs when an error occur in payment process
     * @param $model Transaction
     * @return mixed
     */
    public static function ErrorPay($model);


}