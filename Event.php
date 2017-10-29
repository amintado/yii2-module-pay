<?php
namespace amintado\pay;

class Event implements EventInterface {
    public static function afterPay($model)
    {

        return null;// TODO: Implement afterPay() method.
    }


    public static function ErrorPay($model)
    {
        return null;// TODO: Implement ErrorPay() method.
    }
}